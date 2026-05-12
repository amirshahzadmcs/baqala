<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vouchers extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect("admin");
		}
		$this->load->model('admin/Voucher_model');
		$this->load->model('admin/Sim_model');
		$this->load->model('admin/Network_model');
		$this->load->helper('common_helper');
		$this->load->library('form_validation');
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['sim_list'] = $this->Sim_model->get_running_sims();
		$data['networks'] = $this->Network_model->networks();
		$data['total_voucher'] = $this->Voucher_model->total_voucher();
		$data['active_voucher'] = $this->Voucher_model->active_voucher();
		$data['used_voucher'] = $this->Voucher_model->used_voucher();
		$data['expired_voucher'] = $this->Voucher_model->expired_voucher();
		//$data['duplicate_voucher'] = $this->Voucher_model->duplicate_voucher();
		//'<pre>';print_r($data);'</pre>';exit();
		return $this->load->view('admin/voucher/list', $data);
	}

	public function get_list()
	{
		if (!empty($this->input->get('network'))) {
			$network = $this->input->get('network');
		} else {
			$network = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('purchase_from'))) {
			$purchase_from = $this->input->get('purchase_from');
		} else {
			$purchase_from = FALSE;
		}
		if (!empty($this->input->get('purchase_to'))) {
			$purchase_to = $this->input->get('purchase_to');
		} else {
			$purchase_to = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$startDate = $this->input->get('from');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$endDate = $this->input->get('to');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		$fetch_data = $this->Voucher_model->get_list($network, $status, $purchase_from, $purchase_to, $startDate, $endDate, $keyword);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->purchase_date));
			$sub_array[] = $item->network_name;
			$sub_array[] = $item->total_vouchers;
			$sub_array[] = $item->voucher_value;
			$sub_array[] = $item->voucher_vat;
			$sub_array[] = $item->voucher_total;
			$sub_array[] = date('d-m-Y', strtotime($item->expiry_date));
			// if($item->status == '0'){
			// 	$status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
			// }
			// if($item->status == '1'){
			// 	$status = '<span class="badge badge-pill badge-soft-success font-size-13">Used</span>';
			// }
			// if($item->status == '2'){
			// 	$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Expired</span>';
			// }
			// $sub_array[] = $status;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			$sub_array[] = (isset($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : 'NA';
			if ($item->status == '0') {
				$edit_button = check_action_permission(get_user_role(), 'vouchers', 'edit') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/sim/vouchers/edit?id=' . $item->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			} else {
				$edit_button = '';
			}
			$sub_array[] = $edit_button . (check_action_permission(get_user_role(),'vouchers','detail') ? ' <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/sim/vouchers/detail?id=' . $item->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Voucher_model->get_all_data(),
			"recordsFiltered"     =>     $this->Voucher_model->get_filtered_data($network, $status, $purchase_from, $purchase_to, $startDate, $endDate, $keyword),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		$data['sim_list'] = $this->Sim_model->get_running_sims();
		$data['networks'] = $this->Network_model->networks();
		return $this->load->view('admin/voucher/form', $data);
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$id = $this->input->get('id');
		$query = $this->Voucher_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['voucher_detail'] = $query->row();
			$data['voucher_list'] =  $this->Voucher_model->get_group_vouchers($id);
			$data['sim_list'] = $this->Sim_model->get_running_sims();
			$data['networks'] = $this->Network_model->networks();
			return $this->load->view('admin/voucher/edit', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/sim/vouchers');
		}
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$id = $this->input->get('id');
		$query = $this->Voucher_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['voucher_detail'] = $query->row();
			$data['voucher_list'] =  $this->Voucher_model->get_group_vouchers($id);
			$data['sim_list'] = $this->Sim_model->get_running_sims();
			$data['networks'] = $this->Network_model->networks();
			return $this->load->view('admin/voucher/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/sim/vouchers');
		}
	}

	public function save()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('sim_network', 'Sim Network Name', 'trim|required');
		$this->form_validation->set_rules('total_vouchers', 'Total Vouchers Purchased', 'trim|required');
		$this->form_validation->set_rules('voucher_value', 'Voucher Value', 'trim|required');
		$this->form_validation->set_rules('voucher_vat', 'Voucher Vat', 'trim|required');
		$this->form_validation->set_rules('voucher_total', 'Voucher Total Value', 'trim|required');
		$this->form_validation->set_rules('purchase_date', 'Voucher Purchase Date', 'trim|required');
		$this->form_validation->set_rules('expiry_date', 'Voucher Expiry Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Voucher_model->add();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}
		redirect('admin/sim/vouchers');
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Voucher Group Name', 'trim|required');
		$this->form_validation->set_rules('sim_network', 'Sim Network Name', 'trim|required');
		$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|required|callback_check_voucher_duplicate');
		$this->form_validation->set_message('check_voucher_duplicate', 'Duplicate serial number, Try new');
		$this->form_validation->set_rules('voucher_value', 'Voucher Value', 'trim|required');
		$this->form_validation->set_rules('voucher_vat', 'Voucher Vat', 'trim|required');
		$this->form_validation->set_rules('voucher_total', 'Voucher Total Value', 'trim|required');
		$this->form_validation->set_rules('expiry_date', 'Voucher Expiry Date', 'trim|required');
		$this->form_validation->set_rules('purchase_date', 'Voucher Purchase Date', 'trim|required');
		$this->form_validation->set_rules('status', 'Voucher Expiry Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Voucher_model->edit();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/sim/vouchers');
	}

	public function check_voucher_duplicate()
	{
		$id = $this->input->post('id');
		$serial_number = $this->input->post('serial_number');
		$duplicate_check = $this->Voucher_model->check_duplicate_voucher($id, $serial_number);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Voucher_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/sim/vouchers');
	}

	/*------- Add Voucher in Group ------*/
	public function add_vouchers()
	{
		$this->form_validation->set_rules('serial_no[]', 'Serial Number', 'trim|required');
		$this->form_validation->set_rules('group_id', 'Group ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$group_id = $this->input->post('group_id');
			$serial_no = $this->input->post('serial_no');

			$updateArray = array();

			for ($x = 0; $x < sizeof($serial_no); $x++) {

				$updateArray[] = array(
					'group_id' => $group_id,
					'serial_no' => $serial_no[$x]
				);
			}
			$query = $this->db->insert_batch('sim_recharge_vouchers_list', $updateArray);
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}
		redirect('admin/sim/vouchers/edit?id=' . $group_id);
	}

	public function update_vouchers()
	{
		$this->form_validation->set_rules('serial_no[]', 'Serial Number', 'trim|required');
		$this->form_validation->set_rules('id[]', 'Vouchers ID', 'trim|required');
		$this->form_validation->set_rules('group_id', 'Group ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$group_id = $this->input->post('group_id');
			$id = $this->input->post('id');
			$serial_no = $this->input->post('serial_no');

			$updateArray = array();

			for ($x = 0; $x < sizeof($id); $x++) {

				$updateArray[] = array(
					'id' => $id[$x],
					'serial_no' => $serial_no[$x]
				);
			}
			$query = $this->db->update_batch('sim_recharge_vouchers_list', $updateArray, 'id');
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}
		redirect('admin/sim/vouchers/edit?id=' . $group_id);
	}

	public function add_bulk_voucher()
	{
		return $this->load->view("admin/voucher/bulk_voucher_form");
	}

	//Check Duplicate entry in csv
	public function check_duplicate()
	{
		$csvFile = $_FILES['csv_file_check']['tmp_name'];
		if (is_uploaded_file($_FILES['csv_file_check']['tmp_name'])) {
			$handle = fopen($csvFile, "r");
			if ($handle) {
				$cnt = 0;
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$config[] = $data[2];
					$num = count($config);
					$cnt++;

					$arr = array();
					$arrdup = array();
					for ($c = 0; $c < $num; $c++) {
						if (in_array($config[$c], $arr)) {
							$arrdup[] = "Duplicate value at " . $c;
						} else {
							$arr[] = $config[$c];
						}
					}
					//print_r($arr);exit();

				}
				//print_r($arrdup);exit();
				if (count($arrdup) > 0) {
					$msg = implode(', ', $arrdup);
					$this->session->set_userdata('info', "2--" . $msg);
				} else {
					$this->session->set_userdata('info', "1--There is no duplicate value in csv");
				}
				fclose($handle);
			} else {
				$this->session->set_userdata('info', "2--Unable to open file");
			}
		} else {
			$this->session->set_userdata('info', "2--Please upload file");
		}
		redirect('admin/voucher/add_bulk_voucher');
	}

	public function add_bulk()
	{
		if (is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
			$csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
			//print_r(fgetcsv($csvFile));exit();
			//parse data from csv file line by line
			fgetcsv($csvFile);
			while (($line = fgetcsv($csvFile)) !== FALSE) {
				//print_r($line);exit();
				$config['voucher_name'] = $line[1];
				$config['voucher_code'] = $line[2];
				$config['voucher_value'] = $line[3];
				$config['expiry_date'] = $line[4];
				//print_r($config);exit();
				$this->Voucher_model->add_bulk($config);
			}
			//print_r($line);exit();
			fclose($csvFile);
			$this->session->set_userdata('info', "1--CSV successfully uploaded");
		} else {
			$this->session->set_userdata('info', "2--Please upload file");
		}
		redirect('admin/voucher');
	}

	public function set_status()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('_from', 'Frrom', 'trim|required');
			$this->form_validation->set_rules('_to', 'To', 'trim|required');
			$this->form_validation->set_rules('status', 'Voucher Status', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
			}
			if ($this->input->post('status') == 1) {
				$query = $this->Voucher_model->setStatusEnable();
			} else {
				$query = $this->Voucher_model->setStatusDisable();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/voucher');
		} else {
			redirect('admin');
		}
	}

	public function deactivate_vouchers()
	{
		if ($this->admin->isLogged()) {
			$query = $this->Voucher_model->setStatusDisable();
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/voucher');
		} else {
			redirect('admin');
		}
	}

	public function report_list()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/voucher/voucher_report', $data);
	}

	public function get_report_list()
	{
		$fetch_data = $this->Voucher_model->get_report_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $report) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $report->s_no;
			$sub_array[] = $report->voucher_code;
			$sub_array[] = $report->expiry_date;
			$sub_array[] = $report->voucher_value;
			$sub_array[] = $report->is_used == 1 ? '<div class="label label-danger">Used</div>' : '<div class="label label-primary">Unused</div>';;
			$sub_array[] = $report->name;
			$sub_array[] = $report->mobile;
			$sub_array[] = $report->email;
			$data[] = $sub_array;
		}

		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Voucher_model->get_all_report_data(),
			"recordsFiltered"     =>     $this->Voucher_model->get_report_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function print_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->load->library('Pdf_requisition');
		$id = $this->input->get('id');
		$id = $this->input->get('id');
		$query = $this->Voucher_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['voucher_detail'] = $query->row();
			$data['voucher_list'] =  $this->Voucher_model->get_group_vouchers($id);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/sim/vouchers');
		}
		//print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_requisition(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Recharge Voucher Detail');
		$pdf->SetSubject('Recharge Voucher Detail');
		$pdf->SetKeywords('Baqala Station, PDF, Recharge Voucher Detail, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->SetPrintFooter(false);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(0, 5, 0, true);

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
		$pdf->AddPage();
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/voucher/print-voucher-detail', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('Recharge Voucher Detail' . $data['voucher_detail']->id . '.pdf', 'I');
	}
}
