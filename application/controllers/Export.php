<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->customer->isLogged()){
			$this->load->model('Export_model');
			$this->load->library('form_validation');
		}else{
			redirect('login');
		}
	}

	public function orderExcel($id) {
	    ini_set('memory_limit', '-1');
		$orderData = $this->Export_model->export_order($id);
		$order_id = $this->customer->invoiceNmFormat($orderData['order']['id']);
		$fileName = 'order-detail-'. $order_id .'.xlsx';  
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
		->setCreator("Baqala Station")
		->setLastModifiedBy("Admin")
		->setTitle("Baqala Station Order Detail")
		->setSubject("Baqala Station Order Detail")
		->setDescription(
			"Baqala Station Order Detail."
		)
		->setKeywords("office 2007 openxml php")
		->setCategory("Order");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		
		$styleArray = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => [
					'argb' => 'FFEB9C',
				],
				'endColor' => [
					'argb' => 'FFEB9C',
				],
			],
		];
		
		$spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
		
		
		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:I4')->applyFromArray($styleArray)->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('F8CBAD');
		
        $sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:I2');
		$sheet->setCellValue('A2', 'Order List - '.$order_id);
		$sheet->setCellValue('A4', 'PRODUCT SKU');
        $sheet->setCellValue('B4', 'ENGLISH NAME');
        $sheet->setCellValue('C4', 'ARABIC NAME');
        $sheet->setCellValue('D4', 'BRAND');
        $sheet->setCellValue('E4', 'BARCODE');
        $sheet->setCellValue('F4', 'SIZE');
        $sheet->setCellValue('G4', 'QTY');
        $sheet->setCellValue('H4', 'UNIT PRICE');
        $sheet->setCellValue('I4', 'TOTAL PRICE');   
		
        $rows = 5;
        foreach ($orderData['product'] as $val){
			//print_r($val);exit();
            $sheet->setCellValue('A' . $rows, $val['product_sku']);
			$sheet->setCellValue('B' . $rows, $val['product_name']);
            $sheet->setCellValue('C' . $rows, $val['arabic_name']);
            $sheet->setCellValue('D' . $rows, $val['product_brand']);
            $sheet->setCellValue('E' . $rows, $val['barcode']);
            $sheet->setCellValue('F' . $rows, $val['size']);
            $sheet->setCellValue('G' . $rows, $val['quantity']);
            $sheet->setCellValue('H' . $rows, ($val['discounted_price'] == 0) ? $val['real_price'] : $val['discounted_price']);
            $sheet->setCellValue('I' . $rows, $val['order_price']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("exports/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/exports/".$fileName);              
    }
    
    public function quotationExcel($id) {
	    ini_set('memory_limit', '-1');
		$orderData = $this->Export_model->export_quotation($id);
		$order_id = $this->customer->invoiceNmFormat($orderData['order']['id']);
		$fileName = 'quotation-detail-'. $order_id .'.xlsx';  
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
		->setCreator("Baqala Station")
		->setLastModifiedBy("Admin")
		->setTitle("Baqala Station Quotation Detail")
		->setSubject("Baqala Station Quotation Detail")
		->setDescription(
			"Baqala Station Quotation Detail."
		)
		->setKeywords("office 2007 openxml php")
		->setCategory("Quotation");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		
		$styleArray = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => [
					'argb' => 'FFEB9C',
				],
				'endColor' => [
					'argb' => 'FFEB9C',
				],
			],
		];
		
		$spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
		
		
		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:I4')->applyFromArray($styleArray)->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('F8CBAD');
		
        $sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:I2');
		$sheet->setCellValue('A2', 'Quotation List - '.$order_id);
		$sheet->setCellValue('A4', 'PRODUCT SKU');
        $sheet->setCellValue('B4', 'ENGLISH NAME');
        $sheet->setCellValue('C4', 'ARABIC NAME');
        $sheet->setCellValue('D4', 'BRAND');
        $sheet->setCellValue('E4', 'BARCODE');
        $sheet->setCellValue('F4', 'SIZE');
        $sheet->setCellValue('G4', 'QTY');
        $sheet->setCellValue('H4', 'UNIT PRICE');
        $sheet->setCellValue('I4', 'TOTAL PRICE');   
		
        $rows = 5;
        foreach ($orderData['product'] as $val){
			//print_r($val);exit();
            $sheet->setCellValue('A' . $rows, $val['product_sku']);
			$sheet->setCellValue('B' . $rows, $val['product_name']);
            $sheet->setCellValue('C' . $rows, $val['arabic_name']);
            $sheet->setCellValue('D' . $rows, $val['product_brand']);
            $sheet->setCellValue('E' . $rows, $val['barcode']);
            $sheet->setCellValue('F' . $rows, $val['size']);
            $sheet->setCellValue('G' . $rows, $val['quantity']);
            $sheet->setCellValue('H' . $rows, ($val['discounted_price'] == 0) ? $val['real_price'] : $val['discounted_price']);
            $sheet->setCellValue('I' . $rows, $val['order_price']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
		$writer->save("exports/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/exports/".$fileName);              
    }
    
    function attendance_log_excel(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND me.id = '" . $keyword . "'";
            }
        }
		
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }
        
		if($this->input->get('department')) {
			$department = $this->input->get('department');
            if($department != ''){
                $a .= " AND me.department = '" . $department . "'";
            }
        }
        
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.attendance_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
        $a .= " ORDER BY er.created_at DESC";             
        $query = $this->db->query($a);  
        return $query->result();  
    }
}
