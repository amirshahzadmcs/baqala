<?php defined('BASEPATH') or exit('No direct script access allowed');

class CategoryController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if ($this->admin->isLogged()) {
            $this->load->library('form_validation');
            $this->load->library('user_agent');
            $this->action = $this->router->fetch_method();
        } else {
            redirect('admin/common/login');
        }
    }

    public function all_categories()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'categories', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $categories = $this->db->get('asset_categories')->result();
        $roles = $this->db->get('master_job_title')->result();
        return $this->load->view('admin/assets-management/app_setting/category_list', compact('categories', 'roles'));
    }
    public function get_categories()
    {
        $categories = $this->db->select(['categoryId as id', 'parentCategoryId', 'categoryName as text'])->get('asset_categories')->result_array();
        $catTree = $this->build_tree($categories);
        echo json_encode($catTree);
    }
    public function get_assignee()
    {
        $assignee = $this->db->get_where('master_employee', ['designation' => $this->input->get('role_id')])->result();
        echo json_encode(['status' => true, 'assignee' => $assignee]);
    }

    public function single_category()
    {
        $category = $this->db->select('asset_categories.*')
            ->where('asset_categories.categoryId', $this->input->get('category_id'))
            ->get('asset_categories')
            ->row();

        if ($category) {
            // Fetch child rows
            $category->activities = $this->db->select('category_activities.*,master_job_title.id as role_id,master_job_title.name as role_name,master_employee.id as employee_id,master_employee.first_name as employee_name')
                ->join('master_job_title', 'category_activities.activity_assignee_role=master_job_title.id', 'left')
                ->join('master_employee', 'master_employee.id=category_activities.activity_assignee', 'left')
                ->where('category_activities.activity_category_id', $category->categoryId)
                ->get('category_activities')
                ->result();
        }

        echo json_encode(['status' => true, 'category' => $category]);
    }

    public function create_category()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'categories', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $this->form_validation->set_rules('categoryName', 'Category Name', 'required|is_unique[asset_categories.categoryName]');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect($this->agent->referrer());
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
                    'billingCost' => $this->input->post('billingCost'),
                    'isCasCade' => $this->input->post('isCasCade'),
                    'allowAutoExtend' => $this->input->post('allowAutoExtend'),
                    'actualCost' => $this->input->post('actualCost'),
                    'endOfLife' => $this->input->post('endOfLife'),
                    'endOfLifeType' => $this->input->post('endOfLifeType'),
                    'depreciation' => $this->input->post('depreciation'),
                    'scrapValue' => $this->input->post('scrapValue'),
                    'scrapValueType' => $this->input->post('scrapValueType'),
                    'depreciationTaxPct' => $this->input->post('depreciationTaxPct'),
                    'defaultVendor' => $this->input->post('endOfLifeType'),
                    'autoAssign' => $this->input->post('autoAssign'),
                    'tvpActivity' => json_encode(array_values($this->input->post('tvpActivity'))),
                ]
            );
            $category_id = $this->db->insert_id();
            if (!empty($this->input->post('tvpActivity'))) {
                foreach ($this->input->post('tvpActivity') as $activity) {
                    $activity['activity_category_id'] = $category_id;
                    $this->db->insert(
                        'category_activities',
                        $activity
                    );
                }
            }
            $this->session->set_userdata('info', "1--Successfully done");
            return redirect($this->agent->referrer());
        }
    }

    public function update_category()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'categories', $this->action)) {
            redirect('admin/unauthorized-request');
        }

        $category_id = $this->input->post('category_id');
        $this->form_validation->set_rules('category_id', 'category Id', 'required');
        $this->form_validation->set_rules('categoryName', 'Category Name', 'trim|required|callback_check_name_duplicate');
        $this->form_validation->set_message('check_name_duplicate', 'Category Name already Taken, Try new');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset/all-categories');
        } else {
            $this->db->update(
                'asset_categories',
                [
                    'parentCategoryId' => $this->input->post('parentCategoryId'),
                    'categoryName' => $this->input->post('categoryName'),
                    'categoryArabicName' => $this->input->post('categoryArabicName'),
                    'categoryCode' => $this->input->post('categoryCode'),
                    'transferDuration' => $this->input->post('transferDuration'),
                    'transferDurationType' => $this->input->post('transferDurationType'),
                    'billingCost' => $this->input->post('billingCost'),
                    'isCasCade' => $this->input->post('isCasCade'),
                    'allowAutoExtend' => $this->input->post('allowAutoExtend'),
                    'actualCost' => $this->input->post('actualCost'),
                    'endOfLife' => $this->input->post('endOfLife'),
                    'endOfLifeType' => $this->input->post('endOfLifeType'),
                    'depreciation' => $this->input->post('depreciation'),
                    'scrapValue' => $this->input->post('scrapValue'),
                    'scrapValueType' => $this->input->post('scrapValueType'),
                    'depreciationTaxPct' => $this->input->post('depreciationTaxPct'),
                    'defaultVendor' => $this->input->post('endOfLifeType'),
                    'autoAssign' => $this->input->post('autoAssign'),
                    'tvpActivity' => json_encode(array_values($this->input->post('tvpActivity'))),
                ],
                ['categoryId' => $this->input->post('category_id')]
            );
            $this->db->delete('category_activities', ['activity_category_id' => $this->input->post('category_id')]);
            if (!empty($this->input->post('tvpActivity'))) {
                echo '<pre>';
                print_r($this->input->post('tvpActivity'));
                die();
                foreach ($this->input->post('tvpActivity') as $activity) {
                    $activity['activity_category_id'] = $this->input->post('category_id');
                    $this->db->insert(
                        'category_activities',
                        $activity
                    );
                }
            }

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset/all-categories');
        }
    }

    public function delete_category()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'categories', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $id = $this->input->get('id');
        $this->db->delete('asset_categories', ['categoryId' => $id]);
        $this->session->set_userdata('info', "1--Successfully done");
        return redirect('admin/asset/all-categories');
    }


    public function check_name_duplicate()
    {
        $id = $this->input->post('category_id');
        $category_name = $this->input->post('categoryName');
        $duplicate_check = $this->db->where('categoryId!=', $id)->where('categoryName', $category_name)->get('asset_categories')->result();
        if (count($duplicate_check) > 0) {
            return false;
        } else {
            return true;
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
