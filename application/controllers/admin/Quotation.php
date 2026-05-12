<?php defined('BASEPATH') or exit('No direct script access allowed');

class Quotation extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect("admin");
		}
		$this->load->model('admin/Quotation_model');
		$this->load->model('Order_model');
		$this->load->model('admin/Notification_model');
		$this->load->library('form_validation');
		$this->load->library('ci_qr_code');
		$this->config->load('qr_code');
		$this->load->helper('sendmail_helper');
		$this->load->helper('common_helper');
		$this->action = $this->router->method;
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'quotation', $this->action)) {
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
		$data['customers'] = $this->Quotation_model->get_customer();
		$this->load->view('admin/quotation/list', $data);
	}

	public function create_order()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'quotation', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('customer_id', 'Select Customer', 'trim|required');
		$this->form_validation->set_rules('date_added', 'Quotation Date', 'trim|required');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
		$this->form_validation->set_rules('address_id', 'Select Address', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$order_id = $this->Quotation_model->createOrder();
			//$order_id = 0;
			if ($order_id > 0) {
				$this->session->set_userdata('info', "1--Successfully created");
				redirect("admin/quotation/edit?id=" . $order_id);
				exit();
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			}
		}
		redirect("admin/quotation/list");
	}

	public function update_basic_info()
	{
		$this->form_validation->set_rules('quote_id', 'Quotation Number', 'trim|required');
		$this->form_validation->set_rules('customer_id', 'Customer ID', 'trim|required');
		$this->form_validation->set_rules('date_added', 'Quotation Date', 'trim|required');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
		$this->form_validation->set_rules('address_id', 'Select Address', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$order_id = $this->input->post('quote_id');
			$query = $this->Quotation_model->updateOrderInfo();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully created");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			}
		}
		redirect("admin/quotation/edit?id=" . $order_id);
	}

	/*------ Search product -----*/
	public function get_search_list()
	{
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Quotation_model->get_search_hint($data['term']);
		echo json_encode($data);
	}

	public function form()
	{
		if ($this->input->get('id')) {
			$data['result'] = $this->Quotation_model->get_order($this->input->get('id'));
			if ($data['result']['order']['quotation_status'] == 'accept') {
				$this->session->set_userdata('info', "2--You can't edit this quotation after accepted!");
				redirect("admin/quotation/list");
			} else {
				$this->load->view('admin/quotation/form', $data);
			}
		} else {
			$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			redirect("admin/quotation/list");
		}
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'quotation', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data['result'] = $this->Quotation_model->get_order($this->input->get('id'));
			$this->load->view('admin/quotation/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid quotation, try again!!!");
			redirect("admin/quotation/list");
		}
	}

	public function add_product_to_order()
	{
		$id = $this->input->post("order_id");
		$product_id = $this->input->post("product_id");
		$duplicate = $this->Quotation_model->check_duplicate($id, $product_id);
		if ($duplicate) {
			$data = "Product already added to quotation.";
		} else {
			$query = $this->Quotation_model->add_to_quotation();
			if ($query) {
				//$this->session->set_userdata('info', "1--Product successfully added to quotation.");
				$data = "Product successfully added to quotation.";
			} else {
				$data = "Something went wrong, try again!!!";
			}
		}
		echo $data;
		//redirect("admin/quotation/edit?id=".$id);
	}

	public function update_product_to_order()
	{
		$id = $this->input->post("order_id");
		//print_r($id);exit();
		$query = $this->Quotation_model->update_quotation();
		if ($query) {
			$this->session->set_userdata('info', "1--Quotation successfully updated.");
			//$this->session->set_tempdata('success', 'Quotation successfully updated.', 3);
		} else {
			$this->session->set_userdata('info', "1--Something went wrong, try again.");
		}
		redirect("admin/quotation/edit?id=" . $id);
		exit();
		//redirect("admin/quotation/edit?id=".$id,'refresh');
	}

	public function get_list()
	{
		$fetch_data = $this->Quotation_model->get_list();
		$current_date = date('Y-m-d');
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $order) {
			$exp_date = date("Y-m-d", strtotime($order->quotation_expiry_date));
			$shipping_complete_address = $order->c_company . '<br>' . $order->s_person_name . '<br>' . $order->s_mobile . ',' . $order->s_phone . '<br>' . $order->s_address_type . '-' . $order->s_building_villa_no . ', ' . $order->s_street . '<br>' . $order->s_city . ' - ' . $order->s_postal . '<br>' . $order->s_postal;
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $order->id . '" />';
			$sub_array[] = $order->invoice_prefix . '-' . $order->quotation_no;
			$sub_array[] = $order->associate_name;
			$sub_array[] = $order->name;
			$sub_array[] = $order->c_company;
			$sub_array[] = ($order->s_phone == '') ? $order->mobile : $order->s_phone;
			$sub_array[] = $order->s_email;
			$sub_array[] = $shipping_complete_address;
			$sub_array[] = $order->order_total;
			if ($order->quotation_status == 'pending') {
				$status_message = '<span class="badge badge-pill badge-soft-secondary font-size-13"> Pending</span>';
			} elseif ($order->quotation_status == 'review') {
				$status_message = '<span class="badge badge-pill badge-soft-info font-size-13"> In Review</span>';
			} elseif ($order->quotation_status == 'reject') {
				$status_message = '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>';
			} elseif ($order->quotation_status == 'approved') {
				$status_message = '<span class="badge badge-pill bg-dark font-size-13">Approved</span>';
			} elseif ($order->quotation_status == 'accept') {
				$status_message = '<span class="badge badge-pill badge-soft-primary font-size-13">Accepted</span>';
			} elseif ($order->quotation_status == 'pending' && $current_date > $exp_date) {
				$status_message = '<span class="badge badge-pill badge-soft-warning font-size-13">Expired</span>';
			} elseif ($order->quotation_status == 'converted') {
				$status_message = '<span class="badge badge-pill badge-soft-success font-size-13">Converted</span>';
			} elseif ($order->quotation_status == 'delivered') {
				$status_message = '<span class="badge badge-pill bg-success font-size-13">Delivered</span>';
			}

			$sub_array[] = $status_message;
			$sub_array[] = date("d-m-y", strtotime($order->date_added));
			$sub_array[] = date("d-m-y", strtotime($order->quotation_expiry_date));
			$sub_array[] =
				(check_action_permission(get_user_role(), 'quotation', 'print_invoice')
					? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" target="_blank" href="' . base_url() . 'admin/quotation/print_invoice?id=' . $order->id . '"><i class="mdi mdi-printer font-size-18"></i></a>&nbsp;'
					: '') .
				(check_action_permission(get_user_role(), 'quotation', 'detail')
					? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/quotation/detail?id=' . $order->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>'
					: '');

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Quotation_model->get_all_data(),
			"recordsFiltered"     =>     $this->Quotation_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Quotation_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/quotation/list');
	}

	public function checkAccount()
	{
		$userid = $this->input->post('userid');
		$query = $this->Quotation_model->checkAccount($userid);
		if ($query) {
			$output['status'] = true;
			$output['message'] =  "Credit account available.";
		} else {
			$output['status'] = false;
			$output['message'] =  "Credit account not open yet!";
		}
		echo json_encode($output);
	}

	public function print_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'quotation', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_quotation');
		$id = $this->input->get('id');
		$data['result'] = $this->Quotation_model->get_order($id);
		// create new PDF document
		$Pdf_quotation = new Pdf_quotation(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_quotation->SetCreator(PDF_CREATOR);
		$Pdf_quotation->SetAuthor('Baqala Station');
		$Pdf_quotation->SetTitle('Quotation/Bill of Supply/Cash Memo');
		$Pdf_quotation->SetSubject('Order Invoice');
		$Pdf_quotation->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$Pdf_quotation->setPrintHeader(true);
		$Pdf_quotation->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/quotation/invoice_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/quotation/invoice_header2', $data, true);
		$Pdf_quotation->setHtmlHeader($htmlHeader);
		$Pdf_quotation->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/quotation/footer_last', $data, true);
		$Pdf_quotation->setHtmlFooter($lastFooter);
		// set header and footer fonts
		$Pdf_quotation->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_quotation->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$Pdf_quotation->SetMargins(6, 4, 4, true);
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf_quotation->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf_quotation->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$Pdf_quotation->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$Pdf_quotation->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_quotation->AddPage();
		/*
		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

		// create some HTML content
		$html = $this->load->view('admin/order/print_page',$data, true);
		//echo '<pre>';print_r($html);'</pre>';exit();
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, 'left');
		
		$pdf->Output('baqala-invoice.pdf', 'I');*/
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_quotation->setRTL(false);

		// print newline
		$Pdf_quotation->Ln();
		// set font
		$Pdf_quotation->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/quotation/print_quotation', $data, true);;
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_quotation->Output('baqala-quotation-' . $id . '.pdf', 'I');
	}

	//Print Delivery Note
	public function delivery_note()
	{
		$this->load->library('Pdf_delivery2');
		$id = $this->input->get('id');
		$data['result'] = $this->Quotation_model->get_order($id);
		// create new PDF document
		$Pdf_delivery = new Pdf_delivery2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_delivery->SetCreator(PDF_CREATOR);
		$Pdf_delivery->SetAuthor('Baqala Station');
		$Pdf_delivery->SetTitle('Delivery Note/Bill of Supply/Cash Memo');
		$Pdf_delivery->SetSubject('Delivery Note');
		$Pdf_delivery->SetKeywords('Baqala Station, PDF, Delivery Note, Order, Groceries');

		// remove default header/footer
		$Pdf_delivery->setPrintHeader(true);
		$Pdf_delivery->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/quotation/delivery_note/invoice_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/quotation/delivery_note/invoice_header2', $data, true);
		$Pdf_delivery->setHtmlHeader($htmlHeader);
		$Pdf_delivery->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/quotation/delivery_note/footer_last', $data, true);
		$Pdf_delivery->setHtmlFooter($lastFooter);

		// set header and footer fonts
		$Pdf_delivery->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_delivery->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$Pdf_delivery->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf_delivery->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf_delivery->SetFooterMargin(PDF_MARGIN_FOOTER);
		$Pdf_delivery->SetMargins(10, 4, 4, true);

		// set image scale factor
		$Pdf_delivery->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$Pdf_delivery->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_delivery->AddPage();
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_delivery->setRTL(false);

		// print newline
		$Pdf_delivery->Ln();
		// set font
		$Pdf_delivery->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/quotation/delivery_note/print_page', $data, true);;
		$Pdf_delivery->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_delivery->Output('delivery-note-' . $id . '.pdf', 'I');
	}

	public function delivery_slot_ajax()
	{
		$date_slot = $this->input->post('delv_date');
		//print_r($date_slot);exit();
		$time_slots = $this->Quotation_model->get_time_slots($date_slot);
		$output = '<option value="">Select Time Slot</option>';
		foreach ($time_slots as $time_slot) {
			$output .= '<option value="' . $time_slot->name . '">' . $time_slot->name . '</option>';
		}
		echo $output;
	}

	public function convert_order()
	{
		$this->form_validation->set_rules('id', 'Quotation ID', 'trim|required');
		$this->form_validation->set_rules('shipping_date_slot', 'Shipping Date Slot', 'trim|required');
		$this->form_validation->set_rules('shipping_time_slot', 'Shipping Time Slot', 'trim|required');
		$this->form_validation->set_rules('po_number', 'PO Number', 'trim|required');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
		$this->form_validation->set_rules('po_date', 'PO Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$date_slot = $this->input->post('shipping_date_slot');
				$time_slot = $this->input->post('shipping_time_slot');
				$po_number = $this->input->post('po_number');
				$po_date = $this->input->post('po_date');
				$payment_method = $this->input->post('payment_method');
				$data['result'] = $this->Quotation_model->get_order($this->input->post('id'));
				//$payment_method = $data['result']['order']['payment_method'];
				$user_id = $data['result']['order']['customer_id'];
				$net_amt = $data['result']['order']['net_payble_amt'];
				if ($payment_method === 'Credit') {
					$credit_acc_status = $this->Quotation_model->checkAccount($user_id);
					$credit_check = $this->Quotation_model->checkCreditBal($user_id);
					if ($credit_acc_status) {
						//print_r($credit_check);exit();
						$credit_bal = $credit_check->credit_avilable;
						if ($credit_bal >= $net_amt) {
							//print_r($credit_bal);exit();
							$query = $this->Quotation_model->convert_order($data, $date_slot, $time_slot, $po_number, $po_date, $payment_method);
							if (!empty($query) && $query > 0) {
								$data['order_info'] = $this->Order_model->get_order_detail($query);
								$query2 = $this->Quotation_model->set_status_converted($this->input->post('id'), $payment_method);
								if ($query2) {
									$order_id = $query;
									$this->Quotation_model->credit_update($data['order_info'], $po_number);
									$this->Quotation_model->updateStock($order_id);
								}
								//print_r($data);exit();
								//$this->_qrcodeGenerator($data['order_info']->trans_id);
								quotation_received_mail($this->input->post('id')); // Mail to admin
								$this->session->set_userdata('info', "1--Quotation successfully converted to order.");
							} else {
								$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
							}
						} else {
							$this->session->set_userdata('info', "2--Credit balance low. Please select different payment method.");
							redirect("admin/quotation/detail?id=" . $this->input->post('id'), 'refresh');
						}
					} else {
						$this->session->set_userdata('info', "2--Credit not available. Please select different payment method.");
						redirect("admin/quotation/detail?id=" . $this->input->post('id'), 'refresh');
					}
				} else {
					$query = $this->Quotation_model->convert_order($data, $date_slot, $time_slot, $po_number, $po_date, $payment_method);
					if (!empty($query) && $query > 0) {
						$data['order_info'] = $this->Order_model->get_order_detail($query);
						$query2 = $this->Quotation_model->set_status_converted($this->input->post('id'), $payment_method);
						if ($query2) {
							$order_id = $query;
							$this->Quotation_model->updateStock($order_id);
						}
						//print_r($data);exit();
						//$this->_qrcodeGenerator($data['order_info']->trans_id);
						quotation_received_mail($this->input->post('id')); // Mail to admin
						$this->session->set_userdata('info', "1--Quotation successfully converted to order.");
					} else {
						$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
					}
				}
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			}
		}
		redirect("admin/quotation/list");
	}

	public function _qrcodeGenerator($param)
	{
		$qrtext = 'Click below link to download invoice. https://baqalastation.com/app/download-invoice?id=' . $param;
		if (isset($qrtext)) {
			$SERVERFILEPATH = FILE_PATH_QR; //file path
			$text = $qrtext;
			//$text1= substr('123', 0,9);	
			$text1 = $param;
			$folder = $SERVERFILEPATH;
			$file_name1 = $text1 . "-Qrcode.png";
			$file_name = $folder . $file_name1;
			QRcode::png($text, $file_name);
			return true;
		} else {
			return false;
		}
	}

	public function _qrcodeGenerator2($param, $date, $total_amt, $total_vat)
	{
		$this->load->helper('date');
		/*
		$qrtext  = 'Company Name: Maha Alfala Trading Est. '."\n";
        $qrtext .= 'VAT No: 300034911400003'."\n";
        $qrtext .= 'Date Stamp: '.$date."\n";
        $qrtext .= 'Invoice Amount: '.$total_amt."\n";
        $qrtext .= 'VAT Amount: '.$total_vat."\n";
		*/
		$Seller_name  = 'Maha Alfala Trading Est.';
		$vat_no = '300034911400003';
		$inv_date = date('Y-m-d\TH:i:s\Z', strtotime($date));
		$invoice_total = $total_amt;
		$vat_total = $total_vat;

		$seller_dec2hex = $this->dec2hex(strlen($Seller_name));
		$vat_no_dec2hex = $this->dec2hex(strlen($vat_no));
		$inv_date_dec2hex = $this->dec2hex(strlen($inv_date));
		$invoice_total_dec2hex = $this->dec2hex(strlen($invoice_total));
		$vat_total_dec2hex = $this->dec2hex(strlen($vat_total));

		$seller_bin2hex = bin2hex($Seller_name);
		$vat_no_bin2hex = bin2hex($vat_no);
		$inv_date_bin2hex = bin2hex($inv_date);
		$invoice_total_bin2hex = bin2hex($invoice_total);
		$vat_total_bin2hex = bin2hex($vat_total);

		$tlv = '01' . $seller_dec2hex . $seller_bin2hex . '02' . $vat_no_dec2hex . $vat_no_bin2hex . '03' . $inv_date_dec2hex . $inv_date_bin2hex . '04' . $invoice_total_dec2hex . $invoice_total_bin2hex . '05' . $vat_total_dec2hex . $vat_total_bin2hex;
		$base_64 = base64_encode(pack('H*', $tlv));
		//print_r($base_64);exit();
		//print_r('<img src="data:image/png;base64, ARhNYWhhIEFsZmFsYSBUcmFkaW5nIEVzdC4CDzMwMDAzNDkxMTQwMDAwMwMUMjAyMi0xMi0xM1QxNDo1MTo1MFoEBzExMzguNTAFBTE0OC41==" alt="Red dot" />');exit();
		if (isset($base_64)) {
			$SERVERFILEPATH = FILE_PATH_QR; //File Path
			$text = $base_64;
			//$text1= substr('123', 0,9);	
			$text1 = $param;
			$folder = $SERVERFILEPATH;
			$file_name1 = $text1 . "-Qrcode.png";
			$file_name = $folder . $file_name1;
			QRcode::png($text, $file_name);
			return true;
		} else {
			return false;
		}
	}

	public function getAddress()
	{
		$c_address = $this->Quotation_model->get_address($this->input->post('user_id'));
		echo json_encode($c_address);
	}

	public function address_detail()
	{
		$id = $this->input->post('id');
		$output = $this->Quotation_model->get_address_detail($id);
		echo json_encode($output);
	}

	public function getMap()
	{
		$data = $this->load->view('admin/quotation/inc_google_address', '', TRUE);
		echo $data;
	}

	public function set_quotation_status()
	{
		$this->form_validation->set_rules('quotation_id', 'Quotation ID', 'trim|required');
		$this->form_validation->set_rules('quotation_no', 'Quotation Number', 'trim|required');
		$this->form_validation->set_rules('customer_id', 'Customer ID', 'trim|required');
		//$this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required');
		$this->form_validation->set_rules('quotation_status', 'Quotation Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$this->load->helper('sendmail_helper');
			$order_id = $this->input->post('quotation_id');
			$query = $this->Quotation_model->set_quotation_status();
			//$order_id = 0;
			if ($query) {
				$qstatus  = $this->input->post('quotation_status');
				$qcid  = $this->input->post('customer_id');
				$qsid  = $this->input->post('staff_id');
				$qno  = $this->input->post('quotation_no');
				$notification_message = '';
				if ($qstatus == 'review') {
					$notification_message = 'Please review your quotation ' . $qno;
					send_approval_mail($order_id);
				} elseif ($qstatus == 'reject') {
					$notification_message = 'Your quotation ' . $qno . ' has been rejected.';
					send_rejected_mail($order_id);
				} elseif ($qstatus == 'accept') {
					$notification_message = 'Your quotation ' . $qno . ' has been accepted and your order will be process soon';
					send_approved_mail($order_id);
				}
				$this->Notification_model->quotation_noti($notification_message, $qcid, $qsid);
				$this->session->set_userdata('info', "1--Status successfully updated");
				if ($qstatus == 'accept') {
					redirect("admin/quotation/list");
				}
				redirect("admin/quotation/edit?id=" . $order_id);
				exit();
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			}
		}
		redirect("admin/quotation/list");
	}
}
