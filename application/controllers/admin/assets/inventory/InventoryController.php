<?php defined('BASEPATH') or exit('No direct script access allowed');

class InventoryController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if ($this->admin->isLogged()) {
            $this->load->library('form_validation');
            $this->load->helper('common_helper');
            $this->load->helper('file');
            $this->action = $this->router->fetch_method();
        } else {
            redirect('admin/common/login');
        }
    }

    public function index()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'asset_manage_inventory', $this->action)) {
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
        return $this->load->view('admin/assets-management/inventory/manage-inventory');
    }

    public function get_items()
    {
        $this->db->select('inventory_items.*,asset_brands.brand_id,asset_brands.brand_name,asset_brands.brand_ar_name,inventory_units.unit_id,inventory_units.unit_name');
        $this->db->join('asset_brands', 'inventory_items.brand = asset_brands.brand_id', 'left');
        $this->db->join('inventory_units', 'inventory_items.unit = inventory_units.unit_id', 'left');
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->order_by("id", "desc");
        $fetch_data = $this->db->get('inventory_items')->result();
        $i = $_POST['start'] + 1;
        $data = array();
        foreach ($fetch_data as $item) {
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $item->code;
            $sub_array[] = '<img src="' . base_url($item->image) . '" width="60px" height="60px">';
            $sub_array[] = $item->sku;
            $sub_array[] = $item->name;
            $sub_array[] = $item->ar_name;
            $sub_array[] = $item->available_stock ? $item->available_stock : '';
            $sub_array[] = $item->amount > 0 ? $item->amount : '';
            $sub_array[] = $item->unit_name;
            $sub_array[] = implode(' >', getParentCategory($item->category));
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->db->from("inventory_items")->count_all_results(),
            "recordsFiltered" => count($fetch_data),
            "data" => $data
        );
        echo json_encode($output);
        return;
          // $sub_array[] = '<div class="d-flex">
            //                     <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-bs-target="#inventoryaddModal" data-bs-toggle="modal" title="Edit" href="">
            //                                     <i class="mdi mdi-plus font-size-18"></i>
            //                     </a>
            //                     <a class="btn btn-outline-secondary btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="">
            //                         <i class="far fa-copy font-size-18"></i>
            //                     </a>
            //                     <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" href="">
            //                         <i class="fas fa-trash-alt font-size-18"></i>
            //                     </a>
            //                     <a onclick="window.print()" class="btn btn-outline-secondary btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete">
            //                         <i class="fas fa-print font-size-18"></i>
            //                     </a>
            //                     <a class="btn btn-outline-info btn-custom-light btn-sm edit" data-bs-target="#itemsviewModal" data-bs-toggle="modal" title="View" href="">
            //                         <i class="mdi mdi-eye font-size-18"></i>
            //                     </a>
            //                 </div>';
    }

    public function create_item()
    {
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('name', 'Item Name', 'required|is_unique[inventory_items.name]');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset/inventory/manage-items');
        } else {
            $file_path = 'assets/uploads/inventory_items/';
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = $file_path;
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $image = $this->input->post('old_image');
                } else {

                    $imageDetailArray = $this->upload->data();
                    $image = 'assets/uploads/inventory_items/' . $imageDetailArray['file_name'];
                }
            }
            $last_id = $this->db->select_max('id')->get('inventory_items')->row_array()['id'] + 1;
            $this->db->insert(
                'inventory_items',
                [
                    'name' => $this->input->post('name'),
                    'ar_name' => $this->input->post('ar_name'),
                    'code' => 'IM' . accountNoFormat($last_id),
                    'category' => $this->input->post('category'),
                    'brand' => $this->input->post('brand'),
                    'sku' => $this->input->post('sku'),
                    'unit' => $this->input->post('unit'),
                    'description' => $this->input->post('description'),
                    'image' => $image,
                ]
            );

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset/inventory/manage-items');
        }
    }

    public function update_item()
    {
        $this->form_validation->set_rules('name', 'Item Name', 'trim|required|callback_check_name_duplicate');
        $this->form_validation->set_message('check_name_duplicate', 'Item Name already Taken, Try new');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset/inventory/manage-items');
        } else {
            $file_path = 'assets/uploads/inventory_items/';
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = $file_path;
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $image = $this->input->post('old_image');
                } else {

                    $imageDetailArray = $this->upload->data();
                    $image = 'assets/uploads/inventory_items/' . $imageDetailArray['file_name'];
                    $old_path = FCPATH . $this->input->post('old_image');
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
            } else {
                $image = $this->input->post('old_image');
            }
            $this->db->update(
                'inventory_items',
                [
                    'name' => $this->input->post('name'),
                    'ar_name' => $this->input->post('ar_name'),
                    // 'code' => $this->input->post('item_code'),
                    'category' => $this->input->post('category'),
                    'brand' => $this->input->post('brand'),
                    'sku' => $this->input->post('sku'),
                    'unit' => $this->input->post('unit'),
                    'description' => $this->input->post('description'),
                    'image' => $image,
                ],
                ['id' => $this->input->post('item_id')]
            );

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset/inventory/manage-items');
        }
    }



    public function delete_item()
    {
        $id = $this->input->get('id');
        $item = $this->db->select('image')->where('id', $id)->get('inventory_items')->row();

        if ($item) {
            $file_path = FCPATH . $item->image;

            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $this->db->delete('inventory_items', ['id' => $id]);
        }
        $this->session->set_userdata('info', "1--Successfully done");
        return redirect('admin/asset/inventory/manage-items');
    }





    public function check_name_duplicate()
    {
        $id = $this->input->post('item_id');
        $item_name = $this->input->post('name');
        $duplicate_check = $this->db->where('id!=', $id)->where('name', $item_name)->get('inventory_items')->result();
        if (count($duplicate_check) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function get_categories()
    {
        $categories = $this->db->select(['categoryId as id', 'parentCategoryId', 'categoryName as text'])->get('asset_categories')->result_array();
        $catTree = $this->build_tree($categories);
        echo json_encode($catTree);
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
