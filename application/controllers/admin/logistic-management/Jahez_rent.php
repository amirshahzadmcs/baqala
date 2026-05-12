<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jahez_rent extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->admin->isLogged()) {
            redirect('admin/common/login');
        }

        $this->load->model('admin/logistic-management/Jahez_rent_model');
        $this->load->model('admin/masters/city_model');
        $this->load->helper('common_helper');
        $this->load->library('form_validation');

        $this->action = $this->router->fetch_method();
    }

    /* ================================
       PAGE LOAD
    ================================== */
    public function index()
	{
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', $this->action)) {
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
		$data['cities'] = $this->city_model->get_cities()->result();
		$data['search'] = '';
		$data['perPage'] = 50;

		// ✅ Load user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'jahez_rent'
		])->row();

		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		//print_r($data['reports']);exit();
		$this->load->view('admin/logistic-management/jahez_rent/index', $data);
	}

    /* ================================
       AJAX LIST FOR DATATABLE
    ================================== */
    public function get_list()
    {
        $search   = $this->input->post('search') ?? '';
        $perPage  = $this->input->post('length') ?? 50;
        $start    = $this->input->post('start') ?? 0;
        $date_from = $this->input->post('date_from') ?? null;
		$date_to   = $this->input->post('date_to') ?? null;

        $fetch_data = $this->Jahez_rent_model->list($search, $perPage, $start, $date_from, $date_to);

        $i = $start + 1;
        $tableData = [];

        // Fetch visible column settings for the current user
        $pref = $this->db->select('visible_columns')
            ->from('user_column_preferences')
            ->where('user_id', $this->admin->getLoginEmpId())
            ->where('module_name', 'jahez_rent')
            ->get()
            ->row_array();

        // Convert JSON into array
        $visibleColumns = (!empty($pref['visible_columns']))
            ? json_decode($pref['visible_columns'], true)
            : [];

        foreach ($fetch_data['data'] as $item) {
            $row = [];
            $row[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="'.$item['id'].'">';
            $row[] = $i++;

            foreach ($visibleColumns as $column) {
                if ($column == 'id') continue;

                switch ($column) {
                    case 'agreement_date':
                        $row[] = !empty($item[$column]) ? date('d-m-Y', strtotime($item[$column])) : '';
                        break;

                    default:
                        $row[] = htmlspecialchars($item[$column] ?? '');
                }
            }
            // Always last
            $actionDropdown = '';
			// Action buttons dropdown
			$actionDropdown = '<div class="btn-group ms-2 float-end">
            <button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="dripicons-dots-3"></i></button>
            <div class="dropdown-menu dropdown-menu-end">';
            if (check_action_permission(get_user_role(), 'jahez_rent', 'edit')) {
            $actionDropdown .= '<a type="button" class="dropdown-item" onclick="editRentPopup(' . $item['id'] . ')"><i class="mdi mdi-pencil me-2"></i> Edit</a>';
            }
            if (check_action_permission(get_user_role(), 'jahez_rent', 'detail')) {
            $actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0);" onclick="detailRentPopup(' . $item['id'] . ')"><i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail</a>';
            }
            if (check_action_permission(get_user_role(), 'jahez_rent', 'print_agreement_letter')) {
			$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/logistic-management/jahez-rent/print-rent-agreement/' . $item['id']) . '" target="_blank"><i class="mdi mdi-printer me-2"></i> Print Agreement</a>';
            }
			$actionDropdown .= '</div></div>';
            $row[] = $actionDropdown;
            $tableData[] = $row;
        }
        $output = [
            "draw"            => intval($this->input->post("draw")),
            "recordsTotal"    => $fetch_data['pagination']['total'],
            "recordsFiltered" => $fetch_data['pagination']['total'],
            "data"            => $tableData
        ];
        echo json_encode($output);
    }

    public function add()
	{
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['cities'] = $this->city_model->get_cities()->result();
		$data['agreement_id'] = $this->db->query("SELECT id FROM jahez_rent ORDER BY id desc limit 1")->row();
		$output_data = $this->load->view('admin/logistic-management/jahez_rent/components/add-form', $data, TRUE);
		echo $output_data;
	}

	public function edit()
	{
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		if (!$id) {
			echo "<div class='alert alert-danger'>Invalid request ID!</div>";
			return;
		}
		// Fetch record
		$data['rent_detail'] = $this->Jahez_rent_model->get_detail($id);
		if (empty($data['rent_detail'])) {
			echo "<div class='alert alert-danger'>Rent record not found!</div>";
			return;
		}
		// Load required dropdown data
		$data['cities'] = $this->city_model->get_cities()->result();
		// Return HTML to AJAX
		$html = $this->load->view(
			'admin/logistic-management/jahez_rent/components/edit-form',
			$data,
			TRUE
		);

		echo $html;
	}

    /* ================================
       CREATE
    ================================== */
    public function save()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', 'add')) {
			redirect('admin/unauthorized-request');
		}
        $this->form_validation->set_rules('agreement_no', 'Agreement No', 'trim|required');
        $this->form_validation->set_rules('agreement_date', 'Agreement Date', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(["status" => "error", "msg" => validation_errors()]);
            return;
        }
		
		// -------------------------------
		// File Uploads
		// -------------------------------
		$iqama_copy = $this->upload_file('iqama_copy');
		$dl_copy = $this->upload_file('driving_license_copy');

        $data = [
            "agreement_no"   => $this->input->post('agreement_no'),
            "agreement_date" => $this->input->post('agreement_date'),
            "name"           => $this->input->post('name'),
            "iqama_no"       => $this->input->post('iqama_no'),
            "city"           => $this->input->post('city'),
            "mobile_no"      => $this->input->post('mobile_no'),
            "email_id"       => $this->input->post('email_id'),
            "added_by"       => $this->admin->getLoginEmpId(),
			"iqama_copy"     => $iqama_copy,
			"driving_license_copy" => $dl_copy,
            "created_at"     => date('Y-m-d H:i:s')
        ];

        $id = $this->Jahez_rent_model->save($data);

        echo json_encode(["status" => "success", "msg" => "Record saved successfully!", "id" => $id]);
    }

    /* ================================
       UPDATE
    ================================== */
    public function update()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', 'edit')) {
			redirect('admin/unauthorized-request');
		}
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(["status"=>"error","msg"=>"Invalid ID"]);
            return;
        }
        $this->form_validation->set_rules('agreement_date', 'Agreement Date', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(["status"=>"error", "msg"=>validation_errors()]);
            return;
        }
		
		$existing = $this->Jahez_rent_model->get_detail($id);
        $iqama_copy = $this->upload_file('iqama_copy') ?: $existing->iqama_copy;
		$dl_copy    = $this->upload_file('driving_license_copy') ?: $existing->driving_license_copy;

        $data = [
            "agreement_date" => $this->input->post('agreement_date'),
            "name"           => $this->input->post('name'),
            "iqama_no"       => $this->input->post('iqama_no'),
            "city"           => $this->input->post('city'),
            "mobile_no"      => $this->input->post('mobile_no'),
            "email_id"       => $this->input->post('email_id'),
			"iqama_copy"     => $iqama_copy,
			"driving_license_copy" => $dl_copy,
            "updated_at"     => date('Y-m-d H:i:s')
        ];

        $this->Jahez_rent_model->update($id, $data);

        echo json_encode(["status"=>"success", "msg"=>"Updated successfully"]);
    }
	
	private function upload_file($field)
    {
        if (!empty($_FILES[$field]['name'])) {

            $config['upload_path'] = './uploads/jahez_rent/';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($field)) {
                return 'uploads/jahez_rent/' . $this->upload->data('file_name');
            }
        }

        return null;
    }

    /* ================================
       DETAIL
    ================================== */
    public function detail()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', $this->action)) {
			redirect('admin/unauthorized-request');
		}
        $id = $this->input->get('id');
        $data['rent_detail'] = $this->Jahez_rent_model->get_detail($id);

        $html = $this->load->view('admin/logistic-management/jahez_rent/components/detail', $data, TRUE);
        echo $html;
    }

    /* ================================
       DELETE
    ================================== */
    public function delete()
	{
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Jahez_rent_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Deleted successfully");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/jahez-rent');
	}
	
	public function delete_document()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', 'edit')) {
			redirect('admin/unauthorized-request');
		}
        $id = $this->input->post('id');
        $field = $this->input->post('field');

        // Safety Check
        $allowedFields = ['iqama_copy', 'driving_license_copy', 'iban_certificate'];

        if (!in_array($field, $allowedFields)) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid document type']);
            return;
        }

        // Get record
        $detail = $this->Jahez_rent_model->get_detail($id);
        if (!$detail) {
            echo json_encode(['status' => 'error', 'msg' => 'Record not found']);
            return;
        }

        $filePath = $detail->$field;

        if (!empty($filePath) && file_exists(FCPATH . $filePath)) {
            unlink(FCPATH . $filePath); // delete file
        }

        // Update DB field to empty
        $this->Jahez_rent_model->update($id, [ $field => NULL ]);

        echo json_encode([
            'status' => 'success',
            'msg' => ucfirst(str_replace('_', ' ', $field)) . " deleted successfully"
        ]);
    }
	
	public function print_agreement_letter($id){
        if ($this->action && !check_action_permission(get_user_role(), 'jahez_rent', $this->action)) {
			redirect('admin/unauthorized-request');
		}
        if (empty($id)) {
            $this->session->set_userdata('info', "2--Invalid ID!!");
            redirect('admin/logistic-management/jahez-rent');
            return;
        }
		$data['rent_detail'] = $this->Jahez_rent_model->get_detail($id);
		$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		$data['issue_date'] = date('jS M Y', strtotime($data['rent_detail']->agreement_date));
		$class_name = 'Pdf_general_margin';
		$this->load->library($class_name);
	    
		//print_r($data['cv_detail']);exit();
		if(!empty($data['rent_detail'])){
			// create new PDF document
			$pdf = new $class_name(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Jahez Rent Agreement');
			$pdf->SetSubject('BS - Jahez Rent Agreement');
			$pdf->SetKeywords('Baqala Station, PDF, Jahez Rent Agreement, Employee');
			
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true); 
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);
			
			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			// Conditional top margin setting
			$pdf->SetMargins(10, 40, 11, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 20);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage();
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 11);
			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/jahez_rent/print/rent_agreement',compact('data'),TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Rent_Agreement_'.$data['rent_detail']->name.'_'. $data['rent_detail']->agreement_no .'.pdf', 'I');
		}else{
			$this->session->set_userdata('info', "2--Rent detail not found!");
			redirect('admin/logistic-management/jahez-rent');
		}
	}
}
