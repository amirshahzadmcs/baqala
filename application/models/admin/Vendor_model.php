<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_model extends CI_Model{

	function add(){
		$con['upload_path']   = './uploads/vendor_doc/'; 
		$con['allowed_types'] = 'pdf|docx|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
		
		$query = $this->db->query("INSERT INTO vendors SET vendor_name = '" . $this->db->escape_str($this->input->post('vendor_name')) . "', vendor_arabic_name = '" . $this->db->escape_str($this->input->post('vendor_arabic_name')) . "', contact_person_name = '" . $this->db->escape_str($this->input->post('contact_person_name')) . "', vendor_type = '" . $this->db->escape_str($this->input->post('vendor_type')) . "', spare_part_supplier = '" . $this->db->escape_str($this->input->post('spare_part_supplier')) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', telephone = '" . $this->db->escape_str($this->input->post('telephone')) . "', vendor_email = '" . $this->db->escape_str($this->input->post('vendor_email')) . "', fax = '" . $this->db->escape_str($this->input->post('fax')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', payment_terms = '" . $this->db->escape_str($this->input->post('payment_terms')) . "', order_currency = '" . $this->db->escape_str($this->input->post('order_currency')) . "', credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', avl_credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', status = 1, created_at = NOW(), updated_at = now()");
		$vendor_id = $this->db->insert_id();
		
		// Check if there are multiple payment sections
		$account_holder_names = $this->input->post('account_holder_name');
		$bank_account_nos = $this->input->post('bank_account_no');
		$iban_numbers = $this->input->post('iban_number');
		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$region = $this->input->post('region');
		$account_currency = $this->input->post('account_currency');
		$swift_code = $this->input->post('swift_code');
		$bank_city = $this->input->post('bank_city');

		if ($vendor_id &&  isset($_POST['account_holder_name']) && is_array($_POST['account_holder_name'])) {
			$batch_data = []; // Initialize an empty array for batch data
		
			foreach ($account_holder_names as $index => $account_holder_name) {
				$batch_data[] = [
					'vendor_id' => $vendor_id,
					'account_holder_name' => $account_holder_name, // Corrected indexing
					'bank_account_no' => $bank_account_nos[$index],
					'iban_number' => $iban_numbers[$index],
					'bank_name' => $bank_name[$index],
					'branch_name' => $branch_name[$index],
					'region' => $region[$index],
					'account_currency' => $account_currency[$index],
					'swift_code' => $swift_code[$index],
					'bank_city' => $bank_city[$index],
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
			}
		
			// Perform the batch insert
			$this->Vendor_model->add_payment_info_batch($batch_data);
		}		

		if($vendor_id){
			if($_FILES['cr_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('cr_certificate');
				$image_data1 = $this->upload->data();
				$cr_certificate = "uploads/vendor_doc/".$image_data1['file_name'];
			}
			else{
				$cr_certificate = "";
			}
			
			if($_FILES['vat_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('vat_certificate');
				$image_data2 = $this->upload->data();
				$vat_certificate = "uploads/vendor_doc/".$image_data2['file_name'];
			}
			else{
				$vat_certificate = "";
			}
			
			if($_FILES['national_address']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('national_address');
				$image_data3 = $this->upload->data();
				$national_address = "uploads/vendor_doc/".$image_data3['file_name'];
			}
			else{
				$national_address = "";
			}
			
			if($_FILES['iban_letter']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('iban_letter');
				$image_data4 = $this->upload->data();
				$iban_letter = "uploads/vendor_doc/".$image_data4['file_name'];
			}
			else{
				$iban_letter = "";
			}
			
			if($_FILES['credit_agreements']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('credit_agreements');
				$image_data5 = $this->upload->data();
				$credit_agreements = "uploads/vendor_doc/".$image_data5['file_name'];
			}
			else{
				$credit_agreements = "";
			}
			
			if($_FILES['authorization']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorization');
				$image_data6 = $this->upload->data();
				$authorization = "uploads/vendor_doc/".$image_data6['file_name'];
			}
			else{
				$authorization = "";
			}
			$query2 = $this->db->query("INSERT INTO vendor_docs SET vendor_id = '" . $this->db->escape_str((int)$vendor_id) . "', cr_certificate = '" . $this->db->escape_str($cr_certificate) . "', vat_certificate = '" . $this->db->escape_str($vat_certificate) . "', national_address = '" . $this->db->escape_str($national_address) . "', iban_letter = '" . $this->db->escape_str($iban_letter) . "', credit_agreements = '" . $this->db->escape_str($credit_agreements) . "', authorization = '" . $this->db->escape_str($authorization) . "', created_at =  NOW(), updated_at = NOW()");
		}
		return $query;
	}

	public function add_payment_info_batch($batch_data) {
		if (!empty($batch_data)) {
			$this->db->insert_batch('vendor_bank_account', $batch_data);
		}
	}
	
	function edit(){
		$con['upload_path']   = './uploads/vendor_doc/'; 
		$con['allowed_types'] = 'pdf|docx|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
		
		$query = $this->db->query("UPDATE vendors SET vendor_name = '" . $this->db->escape_str($this->input->post('vendor_name')) . "', vendor_arabic_name = '" . $this->db->escape_str($this->input->post('vendor_arabic_name')) . "', contact_person_name = '" . $this->db->escape_str($this->input->post('contact_person_name')) . "', vendor_type = '" . $this->db->escape_str($this->input->post('vendor_type')) . "', spare_part_supplier = '" . $this->db->escape_str($this->input->post('spare_part_supplier')) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', telephone = '" . $this->db->escape_str($this->input->post('telephone')) . "', vendor_email = '" . $this->db->escape_str($this->input->post('vendor_email')) . "', fax = '" . $this->db->escape_str($this->input->post('fax')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', payment_terms = '" . $this->db->escape_str($this->input->post('payment_terms')) . "', order_currency = '" . $this->db->escape_str($this->input->post('order_currency')) . "', credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', status = 1, updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		
		// Check if there are multiple payment sections
		$account_holder_names = $this->input->post('account_holder_name');
		$bank_account_nos = $this->input->post('bank_account_no');
		$iban_numbers = $this->input->post('iban_number');
		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$region = $this->input->post('region');
		$account_currency = $this->input->post('account_currency');
		$swift_code = $this->input->post('swift_code');
		$bank_city = $this->input->post('bank_city');

		$vendor_id = $this->input->post('id');
		if($vendor_id !== ''){
			$this->db->query("DELETE FROM vendor_bank_account WHERE vendor_id = '" . (int)$vendor_id . "'");
			if ($vendor_id &&  isset($_POST['account_holder_name']) && is_array($_POST['account_holder_name'])) {
				$batch_data = []; // Initialize an empty array for batch data
			
				foreach ($account_holder_names as $index => $account_holder_name) {
					$batch_data[] = [
						'vendor_id' => $vendor_id,
						'account_holder_name' => $account_holder_name, // Corrected indexing
						'bank_account_no' => $bank_account_nos[$index],
						'iban_number' => $iban_numbers[$index],
						'bank_name' => $bank_name[$index],
						'branch_name' => $branch_name[$index],
						'region' => $region[$index],
						'account_currency' => $account_currency[$index],
						'swift_code' => $swift_code[$index],
						'bank_city' => $bank_city[$index],
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					];
				}
			
				// Perform the batch insert
				$this->Vendor_model->add_payment_info_batch($batch_data);
			}
		}
		
		$this->db->query("DELETE FROM vendor_docs WHERE vendor_id = '" . (int)$this->input->post('id') . "'");
		if($this->input->post('id') !== ''){
			if($_FILES['cr_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('cr_certificate');
				$image_data1 = $this->upload->data();
				$cr_certificate = "uploads/vendor_doc/".$image_data1['file_name'];
			}
			else{
				$cr_certificate = $this->input->post('old_cr_certificate');
			}
			
			if($_FILES['vat_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('vat_certificate');
				$image_data2 = $this->upload->data();
				$vat_certificate = "uploads/vendor_doc/".$image_data2['file_name'];
			}
			else{
				$vat_certificate = $this->input->post('old_vat_certificate');
			}
			
			if($_FILES['national_address']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('national_address');
				$image_data3 = $this->upload->data();
				$national_address = "uploads/vendor_doc/".$image_data3['file_name'];
			}
			else{
				$national_address = $this->input->post('old_national_address');
			}
			
			if($_FILES['iban_letter']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('iban_letter');
				$image_data4 = $this->upload->data();
				$iban_letter = "uploads/vendor_doc/".$image_data4['file_name'];
			}
			else{
				$iban_letter = $this->input->post('old_iban_letter');
			}
			
			if($_FILES['credit_agreements']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('credit_agreements');
				$image_data5 = $this->upload->data();
				$credit_agreements = "uploads/vendor_doc/".$image_data5['file_name'];
			}
			else{
				$credit_agreements = $this->input->post('old_credit_agreements');
			}
			
			if($_FILES['authorization']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorization');
				$image_data6 = $this->upload->data();
				$authorization = "uploads/vendor_doc/".$image_data6['file_name'];
			}
			else{
				$authorization = $this->input->post('old_authorization');
			}
			$query2 = $this->db->query("INSERT INTO vendor_docs SET vendor_id = '" . $this->db->escape_str((int)$this->input->post('id')) . "', cr_certificate = '" . $this->db->escape_str($cr_certificate) . "', vat_certificate = '" . $this->db->escape_str($vat_certificate) . "', national_address = '" . $this->db->escape_str($national_address) . "', iban_letter = '" . $this->db->escape_str($iban_letter) . "', credit_agreements = '" . $this->db->escape_str($credit_agreements) . "', authorization = '" . $this->db->escape_str($authorization) . "', created_at =  NOW(), updated_at = NOW()");
		}
		return $query;
	}
	
	function make_query(){
		$a = "SELECT v.*, (SELECT vba.iban_number FROM vendor_bank_account vba WHERE v.id = vba.vendor_id LIMIT 1) AS iban_number, (select count(po.id) from purchase_order po where po.vendor_id = v.id) as total_orders, (select sum(po.total) from purchase_order po where po.vendor_id = v.id) as total_order_value FROM vendors v WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if (isset($_POST["search"]["value"])) {
			$a .= " AND (v.vendor_name LIKE '%" . $this->db->escape_like_str($_POST["search"]["value"]) . "%' 
						   OR (SELECT vba.iban_number FROM vendor_bank_account vba WHERE v.id = vba.vendor_id LIMIT 1) LIKE '%" . $this->db->escape_like_str($_POST["search"]["value"]) . "%')";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY v.vendor_name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY v.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data(){
	   	$a = $this->make_query();
	   	if (isset($_POST["search"]["value"])) {
			$a .= " AND (v.vendor_name LIKE '%" . $this->db->escape_like_str($_POST["search"]["value"]) . "%' 
						   OR (SELECT vba.iban_number FROM vendor_bank_account vba WHERE v.id = vba.vendor_id LIMIT 1) LIKE '%" . $this->db->escape_like_str($_POST["search"]["value"]) . "%')";
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('vendors');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM vendors WHERE id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM vendor_docs WHERE vendor_id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM vendor_bank_account WHERE vendor_id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	function get_vendor_by_id($id){
		$query = $this->db->query("SELECT * FROM vendors WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_order_by_vendor($id){
		$query = $this->db->query("SELECT p.*, v.vendor_name, v.building_no, v.street_name, v.district, v.city, v.country, v.postal_code, v.alternate_no, v.vat_number FROM purchase_order p LEFT JOIN vendors v ON(v.id = p.vendor_id) WHERE p.vendor_id = '" . (int)$id . "'");
		return $query->row();
	}
	
	public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE vendors SET status = '1' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE vendors SET status = '0' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	function vendor_documents($id){
		$query = $this->db->query("SELECT * FROM vendor_docs WHERE vendor_id = '" . $id . "'");
		return $query->row();
	}
	
	function vendor_bank_account($id){
		$query = $this->db->query("SELECT * FROM vendor_bank_account WHERE vendor_id = '" . $id . "'");
		return $query->result_array();
	}
	
	function cities(){
		$query = $this->db->query("SELECT * FROM master_city WHERE status = 1 ORDER BY city_name ASC");
		return $query->result();
	}

	function master_banks(){
		$query = $this->db->query("SELECT * FROM master_bank WHERE deleted = '0' ORDER BY bank_name ASC");
		return $query->result();
	}
}
