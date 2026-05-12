<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuel_model extends CI_Model{

	public function getFuelSummaryByMonth()
	{
		$this->db->select("
			DATE_FORMAT(fuel_date, '%Y-%m') AS fuel_month,
			DATE_FORMAT(MIN(fuel_date), '%b %d') AS start_date,
			DATE_FORMAT(MAX(fuel_date), '%b %d') AS end_date,
			COUNT(DISTINCT vehicle_id ) AS total_vehicles,
			SUM(cost) AS total_cost,
			COUNT(*) AS total_records
		");
		$this->db->from('fuel_consumptions');
		$this->db->group_by("DATE_FORMAT(fuel_date, '%Y-%m')");
		$this->db->order_by("fuel_month", "DESC");

		$query = $this->db->get();
		$result = $query->result_array();

		// Add final display format like "Nov 01 → Nov 30"
		foreach ($result as &$row) {
			$row['month_range'] = $row['start_date'] . ' → ' . $row['end_date'];
		}

		return $result;
	}
	
	// Function to apply common filters
	private function apply_filters(&$a) {
		// Keyword search across all 3 sources
		if ($this->input->get('keyword')) {
			$keyword = $this->db->escape_like_str($this->input->get('keyword'));
			$a .= " AND (
						me.full_name LIKE '%{$keyword}%' 
						OR me.emp_no LIKE '%{$keyword}%' 
					)";
		}

		// Vehicle No.
		if ($this->input->get('vehicle_no')) {
			$vehicle_no = $this->db->escape_like_str($this->input->get('vehicle_no'));
			$a .= " AND fc.vehicle_no LIKE '%{$vehicle_no}%'";
		}

		// Vehicle Type
		if ($this->input->get('vehicle_type')) {
			$vehicle_type = $this->db->escape_like_str($this->input->get('vehicle_type'));
			$a .= " AND mv.vehicle_type = '{$vehicle_type}'";
		}

		// Vehicle Category
		if ($this->input->get('vehicle_category')) {
			$vehicle_category = $this->db->escape_like_str($this->input->get('vehicle_category'));
			$a .= " AND mv.vehicle_category = '{$vehicle_category}'";
		}

		// Team
		if ($this->input->get('team')) {
			$team_id = intval($this->input->get('team'));
			$a .= " AND fc.team_id = {$team_id}";
		}

		// Date Range
		if ($this->input->get('date_from') && $this->input->get('date_to')) {
			$v_from = $this->input->get('date_from');
			$v_to   = $this->input->get('date_to');
			$d_from = date("Y-m-d", strtotime($v_from));
			$d_to   = date("Y-m-d", strtotime($v_to));
			$a .= " AND (fc.fuel_date BETWEEN '{$d_from}' AND '{$d_to}')";
		}
	}

	function make_query($month)
	{
		$sql = "SELECT 
				fc.id,
				fc.vehicle_id,
				fc.vehicle_no,
				fc.fuel_date,
				fc.liters,
				fc.cost,
				fc.is_manual,
				fc.remarks,
				fc.created_at,
				fc.updated_at,
				mv.vehicle_type,
				fc.allotment_status,
				me.full_name AS employee_name,
				me.emp_no AS employee_no,
				mjt.name AS designation_name,
				ht.name AS team_name,

				-- Hunger Summary
				hos.rider_id AS hunger_rider_id,
				hos.completed_deliveries AS hunger_orders,

				-- Jahez Summary
				mjs.driver_id AS jahez_driver_id,
				mjs.orders     AS jahez_orders,

				-- Noon Summary
				nos.da_id AS noon_da_id,
				nos.delivered_orders AS noon_orders

			FROM fuel_consumptions fc
			LEFT JOIN master_vehicles mv ON mv.id = fc.vehicle_id
			LEFT JOIN master_employee me ON fc.emp_id = me.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN hunger_team ht ON ht.id = fc.team_id

			-- Hunger (optimized: no DATE() usage)
			LEFT JOIN hunger_order_summary hos 
				ON hos.alloted_vehicle_id = fc.vehicle_id 
			AND hos.date_local >= fc.fuel_date 
			AND hos.date_local < DATE_ADD(fc.fuel_date, INTERVAL 1 DAY)

			-- Jahez
			LEFT JOIN maha_jahez_daily_summary mjs 
				ON mjs.alloted_vehicle_id = fc.vehicle_id 
			AND mjs.order_date >= fc.fuel_date 
			AND mjs.order_date < DATE_ADD(fc.fuel_date, INTERVAL 1 DAY)

			-- Noon
			LEFT JOIN noon_order_summary nos 
				ON nos.alloted_vehicle_id = fc.vehicle_id 
			AND nos.local_date >= fc.fuel_date 
			AND nos.local_date < DATE_ADD(fc.fuel_date, INTERVAL 1 DAY)

			WHERE 1=1";

		// ✅ Filter by month (format: YYYY-MM)
		if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
			$start_date = $month . "-01";
			$end_date   = date("Y-m-t", strtotime($start_date)); // last day of month
			$sql .= " AND fc.fuel_date BETWEEN " . $this->db->escape($start_date) . " 
										AND " . $this->db->escape($end_date);
		}

		return $sql;
	}

	function get_list($month)
	{
		$sql = $this->make_query($month);
		$this->apply_filters($sql);

		// Order (fixed — no dynamic input, safe)
		$sql .= " ORDER BY fc.fuel_date DESC, fc.cost DESC";

		// Pagination (safe with intval)
		$start = intval($_POST['start'] ?? 0);
		$length = intval($_POST['length'] ?? 10);

		if ($length != -1) {
			$sql .= " LIMIT $start, $length";
		}

		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_filtered_data($month)
	{
		$sql = $this->make_query($month);
		$this->apply_filters($sql);
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function get_all_data()
	{
		$month = $this->uri->segment(5); // Use correct URI segment

		$this->db->from('fuel_consumptions');

		if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
			$this->db->where("DATE_FORMAT(fuel_date, '%Y-%m') =", $month);
		}

		return $this->db->count_all_results();
	}

	public function checkDuplicateInBulk($data) {
		// Check if necessary keys are present in the $data array
		if (!isset($data['vehicle_no']) || !isset($data['fuel_date'])) {
			throw new InvalidArgumentException("Missing necessary keys in data array.");
		}

		// Query the database to check for duplicates based on vehicle_no and date
		$this->db->where('vehicle_no', $data['vehicle_no']);
		$this->db->where('fuel_date', date('Y-m-d', strtotime($data['fuel_date'])));
		$query = $this->db->get('fuel_consumptions');
	
		// If a row is returned, it means the data already exists and is a duplicate
		if ($query->num_rows() > 0) {
			return true; // Indicate that a duplicate was found
		}
	
		return false; // No duplicates found
	}

	public function delete_fuel_by_month($month)
	{
		if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
			return false;
		}

		$start = date("$month-01");
		$end   = date("Y-m-t", strtotime($start));

		$this->db->where("fuel_date >=", $start);
		$this->db->where("fuel_date <=", $end);
		return $this->db->delete('fuel_consumptions');
	}

	function monthly_fuel_summary($month, $keyword = null, $aggregator_id = null, $attend_type = null)
	{
		$sql = $this->make_query($month, $keyword, $aggregator_id, $attend_type);

		// Order
		$sql .= " ORDER BY fuel_consumptions.fuel_date ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_employee_monthly_fuel($month)
	{
		$sql = "
			SELECT 
				fc.id AS fuel_id,
				fc.fuel_date,
				fc.liters,
				fc.cost,
				fc.remarks,

				fc.vehicle_id AS vehicle_id,
				fc.vehicle_no,
				fc.allotment_status,
				mv.vehicle_type,

				me.id AS emp_id,
				me.full_name AS full_name,
				me.emp_no AS emp_no,
				mjt.name AS designation_name,
				ht.name AS team_name,

				-- Orders
				COALESCE(hos.completed_deliveries, 0) AS hunger_orders,
				COALESCE(mjs.orders, 0) AS jahez_orders,
				COALESCE(nos.delivered_orders, 0) AS noon_orders 

			FROM fuel_consumptions fc
			LEFT JOIN master_vehicles mv ON mv.id = fc.vehicle_id
			LEFT JOIN master_employee me ON fc.emp_id = me.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN hunger_team ht ON ht.id = fc.team_id

			-- Orders joins
			LEFT JOIN hunger_order_summary hos 
				ON hos.alloted_vehicle_id = fc.vehicle_id
				AND DATE(hos.date_local) = DATE(fc.fuel_date)

			LEFT JOIN maha_jahez_daily_summary mjs 
				ON mjs.alloted_vehicle_id = fc.vehicle_id
				AND DATE(mjs.order_date) = DATE(fc.fuel_date)

			LEFT JOIN noon_order_summary nos 
				ON nos.alloted_vehicle_id = fc.vehicle_id
				AND DATE(nos.local_date) = DATE(fc.fuel_date)

			WHERE DATE_FORMAT(fc.fuel_date, '%Y-%m') = ?
			ORDER BY fc.cost DESC
		";

		return $this->db->query($sql, [$month])->result();
	}

	//Vehicle List for Fuel Management
	public function vehicle_make_query($start_date = null, $end_date = null)
	{
		// 🔹 Case 1: No start/end date given → show ALL vehicles (even without fuel)
		if (empty($start_date) && empty($end_date)) {
			// Get the latest fuel date (for fallback)
			$latest_date_query = $this->db->query("SELECT MAX(DATE(fuel_date)) AS latest_date FROM fuel_consumptions");
			$latest_date = $latest_date_query->row()->latest_date ?? date('Y-m-d'); // fallback to today
			$start_date = $end_date = null; // No filter mode
		}

		// 🔹 Build base SQL
		$sql = "
			SELECT 
				fv.vehicle_id AS vehicle_id,
				fv.vehicle_no,
				mv.vehicle_type,
				mv.vehicle_category,
				mv.allotment_status,
				mv.alloted_user,
				mv.gasoline_chip_status,
				
				fc.allotment_status,
				fc.id AS fuel_id,
				fc.fuel_date,
				fc.liters,
				fc.cost,
				fc.remarks,

				me.id AS emp_id,
				me.full_name AS full_name,
				me.emp_no AS emp_no,
				ht.name AS team_name,

				-- Orders
				COALESCE(hos.completed_deliveries, 0) AS hunger_orders,
				COALESCE(mjs.orders, 0) AS jahez_orders,
				COALESCE(nos.delivered_orders, 0) AS noon_orders,

				-- Logistic Info
				COALESCE(hos.rider_id, mjs.driver_id, nos.da_id) AS id_number,
				COALESCE(fdc_hunger.company_name, fdc_jahez.company_name, fdc_noon.company_name) AS company_name

			FROM fuel_vehicle fv
			LEFT JOIN fuel_consumptions fc ON fc.vehicle_id = fv.vehicle_id
			LEFT JOIN master_vehicles mv ON mv.id = fv.vehicle_id
			LEFT JOIN master_employee me ON fc.emp_id = me.id
			LEFT JOIN hunger_team ht ON ht.id = fc.team_id

			-- Orders joins
			LEFT JOIN hunger_order_summary hos 
				ON hos.alloted_vehicle_id = fc.vehicle_id
				AND DATE(hos.date_local) = DATE(fc.fuel_date)

			LEFT JOIN maha_jahez_daily_summary mjs 
				ON mjs.alloted_vehicle_id = fc.vehicle_id
				AND DATE(mjs.order_date) = DATE(fc.fuel_date)

			LEFT JOIN noon_order_summary nos 
				ON nos.alloted_vehicle_id = fc.vehicle_id
				AND DATE(nos.local_date) = DATE(fc.fuel_date)

			-- Logistic Company Joins
			LEFT JOIN master_logistic_ids mli_hunger ON mli_hunger.id_number = hos.rider_id
			LEFT JOIN food_deliv_companies fdc_hunger ON fdc_hunger.id = mli_hunger.platform_id

			LEFT JOIN master_logistic_ids mli_jahez ON mli_jahez.id_number = mjs.driver_id
			LEFT JOIN food_deliv_companies fdc_jahez ON fdc_jahez.id = mli_jahez.platform_id

			LEFT JOIN master_logistic_ids mli_noon ON mli_noon.id_number = nos.da_id
			LEFT JOIN food_deliv_companies fdc_noon ON fdc_noon.id = mli_noon.platform_id
		";

		// 🔹 Apply WHERE logic dynamically
		if (!empty($start_date) && !empty($end_date)) {
			// Date filter active → show only vehicles with fuel in range
			$sql .= "
				WHERE DATE(fc.fuel_date) BETWEEN " . $this->db->escape($start_date) . " 
				AND " . $this->db->escape($end_date) . "
			";
		} else {
			// No date filter → include vehicles without any fuel data
			$sql .= " WHERE 1 ";
		}

		return $sql;
	}

	public function get_vehicle_list($start_date = null, $end_date = null)
	{
		$sql = $this->vehicle_make_query($start_date, $end_date);
		$this->apply_filters_new($sql);
		$sql .= " ORDER BY fc.fuel_date DESC";

		if ($_POST["length"] != -1) {
			$sql .= " LIMIT " . (int)$_POST['start'] . ", " . (int)$_POST['length'];
		}

		$query = $this->db->query($sql);
		return $query->result();
	}

	// Function to apply common filters
	private function apply_filters_new(&$a) {
		// Keyword search
		if ($this->input->post('keyword')) {
			$keyword = $this->db->escape_like_str($this->input->post('keyword'));
			$a .= " AND (me.full_name LIKE '%{$keyword}%' OR me.emp_no LIKE '%{$keyword}%')";
		}

		if ($this->input->post('vehicle_no')) {
			$vehicle_no = $this->db->escape_like_str($this->input->post('vehicle_no'));
			$a .= " AND fc.vehicle_no LIKE '%{$vehicle_no}%'";
		}

		if ($this->input->post('vehicle_type')) {
			$vehicle_type = $this->db->escape_like_str($this->input->post('vehicle_type'));
			$a .= " AND mv.vehicle_type = '{$vehicle_type}'";
		}

		if ($this->input->post('vehicle_category')) {
			$vehicle_category = $this->db->escape_like_str($this->input->post('vehicle_category'));
			$a .= " AND mv.vehicle_category = '{$vehicle_category}'";
		}

		if ($this->input->post('team')) {
			$team_id = intval($this->input->post('team'));
			$a .= " AND fc.team_id = {$team_id}";
		}
	}

	public function get_filtered_vehicle_data($start_date = null, $end_date = null)
	{
		$sql = $this->vehicle_make_query($start_date, $end_date);
		$this->apply_filters_new($sql);
		$sql .= " ORDER BY fc.fuel_date DESC";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function get_all_vehicle_data()
	{
		$this->db->select("*");
		$this->db->from("fuel_vehicle");
		return $this->db->count_all_results();
	}
	
	public function daily_consumption_report($start_date = null, $end_date = null)
	{
		$sql = $this->vehicle_make_query($start_date, $end_date);
		$this->apply_filters_report($sql);
		$sql .= " ORDER BY fc.fuel_date DESC, fc.cost DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	private function apply_filters_report(&$a) {
		// Keyword search
		if ($this->input->get('keyword')) {
			$keyword = $this->db->escape_like_str($this->input->get('keyword'));
			$a .= " AND (me.full_name LIKE '%{$keyword}%' OR me.emp_no LIKE '%{$keyword}%')";
		}

		if ($this->input->get('vehicle_no')) {
			$vehicle_no = $this->db->escape_like_str($this->input->get('vehicle_no'));
			$a .= " AND fc.vehicle_no LIKE '%{$vehicle_no}%'";
		}

		if ($this->input->get('vehicle_type')) {
			$vehicle_type = $this->db->escape_like_str($this->input->get('vehicle_type'));
			$a .= " AND mv.vehicle_type = '{$vehicle_type}'";
		}

		if ($this->input->get('vehicle_category')) {
			$vehicle_category = $this->db->escape_like_str($this->input->get('vehicle_category'));
			$a .= " AND mv.vehicle_category = '{$vehicle_category}'";
		}

		if ($this->input->get('team')) {
			$team_id = intval($this->input->get('team'));
			$a .= " AND fc.team_id = {$team_id}";
		}

		// ⭐ EXCLUDE ZERO CONSUMPTION
		if ($this->input->get('exclude_zero_consumption')) {
			$a .= " AND fc.cost > 0";
		}
	}

}
