<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sim_allot_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO sim_allot SET allotment_date = '" . $this->db->escape_str($this->input->post('allotment_date')) . "', sim_no = '" . $this->db->escape_str($this->input->post('sim_no')) . "', user_no = '" . $this->db->escape_str($this->input->post('user_no')) . "', user_type = '" . $this->db->escape_str($this->input->post('user_type')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', table_name = '" . $this->db->escape_str($this->input->post('table_name')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE sim_allot SET allotment_date = '" . $this->db->escape_str($this->input->post('allotment_date')) . "', sim_no = '" . $this->db->escape_str($this->input->post('sim_no')) . "', user_no = '" . $this->db->escape_str($this->input->post('user_no')) . "', user_type = '" . $this->db->escape_str($this->input->post('user_type')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', table_name = '" . $this->db->escape_str($this->input->post('table_name')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function make_query($status,$sim_type,$user_type,$sim_network)
    {
        $a = "SELECT allot.*,sim.sim_type,sim.network, net.network_name, dv.name as username FROM sim_allot as allot LEFT JOIN sim_card as sim ON (sim.mobile = allot.sim_no) LEFT JOIN master_network as net ON (net.id = sim.network) LEFT JOIN delivery_vehicles dv ON (dv.id = allot.user_no) WHERE 1=1";
		if($status){
			if($status == 'yes'){
				$a .= " AND allot.status = '1'";
			}else{
				$a .= " AND allot.status = '0'";
			}
		}
		if($user_type){
			$a .= " AND allot.user_type = '" . $user_type . "'";
		}
		if($sim_type){
			$a .= " AND sim.sim_type = '" . $sim_type . "'";
		}
		if($sim_network){
			$a .= " AND sim.network = '" . $sim_network . "'";
		}
        return $a;
    }
    
    public function get_list($status,$sim_type,$user_type,$sim_network)
    {
        $a = $this->make_query($status,$sim_type,$user_type,$sim_network);
        if (isset($_POST["search"]["value"])) {
            $a .= " AND dv.name LIKE '%" . $_POST["search"]["value"] . "%' OR allot.sim_no LIKE '%" . $_POST["search"]["value"] . "%'";
        }
        
        if (isset($_POST["order"])) {
            $a .= " ORDER BY dv.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY allot.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    public function get_filtered_data($status,$sim_type,$user_type,$sim_network)
    {
        $a = $this->make_query($status,$sim_type,$user_type,$sim_network);
        $query = $this->db->query($a);
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from('sim_allot');
        return $this->db->count_all_results();
    }

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM sim_allot WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM sim_allot WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	public function get_plan($id)
	{
		$query = $this->db->query("SELECT id, plan_name FROM master_plans WHERE network_id = '". (int)$id ."' AND status = '1'");
		return $query->result();
	}
	
	public function simLogs()
	{
		$query = $this->db->query("INSERT INTO sim_logs SET allotment_date = '" . $this->db->escape_str($this->input->post('allotment_date')) . "', sim_no = '" . $this->db->escape_str($this->input->post('sim_no')) . "', user_name = '" . $this->db->escape_str($this->input->post('user_no')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	public function getLogs($id)
	{
		$query = $this->db->query("SELECT * FROM sim_logs WHERE sim_no = '" . $id . "'");
		return $query->result();
	}
	
}
