<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Hunger_wallet extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/Hunger_wallet_model', 'wallet_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}
	
	public function index() {
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_wallet_transaction', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
	    $this->load->view("admin/logistic-management/hunger/wallet",$data);
	}
	
	/*----- Bulk Import Hunger -----*/
	public function import_file() {
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_wallet_transaction', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$path = 'uploads/imports/wallet/';
		$json = [];
	
		$this->upload_config($path);
	
		try {
			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors());
			}
	
			$file_data = $this->upload->data();
			$file_name = $path . $file_data['file_name'];
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);
	
			if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
				throw new Exception('Unsupported file format.');
			}
	
			$reader = $this->getReaderByExtension($extension);
			$spreadsheet = $reader->load($file_name);
			$sheet_data = $spreadsheet->getActiveSheet()->toArray();
	
			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);
	
			// Initialize transaction
			$this->db->trans_start();
	
			$batch_data = [];
			$duplicate_rows = [];
	
			foreach ($sheet_data as $val) {
				if ($val[1] != '') {
					// $isDuplicate = $this->wallet_model->checkDuplicateInBulk([
					// 	"created_date" => $val[1],
					// 	"rider_id" => $val[0],
					// ]);
					// //print_r($isDuplicate);exit();
					// if (!$isDuplicate) {
					// 	if($val[1] !== ''){
					// 		$created_date = date('Y-m-d', strtotime($val[1]));
					// 	}else{
					// 		$created_date = '';
					// 	}
						
						
					// } else {
					// 	// Add the row to the list of duplicates
					// 	$duplicate_rows[] = $val;
					// }
					// Get emp_id from logistic_rider by matching id_number with rider_id from Excel
					$this->db->select('employee_id');
					$this->db->where('id_number', $val[0]);
					$rider_info = $this->db->get('logistic_rider')->row();

					$emp_id = $rider_info ? $rider_info->employee_id : 0;

					if($val[1] !== ''){
						$created_date = date('Y-m-d', strtotime($val[1]));
					}else{
						$created_date = '';
					}
					
					$batch_data[] = [
						"created_date" => $created_date,
						"rider_id" => $val[0],
						"wallet_amount" => $val[3],
						"wallet_note" => $this->db->escape_str($val[2]),
						"employee_id" => $emp_id,
						"ip_address" => $this->ip_address,
						"created_at" => $this->datetime,
						"updated_at" => $this->datetime
					];
				}
	
				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = []; // Clear batch data after insertion
				}
			}
			// Insert any remaining data
			if (!empty($batch_data)) {
				$this->insertBatchData($batch_data);
			}
	
			// Commit transaction
			$this->db->trans_complete();
	
			// Delete the file
			if (file_exists($file_name)) {
				unlink($file_name);
			}
	
			// Check if there were any duplicate rows
			if (!empty($duplicate_rows)) {
				$json = [
					'error_message' => count($duplicate_rows) .' Duplicate row(s) found. <span class="text-success">Rest all inserted</span>',
					'duplicate_rows' => $duplicate_rows
				];
			} else {
				$json = [
					'success_message' => 'All Entries are imported successfully.',
				];
			}
		} catch (Exception $e) {
			// Rollback transaction if any error occurs
			$this->db->trans_rollback();
			$json = [
				'error_message' => $e->getMessage()
			];
		}
	
		echo json_encode($json);
		exit();
	}

	private function getReaderByExtension($extension) {
		switch ($extension) {
			case 'csv':
				return new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			case 'xlsx':
			case 'xls':
				return new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			default:
				throw new Exception('Unsupported file format.');
		}
	}
	
	private function insertBatchData($batch_data) {
		$result = $this->db->insert_batch('hunger_wallet_report', $batch_data);
	
		if (!$result) {
			$json = [
				'error_message' => 'Something went wrong. Please try again.',
			];
			echo json_encode($json);
			exit();
		}
	}
	
	public function upload_config($path) {
		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}
	
		$config['upload_path'] = './' . $path;
		$config['allowed_types'] = 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = 4096;
		$this->load->library('upload', $config);
	}

	/*----- Bulk Import Hunger End -----*/

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('rider_id'))){
			$rider_id = $this->input->get('rider_id');
		}
		else{
			$rider_id = FALSE;
		}
		if(!empty($this->input->get('start_date'))){
			$start_date = $this->input->get('start_date');
		}
		else{
			$start_date = FALSE;
		}
		if(!empty($this->input->get('end_date'))){
			$end_date = $this->input->get('end_date');
		}
		else{
			$end_date = FALSE;
		}
		
		$fetch_data = $this->wallet_model->get_list($keyword,$rider_id,$start_date,$end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$item->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->created_date));
			$sub_array[] = $item->rider_id;
			$sub_array[] = $item->emp_no;
			$sub_array[] = $item->full_name;
			$sub_array[] = $item->mobile;
			$sub_array[] = $item->wallet_amount;
			$sub_array[] = '<div style="max-width:300px;">'.$item->wallet_note.'</div>';
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->wallet_model->get_all_data(),  
			"recordsFiltered"     =>     $this->wallet_model->get_filtered_data($keyword,$rider_id,$start_date,$end_date),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function delete(){
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_wallet_transaction', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->wallet_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/hunger/wallet-report');
	}
}
