<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nodues extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Deliveryvehicle_model');
			$this->load->library('form_validation');
			$this->load->helper('text');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/no-dues/index',$data);
	}
	
    public function get_rider_detail()
    {
        $rider_id = $this->input->post('rider_id');
        $data = $this->db->query("SELECT dv.*, ds.total_salary FROM delivery_vehicles dv LEFT JOIN deliveryvehicle_salary ds ON (dv.id = ds.deliveryboy_id) WHERE dv.id = '". $rider_id ."'")->row();
        echo json_encode($data);
    }

    public function get_rider_detail2($id)
	{
		$query = $this->db->query("SELECT dv.*, mn.arabic_name as nationality_arabic FROM delivery_vehicles dv LEFT JOIN master_nationality mn ON (dv.nationality = mn.name) WHERE dv.id = '" . (int)$id . "'");
		return $query->row();
	}

	public function print(){
        $this->form_validation->set_rules('rider', 'Select Rider', 'trim|required');
		$this->form_validation->set_rules('month_of', 'Select Month', 'trim|required');
		$this->form_validation->set_rules('salary', 'Enter Salary', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
            redirect('admin/no-dues');
		}
		else{
            $this->load->library('Pdf_promissory_note');
            $id = $this->input->post('rider');
            $order = $this->get_rider_detail2($id);
            // print_r($order);exit();
            // create new PDF document
            $pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Baqala Station');
            $pdf->SetTitle('BS - Rider No Dues Certificate');
            $pdf->SetSubject('BS - Rider No Dues Certificate');
            $pdf->SetKeywords('Baqala Station, PDF, No Dues Certificate, Rider');
            
            // remove default header/footer
            $pdf->setPrintHeader(true);
            $pdf->SetPrintFooter(true); 
            $htmlHeader = '';
            $htmlHeader2 = '';
            $pdf->setHtmlHeader($htmlHeader);
            $pdf->setHtmlHeader2($htmlHeader2);
            
            $lastFooter = '';
            $pdf->setHtmlFooter($lastFooter);
            
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
            $pdf->SetMargins(4, 60, 8, true);

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
            // Arabic and English content
            // set LTR direction for english translation
            $pdf->setRTL(false);

            // print newline
            $pdf->Ln();
            // set font
            $pdf->SetFont('aealarabiya', '', 10);

            // Arabic and English content
            $htmlcontent = $this->load->view('admin/no-dues/print_no_dues',$order, true);
            $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
            //Close and output PDF document
            $pdf->Output('BS Rider No Dues Certificate '. $id .'.pdf', 'I');
        }
        redirect('admin/deliveryvehicle');
	}
}
