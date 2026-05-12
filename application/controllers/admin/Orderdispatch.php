<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orderdispatch extends CI_Controller {

	public function __construct() {

		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Delivery_model');
			$this->load->model('admin/Marshalling_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		$data['result'] = $this->Marshalling_model->get_van();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/marshalling/db_list',$data);
	}
	
	public function getDispatchList(){	
		$id = $this->input->get('id');	
		$data['orders'] = $this->Marshalling_model->get_pending_by_dboy($id);
		$data['van_detail'] = $this->Marshalling_model->get_dboy_by_id($id);
		//print_r($data['van_detail']);exit();
		$this->load->view('admin/marshalling/order_list',$data);
	}
	
	public function readyDispatchList(){	
		$id = $this->input->get('id');	
		$data['result'] = $this->Marshalling_model->ready_to_dispatch();
		//print_r($data['result']);exit();
		$this->load->view('admin/order/dispatch_list',$data);
	}
	
	public function setStatusDispatch(){
		if($this->admin->isLogged()){
			$ids = implode(",", $this->input->post('check_list'));
			//$crates_array = $this->db->query("SELECT packets FROM orders WHERE id IN (" . $ids . ")")->result_array();
			//$crates = array_column($crates_array, 'packets');;
			//$crates_string = implode(",", $crates);
			//print_r($crates1);exit();
		    $query = $this->Marshalling_model->setStatusDispatch($this->input->post('check_list'));
    		if($query){
				$query1 = $this->Marshalling_model->addConsignments($ids);
				if($query1){
					$orders = $this->Marshalling_model->get_order_by_ids($ids);
					/*********Email*************/
					$eSetting = $this->customer->emailSetting();
					$config = Array(
						'protocol' => $eSetting->protocol,		
						'smtp_host' => $eSetting->smtp_host,		
						'smtp_port' => $eSetting->smtp_port,			
						'smtp_user' => $eSetting->smtp_user,		
						'smtp_pass' => $eSetting->smtp_pass,	
						'mailtype' => 'html'
					);
					foreach($orders as $order){
						$subject = 'Order Dispatched | Baqala Station';
						$message = '<table cellpadding="0" cellspacing="15" border="0" bgcolor="#28a745" width="100%" style="margin:0 auto;max-width:440px;">
						<tbody>
						<tr bgcolor="#ffffff">
						<td>
						<table cellpadding="15" cellspacing="0" border="0" width="100%">
						<tbody>
						<tr>
						<td valign="middle" align="center" colspan="2">
						<img src="'.base_url().'images/logo-white.jpg" alt="logo" style="vertical-align:middle;"></td>

						</tr>
						</tbody>
						</table>
						</td>
						</tr>

						<tr bgcolor="#ffffff">
						<td>
						<table cellpadding="0" cellspacing="0" border="0">
						<tbody>
						<tr>
						<td align="center">
						<h2>Order Dispatched</h2>
						</td>
						</tr>
						<tr>
						<td>
						<table cellpadding="15" cellspacing="0" border="0" width="100%">
						<tbody>
						<tr>
						<td>
						Hello ' . $order->name . ',
						<br/>
						Your order #BS-'. $order->id .' has been dispatched. For any enquiry contact to baqala station.
						<a href="https://www.baqalastation.com">click here </a>

						</td>
						</tr>
						</tbody></table>
						</td>
						</tr>
						</tbody>
						</table>
						</td>
						</tr>

						<tr bgcolor="#ffffff"><td>
						<table cellpadding="0" cellspacing="15" border="0" width="100%"><tbody><tr><td></td>
						</tr><tr><td><p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:20px">Team Baqala Station</p>
						</td></tr>
						</tbody></table>
						</td></tr>
						<tr>
						<td><p style="margin:0;padding:0px;font-family:arial;font-size:9px;color:#fff;line-height:20px;">
						This is a system generated mail. Please Do not reply of this mail .</p>
						</td>
						</tr>
						</tbody>
						</table>';
						
						$this->load->library('email');
						$this->email->initialize($config);
						$this->email->set_newline("\r\n");
						$this->email->from($eSetting->smtp_user, $subject); 
						$this->email->to($order->email);
						$this->email->subject($subject);
						$this->email->message($message);
						$send = $this->email->send();
						/**
						$msg = urlencode('Your order #BS-'. $order->id .' has been dispatched.');
						$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&mobiles=' . $order->mobile . '&sms='.$msg.'&senderid=APNICH';
						$response = file_get_contents($sms);
						*/
					}
					/*SMS*/
					/**
					$msg = urlencode('New consignment has been received from Baqala Station for delivery. For any enquiry please contact to store.');
					$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=' . $this->db->escape_str($this->input->post('driver_mo_no')) . '&sms='.$msg;
					$response = file_get_contents($sms);
					*/
					
					$this->session->set_userdata('info', "1--Orders Successfully Dispatched");
				}else{
					$this->session->set_userdata('info', "2--Error on adding consignments");
				}
    		}
    		else{
    			$this->session->set_userdata('info', "2--Error");
    		}
    		redirect('admin/orderdispatch');
    	}else{
			redirect('admin');
		}
	}
	
	public function print_sheet(){
	    $this->load->library('Pdf');
		$id = $this->input->get('id');
		$data['results'] = $this->Marshalling_model->get_pending_by_dboy($id);
		
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Marshalling Sheet | Baqala Station');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$pdf->setPrintHeader(false);
		
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/marshalling/print_page',$data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('baqala-invoice.pdf', 'I');
	}
	
}
