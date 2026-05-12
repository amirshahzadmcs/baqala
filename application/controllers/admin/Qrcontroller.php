<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcontroller extends CI_Controller {
	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->library('phpqrcode/qrlib');
			$this->load->helper('url');	
		}		
		else{		
			redirect('admin/common/login');			
		}
	}
	
	public function index()
	{
		$this->load->view('admin/qrcode/qrcodetext');
	}
	
	public function qrcodeGenerator()
	{	
		$qrtext = 'Click below link to download invoice. https://www.localhost/projects/avinash/ebasket2/admin/Qrcontroller/';	
		if(isset($qrtext))
		{
			$SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/projects/avinash/ebasket2/uploads/qrcodes/';
			$text = $qrtext;
			$text1= substr('123', 0,9);	
			$folder = $SERVERFILEPATH;
			$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
			$file_name = $folder.$file_name1;
			QRcode::png($text,$file_name);		
			echo"<center><img src=".'http://localhost/projects/avinash/ebasket2/uploads/qrcodes/'.$file_name1."></center";
		}
		else
		{
			echo 'No Text Entered';
		}	
	}
}
?>