<?php defined('BASEPATH') or exit('No direct script access allowed');

class ModelController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'model', $action)) {
				redirect('admin/unauthorized-request');
			}
		} else {
			redirect('admin/common/login');
		}
	}

	public function all_models()
	{
		$this->db->select('asset_models.*, asset_brands.brand_id, asset_brands.brand_name');
		$this->db->from('asset_models');
		$this->db->join('asset_brands', 'asset_brands.brand_id = asset_models.model_brand_id', 'left');
		$models = $this->db->get()->result();
		$brands = $this->db->get('asset_brands')->result();

		return $this->load->view('admin/assets-management/app_setting/model_list', compact('models', 'brands'));
	}

	public function create_model()
	{
		$this->form_validation->set_rules('model_name', 'model Name', 'required|is_unique[asset_models.model_name]');

		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/asset/all-models');
		} else {
			$this->db->insert(
				'asset_models',
				[
					'model_name' => $this->input->post('model_name'),
					'model_ar_name' => $this->input->post('model_ar_name'),
					'model_brand_id' => $this->input->post('model_brand_id'),
					'model_created_by' => $this->admin->getId(),
				]
			);

			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/asset/all-models');
		}
	}

	public function update_model()
	{
		$model_id = $this->input->post('model_id');
		$this->form_validation->set_rules('model_id', 'model Id', 'required');
		$this->form_validation->set_rules('model_name', 'model Name', 'trim|required|callback_check_name_duplicate');
		$this->form_validation->set_message('check_name_duplicate', 'model Name already Taken, Try new');

		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/asset/all-models');
		} else {
			$this->db->update(
				'asset_models',
				[
					'model_name' => $this->input->post('model_name'),
					'model_ar_name' => $this->input->post('model_ar_name'),
					'model_brand_id' => $this->input->post('model_brand_id'),
					'model_updated_at' => date('Y-m-d H:i:s')
				],
				['model_id' => $this->input->post('model_id')]
			);

			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/asset/all-models');
		}
	}

	public function delete_model()
	{
		$id = $this->input->get('id');
		$this->db->delete('asset_models', ['model_id' => $id]);
		$this->session->set_userdata('info', "1--Successfully done");
		return redirect('admin/asset/all-models');
	}


	public function check_name_duplicate()
	{
		$id = $this->input->post('model_id');
		$model_name = $this->input->post('model_name');
		$duplicate_check = $this->db->where('model_id!=', $id)->where('model_name', $model_name)->get('asset_models')->result();
		if (count($duplicate_check) > 0) {
			return false;
		} else {
			return true;
		}
	}
}
