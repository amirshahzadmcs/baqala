<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inhouse_van_model extends CI_Model
{

    public function add($hashpassword)
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO delivery_vehicles SET 
            region_id = '" . $this->input->post('region_id') . "',
			city = '" . $this->db->escape_str($this->input->post('city')) . "',
			district = '" . $this->db->escape_str($this->input->post('district')) . "',
			arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', 
			name = '" . $this->db->escape_str($this->input->post('name')) . "', 
			rider_type = 'Inhouse', 
			application_status = 'verified', 
            email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "',
            nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "',
            profession = '" . $this->db->escape_str($this->input->post('profession')) . "',
            doj = '" . $this->db->escape_str($this->input->post('doj')) . "',
            partner_id = '" . $this->db->escape_str($this->input->post('partner_id')) . "',
            service_area = '" . $this->db->escape_str($this->input->post('service_area')) . "',
			iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', 
			iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "',
			dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "',
			dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "',
            status = '" . (int) $this->input->post('status') . "',
            block_reason = '" . $this->db->escape_str($this->input->post('block_reason')) . "',

            service_type = 'car', 
            van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', 
            vehicle_expiry = '" . $this->db->escape_str($this->input->post('vehicle_expiry')) . "',
            vehicle_year = '" . $this->db->escape_str($this->input->post('vehicle_year')) . "',  
            van_color = '" . $this->db->escape_str($this->input->post('van_color')) . "',  
            van_make = '" . $this->db->escape_str($this->input->post('van_make')) . "', 
            van_model = '" . $this->db->escape_str($this->input->post('van_model')) . "',

            password = '" . $hashpassword . "',
			created_at = '" . $created_at ."', 
			updated_at = '" . $created_at ."', 
			ip = '" . $this->input->ip_address() . "'"
        );
        $insert_id = $this->db->insert_id();
        if($query){
            $cust_account_no = $insert_id + 100;
            $final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
            $this->db->query("UPDATE delivery_vehicles SET driver_id = '" . $final_account_no . "', profile_info_status = '1' WHERE id = '" . (int)$insert_id . "'");
            $this->db->query("INSERT INTO delivery_boy_documents SET deliveryboy_id = '" . (int)$insert_id . "', created_at = '" . $created_at . "', status = '0'");
            $this->db->query("INSERT INTO deliveryvehicle_salary SET deliveryboy_id = '" . (int)$insert_id . "', created_at = '" . $created_at . "'");
        }
        $this->db->trans_complete();
        return $query;
    }

    public function update()
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
        $cust_account_no = (int)$this->input->post('id') + 100;
		$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
        $query = $this->db->query("UPDATE delivery_vehicles SET 
            driver_id = '" . $final_account_no . "',
            region_id = '" . $this->input->post('region_id') . "',
            city = '" . $this->db->escape_str($this->input->post('city')) . "',
            district = '" . $this->db->escape_str($this->input->post('district')) . "',
            arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', 
            name = '" . $this->db->escape_str($this->input->post('name')) . "', 
            rider_type = 'Inhouse',
            application_status = 'verified',
            email = '" . $this->db->escape_str($this->input->post('email')) . "', 
            mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "',
            nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "',
            profession = '" . $this->db->escape_str($this->input->post('profession')) . "',
            doj = '" . $this->db->escape_str($this->input->post('doj')) . "',
            partner_id = '" . $this->db->escape_str($this->input->post('partner_id')) . "',
            service_area = '" . $this->db->escape_str($this->input->post('service_area')) . "',
            iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', 
            dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "',
            iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "',
            status = '" . (int) $this->input->post('status') . "',
            block_reason = '" . $this->db->escape_str($this->input->post('block_reason')) . "',

            service_type = 'car', 
            van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', 
            vehicle_expiry = '" . $this->db->escape_str($this->input->post('vehicle_expiry')) . "',
            vehicle_year = '" . $this->db->escape_str($this->input->post('vehicle_year')) . "',  
            van_color = '" . $this->db->escape_str($this->input->post('van_color')) . "',  
            van_make = '" . $this->db->escape_str($this->input->post('van_make')) . "', 
            van_model = '" . $this->db->escape_str($this->input->post('van_model')) . "', 

            created_at = '" . $created_at ."', 
            updated_at = '" . $created_at ."', 
            ip = '" . $this->input->ip_address() . "' 
            WHERE id = '" . (int)$this->input->post('id') . "' LIMIT 1"
        );
        $this->db->trans_complete();
        return $query;
    }

    public function change_password($hashpassword)
    {
        //echo $this->input->post('status');exit();
        $query = $this->db->query("UPDATE delivery_vehicles SET password = '" . $hashpassword . "', updated_at = NOW(), ip = '" . $this->input->ip_address() . "' WHERE id = '" . (int) $this->input->post('id') . "' LIMIT 1");
        return $query;
    }

    public function get_detail($id)
    {
        $query = $this->db->query("SELECT db.*, mc.color_name, mp.profession_name, mvk.make_name, sa.area_name, dp.company_name as logistic_partner FROM delivery_vehicles db LEFT JOIN master_color mc ON (mc.id = db.van_color) LEFT JOIN master_profession mp ON (mp.id = db.profession) LEFT JOIN mater_van_make mvk ON (mvk.id = db.van_make) LEFT JOIN service_area sa ON (sa.id = db.service_area) LEFT JOIN delivery_partner dp ON (db.partner_id = dp.id) WHERE db.id = '" . (int) $id . "' AND rider_type = 'Inhouse'");
        return $query;
    }
    
    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM delivery_vehicles WHERE id IN (" . $id . ")");
        $query = $this->db->query("DELETE FROM deliveryvehicle_salary WHERE deliveryboy_id IN (" . $id . ")");
        $query = $this->db->query("DELETE FROM delivery_boy_documents WHERE deliveryboy_id IN (" . $id . ")");
        return $query;
    }

    public function make_query()
    {
        $a = "SELECT db.*, (SELECT IF(lp.id > 0, lp.company_name, 'N/A') FROM delivery_partner lp WHERE db.partner_id = lp.id) as partner_name FROM delivery_vehicles db WHERE rider_type = 'Inhouse' AND service_type = 'car'";
        return $a;
    }
    
    public function get_list()
    {
        $a = $this->make_query();
        if (isset($_POST["search"]["value"])) {
            $a .= " AND (db.name LIKE '%" . $_POST["search"]["value"] . "%' OR db.van_no LIKE '%" . $_POST["search"]["value"] . "%')";
        }
        if (isset($_POST["order"])) {
            $a .= " ORDER BY db.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY db.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    public function get_filtered_data()
    {
        $a = $this->make_query();
        $query = $this->db->query($a);
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from('delivery_vehicles');
        $this->db->where('rider_type =', 'Inhouse');
        return $this->db->count_all_results();
    }
}
