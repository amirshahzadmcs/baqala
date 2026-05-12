<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jahez_rent_model extends CI_Model {

    protected $table = 'jahez_rent';

    // ---------------------------------------------------------
    // Insert
    // ---------------------------------------------------------
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // ---------------------------------------------------------
    // Update
    // ---------------------------------------------------------
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // ---------------------------------------------------------
    // List with search + pagination + city name join
    // ---------------------------------------------------------
    public function list($search = '', $perPage = 50, $start = 0, $date_from = null, $date_to = null)
    {
        $this->db->select('
            jr.id, jr.agreement_no, jr.agreement_date,
            jr.name, jr.iqama_no, jr.city, mc.city_name,
            jr.mobile_no, jr.email_id,
            me.emp_no AS added_by_name,
            jr.created_at, jr.updated_at
        ');
        $this->db->from($this->table . ' jr');
        $this->db->join('master_city mc', 'jr.city = mc.id', 'left');
        $this->db->join('master_employee me', 'jr.added_by = me.id', 'left');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('jr.agreement_no', $search);
            $this->db->or_like('jr.name', $search);
            $this->db->or_like('jr.iqama_no', $search);
            $this->db->or_like('mc.city_name', $search);
            $this->db->or_like('jr.mobile_no', $search);
            $this->db->or_like('jr.email_id', $search);
            $this->db->or_like('me.emp_no', $search);
            $this->db->group_end();
        }

        if (!empty($date_from) && !empty($date_to)) {
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $date_from)));
            $to   = date('Y-m-d', strtotime(str_replace('/', '-', $date_to)));
            $this->db->where("jr.agreement_date BETWEEN '$from' AND '$to'");
        }

        $totalQuery = clone $this->db;
        $totalCount = $totalQuery->get()->num_rows();

        $this->db->order_by('jr.id', 'DESC');
        $this->db->limit($perPage, $start);

        $result = $this->db->get()->result_array();

        return [
            'data' => $result,
            'pagination' => [
                'total' => $totalCount,
                'per_page' => $perPage,
                'current_page' => ($start / $perPage) + 1
            ]
        ];
    }

    // ---------------------------------------------------------
    // Single record with city name
    // ---------------------------------------------------------
    public function get_detail($id)
    {
        $this->db->select('jr.*, mc.city_name');
        $this->db->from($this->table . ' jr');
        $this->db->join('master_city mc', 'jr.city = mc.id', 'left');
        $this->db->where('jr.id', $id);

        return $this->db->get()->row();
    }

    // ---------------------------------------------------------
    // Delete one or multiple IDs
    // ---------------------------------------------------------
    public function delete($ids = [])
    {
        if (empty($ids)) return false;
        return $this->db->where_in('id', $ids)->delete($this->table);
    }
}
