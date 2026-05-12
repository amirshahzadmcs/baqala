<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Sdp_model extends CI_Model
{
	public function sdp_report()
    {
		$a = "SELECT dv.* FROM delivery_vehicles dv WHERE dv.partner_id = '". (int)$this->logistic->getId() ."' AND dv.application_status = 'verified'";
        if (isset($_POST["search"]["value"])) {
            $a .= " AND (dv.name LIKE '%" . $_POST["search"]["value"] . "%' OR dv.mobile LIKE '%" . $_POST["search"]["value"] . "%')";
        }
        if (isset($_POST["order"])) {
            $a .= " ORDER BY dv.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY dv.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    public function filter_sdp_report()
    {
        $a = "SELECT dv.* FROM delivery_vehicles dv WHERE dv.partner_id = '". (int)$this->logistic->getId() ."' AND dv.application_status = 'verified'";
        if (isset($_POST["search"]["value"])) {
            $a .= " AND (dv.name LIKE '%" . $_POST["search"]["value"] . "%' OR dv.mobile LIKE '%" . $_POST["search"]["value"] . "%')";
        }
        if (isset($_POST["order"])) {
            $a .= " ORDER BY dv.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY dv.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->num_rows();
    }

    public function all_sdp_report()
    {
        $this->db->select("*");
        $this->db->from('delivery_vehicles');
        $this->db->where('partner_id =', (int)$this->logistic->getId());
        $this->db->where('application_status =', 'verified');
        return $this->db->count_all_results();
    }
}
