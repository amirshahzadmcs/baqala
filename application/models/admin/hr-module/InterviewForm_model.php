<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InterviewForm_model extends CI_Model{

	public function save($data)
    {
        $this->db->insert('interview_forms', $data);
        return $this->db->insert_id();
    }
	
	public function update($id, $data)
	{
		return $this->db->where('id', $id)->update('interview_forms', $data);
	}

	public function list(
        $search = '', $perPage = 50, $start = 0,
        $applied_for = null,
        $date_from = null, $date_to = null,
        $status = null,
        $nationality = null,
        $preferred_city = null,
        $iqama_profession = null,
        $no_of_transfer = null,
        $has_driving_license = null,
        $driving_license_type = null,
        $driving_license_expiry_from = null,
        $driving_license_expiry_to = null,
        $arrival_date_from = null,
        $arrival_date_to = null
    ) {
        // ---------------------------------------------------------
        // Fetch user column preferences
        // ---------------------------------------------------------
        $userPreferences = $this->db->get_where('user_column_preferences', [
            'user_id' => $this->admin->getLoginEmpId(),
            'module_name' => 'interview_forms'
        ])->row();

        $selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
        $visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

        // ---------------------------------------------------------
        // Default columns (if user has no preferences)
        // ---------------------------------------------------------
        if (empty($selectedColumns)) {
            $selectedColumns = [
                'interview.id', 'interview.interview_no', 'interview.interview_date', 'pos.name', 'interview.applicant_name', 'interview.date_of_birth', 'interview.mobile_number', 'interview.email', 'mn.name as nationality_name', 'mc.city_name', 'interview.iban_number', 'interview.iqama_number', 'interview.iqama_expiry', 'mp.profession_name', 'interview.huroob_status', 'interview.no_of_transfer', 'interview.has_driving_license', 'interview.driving_license_number', 'interview.driving_license_type', 'interview.driving_license_expiry', 'interview.arrival_date', 'interview.has_hunger_station', 'interview.has_jahez', 'interview.has_keeta', 'interview.has_noon', 'interview.has_toyou', 'interview.has_marsool', 'interview.has_chefz', 'interview.long_term_relation', 'interview.transfer_sponsorship', 'interview.recommendation', 'interview.remarks', 'interview.iqama_copy', 'interview.driving_license_copy', 'interview.iban_certificate', 'interview.created_at', 'interview.updated_at', 'interview.status', 'interview.hired_date', 'me.emp_no'
            ];
        }

        // ---------------------------------------------------------
        // Prefix columns correctly
        // ---------------------------------------------------------
        $selectedColumns = array_map(function ($col) {

            if (stripos($col, ' AS ') !== false) return $col; // already aliased
            if (strpos($col, '(') !== false) return $col;     // subquery

            if (strpos($col, 'interview.') === 0 ||
                strpos($col, 'pos.') === 0 ||
                strpos($col, 'mc.') === 0 ||
				strpos($col, 'me.') === 0 ||
				strpos($col, 'mn.') === 0 ||
                strpos($col, 'mp.') === 0) {
                return $col;
            }

            // mapping short names
            if (in_array($col, ['position_applied'])) return 'pos.name AS position_applied';
            if (in_array($col, ['city_name'])) return 'mc.city_name';
            if (in_array($col, ['profession_name'])) return 'mp.profession_name';
			if (in_array($col, ['emp_no'])) return 'me.emp_no';
			if (in_array($col, ['nationality_name'])) return 'mn.name AS nationality_name';

            // default
            return 'interview.' . $col;
        }, $selectedColumns);

        // ---------------------------------------------------------
        // Begin Query
        // ---------------------------------------------------------
        $this->db->select(implode(', ', $selectedColumns), false);
        $this->db->from('interview_forms interview');
        $this->db->join('master_job_title pos', 'interview.position_applied = pos.id', 'left');
        $this->db->join('master_city mc', 'interview.preferred_city = mc.id', 'left');
        $this->db->join('master_profession mp', 'interview.iqama_profession = mp.id', 'left');
		$this->db->join('master_employee me', 'interview.added_by = me.id', 'left');
		$this->db->join('master_nationality mn', 'interview.nationality = mn.id', 'left');
        // ---------------------------------------------------------
        // Prepare visible columns for search
        // ---------------------------------------------------------
        $searchableColumns = array_map(function ($col) {

            if (stripos($col, ' AS ') !== false) return explode(' AS ', $col)[0];
            if (strpos($col, '(') !== false) return $col;

            if (strpos($col, 'interview.') === 0 ||
                strpos($col, 'pos.') === 0 ||
                strpos($col, 'mp.') === 0 ||
				strpos($col, 'me.') === 0 ||
				strpos($col, 'mn.') === 0 ||
                strpos($col, 'mc.') === 0) {
                return $col;
            }

            // Short names mapping
            if ($col === 'position_applied') return 'pos.name';
            if ($col === 'city_name') return 'mc.city_name';
            if ($col === 'profession_name') return 'mp.profession_name';
			if ($col === 'nationality_name') return 'mn.name';
			if ($col === 'emp_no') return 'me.emp_no';

            return 'interview.' . $col;

        }, $visibleColumns);

        // ---------------------------------------------------------
        // Search across ALL visible columns
        // ---------------------------------------------------------
        if (!empty($search) && !empty($searchableColumns)) {
            $this->db->group_start();
            foreach ($searchableColumns as $col) {
                $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }

        // ---------------------------------------------------------
        // Filters
        // ---------------------------------------------------------
        if (!empty($applied_for)) {
            $this->db->where('interview.position_applied', $applied_for);
        }
        if (!empty($date_from)) {
            $this->db->where('interview.interview_date >=', date('Y-m-d', strtotime($date_from)));
        }
        if (!empty($date_to)) {
            $this->db->where('interview.interview_date <=', date('Y-m-d', strtotime($date_to)));
        }
        if (!empty($status)) {
            $this->db->where('interview.status', $status);
        }
        if (!empty($nationality)) {
            $this->db->where('interview.nationality', $nationality);
        }
        if (!empty($preferred_city)) {
            $this->db->where('interview.preferred_city', $preferred_city);
        }
        if (!empty($iqama_profession)) {
            $this->db->where('interview.iqama_profession', $iqama_profession);
        }
        if (!empty($no_of_transfer)) {
            $this->db->where('interview.no_of_transfer', $no_of_transfer);
        }
        if (!empty($has_driving_license)) {
            $this->db->where('interview.has_driving_license', $has_driving_license);
        }
        if (!empty($driving_license_type)) {
            $this->db->where('interview.driving_license_type', $driving_license_type);
        }
        if (!empty($driving_license_expiry_from)) {
            $this->db->where('interview.driving_license_expiry >=', date('Y-m-d', strtotime($driving_license_expiry_from)));
        }
        if (!empty($driving_license_expiry_to)) {
            $this->db->where('interview.driving_license_expiry <=', date('Y-m-d', strtotime($driving_license_expiry_to)));
        }
        if (!empty($arrival_date_from)) {
            $this->db->where('interview.arrival_date >=', date('Y-m-d', strtotime($arrival_date_from)));
        }
        if (!empty($arrival_date_to)) {
            $this->db->where('interview.arrival_date <=', date('Y-m-d', strtotime($arrival_date_to)));
        }

        // ---------------------------------------------------------
        // Clone query for total count
        // ---------------------------------------------------------
        $totalQuery = clone $this->db;
        $totalCount = $totalQuery->get()->num_rows();

        // ---------------------------------------------------------
        // Pagination
        // ---------------------------------------------------------
        $this->db->order_by('interview.interview_no', 'DESC');
        $this->db->limit($perPage, max(0, $start));

        $result = $this->db->get()->result_array();

        // ---------------------------------------------------------
        // Return
        // ---------------------------------------------------------
        return [
            'data' => $result,
            'available_columns' => $selectedColumns,
            'visible_columns' => $visibleColumns,
            'pagination' => [
                'total' => $totalCount,
                'per_page' => $perPage,
                'current_page' => ($start / $perPage) + 1
            ]
        ];
    }

    public function export_list(
        $search = '',
        $applied_for = null,
        $date_from = null,
        $date_to = null,
        $status = null,
        $nationality = null,
        $preferred_city = null,
        $iqama_profession = null,
        $no_of_transfer = null,
        $has_driving_license = null,
        $driving_license_type = null,
        $driving_license_expiry_from = null,
        $driving_license_expiry_to = null,
        $arrival_date_from = null,
        $arrival_date_to = null,
        $selectedIds = [],
        $column_type = 'visible_columns'
    ) {
        // -------------------------------------------------
        // User column preferences
        // -------------------------------------------------
        $userPreferences = $this->db->get_where('user_column_preferences', [
            'user_id' => $this->admin->getLoginEmpId(),
            'module_name' => 'interview_forms'
        ])->row();

        $allColumnKeys = [
            'id', 'interview_no', 'interview_date', 'position_applied', 'applicant_name', 'date_of_birth', 'mobile_number', 'email', 'nationality_name', 'city_name', 'iban_number', 'iqama_number', 'iqama_expiry', 'profession_name', 'huroob_status', 'no_of_transfer', 'has_driving_license', 'driving_license_number', 'driving_license_type', 'driving_license_expiry', 'arrival_date', 'has_hunger_station', 'has_jahez', 'has_keeta', 'has_noon', 'has_toyou', 'has_marsool', 'has_chefz', 'long_term_relation', 'transfer_sponsorship', 'recommendation', 'remarks', 'iqama_copy', 'driving_license_copy', 'iban_certificate', 'status', 'hired_date', 'emp_no', 'created_at', 'updated_at'
        ];

        $visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);
        $availableColumns = $allColumnKeys;

        // -------------------------------------------------
        // Column selection logic
        // -------------------------------------------------
        if ($column_type === 'all_columns' && !empty($availableColumns)) {
            $columns = $availableColumns;
        } else {
            $columns = $visibleColumns;
        }

        // Fallback
        if (empty($columns)) {
            $columns = [
                'interview_no',
                'interview_date',
                'applicant_name',
                'mobile_number',
                'email',
                'iqama_number',
                'iqama_expiry',
                'status',
                'remarks',
                'created_at'
            ];
        }

        // -------------------------------------------------
        // Prefix columns
        // -------------------------------------------------
        $selectColumns = array_map(function ($col) {

            if (stripos($col, ' AS ') !== false) return $col;

            if ($col === 'position_applied') {
                return 'pos.name AS position_applied';
            }

            if ($col === 'city_name') {
                return 'mc.city_name AS city_name';
            }

            if ($col === 'emp_no') {
                return 'me.emp_no AS emp_no';
            }
			
			if ($col === 'nationality_name') {
                return 'mn.name AS nationality_name';
            }

            if ($col === 'profession_name') {
                return 'mp.profession_name AS profession_name';
            }
            return 'interview.' . $col;

        }, $columns);

        // -------------------------------------------------
        // Query
        // -------------------------------------------------
        $this->db->select(implode(', ', $selectColumns), false);
        $this->db->from('interview_forms interview');
        $this->db->join('master_job_title pos', 'interview.position_applied = pos.id', 'left');
        $this->db->join('master_city mc', 'interview.preferred_city = mc.id', 'left');
        $this->db->join('master_profession mp', 'interview.iqama_profession = mp.id', 'left');
        $this->db->join('master_employee me', 'interview.added_by = me.id', 'left');
		$this->db->join('master_nationality mn', 'interview.nationality = mn.id', 'left');

        // -------------------------------------------------
        // Selected IDs (highest priority)
        // -------------------------------------------------
        if (!empty($selectedIds)) {
            $this->db->where_in('interview.id', $selectedIds);
        }
        // -------------------------------------------------
        // Prepare searchable columns (alias-safe)
        // -------------------------------------------------
        $searchableColumns = array_map(function ($col) {

            if (stripos($col, ' AS ') !== false) {
                return explode(' AS ', $col)[0];
            }

            if ($col === 'position_applied') {
                return 'pos.name';
            }

            if ($col === 'city_name') {
                return 'mc.city_name';
            }

            if ($col === 'profession_name') {
                return 'mp.profession_name';
            }

            if ($col === 'emp_no') {
                return 'me.emp_no';
            }
			
			if ($col === 'nationality_name') {
                return 'mn.name';
            }

            return 'interview.' . $col;

        }, $columns);

        // -------------------------------------------------
        // Search
        // -------------------------------------------------
        if (!empty($search) && !empty($searchableColumns)) {
            $this->db->group_start();
            foreach ($searchableColumns as $col) {
                $this->db->or_like($col, $search);
            }
            $this->db->group_end();
        }

        // -------------------------------------------------
        // Filters
        // -------------------------------------------------
        if (!empty($applied_for)) {
            $this->db->where('interview.position_applied', $applied_for);
        }

        if (!empty($date_from)) {
            $this->db->where('interview.interview_date >=', date('Y-m-d', strtotime($date_from)));
        }

        if (!empty($date_to)) {
            $this->db->where('interview.interview_date <=', date('Y-m-d', strtotime($date_to)));
        }

        if (!empty($status)) {
            $this->db->where('interview.status', $status);
        }
        if (!empty($nationality)) {
            $this->db->where('interview.nationality', $nationality);
        }
        if (!empty($preferred_city)) {
            $this->db->where('interview.preferred_city', $preferred_city);
        }
        if (!empty($iqama_profession)) {
            $this->db->where('interview.iqama_profession', $iqama_profession);
        }
        if (!empty($no_of_transfer)) {
            $this->db->where('interview.no_of_transfer', $no_of_transfer);
        }
        if (!empty($has_driving_license)) {
            $this->db->where('interview.has_driving_license', $has_driving_license);
        }
        if (!empty($driving_license_type)) {
            $this->db->where('interview.driving_license_type', $driving_license_type);
        }
        if (!empty($driving_license_expiry_from)) {
            $this->db->where('interview.driving_license_expiry >=', date('Y-m-d', strtotime($driving_license_expiry_from)));
        }
        if (!empty($driving_license_expiry_to)) {
            $this->db->where('interview.driving_license_expiry <=', date('Y-m-d', strtotime($driving_license_expiry_to)));
        }
        if (!empty($arrival_date_from)) {
            $this->db->where('interview.arrival_date >=', date('Y-m-d', strtotime($arrival_date_from)));
        }
        if (!empty($arrival_date_to)) {
            $this->db->where('interview.arrival_date <=', date('Y-m-d', strtotime($arrival_date_to)));
        }

        $this->db->order_by('interview.interview_no', 'DESC');
        $data = $this->db->get()->result_array();

        // -------------------------------------------------
        // Clean headers (alias-safe)
        // -------------------------------------------------
        $headers = [];
        foreach ($columns as $col) {
            if (stripos($col, ' AS ') !== false) {
                $headers[] = trim(explode(' AS ', $col)[1]);
            } else {
                $headers[] = $col;
            }
        }

        return [
            'headers' => $headers,
            'data' => $data
        ];
    }
	
	function get_detail($id){
		$query = $this->db->query("SELECT interview.*, pos.name as pos_name, pos.arabic_name as arabic_pos_name, mc.city_name, mp.profession_name, me.emp_no as added_by_emp_no, mn.name as nationality_name, mn.arabic_name as nationality_arabic_name FROM interview_forms interview LEFT JOIN master_job_title pos ON (interview.position_applied = pos.id) LEFT JOIN master_city mc ON (interview.preferred_city = mc.id) LEFT JOIN master_profession mp ON (interview.iqama_profession = mp.id) LEFT JOIN master_employee me ON (interview.added_by = me.id) LEFT JOIN master_nationality mn ON (interview.nationality = mn.id) WHERE interview.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM interview_forms WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

}
