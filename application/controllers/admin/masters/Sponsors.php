<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sponsors extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/Sponsor_model', 'sponsor_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			//$this->load->helper('sendmail_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'sponsors', $action) && !in_array($action, ['save', 'update', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/masters/sponsor/index', $data);
	}

	public function add()
	{
		$output_data = $this->load->view('admin/masters/sponsor/components/add', '', TRUE);
		$result = array("type" => 'success', "message" => '', "output_html" => $output_data);
		echo json_encode($result);
	}


	public function save()
	{
		$this->form_validation->set_rules('employer_id', 'Employeer ID', 'trim|required');
		$this->form_validation->set_rules('employer_name', 'Employeer Name', 'trim|required');
		$this->form_validation->set_rules('employer_cr_no', 'Employeer CR No', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$data = array(
				'employer_id' => $this->input->post('employer_id'),
				'employer_name' => $this->input->post('employer_name'),
				'employer_arabic_name' => $this->input->post('employer_arabic_name'),
				'employer_cr_no' => $this->input->post('employer_cr_no'),
				'mol_id' => $this->input->post('mol_id'),
				'employer_address' => $this->input->post('employer_address'),
				'employer_work_location' => $this->input->post('employer_work_location'),
				'employer_email' => $this->input->post('employer_email'),
				'represented_by' => $this->input->post('represented_by'),
				'created_at' => $this->datetime,
				'updated_at' => $this->datetime,
			);
			// Save data using the model
			$insert_id = $this->sponsor_model->save($data);
			if ($insert_id) {
				$result = array("type" => 'success', "message" => 'Sponsor detail successfully added.', "reload" => 'true');
			} else {
				$result = array("type" => 'error', "message" => 'Error in saving sponsor detail, try again', "reload" => 'false');
			}
		}
		echo json_encode($result);
	}

	public function edit()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->sponsor_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['sponsor_detail'] = $query->row_array();
				$output_data = $this->load->view('admin/masters/sponsor/components/edit', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Sponsor detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Sponsor detail not found, try again');
			}
		}
		echo json_encode($result);
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employer_id', 'Employeer ID', 'trim|required');
		$this->form_validation->set_rules('employer_name', 'Employeer Name', 'trim|required');
		$this->form_validation->set_rules('employer_cr_no', 'Employeer CR No', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$id = $this->input->post('id');
			$data = array(
				'employer_id' => $this->input->post('employer_id'),
				'employer_name' => $this->input->post('employer_name'),
				'employer_arabic_name' => $this->input->post('employer_arabic_name'),
				'employer_cr_no' => $this->input->post('employer_cr_no'),
				'mol_id' => $this->input->post('mol_id'),
				'employer_address' => $this->input->post('employer_address'),
				'employer_work_location' => $this->input->post('employer_work_location'),
				'employer_email' => $this->input->post('employer_email'),
				'represented_by' => $this->input->post('represented_by'),
				'updated_at' => $this->datetime,
			);
			// Save data using the model
			$updated = $this->sponsor_model->update($id, $data);
			if ($updated) {
				$this->session->set_userdata('info', "1--Sponsor detail successfully updated.");
			} else {
				$this->session->set_userdata('info', "2--Sponsor detail not updated.");
			}
		}
		redirect('admin/master/sponsors');
	}

	public function get_list()
	{
		$fetch_data = $this->sponsor_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $item->employer_id;
			$sub_array[] = (($item->employer_name !== '') ? $item->employer_name : '');
			$sub_array[] = (($item->employer_arabic_name !== '') ? $item->employer_arabic_name : '');
			$sub_array[] = $item->employer_cr_no;
			$sub_array[] = $item->mol_id;
			$sub_array[] = ($item->total_riders > 0) ? '<button type="button" class="btn btn-link border text-center view-sponsor-employees" data-sponsorid="'.$item->id.'">'.$item->total_riders.'</button>' : '<button type="button" class="btn btn-link border text-center" disabled>'.$item->total_riders.'</button>';
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			$sub_array[] = ((isset($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : '');
			$sub_array[] = check_action_permission(get_user_role(), 'sponsors', 'edit') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" onclick="editSponsorsBtn(' . $item->id . ')" title="Edit"><i class="mdi mdi-pencil font-size-18"></i></button>' : '';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"             =>  intval($_POST["draw"]),
			"recordsTotal"     =>  $this->sponsor_model->get_all_data(),
			"recordsFiltered"  =>  $this->sponsor_model->get_filtered_data(),
			"data"             =>  $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		if (is_array($ids) && !empty($ids)) {
			$query = $this->sponsor_model->delete($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully deleted");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid selection");
		}
		redirect('admin/master/sponsors');
	}

	public function sponsorsEmployees()
	{
		header('Content-Type: application/json'); // Ensure JSON response

		$this->form_validation->set_rules('id', 'Sponsor ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$id = $this->input->post('id');
		$sponsor_detail = $this->sponsor_model->get_detail($id);

		if ($sponsor_detail) {
			$data['sponsor_info'] = $sponsor_detail;
			$data['employees_list'] = $this->sponsor_model->get_sponsors_employees($id);
			//dd($data['employees_list']);
			$output_data = $this->load->view('admin/masters/sponsor/components/employee-list', $data, TRUE);
			
			echo json_encode(["type" => 'success', "message" => 'Rider list successfully fetched.', "output_html" => $output_data]);
		} else {
			echo json_encode(["type" => 'error', "message" => 'Rider list not found, try another sponsor.']);
		}
	}
}
