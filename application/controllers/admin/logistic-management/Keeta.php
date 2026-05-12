<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Keeta extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/Keeta_model', 'keeta_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}
	
	public function index() {
		if ($this->action && !check_action_permission(get_user_role(), 'keeta_daily_performance', $this->action)) {
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
	    $this->load->view("admin/logistic-management/keeta/index",$data);
	}

	/*----- Bulk Import Hunger -----*/
	public function import_file() {
		if ($this->action && !check_action_permission(get_user_role(), 'keeta_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$path = 'uploads/imports/keeta/';
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
	
			foreach ($sheet_data as $key => $val) {
				if ($val[1] != '') {
					$isDuplicate = $this->keeta_model->get([
						"summary_date" => $val[0], 
                    	"courier_id" => $val[1]
					]);
					//print_r($isDuplicate);exit();
					if (!$isDuplicate) {
						$date_local = date('Y-m-d', strtotime($this->input->post('order_date')));

						// Get emp_id from logistic_rider by matching id_number with rider_id from Excel
						$this->db->select('
							logistic_rider.employee_id, 
							master_vehicles.id as vehicle_id, 
							(
								SELECT ht.id
								FROM hunger_team ht
								WHERE ht.team REGEXP CONCAT(\'"\', logistic_rider.employee_id, \'"\')
								ORDER BY ht.id ASC
								LIMIT 1
							) as team_id
						', false);
						$this->db->from('logistic_rider');
						$this->db->join('master_vehicles', 'master_vehicles.alloted_user = logistic_rider.employee_id', 'left');
						$this->db->where('logistic_rider.id_number', $val[1]);
						$rider_info = $this->db->get()->row();

						$emp_id = $rider_info ? $rider_info->employee_id : 0;
						$vehicle_id = $rider_info ? $rider_info->vehicle_id : 0;
						$team_id = $rider_info ? $rider_info->team_id : 0;
						
						$batch_data[] = [
							'emp_id'				=> $emp_id,
							'order_date'			=> $date_local,
							'summary_date'			=> $val[0],
							'courier_id'			=> $val[1],
							'courier_first_name'	=> $val[2],
							'courier_last_name'		=> $val[3],
							'headquarters'			=> $val[4],
							'branch'				=> $val[5],
							'supervisor'			=> $val[6],
							'vehicle_type'			=> $val[7],
							'accepted_tasks'		=> $val[8],
							'delivered_tasks'		=> $val[9],
							'cancelled_tasks'		=> $val[10],
							'rejected_task'			=> $val[11],
							'rejected_task_courier'	=> $val[12],
							'rejected_task_auto'	=> $val[13],
							'courier_app_online_time'=> $val[14],
							'ontime_rate'			=> $val[15],
							'avg_delv_time_order'	=> $val[16],
							'delivered_order_prop'	=> $val[17],
							"alloted_vehicle_id" => $vehicle_id,
							"alloted_team_id" => $team_id,
							'ip_address'		=> $this->ip_address,
							'created_at' 		=> $this->datetime,
						];
					} else {
						// Add the row to the list of duplicates
						$duplicate_rows[] = $val;
					}
				}
	
				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = [];
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
		$result = $this->db->insert_batch('keeta_order_summary', $batch_data);
	
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

	/*----- Bulk Import Keeta End -----*/

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('courier_id'))){
			$courier_id = $this->input->get('courier_id');
		}
		else{
			$courier_id = FALSE;
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
		
		$fetch_data = $this->keeta_model->get_list($keyword,$courier_id,$start_date,$end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$item->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->order_date));
			$sub_array[] = $item->courier_id;
			$sub_array[] = $item->courier_first_name .' '. $item->courier_last_name;
			$sub_array[] = $item->vehicle_type;
			$sub_array[] = $item->accepted_tasks;
			$sub_array[] = $item->delivered_tasks;
			$sub_array[] = $item->cancelled_tasks;
			$sub_array[] = $item->rejected_task;
			$sub_array[] = $item->rejected_task_courier;
			$sub_array[] = $item->rejected_task_auto;
			$sub_array[] = $item->courier_app_online_time;
			$sub_array[] = $item->ontime_rate;
			$sub_array[] = $item->avg_delv_time_order;
			$sub_array[] = $item->delivered_order_prop;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			// $sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/master/employee/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/master/employee/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->keeta_model->get_all_data(),  
			"recordsFiltered"     =>     $this->keeta_model->get_filtered_data($keyword,$courier_id,$start_date,$end_date),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		if ($this->action && !check_action_permission(get_user_role(), 'keeta_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->keeta_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/keeta/index');
	}
	
}
