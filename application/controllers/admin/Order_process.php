<?php defined('BASEPATH') or exit('No direct script access allowed');

class Order_process extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect("admin");
		}
		$this->load->model('admin/Order_process_model');
		$this->load->model('admin/Delivery_model');
		$this->load->model('admin/Van_model');
		$this->load->model('admin/Agent_model');
		$this->load->library('form_validation');
		$this->load->library('phpqrcode/qrlib');
		$this->load->helper('url');
		$this->load->helper('barcode_helper');
		$this->load->helper('common_helper');
		$this->action=$this->router->method;
	}

	public function index()
	{
		if($this->action && !check_action_permission(get_user_role(),'order',$this->action)){
			redirect('admin/unauthorized-request');
		}
		//print_r($this->input->get('slotFilter'));exit();
		$data['result'] = $this->Order_process_model->get_orders();
		$data['delivery_list'] = $this->Delivery_model->all_dboy_list();
		$data['slots'] = $this->Order_process_model->get_timeslots();
		//echo '<pre>';print_r($data['slots']->result());exit();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/order/order_list', $data);
	}

	public function CollectionReports()
	{
		$data['results'] = $this->Order_process_model->get_orders_collection()->result();
		$data['delivery_list'] = $this->Delivery_model->all_dboy_list();
		$delivery_ch = $this->Order_process_model->dcharge_collection();
		$dColl = 0;
		foreach ($delivery_ch as $dcharge) {
			$dColl += $dcharge->delivery_amt;
		}
		$data['delivery_ch'] = $dColl;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/reports/delivery_order_list', $data);
	}

	public function complete_list()
	{
		$data['result'] = $this->Order_process_model->get_completed_orders();
		//echo '<pre>';print_r($data['result']->result());exit();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/order/complete_list', $data);
	}

	public function quick_view()
	{
		$id = $this->input->post("id");
		$data['result'] = $this->Order_process_model->get_order($id);
		$data['delivery_list'] = $this->Delivery_model->active_dboy_list();
		$output_data = $this->load->view('admin/order/quick-view', $data, TRUE);
		//echo '<pre>';print_r($data);exit();
		//echo json_encode($data);
		echo $output_data;
	}

	public function detail()
	{
		if($this->action && !check_action_permission(get_user_role(),'order',$this->action)){
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get("id");
		$data['result'] = $this->Order_process_model->get_order($id);
		$data['delivery_list'] = $this->Delivery_model->active_dboy_list();
		$this->load->view('admin/order/detail', $data);
	}

	public function process()
	{
		if($this->action && !check_action_permission(get_user_role(),'order',$this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Order ID', 'trim|required', array('required' => 'Invalid Order Type'));
		$this->form_validation->set_rules('status', 'Order Status', 'trim|required', array('required' => 'Select valid status'));
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$id = $this->input->post('id');
			$data['result'] = $this->Order_process_model->get_order($id);
			//print_r($data['result']);exit();	
			$status = $this->input->post('status');
			$tracking_id = $this->input->post("tracking_id");
			$packets = $this->input->post("packets_no");
			$delivery_id = $this->input->post("delivery_boy");
			$remarks = $this->input->post("remarks");
			$created_by = $this->admin->getId();
			$created_at = CURRENT_TIME;
			//$mobile = $this->input->post("mobile");
			$delv_mob = $this->Delivery_model->get_deliverboy_mobile($delivery_id);
			if ($delv_mob) {
				$delv_mobile = $delv_mob->mobile;
			}
			$canreason = $this->input->post("canreason");
			//echo '<pre>';print_r($delv_mob->mobile);'</pre>';exit();
			$this->Order_process_model->process($id, $status, $tracking_id, $delivery_id, $canreason, $packets);

			if ($status == '1') {
				$status_type = 'Received';
				$description = 'Your order received.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Received");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);
				}
			}
			if ($status == '2') {
				$status_type = 'Accepted';
				$description = 'Your order accepted.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Accepted");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);

					$subject = 'Your order id ' . $data["result"]["order"]["invoice_prefix"] . '-' . $data["result"]["order"]["id"] . ' with Baqala Station has been confirmed';
					$message = $this->load->view("admin/order/email_confirmation", $data, true);

					//$msg = urlencode('Order Confirmed - Your Order with Order ID - #00'.$id.' amounting of Rs. '.$data['result']['order']['order_total'].' has been confirmed. We will send you an update when your Order will shipped.');
					//$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&mobiles=' . $data['result']['order']['mobile'] . '&sms='.$msg.'&senderid=APNICH';
					//$response = file_get_contents($sms);

					/*********Email*************/
					$eSetting = $this->customer->emailSetting();
					$config = array(
						'protocol' => $eSetting->protocol,
						'smtp_host' => $eSetting->smtp_host,
						'smtp_port' => $eSetting->smtp_port,
						'smtp_user' => $eSetting->smtp_user,
						'smtp_pass' => $eSetting->smtp_pass,
						'mailtype' => 'html'
					);

					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->set_newline("\r\n");
					$this->email->from($eSetting->smtp_user, $subject);
					$this->email->to($this->input->post('email'));
					$this->email->subject($subject);
					$this->email->message($message);
					$send = $this->email->send();
					/**********************/
				}
			}

			if ($status == '3') {
				$status_type = 'Cancel By Admin';
				$description = 'Your order has been canceled by us.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Cancel By Admin");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);

					$o_id = $data['result']['order']['id'];
					$trans_id = $data['result']['order']['trans_id'];
					$trans_method = $data['result']['order']['payment_method'];
					$rewards_point = $data['result']['order']['cashback_applied'];
					$wallet_amount = $data['result']['order']['wallet_applied'];
					$uid = $data['result']['order']['customer_id'];
					//print_r($rewards_point);exit();
					if ($trans_method == 'Credit') {
						$this->Order_process_model->updateCancelCredit($o_id, $trans_id, $uid);
					}
					if ($rewards_point > 0) {
						$remarks = 'Amount refund for order id ' . $o_id;
						$this->Order_process_model->reward_refund($uid, $rewards_point, $remarks);
					}
					if ($wallet_amount > 0) {
						$remarks = 'Reward points refund for order id ' . $o_id;
						$this->Order_process_model->wallet_refund($uid, $wallet_amount, $remarks);
					}
					$subject = 'Your order id ' . $data["result"]["order"]["invoice_prefix"] . '-' . $data["result"]["order"]["id"] . ' with Baqala Station has been cancelled';
					$message = $this->load->view("admin/order/email_deny", $data, true);

					/*********Email*************/
					$eSetting = $this->customer->emailSetting();
					$config = array(
						'protocol' => $eSetting->protocol,
						'smtp_host' => $eSetting->smtp_host,
						'smtp_port' => $eSetting->smtp_port,
						'smtp_user' => $eSetting->smtp_user,
						'smtp_pass' => $eSetting->smtp_pass,
						'mailtype' => 'html'
					);

					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->set_newline("\r\n");
					$this->email->from($eSetting->smtp_user, $subject);
					$this->email->to($this->input->post('email'));
					$this->email->subject($subject);
					$this->email->message($message);
					$send = $this->email->send();
					/**********************/
				}
			}

			if ($status == '4') {
				$status_type = 'Delivery Boy Assigned';
				$description = 'Your order assigned to delivery boy.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already as Delivery Boy Assigned");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);
				}
			}

			if ($status == '5') {
				$status_type = 'Dispatched';
				$description = 'Your order has been dispatched.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Dispatched");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);

					$subject = 'Order Dispatched | Baqala Station';
					$message = $this->load->view("admin/order/email_dispatched", $data, true);
					/*
					$msg = urlencode('Your order #00'. $id .' has been dispatched. Tracking id is ' . $tracking_id);
					$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&mobiles=' . $this->db->escape_str($mobile) . '&sms='.$msg.'&senderid=Saugat';
					$response = file_get_contents($sms);*/
				}
			}

			if ($status == '6') {
				$status_type = 'Delivered';
				$description = 'Your order has been delivered.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Delivered");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);
					$data['result'] = $this->Order_process_model->get_order($id);
					if ($data["result"]["order"]["payment_method"] == 'Credit') {
						$this->Order_process_model->updateCreditStatus($id);
					}
					$this->db->query("UPDATE `orders` SET delivery_date = '" . $created_at . "', date_modified = '" . $created_at . "' WHERE id = '" . (int)$id . "' LIMIT 1");
					$this->db->query("UPDATE `quotation` SET quotation_status = 'delivered', delivery_date = '" . $created_at . "', date_modified = '" . $created_at . "' WHERE id = '" . (int)$data["result"]["order"]["quotation_no"] . "' LIMIT 1");
					$subject = 'Your order id ' . $data["result"]["order"]["invoice_prefix"] . '-' . $data["result"]["order"]["id"] . ' with Baqala Station has been delivered';
					$message = $this->load->view("admin/order/email_deliever", $data, true);
					$attatchment = $this->generate_invoice($data["result"]["order"]["id"]);
					/*********Email*************/
					$eSetting = $this->customer->emailSetting();
					$config = array(
						'protocol' => $eSetting->protocol,
						'smtp_host' => $eSetting->smtp_host,
						'smtp_port' => $eSetting->smtp_port,
						'smtp_user' => $eSetting->smtp_user,
						'smtp_pass' => $eSetting->smtp_pass,
						'mailtype' => 'html'
					);

					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->set_newline("\r\n");
					$this->email->from($eSetting->smtp_user, $subject);
					$this->email->to($this->input->post('email'));
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->attach($attatchment);
					$send = $this->email->send();
					/**********************/
				}
			}

			if ($status == '7') {
				$status_type = 'Cancel On Delivery';
				$description = 'Your order has been cancelled on delivery.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Cancel On Delivery");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);
				}
			}

			if ($status == '8') {
				$status_type = 'Refund';
				$description = 'Order amount has been refunded.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Refund");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);
				}
			}

			if ($status == '9') {
				$status_type = 'Cancel By Customer';
				$description = 'Your order cancel by customer.';
				$checkLog = $this->Order_process_model->log_check($id, $status_type);
				if ($checkLog) {
					$this->session->set_userdata('info', "2--Order already marked as Cancel By Customer");
					redirect("admin/order_process");
				} else {
					$this->Order_process_model->create_log($id, $status_type, $description, $remarks, $created_by);
				}
			}
			$this->session->set_userdata('info', "1--Status successfully updated");
		}
		//redirect("admin/order_process/detail?id=".$id);
		redirect("admin/order/list");
	}

	public function refund()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$refund_id = $this->input->post('refund_id');
		$this->Order_process_model->refund($id, $refund_id, $status);
		redirect("admin/order_process/detail?id=" . $id);
	}

	/*---- Generate Invoice for Email -----*/

	public function generate_invoice($id)
	{
		$this->load->library('Pdf_invoice');
		$data['result'] = $this->Order_process_model->get_order($id);
		//$this->_qrcodeGenerator($data['result']['order']['trans_id']);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if ($data['result']['order']['order_status_id'] == '6') {
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		// create new PDF document
		$pdf = new Pdf_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/order/invoice_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/order/invoice_header2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/order/footer_last', $data, true);
		$pdf->setHtmlFooter($lastFooter);

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
		//$pdf->SetMargins(1, 87, 4, true);
		$pdf->SetMargins(6, 4, 4, true);

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
		$htmlcontent = $this->load->view('admin/order/print_page', $data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$path = FILE_PATH_INVOICE;
		$filename = 'baqala-invoice-' . $id;
		$pdf->Output($path . $filename . '.pdf', 'F');
		return $path . $filename . '.pdf';
	}
	/* public function get_tracking_id(){
		$id = $this->input->get('order_id');
		$query = $this->Order_process_model->get_order($id);
			
		$method = $query['order']['payment_method'];
		if($method == 'PayTM'){
			$mt = 'P';
			$cp = 0;
		}
		else{
			$mt = 'C';
			$cp = ceil($query['order']['order_total']);
		}
		$data['Customer'] = array(
				"CUSTCD"=>"SP000103005"
				);
		$data['DocketList'][] = array(
				"AgentID"=>"",
				"AwbNo"=>"",
				"Breath"=>"1",
				"CPD"=>"",
				"CollectableAmount"=>$cp,
				"Consg_Number"=>$query['order']['id'],
				"Consolidate_EW"=>"",
				"CustomerName"=>$query['order']['shipping_firstname'],
				"Ewb_Number"=>"",
				"GST_REG_STATUS"=>"Y",
				"HSN_code"=>"02314h03",
				"Height"=>"1",
				"Invoice_Ref"=>$query['order']['id'],
				"IsPudo"=>"N",
				"ItemName"=>"Arvino Packet",
				"Length"=>"1",
				"Mode"=>$mt,
				"NoOfPieces"=>"1",
				"OrderConformation"=>"Y",
				"OrderNo"=>$query['order']['id'],
				"ProductCode"=>"00123",
				"PudoId"=>"",
				"REASON_TRANSPORT"=>"",
				"RateCalculation"=>"N",
				"Seller_GSTIN"=>"123223H2",
				"ShippingAdd1"=>$query['order']['shipping_address1'],
				"ShippingAdd2"=>$query['order']['shipping_address2'],
				"ShippingCity"=>$query['order']['shipping_city'],
				"ShippingEmailId"=>$query['order']['email'],
				"ShippingMobileNo"=>$query['order']['shipping_mobile'],
				"ShippingState"=>$query['order']['shipping_state'],
				"ShippingTelephoneNo"=>$query['order']['shipping_mobile'],
				"ShippingZip"=>$query['order']['shipping_postcode'],
				"Shipping_GSTIN"=>"H212hf33",
				"TotalAmount"=>ceil($query['order']['order_total']),
				"TransDistance"=>"",
				"TransporterID"=>"",
				"TransporterName"=>"",
				"TypeOfDelivery"=>"Home Delivery",
				"TypeOfService"=>"Economy",
				"UOM"=>"Per KG",
				"VendorAddress1"=>"H-339, EPIP, Sitapura Industrial Area, Near Fire Station",
				"VendorAddress2"=>"Jaipur, Rajasthan",
				"VendorName"=>"Arvino",
				"VendorPincode"=>"302022",
				"VendorTeleNo"=>"8239450450",
				"Weight"=>"0.150");
				
		
		
		$Customer= array($data);
		$headers = array
		('Content-Type: application/json');
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,
		'https://instacom.dotzot.in/RestService/PushOrderDataService.svc/PushOrderData_PUDO_GST' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $data ) );
		$result = curl_exec($ch);
		curl_close($ch);
		echo $result;
	} */
	/*
	public function print_page(){
	    $this->load->library('pdfgenerator');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		$html = $this->load->view('admin/order/print_page',$data, true);
		$filename = 'invoice_'.time();
		$this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
	}
	
	public function label(){
		$this->load->library('pdfgenerator');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		$html = $this->load->view('admin/order/label',$data, true);
		$filename = 'label_'.time();
		$this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
	}
	*/
	public function report()
	{
		$data['from'] = $this->input->post('from');
		$data['to'] = $this->input->post('to');
		$data['report'] = $this->Order_process_model->get_report($data['from'], $data['to']);
		$this->load->view("admin/order/report", $data);
	}

	public function label()
	{
		$this->load->library('Pdf');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		//print_r($data['result']);exit();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Order Label (' . $id . ') - Baqala Station-Label');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(1, 0, 1);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 5);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 8);

		// add a page
		//$pdf->AddPage();
		$pdf->AddPage('L', 'A7');
		//$pdf->Cell(0, 0, 'A6 PORTRAIT', 1, 1, 'C');
		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

		// create some HTML content
		$html = $this->load->view('admin/order/label', $data, true);

		//echo '<pre>';print_r($html);'</pre>';exit();
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('label-' . $id . '.pdf', 'I');
	}

	public function print_invoice1()
	{
		$this->load->library('Pdf');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		$custom_layout = array(90, 300);
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		$pdf->setPrintHeader(false);
		$pdf->SetMargins(0, 0, 0, false);

		// remove default header/footer
		$pdf->setPrintHeader(false);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
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
		$pdf->SetFont('aealarabiya', '', 10);
		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES . 'background.jpg';
		$pdf->Image($img_file, 0, 0, 90, 150, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();
		// Arabic and English content
		$htmlcontent = $this->load->view('admin/order/retailer_page', $data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('baqala-invoice-' . $id . '.pdf', 'I');
	}

	public function print_invoice()
	{
		if($this->action && !check_action_permission(get_user_role(),'order',$this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_invoice');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		//$this->_qrcodeGenerator($data['result']['order']['trans_id']);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if ($data['result']['order']['order_status_id'] == '6') {
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		// create new PDF document
		$pdf = new Pdf_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/order/invoice_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/order/invoice_header2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/order/footer_last', $data, true);
		$pdf->setHtmlFooter($lastFooter);

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
		$pdf->SetMargins(6, 4, 4, true);

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
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/order/print_page', $data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('baqala-invoice-' . $id . '.pdf', 'I');
	}

	public function print_invoice_wt()
	{
		$this->load->library('Pdf_invoice');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		//$this->_qrcodeGenerator($data['result']['order']['trans_id']);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if ($data['result']['order']['order_status_id'] == '6') {
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		// create new PDF document
		$pdf = new Pdf_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/order/invoice_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/order/invoice_header2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/order/footer_last', $data, true);
		$pdf->setHtmlFooter($lastFooter);

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
		$pdf->SetMargins(1, 1, 4, true);

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
		$htmlcontent = $this->load->view('admin/order/print_page_wt', $data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('baqala-invoice-' . $id . '.pdf', 'I');
	}

	public function print_arabic_invoice()
	{
		$this->load->library('Pdf_ar_invoice');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
		//$this->_qrcodeGenerator($data['result']['order']['trans_id']);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if ($data['result']['order']['order_status_id'] == '6') {
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		// create new PDF document
		$pdf = new Pdf_ar_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/order/inv_header_arabic1', $data, true);
		$htmlHeader2 = $this->load->view('admin/order/inv_header_arabic2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/order/print_footer_arabic', $data, true);
		$pdf->setHtmlFooter($lastFooter);

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
		$pdf->SetMargins(1, 87, 4, true);

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
		$htmlcontent = $this->load->view('admin/order/inv_arabic', $data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('baqala-arabic-invoice-' . $id . '.pdf', 'I');
	}

	public function print_retailer_invoice()
	{
		$this->load->library('Pdf_retail');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);

		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if ($data['result']['order']['order_status_id'] == '6') {
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		$custom_layout = array(78, 4000);
		//$custom_layout = array(90,300);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
		$pdf = new TCPDF('P', 'mm', $custom_layout, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		$pdf->setPrintHeader(false);
		$pdf->SetMargins(1, false, 2, 2);
		$pdf->SetAutoPageBreak(TRUE, 1);
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//$pdf->SetMargins(1, 0, 0, true);

		$pdf->AddPage();
		$pdf->SetFont('aealarabiya', '', 10);

		$html = $this->load->view('admin/order/retailer_page', $data, true);

		$pdf->writeHTML($html);

		$pdf->Output('retailer-invoice-' . $id . '.pdf', 'I');
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

	/*----- For Leagal Use -----*/

	function dec2hex($number)
	{
		if ($number > 15) {
			$hexval = dechex($number);
		} else {
			$hexval = '0' . dechex($number);
		}
		return $hexval;
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

	//Print Delivery Note
	public function delivery_note()
	{
		$this->load->library('Pdf_delivery2');
		$id = $this->input->get('id');
		$data['result'] = $this->Order_process_model->get_order($id);
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
		$htmlHeader = $this->load->view('admin/order/delivery_note/invoice_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/order/delivery_note/invoice_header2', $data, true);
		$Pdf_delivery->setHtmlHeader($htmlHeader);
		$Pdf_delivery->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/order/delivery_note/footer_last', $data, true);
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
		$htmlcontent = $this->load->view('admin/order/delivery_note/print_page', $data, true);;
		$Pdf_delivery->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_delivery->Output('delivery-note-' . $id . '.pdf', 'I');
	}
}
