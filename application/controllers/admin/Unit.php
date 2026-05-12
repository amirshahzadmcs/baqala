this-><?php defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Unit_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_unit', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/master_unit/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Unit_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $unit) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $unit->id . '" name="check_list[]" />';
			$sub_array[] = $unit->unit_name . '<br>' . $unit->unit_name_ar;
			$sub_array[] = $unit->sort_order;
			$sub_array[] = $unit->created_at;
			$sub_array[] = $unit->updated_at;
			$sub_array[] = $unit->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = check_action_permission(get_user_role(), 'manage_unit', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/unit/add?id=' . $unit->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Unit_model->get_all_data(),
			"recordsFiltered"     =>     $this->Unit_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_unit', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Unit_model->get_unit_by_id($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['unit_name'] = $query->unit_name;
				$data['unit_name_ar'] = $query->unit_name_ar;
				$data['sort_order'] = $query->sort_order;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['unit_name'] = "";
			$data['unit_name_ar'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/master_unit/form', $data);
	}

	public function add_unit()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('unit_name', 'Unit Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('unit_name', 'Unit Name', 'trim|required|is_unique[master_unit.unit_name]', array('is_unique' => 'Duplicate unit name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Unit_model->edit();
			} else {
				$query = $this->Unit_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/unit');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_unit', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Unit_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/unit');
	}
}
