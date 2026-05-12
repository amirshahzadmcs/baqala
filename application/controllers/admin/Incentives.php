<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Incentives extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect("admin");
		}
		$this->load->model('admin/Incentives_model');
		$this->load->library('form_validation');
		$this->action = $this->router->method;
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_target_and_incentive', $this->action)) {
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
		//$data['results'] = $this->Incentives_model->get_list();
		//print_r($data['results']);exit();
		$this->load->view('admin/incentives/incentives_list', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_target_and_incentive', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		return $this->load->view('admin/incentives/incentives_form');
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_target_and_incentive', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$data['incentive_info'] = $this->Incentives_model->get_incentives($id);
			$data['incentive_slabs'] = $this->Incentives_model->get_incentive_slabs($id);
			//dd($data['incentive_slabs']);
			return $this->load->view('admin/incentives/incentives_edit', $data);
		} else {
			$this->session->set_userdata('info', "2--No record found!");
			$this->load->view('admin/incentives/incentives_list');
		}
	}

	public function get_list()
	{
		$fetch_data = $this->Incentives_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->id;
			$sub_array[] = $item->incentive_name;
			$sub_array[] = $item->incentive_period;
			$sub_array[] = $item->target;
			$sub_array[] = $item->deduction;
			$sub_array[] = $item->daily_bonus;
			$sub_array[] = $item->monthly_bonus;
			$sub_array[] = ($item->total_riders > 0) ? '<button type="button" class="btn btn-link border text-center view-incentive-employees" data-incentiveid="' . $item->id . '">' . $item->total_riders . '</a>' : '<button type="button" class="btn btn-link border text-center" disabled>' . $item->total_riders . '</a>';
			$sub_array[] = $item->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			$sub_array[] = (isset($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : 'NA';
			$status_btn = '<button type="button" 
				class="btn btn-outline-secondary btn-custom-light btn-sm update-status" 
				data-id="' . $item->id . '" 
				data-status="' . $item->status . '" 
				title="Update Status">
				<i class="mdi mdi-refresh font-size-18"></i>
			</button>';
			$actions = '';
			if (check_action_permission(get_user_role(), 'delivery_target_and_incentive', 'edit')) {
				$actions .= '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/incentives/edit?id=' . $item->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> ';
				$actions .= '<a class="btn btn-outline-secondary btn-custom-light btn-sm" title="Print Incentive" href="' . base_url() . 'admin/incentives/export-detail-pdf/' . $item->id . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a> ';
				$actions .= $status_btn;
			}
			$sub_array[] = $actions;

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Incentives_model->get_all_data(),
			"recordsFiltered"     =>     $this->Incentives_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function save()
	{
		//dd($this->input->post());
		$this->form_validation->set_rules('incentive_name', 'Incentive Name', 'required');
		$this->form_validation->set_rules('incentive_period', 'Incentive Period', 'required');
		$this->form_validation->set_rules('target', 'Monthly Target', 'required|numeric');
		$this->form_validation->set_rules('deduction', 'Deduction', 'required|numeric');
		$this->form_validation->set_rules('daily_bonus', 'Daily Bonus', 'required|numeric');
		$this->form_validation->set_rules('monthly_bonus', 'Monthly Bonus', 'required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('slab_start[]', 'Slab Start', 'trim|required');
		$this->form_validation->set_rules('slab_end[]', 'Slab End', 'trim|required');
		$this->form_validation->set_rules('commission[]', 'Commission', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => false, 'message' => validation_errors()]);
			return;
		}

		$incentive_data = [
			'incentive_name' => $this->input->post('incentive_name'),
			'incentive_period' => $this->input->post('incentive_period'),
			'target' => $this->input->post('target'),
			'deduction' => $this->input->post('deduction'),
			'daily_bonus' => $this->input->post('daily_bonus'),
			'monthly_bonus' => $this->input->post('monthly_bonus'),
			'acceptance_penalty_450' => $this->input->post('acceptance_penalty_450'),
			'acceptance_penalty_less_450' => $this->input->post('acceptance_penalty_less_450'),
			'contact_penalty_450' => $this->input->post('contact_penalty_450'),
			'contact_penalty_less_450' => $this->input->post('contact_penalty_less_450'),
			'decline_penalty' => $this->input->post('decline_penalty'),
			'status' => $this->input->post('status')
		];

		// Insert the incentive and get the ID
		$this->db->insert('incentives', $incentive_data);
		$incentive_id = $this->db->insert_id();

		if ($incentive_id) {
			// Prepare additional data arrays
			$slab_starts = $this->input->post('slab_start');
			$slab_ends = $this->input->post('slab_end');
			$commissions = $this->input->post('commission');

			// Prepare data for batch insert
			$additional_data = array();
			for ($i = 0; $i < count($slab_starts); $i++) {
				$additional_data[] = array(
					'incentive_id' => $incentive_id,
					'slab_start' => $slab_starts[$i],
					'slab_end' => $slab_ends[$i],
					'commission' => $commissions[$i]
				);
			}
			// Insert slabs in batch
			$this->db->insert_batch('incentive_range', $additional_data);
			echo json_encode(['status' => true, 'message' => 'Incentive saved successfully']);
		} else {
			echo json_encode(['status' => false, 'message' => 'Error saving incentive']);
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Incentive Id', 'required');
		$this->form_validation->set_rules('incentive_name', 'Incentive Name', 'required');
		$this->form_validation->set_rules('incentive_period', 'Incentive Period', 'required');
		$this->form_validation->set_rules('target', 'Monthly Target', 'required|numeric');
		$this->form_validation->set_rules('deduction', 'Deduction', 'required|numeric');
		$this->form_validation->set_rules('daily_bonus', 'Daily Bonus', 'required|numeric');
		$this->form_validation->set_rules('monthly_bonus', 'Monthly Bonus', 'required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('slab_start[]', 'Slab Start', 'trim|required');
		$this->form_validation->set_rules('slab_end[]', 'Slab End', 'trim|required');
		$this->form_validation->set_rules('commission[]', 'Commission', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => false, 'message' => validation_errors()]);
			return;
		}

		$incentive_id = $this->input->post('id');
		$incentive_data = [
			'incentive_name' => $this->input->post('incentive_name'),
			'incentive_period' => $this->input->post('incentive_period'),
			'target' => $this->input->post('target'),
			'deduction' => $this->input->post('deduction'),
			'daily_bonus' => $this->input->post('daily_bonus'),
			'monthly_bonus' => $this->input->post('monthly_bonus'),
			'acceptance_penalty_450' => $this->input->post('acceptance_penalty_450'),
			'acceptance_penalty_less_450' => $this->input->post('acceptance_penalty_less_450'),
			'contact_penalty_450' => $this->input->post('contact_penalty_450'),
			'contact_penalty_less_450' => $this->input->post('contact_penalty_less_450'),
			'decline_penalty' => $this->input->post('decline_penalty')
		];

		$this->db->trans_start(); // Start transaction

		if ($incentive_id) {
			// Update existing incentive
			$this->db->where('id', $incentive_id);
			$this->db->update('incentives', $incentive_data);

			// Delete old slabs before inserting new ones
			$this->db->where('incentive_id', $incentive_id);
			$this->db->delete('incentive_range');

			// Prepare additional data arrays
			$slab_starts = $this->input->post('slab_start');
			$slab_ends = $this->input->post('slab_end');
			$commissions = $this->input->post('commission');

			// Prepare data for batch insert
			$additional_data = array();
			for ($i = 0; $i < count($slab_starts); $i++) {
				$additional_data[] = array(
					'incentive_id' => $incentive_id,
					'slab_start' => $slab_starts[$i],
					'slab_end' => $slab_ends[$i],
					'commission' => $commissions[$i]
				);
			}

			// Batch insert into the incentive_details table
			$this->db->insert_batch('incentive_range', $additional_data);

			$this->db->trans_complete(); // Complete transaction

			if ($this->db->trans_status() === FALSE) {
				echo json_encode(['status' => false, 'message' => 'Database error while saving incentive']);
			} else {
				echo json_encode(['status' => true, 'message' => 'Incentive updated successfully']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'Error saving incentive']);
		}
	}
	
	public function update_status()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$unassign = $this->input->post('unassign');

		if (empty($id) || empty($status)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		// Start database transaction
		$this->db->trans_begin();

		// Update incentive status
		$this->db->where('id', $id);
		$this->db->update('incentives', [
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s')
		]);

		// If deactivating and unassigning riders
		if ($status === 'inactive' && $unassign === 'true') {
			$this->db->where('incentive_id', $id);
			$this->db->update('logistic_rider', [
				'incentive_id' => NULL,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		// Check for any query failure
		if ($this->db->trans_status() === FALSE) {
			// Rollback changes if any query failed
			$this->db->trans_rollback();
			echo json_encode([
				'status' => 'error',
				'message' => 'Failed to update incentive status.'
			]);
			return;
		}

		// Commit the transaction if all queries succeeded
		$this->db->trans_commit();

		echo json_encode([
			'status' => 'success',
			'message' => 'Incentive status updated successfully.'
		]);
	}

	// Export Incentive List as PDF
	public function Export_pdf_all()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_target_and_incentive', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$this->load->library('Pdf_employee_offer');
		$postData = $this->input->post();
		$query = $this->Incentives_model->print_incentive();
		if ($query) {
			$data['detail'] = $query;
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Delivery Incentive Slab');
			$pdf->SetSubject('BS - Delivery Incentive Slab');
			$pdf->SetKeywords('Baqala Station, PDF, Delivery Incentive Slab, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 8);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage('P', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);
			$htmlcontent = $this->load->view('admin/incentives/print/incentive-list', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Delivery-incentive-list-' . date('d-m-Y') . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Delivery incentive detail not found!");
			redirect('admin/hr/employees');
		}
	}

	// Export Incentive List as PDF
	public function Export_pdf_single($id)
	{
		$this->load->library('Pdf_employee_offer');
		$postData = $this->input->post();
		if ($id) {
			$data['incentive_info'] = $this->Incentives_model->get_incentives($id);
			$data['incentive_slabs'] = $this->Incentives_model->get_incentive_slabs($id);
			$data['incentive_employees'] = $this->Incentives_model->get_incentive_employees($id);
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Delivery Incentive Slab');
			$pdf->SetSubject('BS - Delivery Incentive Slab');
			$pdf->SetKeywords('Baqala Station, PDF, Delivery Incentive Slab, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 8);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage('P', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);
			$htmlcontent = $this->load->view('admin/incentives/print/incentive-detail', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Delivery-incentive-detail-' . date('d-m-Y') . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Delivery incentive detail not found!");
			redirect('admin/hr/employees');
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_target_and_incentive', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');

		if (empty($ids)) {
			$this->session->set_userdata('info', "2--No records selected");
			redirect('admin/incentives/list');
			return;
		}

		$idList = implode(',', $ids);
		$query = $this->Incentives_model->delete($idList);

		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error deleting records");
		}

		redirect('admin/incentives/list');
	}

	public function incentiveEmployees()
	{
		header('Content-Type: application/json'); // Ensure JSON response

		$this->form_validation->set_rules('id', 'Incentive ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$id = $this->input->post('id');
		$incentive_detail = $this->Incentives_model->get_incentives($id);

		if ($incentive_detail) {
			$data['incentive_info'] = $incentive_detail;
			$data['employees_list'] = $this->Incentives_model->get_incentive_employees($id);
			//dd($data['employees_list']);
			$output_data = $this->load->view('admin/incentives/components/employee-list', $data, TRUE);

			echo json_encode(["type" => 'success', "message" => 'Rider list successfully fetched.', "output_html" => $output_data]);
		} else {
			echo json_encode(["type" => 'error', "message" => 'Rider list not found, try another incentive.']);
		}
	}
}
