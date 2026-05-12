<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_email_config')) {
    function get_email_config() {
        $CI =& get_instance();
        $CI->load->database();

        $eSetting = $CI->customer->emailSetting();

        return array(
            'protocol'     => $eSetting->protocol,
            'smtp_host'    => $eSetting->smtp_host,
            'smtp_port'    => $eSetting->smtp_port,
            'smtp_user'    => $eSetting->smtp_user,
            'smtp_pass'    => $eSetting->smtp_pass,
            'smtp_crypto'  => ((string) $eSetting->smtp_port === '465') ? 'ssl' : 'tls',
            'mailtype'     => 'html',
            'charset'      => 'utf-8',
            'wordwrap'     => true,
            'newline'      => "\r\n",
            'crlf'         => "\r\n",
            'smtp_timeout' => 20
        );
    }
}

if( ! function_exists('quotation_received_mail')){
	function quotation_received_mail($id){
		//get main CodeIgniter object
		$CI =& get_instance();
       	//load databse library
       	$CI->load->database();
       	// You may need to load the model if it hasn't been pre-loaded
    	$CI->load->model('Quotation_model');

		$data['result'] = $CI->Quotation_model->get_order($id);
		//print_r($data['result']);exit();
		if($id !== ''){
			$subject = 'New Requisition Received '. $data['result']['order']['invoice_prefix'] .'-'. $data['result']['order']['quotation_no'];
			$message =  $CI->load->view("mail/quotation_received_mail", $data, true);
			
    		/*********Email*************/
    		$eSetting = $CI->customer->emailSetting();
    		$config = Array(
    			'protocol' => $eSetting->protocol,		
    			'smtp_host' => $eSetting->smtp_host,		
    			'smtp_port' => $eSetting->smtp_port,			
    			'smtp_user' => $eSetting->smtp_user,		
    			'smtp_pass' => $eSetting->smtp_pass,	
    			'mailtype' => 'html'
    		);
    	
    		$CI->load->library('email');
    		$CI->email->initialize($config);
    		$CI->email->set_newline("\r\n");
    		$CI->email->from($eSetting->smtp_user, $subject); 
    		$CI->email->to('sales@baqalastation.com');
    		$CI->email->cc('parvez@baqalastation.com');
    		$CI->email->subject($subject);
    		$CI->email->message($message);
    		$send = $CI->email->send();
		}
		return true;
	}
}

if( ! function_exists('send_approval_mail')){
	function send_approval_mail($id){
		//get main CodeIgniter object
		$CI =& get_instance();
       	//load databse library
       	$CI->load->database();
       	// You may need to load the model if it hasn't been pre-loaded
    	$CI->load->model('Quotation_model');

		$data['result'] = $CI->Quotation_model->get_order($id);
		//print_r($data['result']);exit();
		if($id !== ''){
			$subject = 'Order Status Updated from Pending to Review.';
			$message =  $CI->load->view("admin/attatchment-template/email_quotation_approval", $data, true);
			//$attatchment = generate_quotation($data['result']['order']['id']);
			
    		/*********Email*************/
    		$eSetting = $CI->customer->emailSetting();
    		$config = Array(
    			'protocol' => $eSetting->protocol,		
    			'smtp_host' => $eSetting->smtp_host,		
    			'smtp_port' => $eSetting->smtp_port,			
    			'smtp_user' => $eSetting->smtp_user,		
    			'smtp_pass' => $eSetting->smtp_pass,	
    			'mailtype' => 'html'
    		);
    	
    		$CI->load->library('email');
    		$CI->email->initialize($config);
    		$CI->email->set_newline("\r\n");
    		$CI->email->from($eSetting->smtp_user, $subject); 
    		$CI->email->to($data['result']['order']['email']);
    		$CI->email->subject($subject);
    		$CI->email->message($message);
			//$CI->email->attach($attatchment);
    		$send = $CI->email->send();
		}
		return true;
	}
}

if( ! function_exists('generate_quotation')){
	function generate_quotation($id){
		//get main CodeIgniter object
		$CI =& get_instance();
       	//load databse library
       	$CI->load->database();
		$CI->load->helper('url');
		// You may need to load the model if it hasn't been pre-loaded
    	$CI->load->model('Quotation_model');
		$CI->load->library('Pdf_quotation');
		$data['result'] = $CI->Quotation_model->get_order($id);
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
		$htmlHeader = $CI->load->view('admin/quotation/invoice_header',$data, true);
		$htmlHeader2 = $CI->load->view('admin/quotation/invoice_header2',$data, true);
		$Pdf_quotation->setHtmlHeader($htmlHeader);
		$Pdf_quotation->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $CI->load->view('admin/quotation/footer_last',$data['result'], true);
		$Pdf_quotation->setHtmlFooter($lastFooter);
		// set header and footer fonts
		$Pdf_quotation->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_quotation->AddPage();
		
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_quotation->setRTL(false);

		// print newline
		$Pdf_quotation->Ln();
		// set font
		$Pdf_quotation->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $CI->load->view('admin/quotation/print_quotation',$data, true);;
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$path = FILE_PATH_QUOTE;
		$filename = 'baqala-quotation-'.$id;
		$Pdf_quotation->Output($path.$filename.'.pdf', 'F');
		return $path.$filename.'.pdf';
	}
}

if( ! function_exists('send_approved_mail')){
	function send_approved_mail($id){
		//get main CodeIgniter object
		$CI =& get_instance();
		//load databse library
		$CI->load->database();
		// You may need to load the model if it hasn't been pre-loaded
		$CI->load->model('Quotation_model');

		$data['result'] = $CI->Quotation_model->get_order($id);
		//print_r($data['result']);exit();
		if($id !== ''){
			$subject = 'Quotation No. '. $data['result']['order']['invoice_prefix'] .'-'. $data['result']['order']['quotation_no'] .' is approved.';
			$message =  $CI->load->view("admin/attatchment-template/email_quotation_approved", $data, true);
			//$attatchment = generate_quotation($data['result']['order']['id']);
			
			/*********Email*************/
			$eSetting = $CI->customer->emailSetting();
			$config = Array(
				'protocol' => $eSetting->protocol,		
				'smtp_host' => $eSetting->smtp_host,		
				'smtp_port' => $eSetting->smtp_port,			
				'smtp_user' => $eSetting->smtp_user,		
				'smtp_pass' => $eSetting->smtp_pass,	
				'mailtype' => 'html'
			);
		
			$CI->load->library('email');
			$CI->email->initialize($config);
			$CI->email->set_newline("\r\n");
			$CI->email->from($eSetting->smtp_user, $subject); 
			$CI->email->to($data['result']['order']['email']);
			$CI->email->subject($subject);
			$CI->email->message($message);
			//$CI->email->attach($attatchment);
			$send = $CI->email->send();
		}
		return true;
	}
}

if( ! function_exists('send_rejected_mail')){
	function send_rejected_mail($id){
		//get main CodeIgniter object
		$CI =& get_instance();
		//load databse library
		$CI->load->database();
		// You may need to load the model if it hasn't been pre-loaded
		$CI->load->model('Quotation_model');

		$data['result'] = $CI->Quotation_model->get_order($id);
		//print_r($data['result']);exit();
		if($id !== ''){
			$subject = 'Quotation No. '. $data['result']['order']['invoice_prefix'] .'-'. $data['result']['order']['quotation_no'] .' is rejected, for more information login to your account.';
			$message =  $CI->load->view("admin/attatchment-template/email_quotation_rejected", $data, true);
			
			/*********Email*************/
			$eSetting = $CI->customer->emailSetting();
			$config = Array(
				'protocol' => $eSetting->protocol,		
				'smtp_host' => $eSetting->smtp_host,		
				'smtp_port' => $eSetting->smtp_port,			
				'smtp_user' => $eSetting->smtp_user,		
				'smtp_pass' => $eSetting->smtp_pass,	
				'mailtype' => 'html'
			);
		
			$CI->load->library('email');
			$CI->email->initialize($config);
			$CI->email->set_newline("\r\n");
			$CI->email->from($eSetting->smtp_user, $subject); 
			$CI->email->to($data['result']['order']['email']);
			$CI->email->subject($subject);
			$CI->email->message($message);
			$send = $CI->email->send();
		}
		return true;
	}
}

if( ! function_exists('send_employee_credential')){
	function send_employee_credential($emp_no,$email,$password){
		//get main CodeIgniter object
		$CI =& get_instance();
		//load databse library
		$CI->load->database();
		//print_r($data['result']);exit();
		if($email !== ''){
			$data['email'] = $email;
			$data['emp_no'] = $emp_no;
			$data['password'] = $password;
			$subject = 'Login Credentials For Your Baqala Station Account.';
			$message =  $CI->load->view("admin/attatchment-template/send-credentials", $data, true);
			
			/*********Email*************/
			$eSetting = $CI->customer->emailSetting();
			$config = Array(
				'protocol' => $eSetting->protocol,		
				'smtp_host' => $eSetting->smtp_host,		
				'smtp_port' => $eSetting->smtp_port,			
				'smtp_user' => $eSetting->smtp_user,		
				'smtp_pass' => $eSetting->smtp_pass,	
				'mailtype' => 'html'
			);
		
			$CI->load->library('email');
			$CI->email->initialize($config);
			$CI->email->set_newline("\r\n");
			$CI->email->from($eSetting->smtp_user, $subject); 
			$CI->email->to($email);
			$CI->email->subject($subject);
			$CI->email->message($message);
			$send = $CI->email->send();
		}
		return true;
	}
}

if( ! function_exists('send_logistic_credential')){
	function send_logistic_credential($email,$password,$other){
		//get main CodeIgniter object
		$CI =& get_instance();
		//load databse library
		$CI->load->database();
		//print_r($data['result']);exit();
		if($email !== ''){
			$data['email'] = $email;
			$data['password'] = $password;
			$data['manager_detail'] = $other['manager_detail'];
			$data['username'] = $other['username'];
			$data['company_name'] = $other['company_name'];
			$subject = 'Login Credentials For Your Baqala Station Account.';
			$message =  $CI->load->view("admin/attatchment-template/logistic-welcome-mail", $data, true);
			
			/*********Email*************/
			$eSetting = $CI->customer->emailSetting();
			$config = Array(
				'protocol' => $eSetting->protocol,		
				'smtp_host' => $eSetting->smtp_host,		
				'smtp_port' => $eSetting->smtp_port,			
				'smtp_user' => $eSetting->smtp_user,		
				'smtp_pass' => $eSetting->smtp_pass,	
				'mailtype' => 'html'
			);
		
			$CI->load->library('email');
			$CI->email->initialize($config);
			$CI->email->set_newline("\r\n");
			$CI->email->from($eSetting->smtp_user, $subject); 
			$CI->email->to($email);
			$CI->email->subject($subject);
			$CI->email->message($message);
			$send = $CI->email->send();
		}
		return true;
	}
}


if (!function_exists('send_mail_to_approvers')) {
    function send_mail_to_approvers($approvers) {
        // Get the main CodeIgniter instance
        $CI =& get_instance();

        // Load required libraries and helpers
        $CI->load->library('email');
        $CI->load->database();

        // Get email settings
        $eSetting = $CI->customer->emailSetting();
        $config = array(
            'protocol'  => $eSetting->protocol,
            'smtp_host' => $eSetting->smtp_host,
            'smtp_port' => $eSetting->smtp_port,
            'smtp_user' => $eSetting->smtp_user,
            'smtp_pass' => $eSetting->smtp_pass,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => true
        );

        $CI->email->initialize($config);

        // Loop through each approver and send the email
        foreach ($approvers as $approver) {
            if (!empty($approver['email'])) {
                $data = array(
                    'name' => $approver['name'],
                    'arabic_name' => $approver['arabic_name'],
                    'email' => $approver['email']
                );

                // Generate the email content using a view
                $subject = 'New Task Notification';
                $message = $CI->load->view('admin/attatchment-template/request_approval', $data, true);

                $CI->email->clear();
                $CI->email->from($eSetting->smtp_user, $subject);
                $CI->email->to($approver['email']);
                //$CI->email->to('backoffice2@arinfotech.org');
                $CI->email->subject($subject);
                $CI->email->message($message);

                if (!$CI->email->send()) {
                    log_message('error', 'Failed to send email to ' . $approver['email'] . ': ' . $CI->email->print_debugger());
                }
            }
        }
        return true;
    }
}

if (!function_exists('send_mail_single_approvers')) {
    function send_mail_single_approvers($approver) {
        // Get the main CodeIgniter instance
        $CI =& get_instance();

        // Load required libraries and helpers
        $CI->load->library('email');
        $CI->load->database();

        // Get email settings
        $eSetting = $CI->customer->emailSetting();
        $config = array(
            'protocol'  => $eSetting->protocol,
            'smtp_host' => $eSetting->smtp_host,
            'smtp_port' => $eSetting->smtp_port,
            'smtp_user' => $eSetting->smtp_user,
            'smtp_pass' => $eSetting->smtp_pass,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => true
        );

        $CI->email->initialize($config);

        if (!empty($approver['email'])) {
			$data = array(
				'name' => $approver['name'],
				'arabic_name' => $approver['arabic_name'],
				'email' => $approver['email']
			);

			// Generate the email content using a view
			$subject = 'New Task Notification';
			$message = $CI->load->view('admin/attatchment-template/request_approval', $data, true);

			$CI->email->clear();
			$CI->email->from($eSetting->smtp_user, $subject);
			$CI->email->to($approver['email']);
			//$CI->email->to('backoffice2@arinfotech.org');
			$CI->email->subject($subject);
			$CI->email->message($message);

			if (!$CI->email->send()) {
				log_message('error', 'Failed to send email to ' . $approver['email'] . ': ' . $CI->email->print_debugger());
			}
		}
        return true;
    }
}

if (!function_exists('send_otp_mail')) {
    function send_otp_mail($email_data) {
        // Get the main CodeIgniter instance
        $CI =& get_instance();

        // Load required libraries and helpers
        $CI->load->library('email');
        $CI->load->database();

        // Get email settings
        $eSetting = $CI->customer->emailSetting();
        $config = array(
            'protocol'  => $eSetting->protocol,
            'smtp_host' => $eSetting->smtp_host,
            'smtp_port' => $eSetting->smtp_port,
            'smtp_user' => $eSetting->smtp_user,
            'smtp_pass' => $eSetting->smtp_pass,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => true
        );

        $CI->email->initialize($config);

        if (!empty($email_data['email'])) {
			$data = array(
				'name' => $email_data['name'],
				'email' => $email_data['email'],
				'otp' => $email_data['otp']
			);

			// Generate the email content using a view
			$subject = 'OTP for Shuttle Booking';
			$data['subject'] = 'OTP for Shuttle Booking';
			$message = $CI->load->view('admin/attatchment-template/otp_email', $data, true);

			$CI->email->clear();
			$CI->email->from($eSetting->smtp_user, $subject);
			$CI->email->to($email_data['email']);
			//$CI->email->to('backoffice2@arinfotech.org');
			$CI->email->subject($subject);
			$CI->email->message($message);

			if (!$CI->email->send()) {
				log_message('error', 'Failed to send email to ' . $email_data['email'] . ': ' . $CI->email->print_debugger());
			}
		}
        return true;
    }
}

if (!function_exists('send_booking_confirmation_mail')) {
    function send_booking_confirmation_mail($email_data) {
        // Get the main CodeIgniter instance
        $CI =& get_instance();

        // Load required libraries and helpers
        $CI->load->library('email');
        $CI->load->database();

        // Get email settings
        $eSetting = $CI->customer->emailSetting();
        $config = array(
            'protocol'  => $eSetting->protocol,
            'smtp_host' => $eSetting->smtp_host,
            'smtp_port' => $eSetting->smtp_port,
            'smtp_user' => $eSetting->smtp_user,
            'smtp_pass' => $eSetting->smtp_pass,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => true
        );

        $CI->email->initialize($config);

        if (!empty($email_data['email'])) {
			$data = array(
				'name' => $email_data['name'],
				'email' => $email_data['email'],
				'visit_type' => $email_data['visit_type'],
				'visit_date' => $email_data['visit_date'],
			);

			// Generate the email content using a view
			$subject = 'Medical Shuttle Booking Confirmation';
			$data['subject'] = 'Medical Shuttle Booking Confirmation';
			$message = $CI->load->view('admin/attatchment-template/clinical_confirmation_email', $data, true);

			$CI->email->clear();
			$CI->email->from($eSetting->smtp_user, $subject);
			$CI->email->to($email_data['email']);
			//$CI->email->to('backoffice2@arinfotech.org');
			$CI->email->subject($subject);
			$CI->email->message($message);

			if (!$CI->email->send()) {
				log_message('error', 'Failed to send email to ' . $email_data['email'] . ': ' . $CI->email->print_debugger());
			}
		}
        return true;
    }
}

//Send globally email
if (!function_exists('send_global_mail_helper')) {
    function send_global_mail_helper($email_data) {
        $CI =& get_instance();

        $CI->load->library('email');
        $CI->load->database();

        $config = get_email_config();
        $CI->email->initialize($config);

        if (empty($email_data['email'])) {
            log_message('error', 'send_global_mail_helper: email is empty.');
            return false;
        }

        if (empty($email_data['subject'])) {
            log_message('error', 'send_global_mail_helper: subject is empty.');
            return false;
        }

        if (empty($email_data['template'])) {
            log_message('error', 'send_global_mail_helper: template is empty.');
            return false;
        }

        $subject = $email_data['subject'];
        $message = $CI->load->view($email_data['template'], $email_data, true);

        $CI->email->clear(true);
        $CI->email->from($config['smtp_user'], $subject);

        if (is_array($email_data['email'])) {
            $CI->email->to(implode(',', $email_data['email']));
            $logEmail = implode(',', $email_data['email']);
        } else {
            $CI->email->to($email_data['email']);
            $logEmail = $email_data['email'];
        }

        $CI->email->subject($subject);
        $CI->email->message($message);

        if (!empty($email_data['attachment'])) {
            if (is_array($email_data['attachment'])) {
                foreach ($email_data['attachment'] as $file) {
                    $CI->email->attach($file);
                }
            } else {
                $CI->email->attach($email_data['attachment']);
            }
        }

        if ($CI->email->send()) {
            log_message('debug', 'Email sent successfully to ' . $logEmail . ' | Subject: ' . $subject);
            return true;
        }

        log_message('error', 'Failed to send email to ' . $logEmail . ' | Subject: ' . $subject . ' | ' . $CI->email->print_debugger());
        return false;
    }
}

//Cron mail for sending notification
if (!function_exists('send_notification_mail')) {
    function send_notification_mail($email_data) {
        // Get the main CodeIgniter instance
        $CI =& get_instance();

        // Load required libraries and helpers
        $CI->load->library('email');
        $CI->load->database();

        // Get email settings
        $config = get_email_config();
        $CI->email->initialize($config);

        if (!empty($email_data['email'])) {
			// Generate the email content using a view
			$subject = $email_data['subject'];
			$message = $CI->load->view($email_data['template'], $email_data, true);

			$CI->email->clear();
			$CI->email->from($config['smtp_user'], $subject);
			$CI->email->to($email_data['email']);
			//$CI->email->to('backoffice2@arinfotech.org');
			$CI->email->subject($subject);
			$CI->email->message($message);

			if (!$CI->email->send()) {
				log_message('error', 'Failed to send email to ' . $email_data['email'] . ': ' . $CI->email->print_debugger());
			}
		}
        return true;
    }
}
