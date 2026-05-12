<?php defined('BASEPATH') or exit('No direct script access allowed');

class AssetController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'all_assets', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$categories = $this->db->get('asset_categories')->result();
		return $this->load->view('admin/assets-management/assets/assets-list');
	}

	public function get_categories()
	{
		$categories = $this->db->select(['categoryId as id', 'parentCategoryId', 'categoryName as text'])->get('asset_categories')->result_array();
		$catTree = $this->build_tree($categories);
		echo json_encode($catTree);
	}


	public function add_asset()
	{
		$departments = $this->db->get_where('master_department', ['status' => 'active'])->result();
		$users = $this->db->get_where('customer', ['status' => 1])->result();
		$status = $this->db->get_where('assets_status', ['status_type' => '1'])->result();
		$conditions = $this->db->get('asset_conditions')->result();
		$brands = $this->db->get('asset_brands')->result();
		$models = $this->db->get('asset_models')->result();
		$assets = $this->db->get_where('assets', ['status' => '1'])->result();
		return $this->load->view('admin/assets-management/assets/add-asset', compact('departments', 'users', 'status', 'conditions', 'brands', 'models', 'assets'));
	}

	public function add_category()
	{
		$this->form_validation->set_rules('categoryName', 'Category Name', 'required');
		$this->form_validation->set_rules('categoryArabicName', 'Category Arabic Name', 'required');
		if ($this->form_validation->run() == false) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/asset-manage/add-asset');
		} else {

			$this->db->insert(
				'asset_categories',
				[
					'parentCategoryId' => $this->input->post('parentCategoryId'),
					'categoryName' => $this->input->post('categoryName'),
					'categoryArabicName' => $this->input->post('categoryArabicName'),
					'categoryCode' => $this->input->post('categoryCode'),
					'transferDuration' => $this->input->post('transferDuration'),
					'transferDurationType' => $this->input->post('transferDurationType'),
					'isCasCade' => $this->input->post('isCasCade'),
					'allowAutoExtend' => $this->input->post('allowAutoExtend'),
					'endOfLife' => $this->input->post('endOfLife'),
					'endOfLifeType' => $this->input->post('endOfLifeType'),
					'depreciation' => $this->input->post('depreciation'),
					'scrapValue' => $this->input->post('scrapValue'),
					'scrapValueType' => $this->input->post('scrapValueType'),
					'depreciationTaxPct' => $this->input->post('depreciationTaxPct'),
					'defaultVendor' => $this->input->post('endOfLifeType'),
					'autoAssign' => $this->input->post('autoAssign'),
					'tvpActivity' => json_encode($this->input->post('tvpActivity')),
				]
			);
			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/asset-manage/add-asset');
		}
	}

	private function build_tree($categories, $parent_id = 0)
	{
		$tree = array();
		foreach ($categories as $category) {
			if ($category['parentCategoryId'] == $parent_id) {
				$category['children'] = $this->build_tree($categories, $category['id']);
				$tree[] = $category;
			}
		}
		return $tree;
	}
}
