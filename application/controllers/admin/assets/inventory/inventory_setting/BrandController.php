<?php defined('BASEPATH') or exit('No direct script access allowed');

class BrandController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			$this->load->library('user_agent');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'brand', $action)) {
				redirect('admin/unauthorized-request');
			}
		} else {
			redirect('admin/common/login');
		}
	}
	public function all_brands()
	{
		$this->db->select('asset_brands.*, GROUP_CONCAT(ac.categoryName) as categoryNames', false);
		$this->db->join('asset_categories ac', 'FIND_IN_SET(ac.categoryId, REPLACE(REPLACE(REPLACE(REPLACE(asset_brands.brand_category_ids, \'["\', \'\'), \'"]\', \'\'), \'"\', \'\'), \' \', \'\'))', 'left');
		$this->db->group_by('asset_brands.brand_id');
		$brands = $this->db->get('asset_brands')->result();
		return $this->load->view('admin/assets-management/inventory/inventory_setting/brand_list', compact('brands'));
	}



	public function create_brand()
	{
		$this->form_validation->set_rules('brand_name', 'brand Name', 'required|is_unique[asset_brands.brand_name]');

		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect($this->agent->referrer());
		} else {
			$this->db->insert(
				'asset_brands',
				[
					'brand_name' => $this->input->post('brand_name'),
					'brand_ar_name' => $this->input->post('brand_ar_name'),
					'brand_category_ids' => json_encode($this->input->post('brand_category_ids')),
					'brand_created_by' => $this->admin->getId(),
				]
			);

			$this->session->set_userdata('info', "1--Successfully done");
			return redirect($this->agent->referrer());
		}
	}

	public function update_brand()
	{
		$brand_id = $this->input->post('brand_id');
		$this->form_validation->set_rules('brand_id', 'brand Id', 'required');
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|callback_check_name_duplicate');
		$this->form_validation->set_message('check_name_duplicate', 'Brand Name already Taken, Try new');

		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/asset/all-brands');
		} else {
			$this->db->update(
				'asset_brands',
				[
					'brand_name' => $this->input->post('brand_name'),
					'brand_ar_name' => $this->input->post('brand_ar_name'),
					'brand_category_ids' => json_encode($this->input->post('brand_category_ids')),
					'brand_updated_at' => date('Y-m-d H:i:s')
				],
				['brand_id' => $this->input->post('brand_id')]
			);

			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/asset/all-brands');
		}
	}

	public function delete_brand()
	{
		$id = $this->input->get('id');
		$this->db->delete('asset_brands', ['brand_id' => $id]);
		$this->session->set_userdata('info', "1--Successfully done");
		return redirect('admin/asset/all-brands');
	}


	public function check_name_duplicate()
	{
		$id = $this->input->post('brand_id');
		$brand_name = $this->input->post('brand_name');
		$duplicate_check = $this->db->where('brand_id!=', $id)->where('brand_name', $brand_name)->get('asset_brands')->result();
		if (count($duplicate_check) > 0) {
			return false;
		} else {
			return true;
		}
	}
}
