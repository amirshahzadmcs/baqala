<?php defined('BASEPATH') or exit('No direct script access allowed');

class ConditionController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'condition', $action)) {
				redirect('admin/unauthorized-request');
			}
		} else {
			redirect('admin/common/login');
		}
	}

	public function all_conditions()
	{
		$conditions = $this->db->get('asset_conditions')->result();

		return $this->load->view('admin/assets-management/app_setting/condition_list', compact('conditions'));
	}

	public function create_condition()
	{
		$this->form_validation->set_rules('condition_name', 'Condition Name', 'required|is_unique[asset_conditions.condition_name]');

		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/asset/all-conditions');
		} else {
			$this->db->insert(
				'asset_conditions',
				[
					'condition_name' => $this->input->post('condition_name'),
					'condition_ar_name' => $this->input->post('condition_ar_name'),
					'created_by' => $this->admin->getId(),
				]
			);

			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/asset/all-conditions');
		}
	}

	public function update_condition()
	{
		$this->form_validation->set_rules('condition_id', 'Condition Id', 'required');
		$this->form_validation->set_rules('condition_name', 'Condition Name', 'required|is_unique[asset_conditions.condition_name]');

		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/asset/all-conditions');
		} else {
			$this->db->update(
				'asset_conditions',
				[
					'condition_name' => $this->input->post('condition_name'),
					'condition_ar_name' => $this->input->post('condition_ar_name'),
				],
				['condition_id' => $this->input->post('condition_id')]
			);

			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/asset/all-conditions');
		}
	}

	public function delete_condition()
	{
		$id = $this->input->get('id');
		$this->db->delete('asset_conditions', ['condition_id' => $id]);
		$this->session->set_userdata('info', "1--Successfully done");
		return redirect('admin/asset/all-conditions');
	}
}
