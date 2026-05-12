<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Report_model extends CI_Model
{
    public function verifiedRiderList()
    {
        $this->db->select("*");
        $this->db->from('delivery_vehicles');
        $this->db->where('partner_id =', (int)$this->logistic->getId());
        $this->db->where('application_status =', 'verified');
        $query = $this->db->get();
        return $query->result();
    }
}
