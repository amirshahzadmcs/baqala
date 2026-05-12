<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Rolepermission_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * This funtion takes id as a parameter and will fetch the record.
	 * If id is not provided, then it will fetch all the records form the table.
	 * @param int $id
	 * @return mixed
	 */

	public function getRoles()
	{
		$query = $this->db->query("SELECT * FROM roles 
								   WHERE is_active = '1' 
								   AND deleted = '0' 
								   AND id != '1' 
								   AND is_superadmin != '1'
								   ORDER BY name ASC")->result_array();
		return $query;
	}

	public function getPermissionTree($roleId = null)
	{
		$categories = [];
		$queryCategories = $this->db->query("SELECT * FROM permission_category WHERE perm_group_id = '0' AND status = '1' ORDER BY name ASC");

		if ($queryCategories->num_rows()) {
			foreach ($queryCategories->result() as $category) {
				$children = [];
				$queryChildren = $this->db->query("SELECT * FROM permission_category WHERE perm_group_id = '{$category->id}' AND status = '1' ORDER BY name ASC");

				foreach ($queryChildren->result() as $child) {
					$subChildren = [];
					$querySubChildren = $this->db->query("SELECT * FROM permission_category WHERE perm_group_id = '{$child->id}' AND status = '1' ORDER BY name ASC");

					foreach ($querySubChildren->result() as $subChild) {
						$grandChildren = [];
						$queryGrandChildren = $this->db->query("SELECT * FROM permission_category WHERE perm_group_id = '{$subChild->id}' AND status = '1' ORDER BY name ASC");

						foreach ($queryGrandChildren->result() as $grandChild) {
							$grandSubChildren = [];
							$queryGrandSubChildren = $this->db->query("SELECT * FROM permission_category WHERE perm_group_id = '{$grandChild->id}' AND status = '1' ORDER BY name ASC");

							foreach ($queryGrandSubChildren->result() as $grandSubChild) {
								// Level 5
								$grandSubChildPermission = $this->db->select('allowed_methods')->where('role_id', $roleId)->where('perm_cat_id', $grandSubChild->id)->get('roles_permissions')->row_array();
								$grandSubChildren[] = [
									'id' => $grandSubChild->id,
									'name' => $grandSubChild->name,
									'short_code' => $grandSubChild->short_code,
									'methods' => $grandSubChild->methods,
									'view' => $grandSubChild->enable_view,
									'add' => $grandSubChild->enable_add,
									'edit' => $grandSubChild->enable_edit,
									'delete' => $grandSubChild->enable_delete,
									'allowed_permissions' => isset($grandSubChildPermission['allowed_methods']) ? json_decode($grandSubChildPermission['allowed_methods'], true) : []
								];
							}

							// Level 4
							$grandChildPermission = $this->db->select('allowed_methods')->where('role_id', $roleId)->where('perm_cat_id', $grandChild->id)->get('roles_permissions')->row_array();
							$grandChildren[] = [
								'id' => $grandChild->id,
								'name' => $grandChild->name,
								'short_code' => $grandChild->short_code,
								'methods' => $grandChild->methods,
								'view' => $grandChild->enable_view,
								'add' => $grandChild->enable_add,
								'edit' => $grandChild->enable_edit,
								'delete' => $grandChild->enable_delete,
								'allowed_permissions' => isset($grandChildPermission['allowed_methods']) ? json_decode($grandChildPermission['allowed_methods'], true) : [],
								'children' => $grandSubChildren
							];
						}

						// Level 3
						$subChildPermission = $this->db->select('allowed_methods')->where('role_id', $roleId)->where('perm_cat_id', $subChild->id)->get('roles_permissions')->row_array();
						$subChildren[] = [
							'id' => $subChild->id,
							'name' => $subChild->name,
							'short_code' => $subChild->short_code,
							'methods' => $subChild->methods,
							'view' => $subChild->enable_view,
							'add' => $subChild->enable_add,
							'edit' => $subChild->enable_edit,
							'delete' => $subChild->enable_delete,
							'allowed_permissions' => isset($subChildPermission['allowed_methods']) ? json_decode($subChildPermission['allowed_methods'], true) : [],
							'children' => $grandChildren
						];
					}
					// Level 2
					$childPermission = $this->db->select('allowed_methods')->where('role_id', $roleId)->where('perm_cat_id', $child->id)->get('roles_permissions')->row_array();
					$children[] = [
						'id' => $child->id,
						'name' => $child->name,
						'short_code' => $child->short_code,
						'methods' => $child->methods,
						'view' => $child->enable_view,
						'add' => $child->enable_add,
						'edit' => $child->enable_edit,
						'delete' => $child->enable_delete,
						'allowed_permissions' => isset($childPermission['allowed_methods']) ? json_decode($childPermission['allowed_methods'], true) : [],
						'children' => $subChildren
					];
				}

				// Level 1
				$categoryPermission = $this->db->select('allowed_methods')->where('role_id', $roleId)->where('perm_cat_id', $category->id)->get('roles_permissions')->row_array();
				$categories[] = [
					'id' => $category->id,
					'name' => $category->name,
					'short_code' => $category->short_code,
					'methods' => $category->methods,
					'view' => $category->enable_view,
					'add' => $category->enable_add,
					'edit' => $category->enable_edit,
					'delete' => $category->enable_delete,
					'allowed_permissions' => isset($categoryPermission['allowed_methods']) ? json_decode($categoryPermission['allowed_methods'], true) : [],
					'children' => $children
				];
			}
		}
		return $categories;
	}


	public function getPermissionByRole($role_id)
	{
		$this->db->select('`roles_permissions`.*, permission_category.id as permission_category_id,permission_category.name as permission_category_name,permission_category.short_code as permission_category_code');
		$this->db->from('roles_permissions');

		$this->db->join('permission_category', 'permission_category.id=roles_permissions.perm_cat_id');
		$this->db->where('roles_permissions.role_id', $role_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function getInsertBatch($role_id, $to_be_insert = array())
	{
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
		// # Deleting Old Data
		if (!empty($role_id)) {
			$this->db->where('role_id', $role_id);
			$this->db->delete('roles_permissions');
		}
		if (!empty($to_be_insert)) {
			$this->db->insert_batch('roles_permissions', $to_be_insert);
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {

			$this->db->trans_rollback();
			return FALSE;
		} else {

			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function getPermissionWithSelectedByRole($role_id)
	{
		$sql = "SELECT permissions.*, role_permissions.id as `role_permission_id`,IF(role_permissions.id IS NULL,0,1) AS role_permission_state FROM `permissions` LEFT JOIN role_permissions on permissions.id=role_permissions.permission_id and role_permissions.role_id =$role_id";

		$query = $this->db->query($sql);
		return $query->result();
	}
}
