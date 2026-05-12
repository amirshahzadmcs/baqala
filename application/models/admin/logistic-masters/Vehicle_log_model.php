<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vehicle_log_model extends CI_Model
{
    /*---- All Log ------*/

    /**
     * Apply filters to SQL query
     */
    private function apply_filters($sql, $filters = [])
    {
        if (!empty($filters['vehicle_no'])) {
            $sql .= " AND v.vehicle_no LIKE '%" . $this->db->escape_str($filters['vehicle_no']) . "%'";
        }
        if (!empty($filters['sequel_no'])) {
            $sql .= " AND v.sequel_no LIKE '%" . $this->db->escape_str($filters['sequel_no']) . "%'";
        }
        if (!empty($filters['vehicle_type'])) {
            $sql .= " AND v.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
        }
        if (!empty($filters['vehicle_make'])) {
            $sql .= " AND v.vehicle_make = " . $this->db->escape($filters['vehicle_make']);
        }
        if (!empty($filters['vehicle_model'])) {
            $sql .= " AND v.vehicle_model = " . $this->db->escape($filters['vehicle_model']);
        }
        if (!empty($filters['vehicle_color'])) {
            $sql .= " AND v.vehicle_color = " . $this->db->escape($filters['vehicle_color']);
        }
        if (!empty($filters['vehicle_year'])) {
            $sql .= " AND v.vehicle_year = " . $this->db->escape($filters['vehicle_year']);
        }
        if (!empty($filters['status'])) {
            $sql .= " AND v.status = " . $this->db->escape($filters['status']);
        }
        if (!empty($filters['alloted_user'])) {
            $sql .= " AND e.id = " . $this->db->escape($filters['alloted_user']);
        }
        if (!empty($filters['vehicle_ownership'])) {
            $sql .= " AND v.vehicle_ownership = " . $this->db->escape($filters['vehicle_ownership']);
        }
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $sql .= " AND DATE(allot.status_date) BETWEEN " .
                $this->db->escape($filters['from_date']) . " AND " .
                $this->db->escape($filters['to_date']);
        }
        return $sql;
    }

    // Build base query
    private function make_query($filters = [])
    {
        $sql = "
            SELECT 
                allot.*,
                v.vehicle_no,
                v.vehicle_type,
                v.vehicle_model,
                v.chassis_no,
                v.sequel_no,
                v.vehicle_year,
                v.status,
                v.vehicle_ownership,
                v.tamm_attachment,
                vm.make_name AS vehicle_make_name,
                mc.color_name AS vehicle_color_name,
                e.emp_no,
                e.full_name,
                e.iqama_no,
                mjt.name AS designation_name,
                md.name AS department_name,
                ml.parking_name 
            FROM vehicle_log allot 
            LEFT JOIN master_vehicles v ON allot.vehicle_id = v.id
            LEFT JOIN master_parkings ml ON (allot.location = ml.id) 
            LEFT JOIN mater_van_make vm ON v.vehicle_make = vm.id
            LEFT JOIN master_color mc ON v.vehicle_color = mc.id
            LEFT JOIN master_employee e ON allot.rider_id = e.id
            LEFT JOIN master_department md ON e.department = md.id
            LEFT JOIN master_job_title mjt ON e.designation = mjt.id
            WHERE 1=1
        ";

        // Apply filters
        $sql = $this->apply_filters($sql, $filters);

        return $sql;
    }

    // Fetch paginated data
    public function get_datatables($filters = [])
    {
        $query = $this->make_query($filters);

        // Search
        if (!empty($_POST['search']['value'])) {
            $search = $this->db->escape_like_str($_POST['search']['value']);
            $query .= " AND (e.full_name LIKE '%$search%' OR v.vehicle_no LIKE '%$search%')";
        }

        // Order
        if (isset($_POST['order'])) {
            $query .= " ORDER BY allot.id " . $_POST['order'][0]['dir'];
        } else {
            $query .= " ORDER BY allot.id DESC";
        }

        // Limit
        if ($_POST['length'] != -1) {
            $query .= " LIMIT " . intval($_POST['start']) . ", " . intval($_POST['length']);
        }

        return $this->db->query($query)->result_array();
    }

    // Count after filter
    public function count_filtered($filters = [])
    {
        $query = $this->make_query($filters);

        if (!empty($_POST['search']['value'])) {
            $search = $this->db->escape_like_str($_POST['search']['value']);
            $query .= " AND (e.full_name LIKE '%$search%' OR v.vehicle_no LIKE '%$search%')";
        }

        return $this->db->query($query)->num_rows();
    }

    // Count total
    public function count_all($filters = [])
    {
        $query = $this->make_query($filters);
        return $this->db->query($query)->num_rows();
    }

    public function vehicle_wise_log($vehicle_no)
    {
        $query = $this->db->query("SELECt vl.*, me.id as emp_id, me.emp_no, me.full_name, mjt.name as pos_name, mv.vehicle_no, ml.parking_name FROM vehicle_log vl LEFT JOIN master_employee me ON (vl.rider_id = me.id) LEFT JOIN master_job_title mjt ON (me.designation = mjt.id) LEFT JOIN master_vehicles mv ON (vl.vehicle_id = mv.id) LEFT JOIN master_parkings ml ON (vl.location = ml.id) WHERE vl.vehicle_id = '". $vehicle_no ."' ORDER BY vl.id DESC");
        return $query->result_array();
    }
	
	public function employee_wise_log($emp_id)
    {
        $query = $this->db->query("SELECt vl.*, mv.vehicle_no, mv.vehicle_type, mv.vehicle_model, mv.chassis_no, mv.sequel_no, mc.color_name, mvk.make_name, ml.parking_name FROM vehicle_log vl LEFT JOIN master_vehicles mv ON (vl.vehicle_id = mv.id) LEFT JOIN master_color mc ON (mc.id = mv.vehicle_color) LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_parkings ml ON (vl.location = ml.id) WHERE vl.rider_id = '". $emp_id ."' ORDER BY vl.id DESC");
        return $query->result_array();
    }

    private function get_filter_conditions($filters = [])
    {
        $conditions = '';

        if (!empty($filters['vehicle_no'])) {
            $conditions .= " AND v.vehicle_no LIKE '%" . $this->db->escape_str($filters['vehicle_no']) . "%'";
        }
        if (!empty($filters['sequel_no'])) {
            $conditions .= " AND v.sequel_no LIKE '%" . $this->db->escape_str($filters['sequel_no']) . "%'";
        }
        if (!empty($filters['vehicle_type'])) {
            $conditions .= " AND v.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
        }
        if (!empty($filters['vehicle_make'])) {
            $conditions .= " AND v.vehicle_make = " . $this->db->escape($filters['vehicle_make']);
        }
        if (!empty($filters['vehicle_model'])) {
            $conditions .= " AND v.vehicle_model = " . $this->db->escape($filters['vehicle_model']);
        }
        if (!empty($filters['vehicle_color'])) {
            $conditions .= " AND v.vehicle_color = " . $this->db->escape($filters['vehicle_color']);
        }
        if (!empty($filters['vehicle_year'])) {
            $conditions .= " AND v.vehicle_year = " . $this->db->escape($filters['vehicle_year']);
        }
        if (!empty($filters['status'])) {
            $conditions .= " AND v.status = " . $this->db->escape($filters['status']);
        }
        if (!empty($filters['alloted_user'])) {
            $conditions .= " AND e.id = " . $this->db->escape($filters['alloted_user']);
        }
        if (!empty($filters['vehicle_ownership'])) {
            $conditions .= " AND v.vehicle_ownership = " . $this->db->escape($filters['vehicle_ownership']);
        }
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $conditions .= " AND DATE(allot.status_date) BETWEEN " .
                $this->db->escape($filters['from_date']) . " AND " .
                $this->db->escape($filters['to_date']);
        }

        return $conditions;
    }

    public function get_vehicle_allotment_report($filters = [])
    {
        $sql = "
            SELECT 
                v.vehicle_no,
                v.vehicle_type,
                v.vehicle_model,
                v.chassis_no,
                v.sequel_no,
                v.vehicle_year,
                v.status,
                v.vehicle_ownership,
                v.tamm_attachment,
                vm.make_name as vehicle_make_name,
                mc.color_name as vehicle_color_name,
                e.emp_no,
                e.full_name,
                e.iqama_no,
                mjt.name AS designation_name,
                md.name AS department_name,
                allot.status_date AS allot_date,
                unallot.status_date AS unallot_date,
                allot.remarks,
                ml.parking_name 
            FROM vehicle_log allot
            LEFT JOIN vehicle_log unallot 
                ON unallot.vehicle_id = allot.vehicle_id 
                AND unallot.rider_id = allot.rider_id
                AND unallot.log_status = 'unalloted'
                AND unallot.id > allot.id
            LEFT JOIN master_vehicles v ON allot.vehicle_id = v.id 
            LEFT JOIN master_parkings ml ON (allot.location = ml.id) 
            LEFT JOIN mater_van_make vm ON v.vehicle_make = vm.id
            LEFT JOIN master_color mc ON v.vehicle_color = mc.id
            LEFT JOIN master_employee e ON allot.rider_id = e.id
            LEFT JOIN master_department md ON (e.department = md.id)
            LEFT JOIN master_job_title mjt ON (e.designation = mjt.id)
            WHERE allot.log_status = 'alloted'
        ";

        // Append reusable conditions
        $sql .= $this->get_filter_conditions($filters);

        $sql .= " GROUP BY allot.id ORDER BY allot.status_date DESC";

        return $this->db->query($sql)->result_array();
    }

}
