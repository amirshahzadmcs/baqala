<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ThreePl_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = '3pl_rider_applications';
	}
	
	/* ----- Basic CRUD ----- */
	public function save($data) {
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data) {
		return $this->db->update($this->table, $data, $where);
	}

	public function delete($ids) {
		if (!is_array($ids) || empty($ids)) {
			return false;
		}
		$this->db->where_in('id', $ids);
		$this->db->delete($this->table);
		return $this->db->affected_rows() > 0;
	}

	public function get($where = []) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		return $this->db->get($this->table)->row();
	}

	/* ----- List with filters, search & pagination ----- */
	public function list($search = '', $perPage = 50, $start = 0, $date_from = null, $date_to = null) {
		// Column preferences (if enabled for module)
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'threepl_rider_applications'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns  = json_decode($userPreferences->visible_columns ?? '[]', true);

		// Default fallback if no preferences
		if (empty($selectedColumns)) {
			$selectedColumns = [
				'id', 'is_referral', 'referrer_full_name', 'referrer_mobile',
				'referrer_iqama_id', 'referrer_hungerstation_id', 'referrer_iban',
				'rider_full_name', 'rider_mobile', 'rider_iqama_id', 'rider_iqama_expiry',
				'nationality', 'email', 'dob', 'rider_city', 'rider_iban',
				'saudi_status', 'iqama_file', 'license_file', 'iban_file', 'photo_file',
				'created_at', 'updated_at'
			];
		}

		$this->db->select(implode(', ', $selectedColumns), false);
		$this->db->from($this->table);

		// Search across multiple columns
		if (!empty($search)) {
			$this->db->group_start()
				->like('rider_full_name', $search)
				->or_like('rider_mobile', $search)
				->or_like('rider_iqama_id', $search)
				->or_like('referrer_full_name', $search)
				->or_like('referrer_mobile', $search)
				->or_like('email', $search)
				->group_end();
		}

		// Filters
		if (!empty($date_from)) {
			$this->db->where('DATE(created_at) >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('DATE(created_at) <=', date('Y-m-d', strtotime($date_to)));
		}

		// Count total rows
		$totalRowsQuery = clone $this->db;
		$totalRowsCount = $totalRowsQuery->get()->num_rows();

		// Pagination & order
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit($perPage, max(0, $start));
		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'pagination' => [
				'total' => $totalRowsCount,
				'per_page' => $perPage,
				'current_page' => ($start / $perPage) + 1
			]
		];
	}

	public function getRiderApplicationsReport($search = '', $column_type = 'visible', $file_format = 'html', $date_from = null, $date_to = null)
	{
		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(), 
			'module_name' => '3pl_rider_applications'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns  = json_decode($userPreferences->visible_columns ?? '[]', true);

		// Default columns if none selected or 'all_columns'
		if (empty($selectedColumns) || $column_type == 'all_columns') {
			$selectedColumns = [
				'id', 'is_referral', 'referrer_full_name', 'referrer_mobile', 'referrer_iqama_id', 
				'referrer_hungerstation_id', 'referrer_iban', 'rider_full_name', 'rider_mobile', 
				'rider_iqama_id', 'rider_iqama_expiry', 'nationality', 'email', 'dob', 'rider_city', 
				'rider_iban', 'saudi_status', 'iqama_file', 'license_file', 'iban_file', 'photo_file', 
				'created_at', 'updated_at'
			];
		}

		// Build SELECT
		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('3pl_rider_applications');

		// Date filters (if any)
		if (!empty($date_from)) {
			$this->db->where('created_at >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('created_at <=', date('Y-m-d', strtotime($date_to)));
		}

		// Search filter
		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $col) {
				$this->db->or_like($col, $sanitizedSearch);
			}
			$this->db->group_end();
		}

		// Optional order
		$this->db->order_by('created_at', 'DESC');

		$result = $this->db->get()->result_array();
		$totalRows = count($result);

		// ✅ File/Image Columns
		$fileColumns = ['iqama_file', 'license_file', 'iban_file', 'photo_file'];
		foreach ($result as &$row) {
			foreach ($fileColumns as $fileCol) {
				if (!empty($row[$fileCol])) {
					$fileUrl = base_url($row[$fileCol]);
					if ($file_format === 'excel') {
						$row[$fileCol] = basename($fileUrl); // show filename
					} else {
						$row[$fileCol] = '<img src="' . $fileUrl . '" style="height:50px;width:50px;object-fit:cover;border-radius:5px;cursor:pointer;" class="img-clickable" data-file="' . $fileUrl . '">';
					}
				}
			}
		}

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'total_rows' => $totalRows
		];
	}

}
