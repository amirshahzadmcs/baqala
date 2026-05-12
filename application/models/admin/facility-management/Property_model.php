<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Property_model extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $query = $this->db->get('facilities_properties');
        return $query->result_array();
    }

    public function get_by_id($id) {
		$this->db->select('
			facilities_properties.*,
			sponsors.employer_name AS tenant_company_name,
			sponsors.employer_id AS tenant_unified_number,
			sponsors.employer_cr_no AS tenant_cr_no
		');
		$this->db->from('facilities_properties');
		$this->db->join('sponsors', 'facilities_properties.tenant_company_id = sponsors.id', 'left');
		$this->db->where('facilities_properties.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function save_property($data) {
        $this->db->insert('facilities_properties', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('facilities_properties', $data);
    }
	
	/*----- Property List -----*/

	public function propertyList($keyword, $property_type, $property_city, $property_status, $ejar_start_date, $ejar_end_date, $perPage = 0, $start = 0, $column_preferences = 'selected_columns') {
		// Step 0: Sanitize inputs
		$keyword = trim($keyword);
		$property_type = trim($property_type);
		$property_city = trim($property_city);
		$property_status = trim($property_status);
		$ejar_start_date = trim($ejar_start_date);
		$ejar_end_date = trim($ejar_end_date);
	
		// Step 1: Load user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'facilities_properties'
		])->row();
	
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);
	
		// All column keys (with replacements)
		$allColumnKeys = [
			"id", "property_number", "property_name", "property_type", 
			"master_city.city_name AS property_city", "property_status", 
			"sponsors.employer_name AS tenant_company_id", "sponsors.employer_id AS tenant_unified_number", "sponsors.employer_cr_no AS tenant_cr_no", 
			"brokerage_entity_name", "brokerage_entity_address", "brokerage_landline_no", 
			"brokerage_cr_no", "brokerage_vat_no", "broker_name", 
			"master_nationality.name AS broker_nationality", 
			"broker_id_no", "broker_person", "broker_mobile_no", "broker_email_id", 
			"account_name", "master_bank.bank_name AS bank_name", "iban", 
			"ejar_contract_number", "ejar_contract_start_date", "ejar_contract_end_date", 
			"attach_ejar_contract", "created_at", "updated_at"
		];
	
		// Display names (for column mapping)
		$allColumnDisplayMap = [
			"tenant_company_id" => "sponsors.employer_name",
			"tenant_unified_number" => "sponsors.employer_id",
			"tenant_cr_no" => "sponsors.employer_cr_no",
			"bank_name" => "master_bank.bank_name",
			"property_city" => "master_city.city_name",
			"broker_nationality" => "master_nationality.name"
		];
	
		if ($column_preferences === 'all_columns' || empty($selectedColumns)) {
			$visibleColumns = array_keys($allColumnDisplayMap + array_fill_keys(array_map(function ($col) {
				return preg_replace('/^.*? AS /', '', $col);
			}, $allColumnKeys), true));
		} elseif (empty($visibleColumns)) {
			$visibleColumns = $selectedColumns;
		}
	
		// Step 2: SELECT columns
		$columnsToSelect = [];
		foreach ($visibleColumns as $col) {
			if (array_key_exists($col, $allColumnDisplayMap)) {
				$columnsToSelect[] = "{$allColumnDisplayMap[$col]} AS `{$col}`";
			} elseif (in_array($col, array_column($allColumnKeys, null, null))) {
				$columnsToSelect[] = "`facilities_properties`.`$col`";
			}
		}
		if (empty($columnsToSelect)) {
			$columnsToSelect[] = "`facilities_properties`.`property_number`";
		}
	
		// Step 3: FROM and JOINs
		$baseFrom = " FROM `facilities_properties`
			LEFT JOIN `sponsors` ON `facilities_properties`.`tenant_company_id` = `sponsors`.`id`
			LEFT JOIN `master_city` ON `facilities_properties`.`property_city` = `master_city`.`id`
			LEFT JOIN `master_bank` ON `facilities_properties`.`bank_name` = `master_bank`.`id`
			LEFT JOIN `master_nationality` ON `facilities_properties`.`broker_nationality` = `master_nationality`.`id`
			WHERE 1=1";
	
		// Step 4: Filters
		$where = "";
		if ($keyword) {
			$kw = $this->db->escape_like_str($keyword);
			$where .= " AND (`facilities_properties`.`property_number` LIKE '%{$kw}%' OR `facilities_properties`.`property_name` LIKE '%{$kw}%')";
		}
		if ($property_type) {
			$where .= " AND `facilities_properties`.`property_type` = '" . $this->db->escape_str($property_type) . "'";
		}
		if ($property_city) {
			$where .= " AND `facilities_properties`.`property_city` = '" . $this->db->escape_str($property_city) . "'";
		}
		if ($property_status) {
			$where .= " AND `facilities_properties`.`property_status` = '" . $this->db->escape_str($property_status) . "'";
		}
		if ($ejar_start_date && $ejar_end_date) {
			$start = date("Y-m-d", strtotime($ejar_start_date));
			$end = date("Y-m-d", strtotime($ejar_end_date));
			$where .= " AND (`facilities_properties`.`ejar_contract_start_date` BETWEEN '{$start}' AND '{$end}')";
		}
	
		// Step 5: Pagination Count
		$countQuery = "SELECT COUNT(*) AS total" . $baseFrom . $where;
		$totalRowsCount = $this->db->query($countQuery)->row()->total;
	
		// Step 6: Final Data Query
		$dataQuery = "SELECT " . implode(', ', $columnsToSelect) . $baseFrom . $where . " ORDER BY `facilities_properties`.`id` DESC";
		if ($perPage > 0) {
			$dataQuery .= " LIMIT " . intval($perPage) . " OFFSET " . intval($start);
		}
	
		$result = $this->db->query($dataQuery)->result_array();
	
		// Step 7: Return Result
		return [
			'data' => $result,
			'available_columns' => array_keys($allColumnDisplayMap + array_fill_keys(array_map(function ($col) {
				return preg_replace('/^.*? AS /', '', $col);
			}, $allColumnKeys), true)),
			'visible_columns' => $visibleColumns,
			'pagination' => [
				'total' => (int)$totalRowsCount,
				'per_page' => (int)$perPage,
				'current_page' => (int)$start
			]
		];
	}	

	/*---- Property List End -----*/
	
	public function delete($ids)
	{
		if (is_array($ids)) {
			// Delete from sub tables first
			$this->db->where_in('property_id', $ids);
			$this->db->delete('rent_facilities');

			$this->db->where_in('property_id', $ids);
			$this->db->delete('rent_utilities');

			$this->db->where('property_id', $ids);
			$this->db->delete('facility_room_bedding');

			// Delete from main table
			$this->db->where_in('id', $ids);
			return $this->db->delete('facilities_properties');
		} else {
			// Delete from sub tables first
			$this->db->where('property_id', $ids);
			$this->db->delete('rent_facilities');

			$this->db->where('property_id', $ids);
			$this->db->delete('rent_utilities');

			$this->db->where('property_id', $ids);
			$this->db->delete('facility_room_bedding');

			// Delete from main table
			$this->db->where('id', $ids);
			return $this->db->delete('facilities_properties');
		}
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM facilities_properties WHERE id = '" . (int)$id . "'");
		return $query;
	}

	// Function to get rent payment schedule
	public function get_full_rent_details($property_id) {
		// Fetch the rent schedule for this property
		$this->db->select('*');
		$this->db->from('rent_payment_schedule');
		$this->db->where('property_id', $property_id);
		$query = $this->db->get();
	
		if ($query->num_rows() === 0) {
			return []; // No rent schedule found
		}
	
		$rent = $query->result_array(); // Get the single rent schedule
	
		// Fetch rent utilities
		$this->db->select('*');
		$this->db->from('rent_utilities');
		$this->db->where('property_id', $property_id);
		$utilities = $this->db->get()->result_array();
	
		// Fetch rent facilities
		$this->db->select('*');
		$this->db->from('rent_facilities');
		$this->db->where('property_id', $property_id);
		$facilities = $this->db->get()->result_array();
	
		// Combine all in one return
		return [
			'schedule' => $rent,
			'utilities' => $utilities,
			'facilities' => $facilities
		];
	}
	
	/*------ Rooms and Bedding ------*/

	function make_bedding_query() {
		$this->db->select('
			facility_room_bedding.*,
			facilities_properties.property_number,
			facilities_properties.property_name,
			facilities_properties.property_type
		');
		$this->db->from('facility_room_bedding');
		$this->db->join('facilities_properties', 'facility_room_bedding.property_id = facilities_properties.id', 'left');
	}

	function get_bedding_list() {
		$this->make_bedding_query();

		// Order by property_name DESC
		$this->db->order_by('facilities_properties.property_name', 'DESC');

		// Pagination
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		$query = $this->db->get();
		return $query->result();
	}

	function get_bedding_filtered_data() {
		$this->make_bedding_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_all_bedding_data() {
		$this->db->from('facility_room_bedding');
		return $this->db->count_all_results();
	}

	public function save_bedding($data) {
        $this->db->insert('facility_room_bedding', $data);
        return $this->db->insert_id();
    }

    public function update_bedding($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('facility_room_bedding', $data);
    }

    public function get_bedding_by_id($id) {
		$this->db->select('
			facility_room_bedding.*,
			facilities_properties.property_number,
			facilities_properties.property_name,
			facilities_properties.property_type
		');
		$this->db->from('facility_room_bedding');
		$this->db->join('facilities_properties', 'facility_room_bedding.property_id = facilities_properties.id', 'left');
		$this->db->where('facility_room_bedding.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_floors_by_property($property_id) {
		$this->db->select('floors');
		$this->db->from('rent_facilities');
		$this->db->where('property_id', $property_id);
		$query = $this->db->get();
		return $query->result_array(); // multiple rows expected
	}

	public function get_units_by_floor($property_id, $floor) {
		$this->db->select('rooms, kitchen');
		$this->db->from('rent_facilities');
		$this->db->where('property_id', $property_id);
		$this->db->where('floors', $floor);
		$query = $this->db->get();
		return $query->row_array(); // since it's for single floor
	}

	public function delete_beddings($ids)
	{
		if (is_array($ids)) {
			// Delete from main table
			$this->db->where_in('id', $ids);
			return $this->db->delete('facility_room_bedding');
		} else {
			// Delete from main table
			$this->db->where('id', $ids);
			return $this->db->delete('facility_room_bedding');
		}
	}
	
}
