<?php defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Category_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_category', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['results'] = $this->Category_model->get_category();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/category/category_list', $data);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Category_model->get_category_by_id($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['seo'] = $query->slug;
				$data['name'] = $query->name;
				$data['arabic_name'] = $query->arabic_name;
				$data['sort_order'] = $query->sort_order;
				$data['heading_text'] = $query->heading_text;
				$data['description'] = $query->description;
				$data['arabic_desc'] = $query->arabic_desc;
				$data['metatitle'] = $query->metatitle;
				$data['metadescription'] = $query->metadescription;
				$data['metakeyword'] = $query->metakeyword;
				$data['o_img'] = $query->image;
				$data['o_icon'] = $query->icon;
				$data['parent_id'] = $query->parent_id;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['seo'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['sort_order'] = "";
			$data['heading_text'] = "";
			$data['description'] = "";
			$data['arabic_desc'] = "";
			$data['metatitle'] = "";
			$data['metadescription'] = "";
			$data['o_img'] = "";
			$data['o_icon'] = "";
			$data['metakeyword'] = "";
			$data['parent_id'] = "";
			$data['status'] = "";
		}
		$data['parent'] = $this->Category_model->get_category();
		$this->load->view('admin/category/category_form', $data);
	}

	public function add_category()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_category', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($_FILES['image']['name']) {
				$con['upload_path']   = './uploads/';
				$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
					echo $this->upload->display_errors();
					exit;
				} else {
					$image_data = $this->upload->data();
					$image = "uploads/" . $image_data['file_name'];
				}
			} else {
				$image = $this->input->post('o_img');
			}

			if ($_FILES['icon']['name']) {
				$con['upload_path']   = './uploads/';
				$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('icon')) {
					echo $this->upload->display_errors();
					exit;
				} else {
					$image_data1 = $this->upload->data();
					$icon = "uploads/" . $image_data1['file_name'];
				}
			} else {
				$icon = $this->input->post('o_icon');
			}
			if ($this->input->post('id')) {
				$query = $this->Category_model->edit($image, $icon);
			} else {
				$query = $this->Category_model->add($image, $icon);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
			redirect('admin/category');
		}
	}

	public function setStatusEnable()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_category', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Category_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/category');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_category', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Category_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/category');
		} else {
			redirect('admin');
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_category', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Category_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/category');
	}
}
