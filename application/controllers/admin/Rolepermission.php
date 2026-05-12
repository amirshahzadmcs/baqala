<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rolepermission extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Rolepermission_model');
			$this->load->library('form_validation');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'permissions', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['roles'] = $this->Rolepermission_model->getRoles();


		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}

		$this->load->view('admin/permissions/list', $data);
	}

	public function quick_edit()
	{
		$this->form_validation->set_rules('role_id', 'Role ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$data['permissions_cat'] = $this->Rolepermission_model->getPermissionTree($this->input->post('role_id') ?? null);
			$data['permissions'] = $this->Rolepermission_model->getPermissionByRole($this->input->post('role_id'));
			$data['role_id'] = $this->input->post('role_id');
			if (!empty($data['permissions_cat'])) {
				$output_data = $this->load->view('admin/permissions/permission-form', $data, TRUE);
			} else {
				$output_data = $this->load->view('admin/permissions/add-permission', $data, TRUE);
			}

			echo $output_data;
		}
	}

	public function add($id)
	{
		$this->form_validation->set_rules('role_id', 'Role Name', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {

			$requestData = $this->input->post();

			if (!isset($requestData['role_id']) || empty($requestData['role_id'])) {
				$this->session->set_flashdata('error', 'Role ID is required.');
				redirect('admin/roles');
			}

			$role_id = $requestData['role_id'];
			$parentCategories = isset($requestData['parentCat']) ? $requestData['parentCat'] : [];

			$permissionsData = [];

			foreach ($parentCategories as $parentCat) {
				$parentCatId = isset($parentCat['cat_id']) ? $parentCat['cat_id'] : null;
				$parentPermissions = isset($parentCat['cat_per_key']) ? $parentCat['cat_per_key'] : [];


				if ($parentCatId && !empty($parentPermissions)) {
					$permissionsData[] = [
						'role_id' => $role_id,
						'perm_cat_id' => $parentCatId,
						'allowed_methods' => json_encode(array_values($parentPermissions)),
						'created_at' => date('Y-m-d H:i:s')
					];
				}


				if (isset($parentCat['children']) && is_array($parentCat['children'])) {
					foreach ($parentCat['children'] as $child) {
						$childCatId = isset($child['cat_id']) ? $child['cat_id'] : null;
						$childPermissions = isset($child['cat_per_key']) ? $child['cat_per_key'] : [];

						if ($childCatId && !empty($childPermissions)) {
							$permissionsData[] = [
								'role_id' => $role_id,
								'perm_cat_id' => $childCatId,
								'allowed_methods' => json_encode(array_values($childPermissions)),
								'created_at' => date('Y-m-d H:i:s')
							];
						}


						if (isset($child['grandchildren']) && is_array($child['grandchildren'])) {
							foreach ($child['grandchildren'] as $grandchild) {
								$grandchildCatId = isset($grandchild['cat_id']) ? $grandchild['cat_id'] : null;
								$grandchildPermissions = isset($grandchild['cat_per_key']) ? $grandchild['cat_per_key'] : [];

								if ($grandchildCatId && !empty($grandchildPermissions)) {
									$permissionsData[] = [
										'role_id' => $role_id,
										'perm_cat_id' => $grandchildCatId,
										'allowed_methods' => json_encode(array_values($grandchildPermissions)),
										'created_at' => date('Y-m-d H:i:s')
									];
								}

								if (isset($grandchild['subgrandchildren']) && is_array($grandchild['subgrandchildren'])) {
									foreach ($grandchild['subgrandchildren'] as $subgrandchildren) {
										$subgrandchildrenCatId = isset($subgrandchildren['cat_id']) ? $subgrandchildren['cat_id'] : null;
										$subgrandchildrenPermissions = isset($subgrandchildren['cat_per_key']) ? $subgrandchildren['cat_per_key'] : [];

										if ($subgrandchildrenCatId && !empty($subgrandchildrenPermissions)) {
											$permissionsData[] = [
												'role_id' => $role_id,
												'perm_cat_id' => $subgrandchildrenCatId,
												'allowed_methods' => json_encode(array_values($subgrandchildrenPermissions)),
												'created_at' => date('Y-m-d H:i:s')
											];
										}
										if (isset($subgrandchildren['subsubgrandchildren']) && is_array($subgrandchildren['subsubgrandchildren'])) {
											foreach ($subgrandchildren['subsubgrandchildren'] as $subsubgrandchildren) {
												$subsubgrandchildrenCatId = isset($subsubgrandchildren['cat_id']) ? $subsubgrandchildren['cat_id'] : null;
												$subsubgrandchildrenPermissions = isset($subsubgrandchildren['cat_per_key']) ? $subsubgrandchildren['cat_per_key'] : [];

												if ($subsubgrandchildrenCatId && !empty($subsubgrandchildrenPermissions)) {
													$permissionsData[] = [
														'role_id' => $role_id,
														'perm_cat_id' => $subsubgrandchildrenCatId,
														'allowed_methods' => json_encode(array_values($subsubgrandchildrenPermissions)),
														'created_at' => date('Y-m-d H:i:s')
													];
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}

			$query = $this->Rolepermission_model->getInsertBatch($role_id, $permissionsData);
			if ($query) {
				$this->session->set_userdata('info', "1--Permissions successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}

		redirect('admin/roles/permission/list');
	}
}
