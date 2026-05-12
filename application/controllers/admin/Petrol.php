<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Petrol extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/Petrol_model', 'import');
		$this->load->library('form_validation');
		$this->ip_address   = $_SERVER['REMOTE_ADDR'];
		$this->datetime 	= CURRENT_TIME;
	}
	
	public function index() {
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
	    $this->load->view("admin/petrol_summary/index",$data);
	}
	
	public function upload() {
    	$this->load->view("admin/petrol_summary/import");
    }

	public function import_file() {
		$path 		= 'uploads/imports/petrol/';
		$json 		= [];
		$this->upload_config($path);
		if (!$this->upload->do_upload('file')) {
			$json = [
				'error_message' => $this->upload->display_errors(),
			];
		} else {
			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);
			if('csv' == $extension) {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet 	= $reader->load($file_name);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
			$list 			= [];
			foreach($sheet_data as $key => $val) {
				if($key != 0 && $val[2] !=='') {
					$filling_date = date('Y-m-d', strtotime(str_replace('/', '-', $val[1])));
					$result 	= $this->import->get(["filling_date" => $filling_date, "vehicle_no" => $val[2]]);
					if($result) {
					
					}else {
						$list [] = [
							'filling_date'	=> $filling_date,
							'vehicle_no'	=> $val[2],
							'amount'		=> $val[3],
							'ip_address'	=> $this->ip_address,
							'created_at' 	=> $this->datetime,
						];
					}
				}
			}
			//print_r($list);exit();
			if(file_exists($file_name)){
				unlink($file_name);
			}
			if(count($list) > 0) {
				$result 	= $this->import->add_batch($list);
				if($result) {
					$json = [
						'success_message' 	=> "All Entries are imported successfully.",
					];
				} else {
				    $json = [
						'error_message' 	=> "Something went wrong. Please try again."
					];
				}
			} else {
			    $json = [
					'error_message' => 'No new record is found in this sheet.',
				];
			}
		}
		echo json_encode($json);
	}

	public function upload_config($path) {
		if (!is_dir($path)) 
			mkdir($path, 0777, TRUE);		
		$config['upload_path'] 		= './'.$path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
	}

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
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
		
		$fetch_data = $this->import->get_list($keyword,$start_date,$end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$item->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->filling_date));
			$sub_array[] = $item->vehicle_no;
			$sub_array[] = $item->amount;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			// $sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/petrol-summary/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/petrol-summary/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->import->get_all_data(),  
			"recordsFiltered"     =>     $this->import->get_filtered_data($keyword,$start_date,$end_date),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->import->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/petrol-summary/index');
	}
}
