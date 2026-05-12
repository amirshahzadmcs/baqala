<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Export extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		$this->load->model('admin/Export_model');
		$this->load->model('admin/Voucher_model');
		$this->load->library('form_validation');
		$this->load->helper('common_helper');
		$this->action =  $this->router->fetch_method();
	}

	public function allProductExcel()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		ini_set('memory_limit', '-1');
		$fileName = 'all-product.xlsx';
		$productData = $this->Export_model->export_products();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Product Master")
			->setSubject("Baqala Station Product Master")
			->setDescription(
				"Baqala Station Product Master."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(30, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(30, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:V2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:V4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:U2');
		$sheet->setCellValue('A2', 'Baqala Station Product Master');
		$sheet->setCellValue('A4', 'ID');
		$sheet->setCellValue('B4', 'PARENT SKU');
		$sheet->setCellValue('C4', 'CHILD SKU');
		$sheet->setCellValue('D4', 'SELLER SKU');
		$sheet->setCellValue('E4', 'ENGLISH NAME');
		$sheet->setCellValue('F4', 'ARABIC NAME');
		$sheet->setCellValue('G4', 'SIZE');
		$sheet->setCellValue('H4', 'PRICE');
		$sheet->setCellValue('I4', 'D. PRICE');
		$sheet->setCellValue('J4', 'BARCODE');
		$sheet->setCellValue('K4', 'RACK');
		$sheet->setCellValue('L4', 'SHELF');
		$sheet->setCellValue('M4', 'VARIATION');
		$sheet->setCellValue('N4', 'MOQ');
		$sheet->setCellValue('O4', 'BRAND');
		$sheet->setCellValue('P4', 'CATEGORY');
		$sheet->setCellValue('Q4', 'SUB CATEGORY');
		$sheet->setCellValue('R4', 'COD');
		$sheet->setCellValue('S4', 'B2B');
		$sheet->setCellValue('T4', 'PRODUCT DESCRIPTION ENGLISH');
		$sheet->setCellValue('U4', 'PRODUCT DESCRIPTION ARABIC');
		$sheet->setCellValue('V4', 'STATUS');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['id']);
			$sheet->setCellValue('B' . $rows, $val['parent_sku']);
			$sheet->setCellValue('C' . $rows, $val['parent_sku'] . '-' . $val['product_sku']);
			$sheet->setCellValue('D' . $rows, $val['seller_sku']);
			$sheet->setCellValue('E' . $rows, $val['name']);
			$sheet->setCellValue('F' . $rows, $val['name_ar']);
			$sheet->setCellValue('G' . $rows, $val['size'] . ' ' . $val['unit_name']);
			$sheet->setCellValue('H' . $rows, $val['price']);
			$sheet->setCellValue('I' . $rows, $val['discounted_price']);
			$sheet->setCellValue('J' . $rows, $val['barcode']);
			$sheet->setCellValue('K' . $rows, $val['rack_name']);
			$sheet->setCellValue('L' . $rows, $val['shelf_name']);
			$sheet->setCellValue('M' . $rows, $val['is_variation']);
			$sheet->setCellValue('N' . $rows, $val['moq']);
			$sheet->setCellValue('O' . $rows, $val['brand_name']);
			$sheet->setCellValue('P' . $rows, $val['main_cat_name']);
			$sheet->setCellValue('Q' . $rows, $val['sub_cat_name']);
			$sheet->setCellValue('R' . $rows, $val['cod_availability']);
			$sheet->setCellValue('S' . $rows, $val['b2b_availability']);
			$sheet->setCellValue('T' . $rows, $val['description']);
			$sheet->setCellValue('U' . $rows, $val['description_ar']);
			$sheet->setCellValue('V' . $rows, $val['status_availability']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function allActiveProductExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'active-product.xlsx';
		$productData = $this->Export_model->export_active_products();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Active Product Master")
			->setSubject("Baqala Station Active Product Master")
			->setDescription(
				"Baqala Station Active Product Master."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

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

		$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:N2');
		$sheet->setCellValue('A2', 'Baqala Station Active Product Master');
		$sheet->setCellValue('A4', 'Id');
		$sheet->setCellValue('B4', 'English Name');
		$sheet->setCellValue('C4', 'Arabic Name');
		$sheet->setCellValue('D4', 'Parent SKU');
		$sheet->setCellValue('E4', 'Variation');
		$sheet->setCellValue('F4', 'MOQ');
		$sheet->setCellValue('G4', 'Brand');
		$sheet->setCellValue('H4', 'Category');
		$sheet->setCellValue('I4', 'Sub Category');
		$sheet->setCellValue('J4', 'COD');
		$sheet->setCellValue('K4', 'B2B');
		$sheet->setCellValue('L4', 'Product Description English');
		$sheet->setCellValue('M4', 'Product Description Arabic');
		$sheet->setCellValue('N4', 'Status');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['id']);
			$sheet->setCellValue('B' . $rows, $val['name']);
			$sheet->setCellValue('C' . $rows, $val['name_ar']);
			$sheet->setCellValue('D' . $rows, $val['parent_sku']);
			$sheet->setCellValue('E' . $rows, $val['is_variation']);
			$sheet->setCellValue('F' . $rows, $val['moq']);
			$sheet->setCellValue('G' . $rows, $val['brand_name']);
			$sheet->setCellValue('H' . $rows, $val['main_cat_name']);
			$sheet->setCellValue('I' . $rows, $val['sub_cat_name']);
			$sheet->setCellValue('J' . $rows, $val['cod_availability']);
			$sheet->setCellValue('K' . $rows, $val['b2b_availability']);
			$sheet->setCellValue('L' . $rows, $val['description']);
			$sheet->setCellValue('M' . $rows, $val['description_ar']);
			$sheet->setCellValue('N' . $rows, $val['status_availability']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function allDeactiveProductExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'deactive-product.xlsx';
		$productData = $this->Export_model->export_deactive_products();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Deactive Product Master")
			->setSubject("Baqala Station Deactive Product Master")
			->setDescription(
				"Baqala Station Deactive Product Master."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

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

		$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:N2');
		$sheet->setCellValue('A2', 'Baqala Station Deactive Product Master');
		$sheet->setCellValue('A4', 'Id');
		$sheet->setCellValue('B4', 'English Name');
		$sheet->setCellValue('C4', 'Arabic Name');
		$sheet->setCellValue('D4', 'Parent SKU');
		$sheet->setCellValue('E4', 'Variation');
		$sheet->setCellValue('F4', 'MOQ');
		$sheet->setCellValue('G4', 'Brand');
		$sheet->setCellValue('H4', 'Category');
		$sheet->setCellValue('I4', 'Sub Category');
		$sheet->setCellValue('J4', 'COD');
		$sheet->setCellValue('K4', 'B2B');
		$sheet->setCellValue('L4', 'Product Description English');
		$sheet->setCellValue('M4', 'Product Description Arabic');
		$sheet->setCellValue('N4', 'Status');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['id']);
			$sheet->setCellValue('B' . $rows, $val['name']);
			$sheet->setCellValue('C' . $rows, $val['name_ar']);
			$sheet->setCellValue('D' . $rows, $val['parent_sku']);
			$sheet->setCellValue('E' . $rows, $val['is_variation']);
			$sheet->setCellValue('F' . $rows, $val['moq']);
			$sheet->setCellValue('G' . $rows, $val['brand_name']);
			$sheet->setCellValue('H' . $rows, $val['main_cat_name']);
			$sheet->setCellValue('I' . $rows, $val['sub_cat_name']);
			$sheet->setCellValue('J' . $rows, $val['cod_availability']);
			$sheet->setCellValue('K' . $rows, $val['b2b_availability']);
			$sheet->setCellValue('L' . $rows, $val['description']);
			$sheet->setCellValue('M' . $rows, $val['description_ar']);
			$sheet->setCellValue('N' . $rows, $val['status_availability']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function imageMissingProductExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'image-product.xlsx';
		$productData = $this->Export_model->export_missimg_products();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Image Missing Product Master")
			->setSubject("Baqala Station Image Missing Product Master")
			->setDescription(
				"Baqala Station Image Missing Product Master."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

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

		$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:N2');
		$sheet->setCellValue('A2', 'Baqala Station Image Missing Product Master');
		$sheet->setCellValue('A4', 'Id');
		$sheet->setCellValue('B4', 'English Name');
		$sheet->setCellValue('C4', 'Arabic Name');
		$sheet->setCellValue('D4', 'Parent SKU');
		$sheet->setCellValue('E4', 'Variation');
		$sheet->setCellValue('F4', 'MOQ');
		$sheet->setCellValue('G4', 'Brand');
		$sheet->setCellValue('H4', 'Category');
		$sheet->setCellValue('I4', 'Sub Category');
		$sheet->setCellValue('J4', 'COD');
		$sheet->setCellValue('K4', 'B2B');
		$sheet->setCellValue('L4', 'Product Description English');
		$sheet->setCellValue('M4', 'Product Description Arabic');
		$sheet->setCellValue('N4', 'Status');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['id']);
			$sheet->setCellValue('B' . $rows, $val['name']);
			$sheet->setCellValue('C' . $rows, $val['name_ar']);
			$sheet->setCellValue('D' . $rows, $val['parent_sku']);
			$sheet->setCellValue('E' . $rows, $val['is_variation']);
			$sheet->setCellValue('F' . $rows, $val['moq']);
			$sheet->setCellValue('G' . $rows, $val['brand_name']);
			$sheet->setCellValue('H' . $rows, $val['main_cat_name']);
			$sheet->setCellValue('I' . $rows, $val['sub_cat_name']);
			$sheet->setCellValue('J' . $rows, $val['cod_availability']);
			$sheet->setCellValue('K' . $rows, $val['b2b_availability']);
			$sheet->setCellValue('L' . $rows, $val['description']);
			$sheet->setCellValue('M' . $rows, $val['description_ar']);
			$sheet->setCellValue('N' . $rows, $val['status_availability']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function arabicMissingProductExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'arabic-product.xlsx';
		$productData = $this->Export_model->export_missarabic_products();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Arabic Missing Product Master")
			->setSubject("Baqala Station Arabic Missing Product Master")
			->setDescription(
				"Baqala Station Arabic Missing Product Master."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

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

		$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:N2');
		$sheet->setCellValue('A2', 'Baqala Station Arabic Missing Product Master');
		$sheet->setCellValue('A4', 'Id');
		$sheet->setCellValue('B4', 'English Name');
		$sheet->setCellValue('C4', 'Arabic Name');
		$sheet->setCellValue('D4', 'Parent SKU');
		$sheet->setCellValue('E4', 'Variation');
		$sheet->setCellValue('F4', 'MOQ');
		$sheet->setCellValue('G4', 'Brand');
		$sheet->setCellValue('H4', 'Category');
		$sheet->setCellValue('I4', 'Sub Category');
		$sheet->setCellValue('J4', 'COD');
		$sheet->setCellValue('K4', 'B2B');
		$sheet->setCellValue('L4', 'Product Description English');
		$sheet->setCellValue('M4', 'Product Description Arabic');
		$sheet->setCellValue('N4', 'Status');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['id']);
			$sheet->setCellValue('B' . $rows, $val['name']);
			$sheet->setCellValue('C' . $rows, $val['name_ar']);
			$sheet->setCellValue('D' . $rows, $val['parent_sku']);
			$sheet->setCellValue('E' . $rows, $val['is_variation']);
			$sheet->setCellValue('F' . $rows, $val['moq']);
			$sheet->setCellValue('G' . $rows, $val['brand_name']);
			$sheet->setCellValue('H' . $rows, $val['main_cat_name']);
			$sheet->setCellValue('I' . $rows, $val['sub_cat_name']);
			$sheet->setCellValue('J' . $rows, $val['cod_availability']);
			$sheet->setCellValue('K' . $rows, $val['b2b_availability']);
			$sheet->setCellValue('L' . $rows, $val['description']);
			$sheet->setCellValue('M' . $rows, $val['description_ar']);
			$sheet->setCellValue('N' . $rows, $val['status_availability']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function skuMissingProductExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'sku-product.xlsx';
		$productData = $this->Export_model->export_misssku_products();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station SKU Missing Product Master")
			->setSubject("Baqala Station SKU Missing Product Master")
			->setDescription(
				"Baqala Station SKU Missing Product Master."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

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

		$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:N2');
		$sheet->setCellValue('A2', 'Baqala Station SKU Missing Product Master');
		$sheet->setCellValue('A4', 'Id');
		$sheet->setCellValue('B4', 'English Name');
		$sheet->setCellValue('C4', 'Arabic Name');
		$sheet->setCellValue('D4', 'Parent SKU');
		$sheet->setCellValue('E4', 'Variation');
		$sheet->setCellValue('F4', 'MOQ');
		$sheet->setCellValue('G4', 'Brand');
		$sheet->setCellValue('H4', 'Category');
		$sheet->setCellValue('I4', 'Sub Category');
		$sheet->setCellValue('J4', 'COD');
		$sheet->setCellValue('K4', 'B2B');
		$sheet->setCellValue('L4', 'Product Description English');
		$sheet->setCellValue('M4', 'Product Description Arabic');
		$sheet->setCellValue('N4', 'Status');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['id']);
			$sheet->setCellValue('B' . $rows, $val['name']);
			$sheet->setCellValue('C' . $rows, $val['name_ar']);
			$sheet->setCellValue('D' . $rows, $val['parent_sku']);
			$sheet->setCellValue('E' . $rows, $val['is_variation']);
			$sheet->setCellValue('F' . $rows, $val['moq']);
			$sheet->setCellValue('G' . $rows, $val['brand_name']);
			$sheet->setCellValue('H' . $rows, $val['main_cat_name']);
			$sheet->setCellValue('I' . $rows, $val['sub_cat_name']);
			$sheet->setCellValue('J' . $rows, $val['cod_availability']);
			$sheet->setCellValue('K' . $rows, $val['b2b_availability']);
			$sheet->setCellValue('L' . $rows, $val['description']);
			$sheet->setCellValue('M' . $rows, $val['description_ar']);
			$sheet->setCellValue('N' . $rows, $val['status_availability']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	/*----- Export Stock -----*/

	public function allStockExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'all-inventory.xlsx';
		$productData = $this->Export_model->export_product_stock();
		//print_r($productData);exit();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Product Inventory List")
			->setSubject("Baqala Station Product Inventory List")
			->setDescription(
				"Baqala Station Product Inventory List."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
		$sheet->setCellValue('A2', 'Baqala Station Inventory List');
		$sheet->setCellValue('A4', 'CHILD SKU');
		$sheet->setCellValue('B4', 'BARCODE');
		$sheet->setCellValue('C4', 'PRODUCT NAME/ DESCRIPTION');
		$sheet->setCellValue('D4', 'QTY');
		$sheet->setCellValue('E4', 'COST');
		$sheet->setCellValue('F4', 'INVENTORY VALUE');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['child_sku']);
			$sheet->setCellValue('B' . $rows, $val['barcode']);
			$sheet->setCellValue('C' . $rows, $val['product_name']);
			$sheet->setCellValue('D' . $rows, $val['stock']);
			$sheet->setCellValue('E' . $rows, $val['unit_price']);
			$sheet->setCellValue('F' . $rows, $val['total_price']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function inStockExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'instock-inventory.xlsx';
		$productData = $this->Export_model->export_inventory_instock();
		//print_r($productData);exit();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Inventory In Stock")
			->setSubject("Baqala Station Inventory In Stock")
			->setDescription(
				"Baqala Station Inventory In Stock."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
		$sheet->setCellValue('A2', 'Baqala Station Inventory In Stock');
		$sheet->setCellValue('A4', 'CHILD SKU');
		$sheet->setCellValue('B4', 'BARCODE');
		$sheet->setCellValue('C4', 'PRODUCT NAME/ DESCRIPTION');
		$sheet->setCellValue('D4', 'QTY');
		$sheet->setCellValue('E4', 'COST');
		$sheet->setCellValue('F4', 'INVENTORY VALUE');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['child_sku']);
			$sheet->setCellValue('B' . $rows, $val['barcode']);
			$sheet->setCellValue('C' . $rows, $val['product_name']);
			$sheet->setCellValue('D' . $rows, $val['stock']);
			$sheet->setCellValue('E' . $rows, $val['unit_price']);
			$sheet->setCellValue('F' . $rows, $val['total_price']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function outStockExcel()
	{
		ini_set('memory_limit', '-1');
		$fileName = 'outofstock-inventory.xlsx';
		$productData = $this->Export_model->export_inventory_outstock();
		//print_r($productData);exit();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Inventory Out of Stock")
			->setSubject("Baqala Station Inventory Out of Stock")
			->setDescription(
				"Baqala Station Inventory Out of Stock."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Products");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
		$sheet->setCellValue('A2', 'Baqala Station Inventory Out of Stock');
		$sheet->setCellValue('A4', 'CHILD SKU');
		$sheet->setCellValue('B4', 'BARCODE');
		$sheet->setCellValue('C4', 'PRODUCT NAME/ DESCRIPTION');
		$sheet->setCellValue('D4', 'QTY');
		$sheet->setCellValue('E4', 'COST');
		$sheet->setCellValue('F4', 'INVENTORY VALUE');

		$rows = 5;
		foreach ($productData as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val['child_sku']);
			$sheet->setCellValue('B' . $rows, $val['barcode']);
			$sheet->setCellValue('C' . $rows, $val['product_name']);
			$sheet->setCellValue('D' . $rows, $val['stock']);
			$sheet->setCellValue('E' . $rows, $val['unit_price']);
			$sheet->setCellValue('F' . $rows, $val['total_price']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save("uploads/" . $fileName);
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "/uploads/" . $fileName);
	}

	public function allSimExcel()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sim_card', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!empty($this->input->get('network'))) {
			$network = $this->input->get('network');
		} else {
			$network = FALSE;
		}
		if (!empty($this->input->get('user'))) {
			$user = $this->input->get('user');
		} else {
			$user = FALSE;
		}
		if (!empty($this->input->get('plan'))) {
			$plan = $this->input->get('plan');
		} else {
			$plan = FALSE;
		}
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if (!empty($this->input->get('sim_type'))) {
			$sim_type = $this->input->get('sim_type');
		} else {
			$sim_type = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('allot_status'))) {
			$allot_status = $this->input->get('allot_status');
		} else {
			$allot_status = FALSE;
		}
		if (!empty($this->input->get('is_gps_sim'))) {
			$is_gps_sim = $this->input->get('is_gps_sim');
		} else {
			$is_gps_sim = FALSE;
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
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "export_sim_list_" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$simData = $this->Export_model->print_sim_list($network, $plan, $status, $sim_type, $allot_status, $is_gps_sim, $startDate, $endDate, $keyword, $user, $sim_no);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station Sim Database")
			->setSubject("Baqala Station Sim Database")
			->setDescription(
				"Baqala Station Sim Database."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Sim Database");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(50, 'pt');
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:R2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:R4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:R2');
		$sheet->setCellValue('A2', 'Baqala Station Sim Database');
		$sheet->setCellValue('A4', 'Sim ID');
		$sheet->setCellValue('B4', 'Addition Date');
		$sheet->setCellValue('C4', 'Owner ID');
		$sheet->setCellValue('D4', 'Owner Name');
		$sheet->setCellValue('E4', 'Mobile No');
		$sheet->setCellValue('F4', 'Sim Card No');
		$sheet->setCellValue('G4', 'Date of purchase');
		$sheet->setCellValue('H4', 'Activation date');
		$sheet->setCellValue('I4', 'Sim Type');
		$sheet->setCellValue('J4', 'Is GPS Sim');
		$sheet->setCellValue('K4', 'Network Provider');
		$sheet->setCellValue('L4', 'Active Plan');
		$sheet->setCellValue('M4', 'EMP ID');
		$sheet->setCellValue('N4', 'Current User');
		$sheet->setCellValue('O4', 'Sim Status');
		$sheet->setCellValue('P4', 'Allotment Status');
		$sheet->setCellValue('Q4', 'Internet Data');
		$sheet->setCellValue('R4', 'Last Updated');

		$rows = 5;
		foreach ($simData as $item) {
			if ($item->status == '0') {
				$status = 'New';
			}
			if ($item->status == '1') {
				$status = 'Active';
			}
			if ($item->status == '2') {
				$status = 'Discontinued';
			}
			if ($item->status == '3') {
				$status = 'Blocked';
			}
			if ($item->status == '4') {
				$status = 'Suspended';
			}
			if ($item->status == '5') {
				$status = 'Free';
			}

			if ($item->allotment == '0') {
				$allotment_status = 'New';
			}
			if ($item->allotment == '1') {
				$allotment_status = 'Alloted';
			}
			if ($item->allotment == '2') {
				$allotment_status = 'Unalloted';
			}
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $item->id);
			$sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($item->created_at)));
			$sheet->setCellValue('C' . $rows, ' ' . $item->owner_id);
			$sheet->setCellValue('D' . $rows, $item->owner_name);
			$sheet->setCellValue('E' . $rows, ' ' . $item->mobile);
			$sheet->setCellValue('F' . $rows, ' ' . $item->sim_no);
			$sheet->setCellValue('G' . $rows, date('d-m-Y', strtotime($item->date_of_purchase)));
			$sheet->setCellValue('H' . $rows, date('d-m-Y', strtotime($item->activation_date)));
			$sheet->setCellValue('I' . $rows, ucfirst($item->sim_type));
			$sheet->setCellValue('J' . $rows, (($item->is_gps_sim == 'on') ? 'Yes' : 'No') . '-' . (($item->gps_installed_vehicle !== '') ? vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_no . ' ' . vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_type : ''));
			$sheet->setCellValue('K' . $rows, $item->network_name);
			$sheet->setCellValue('L' . $rows, $item->plan_name);
			$sheet->setCellValue('M' . $rows, $item->emp_id);
			$sheet->setCellValue('N' . $rows, $item->whole_name);
			$sheet->setCellValue('O' . $rows, $status);
			$sheet->setCellValue('P' . $rows, $allotment_status);
			$sheet->setCellValue('Q' . $rows, $item->internet_data);
			$sheet->setCellValue('R' . $rows, $item->updated_at);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function attendanceLogExcel()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('iqama_no'))) {
			$iqama_no = $this->input->get('iqama_no');
		} else {
			$iqama_no = FALSE;
		}
		if (!empty($this->input->get('department'))) {
			$department = $this->input->get('department');
		} else {
			$department = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "attendance-log-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$attend_log = $this->Export_model->attendance_log_excel();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Employee Attendance Log")
			->setSubject("Baqala Station - Employee Attendance Log")
			->setDescription(
				"Baqala Station Employee Attendance Log."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Employee Attendance Log");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:G2');
		$sheet->setCellValue('A2', 'Baqala Station Employee Attendance Log');
		$sheet->setCellValue('A4', 'EMPLOYEE ID');
		$sheet->setCellValue('B4', 'EMPLOYEE Name');
		$sheet->setCellValue('C4', 'DEPARTMENT');
		$sheet->setCellValue('D4', 'DATE');
		$sheet->setCellValue('E4', 'SIGN IN');
		$sheet->setCellValue('F4', 'SIGN OUT');
		$sheet->setCellValue('G4', 'STATUS');

		$rows = 5;
		foreach ($attend_log as $val) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $val->emp_no);
			$sheet->setCellValue('B' . $rows, $val->full_name . ' (#' . $val->designation_name . ')');
			$sheet->setCellValue('C' . $rows, $val->department_name);
			$sheet->setCellValue('D' . $rows, date('d-m-Y', strtotime($val->attendance_date)));
			$sheet->setCellValue('E' . $rows, (!empty($val->time_in)) ? date('h:i:s a ', strtotime($val->time_in)) : "");
			$sheet->setCellValue('F' . $rows, (!empty($val->time_out)) ? date('h:i:s a ', strtotime($val->time_out)) : "");
			$sheet->setCellValue('G' . $rows, ($val->status == 'in') ? 'In' : 'Out');
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function hungerReportExcel()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('rider_id'))) {
			$rider_id = $this->input->get('rider_id');
		} else {
			$rider_id = FALSE;
		}
		if (!empty($this->input->get('start_date'))) {
			$start_date = $this->input->get('start_date');
		} else {
			$start_date = FALSE;
		}
		if (!empty($this->input->get('end_date'))) {
			$end_date = $this->input->get('end_date');
		} else {
			$end_date = FALSE;
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "hunger-report-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$summary_reports = $this->Export_model->hunger_summary_report($keyword, $rider_id, $start_date, $end_date);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Hunger Summary Report")
			->setSubject("Baqala Station - Hunger Summary Report")
			->setDescription(
				"Baqala Station Hunger Summary Report."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Hunger Summary Report");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:H4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:H2');
		$sheet->setCellValue('A2', 'Baqala Station Hunger Summary Report');
		$sheet->setCellValue('A4', 'EMPLOYEE NO.');
		$sheet->setCellValue('B4', 'EMPLOYEE Name');
		$sheet->setCellValue('C4', 'RIDER ID');
		$sheet->setCellValue('D4', 'NOTIFIED DELIVERY');
		$sheet->setCellValue('E4', 'COMPLETED DELIVERY');
		$sheet->setCellValue('F4', 'UNATTENDED DELIVERIES');
		$sheet->setCellValue('G4', 'ID FINE');
		$sheet->setCellValue('H4', 'ONLINE HOURS');

		$rows = 5;

		$sumTotalNotifiedDelv = 0;
		$sumTotalCompleteDelv = 0;
		$sumTotalCancelledDelv = 0;
		$sumTotalDeclinedDelv = 0;
		$sumTotalNotAcceptDelv = 0;
		$sumTotalIDF = 0;
		$sumTotalOH = 0;

		foreach ($summary_reports as $report) {
			$sumTotalNotifiedDelv += $report['total_notified_deliveries'];
			$sumTotalCompleteDelv += $report['total_completed_deliveries'];
			$sumTotalCancelledDelv += $report['total_cancelled_deliveries'];
			$sumTotalDeclinedDelv += $report['total_declined_deliveries'];
			$sumTotalNotAcceptDelv += $report['total_not_accepted_deliveries'];
			$sumTotalIDF += $report['total_fine'];
			$sumTotalOH += $report['total_working_hours'];

			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $report['emp_no']);
			$sheet->setCellValue('B' . $rows, $report['full_name']);
			$sheet->setCellValue('C' . $rows, $report['rider_id']);
			$sheet->setCellValue('D' . $rows, $report['total_notified_deliveries']);
			$sheet->setCellValue('E' . $rows, $report['total_completed_deliveries']);
			$sheet->setCellValue('F' . $rows, ($report['total_cancelled_deliveries'] + $report['total_declined_deliveries'] + $report['total_not_accepted_deliveries']));
			$sheet->setCellValue('G' . $rows, $report['total_fine']);
			$sheet->setCellValue('H' . $rows, $report['total_working_hours']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function cvExport()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('applied_for'))) {
			$applied_for = $this->input->get('applied_for');
		} else {
			$applied_for = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$start_date = $this->input->get('from');
		} else {
			$start_date = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$end_date = $this->input->get('to');
		} else {
			$end_date = FALSE;
		}
		if (!empty($this->input->get('sponsor_id'))) {
			$sponsor_id = $this->input->get('sponsor_id');
		} else {
			$sponsor_id = FALSE;
		}
		if (!empty($this->input->get('arrival_from'))) {
			$arrival_from = $this->input->get('arrival_from');
		} else {
			$arrival_from = FALSE;
		}
		if (!empty($this->input->get('arrival_to'))) {
			$arrival_to = $this->input->get('arrival_to');
		} else {
			$arrival_to = FALSE;
		}
		if (!empty($this->input->get('cv_status'))) {
			$cv_status = $this->input->get('cv_status');
		} else {
			$cv_status = FALSE;
		}
		if (!empty($this->input->get('interview_status'))) {
			$interview_status = $this->input->get('interview_status');
		} else {
			$interview_status = FALSE;
		}
		if (!empty($this->input->get('agency_name'))) {
			$agency_name = $this->input->get('agency_name');
		} else {
			$agency_name = FALSE;
		}
		if (!empty($this->input->get('nationality'))) {
			$nationality = $this->input->get('nationality');
		} else {
			$nationality = FALSE;
		}
		if (!empty($this->input->get('checklist'))) {
			$selected_ids = $this->input->get('checklist');
		} else {
			$selected_ids = FALSE;
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "cv-export-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$cv_lists = $this->Export_model->cv_export($keyword, $applied_for, $start_date, $end_date, $cv_status, $interview_status, $agency_name, $sponsor_id, $arrival_from, $arrival_to, $selected_ids, $nationality);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Applicant CV")
			->setSubject("Baqala Station - Applicant CV")
			->setDescription(
				"Baqala Station Applicant CV"
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Applicant CV");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:AG2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:AG4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:AG2');
		$sheet->setCellValue('A2', 'Baqala Station Applicant CV');
		$sheet->setCellValue('A4', 'CV Number');
		$sheet->setCellValue('B4', 'Country');
		$sheet->setCellValue('C4', 'Agency Name');
		$sheet->setCellValue('D4', 'Hiring Type');
		$sheet->setCellValue('E4', 'Applicant Type');
		$sheet->setCellValue('F4', 'Position Applied for');
		$sheet->setCellValue('G4', 'Full Name (EN)');
		$sheet->setCellValue('H4', 'Full Name (AR)');
		$sheet->setCellValue('I4', 'Date of Birth');
		$sheet->setCellValue('J4', 'Age');
		$sheet->setCellValue('K4', 'Gender');
		$sheet->setCellValue('L4', 'Marital Status');
		$sheet->setCellValue('M4', 'Nationality');
		$sheet->setCellValue('N4', 'Home Land Mobile No');
		$sheet->setCellValue('O4', 'IMO Available');
		$sheet->setCellValue('P4', 'Personal Email ID');
		$sheet->setCellValue('Q4', 'Passport No');
		$sheet->setCellValue('R4', 'Passport Expiry Date');
		$sheet->setCellValue('S4', 'Passport Issuing Country');
		$sheet->setCellValue('T4', 'Passport Issuing City');
		$sheet->setCellValue('U4', 'CV Status');
		$sheet->setCellValue('V4', 'Interviewer Name');
		$sheet->setCellValue('W4', 'Interview Date');
		$sheet->setCellValue('X4', 'Interview Status');
		$sheet->setCellValue('Y4', 'Reason for rejection');
		$sheet->setCellValue('Z4', 'Sponsor ID');
		$sheet->setCellValue('AA4', 'Sponsor Name');
		$sheet->setCellValue('AB4', 'Visa No');
		$sheet->setCellValue('AC4', 'Visa Expiry Date');
		$sheet->setCellValue('AD4', 'Border Entry No');
		$sheet->setCellValue('AE4', 'Arrival Date');
		$sheet->setCellValue('AF4', 'Blood Group');
		$sheet->setCellValue('AG4', 'Created At');
		$rows = 5;
		foreach ($cv_lists as $report) {
			if ($report['cv_status'] == 'new') {
				$cv_status = 'New';
			} elseif ($report['cv_status'] == 'shortlisted') {
				$cv_status = 'Shortlisted';
			} elseif ($report['cv_status'] == 'not_qualified') {
				$cv_status = 'Not Qualified';
			} else {
				$cv_status = 'NA';
			}

			if ($report['interview_status'] == 'selected') {
				$int_status = 'Selected';
			} elseif ($report['interview_status'] == 'rejected') {
				$int_status = 'Rejected';
			} else {
				$int_status = 'NA';
			}
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, ' ' . $report['cv_no']);
			$sheet->setCellValue('B' . $rows, $report['applicant_country_name']);
			$sheet->setCellValue('C' . $rows, $report['hiring_agency_name']);
			$sheet->setCellValue('D' . $rows, $report['hiring_type']);
			$sheet->setCellValue('E' . $rows, $report['applicant_type']);
			$sheet->setCellValue('F' . $rows, $report['pos_name']);
			$sheet->setCellValue('G' . $rows, (($report['first_name'] !== '') ? $report['first_name'] : '') . (($report['middle_name'] !== '') ? ' ' . $report['middle_name'] : '') . (($report['third_name'] !== '') ? ' ' . $report['third_name'] : '') . (($report['surname'] !== '') ? ' ' . $report['surname'] : ''));
			$sheet->setCellValue('H' . $rows, $report['candidate_arabic_name']);
			$sheet->setCellValue('I' . $rows, (isset($report['dob'])) ? date('d-m-Y', strtotime($report['dob'])) : 'NA');
			$age = age_calculate($report['dob']);
			$sheet->setCellValue('J' . $rows, $age);
			$sheet->setCellValue('K' . $rows, $report['gender']);
			$sheet->setCellValue('L' . $rows, $report['marital_status']);
			$sheet->setCellValue('M' . $rows, $report['nationality']);
			$sheet->setCellValue('N' . $rows, ' ' . $report['mobile']);
			$sheet->setCellValue('O' . $rows, $report['imo_available']);
			$sheet->setCellValue('P' . $rows, ' ' . $report['email']);
			$sheet->setCellValue('Q' . $rows, ' ' . $report['passport_no']);
			$sheet->setCellValue('R' . $rows, (isset($report['passport_exp'])) ? date('d-m-Y', strtotime($report['passport_exp'])) : 'NA');
			$sheet->setCellValue('S' . $rows, $report['passport_country_name']);
			$sheet->setCellValue('T' . $rows, $report['passport_issue_city']);
			$sheet->setCellValue('U' . $rows, $cv_status);
			$sheet->setCellValue('V' . $rows, $report['interviewer']);
			$sheet->setCellValue('W' . $rows, (isset($report['interview_date'])) ? date('d-m-Y', strtotime($report['interview_date'])) : 'NA');
			$sheet->setCellValue('X' . $rows, $report['interview_status']);
			$sheet->setCellValue('Y' . $rows, $report['rejection_reason']);
			$sheet->setCellValue('Z' . $rows, ' ' . $report['sponsor_id']);
			$sheet->setCellValue('AA' . $rows, ' ' . $report['sponsor_name']);
			$sheet->setCellValue('AB' . $rows, ' ' . $report['visa_no']);
			$sheet->setCellValue('AC' . $rows, (isset($report['visa_expiry'])) ? date('d-m-Y', strtotime($report['visa_expiry'])) : 'NA');
			$sheet->setCellValue('AD' . $rows, ' ' . $report['border_entry_no']);
			$sheet->setCellValue('AE' . $rows, (isset($report['arrival_date'])) ? date('d-m-Y', strtotime($report['arrival_date'])) : 'NA');
			$sheet->setCellValue('AF' . $rows, $report['blood_group']);
			$sheet->setCellValue('AG' . $rows, (isset($report['created_at'])) ? date('d-m-Y', strtotime($report['created_at'])) : 'NA');
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function cvExportMedical()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('applied_for'))) {
			$applied_for = $this->input->get('applied_for');
		} else {
			$applied_for = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$start_date = $this->input->get('from');
		} else {
			$start_date = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$end_date = $this->input->get('to');
		} else {
			$end_date = FALSE;
		}
		if (!empty($this->input->get('sponsor_id'))) {
			$sponsor_id = $this->input->get('sponsor_id');
		} else {
			$sponsor_id = FALSE;
		}
		if (!empty($this->input->get('arrival_from'))) {
			$arrival_from = $this->input->get('arrival_from');
		} else {
			$arrival_from = FALSE;
		}
		if (!empty($this->input->get('arrival_to'))) {
			$arrival_to = $this->input->get('arrival_to');
		} else {
			$arrival_to = FALSE;
		}
		if (!empty($this->input->get('cv_status'))) {
			$cv_status = $this->input->get('cv_status');
		} else {
			$cv_status = FALSE;
		}
		if (!empty($this->input->get('interview_status'))) {
			$interview_status = $this->input->get('interview_status');
		} else {
			$interview_status = FALSE;
		}
		if (!empty($this->input->get('agency_name'))) {
			$agency_name = $this->input->get('agency_name');
		} else {
			$agency_name = FALSE;
		}
		if (!empty($this->input->get('nationality'))) {
			$nationality = $this->input->get('nationality');
		} else {
			$nationality = FALSE;
		}
		if (!empty($this->input->get('checklist'))) {
			$selected_ids = $this->input->get('checklist');
		} else {
			$selected_ids = FALSE;
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "cv-export-iqama-medical-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$cv_lists = $this->Export_model->cv_export($keyword, $applied_for, $start_date, $end_date, $cv_status, $interview_status, $agency_name, $sponsor_id, $arrival_from, $arrival_to, $selected_ids, $nationality);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Iqama Medical")
			->setSubject("Baqala Station - Iqama Medical")
			->setDescription(
				"Baqala Station Iqama Medical"
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Iqama Medical");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

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

		$spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:L2');
		$sheet->setCellValue('A2', 'Baqala Station Iqama Medical');
		$sheet->setCellValue('A4', 'S.No.');
		$sheet->setCellValue('B4', 'Name');
		$sheet->setCellValue('C4', 'Passport No');
		$sheet->setCellValue('D4', 'Visa No');
		$sheet->setCellValue('E4', 'Date of Birth');
		$sheet->setCellValue('F4', 'Nationality');
		$sheet->setCellValue('G4', 'Email');
		$sheet->setCellValue('H4', 'Border Entry No');
		$sheet->setCellValue('I4', 'Sponsor ID');
		$sheet->setCellValue('J4', 'Mobile Number');
		$sheet->setCellValue('K4', 'Marital Status');
		$sheet->setCellValue('L4', 'Blood Group');
		$rows = 5;
		$count = 1;
		foreach ($cv_lists as $report) {
			if ($report['cv_status'] == 'new') {
				$cv_status = 'New';
			} elseif ($report['cv_status'] == 'shortlisted') {
				$cv_status = 'Shortlisted';
			} elseif ($report['cv_status'] == 'not_qualified') {
				$cv_status = 'Not Qualified';
			} else {
				$cv_status = 'NA';
			}

			if ($report['interview_status'] == 'selected') {
				$int_status = 'Selected';
			} elseif ($report['interview_status'] == 'rejected') {
				$int_status = 'Rejected';
			} else {
				$int_status = 'NA';
			}
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $count++);
			$sheet->setCellValue('B' . $rows, (($report['first_name'] !== '') ? $report['first_name'] : '') . (($report['middle_name'] !== '') ? ' ' . $report['middle_name'] : '') . (($report['third_name'] !== '') ? ' ' . $report['third_name'] : '') . (($report['surname'] !== '') ? ' ' . $report['surname'] : ''));
			$sheet->setCellValue('C' . $rows, ' ' . $report['passport_no']);
			$sheet->setCellValue('D' . $rows, ' ' . $report['visa_no']);
			$sheet->setCellValue('E' . $rows, (isset($report['dob'])) ? date('d-m-Y', strtotime($report['dob'])) : 'NA');
			$sheet->setCellValue('F' . $rows, ' ' . $report['nationality']);
			$sheet->setCellValue('G' . $rows, ' ' . $report['email']);
			$sheet->setCellValue('H' . $rows, ' ' . $report['border_entry_no']);
			$sheet->setCellValue('I' . $rows, ' ' . $report['sponsor_id']);
			$sheet->setCellValue('J' . $rows, ' ' . $report['mobile']);
			$sheet->setCellValue('K' . $rows, $report['marital_status']);
			$sheet->setCellValue('L' . $rows, $report['blood_group']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function employeeExport()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('nationality'))) {
			$nationality = $this->input->get('nationality');
		} else {
			$nationality = FALSE;
		}
		if (!empty($this->input->get('designation'))) {
			$designation = $this->input->get('designation');
		} else {
			$designation = FALSE;
		}
		if (!empty($this->input->get('department'))) {
			$department = $this->input->get('department');
		} else {
			$department = FALSE;
		}
		if (!empty($this->input->get('iqama_status'))) {
			$iqama_status = $this->input->get('iqama_status');
		} else {
			$iqama_status = FALSE;
		}
		if (!empty($this->input->get('iqama_expiry_start'))) {
			$iqama_start_date = $this->input->get('iqama_expiry_start');
		} else {
			$iqama_start_date = FALSE;
		}
		if (!empty($this->input->get('iqama_expiry_end'))) {
			$iqama_end_date = $this->input->get('iqama_expiry_end');
		} else {
			$iqama_end_date = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('iqama'))) {
			$iqama = $this->input->get('iqama');
		} else {
			$iqama = FALSE;
		}
		if (!empty($this->input->get('start_date'))) {
			$start_date = $this->input->get('start_date');
		} else {
			$start_date = FALSE;
		}
		if (!empty($this->input->get('end_date'))) {
			$end_date = $this->input->get('end_date');
		} else {
			$end_date = FALSE;
		}
		if (!empty($this->input->get('checklist'))) {
			$selected_ids = $this->input->get('checklist');
		} else {
			$selected_ids = FALSE;
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "employee-export-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$employee_lists = $this->Export_model->employee_export($keyword, $designation, $nationality, $department, $iqama_status, $status, $iqama, $start_date, $end_date, $iqama_start_date, $iqama_end_date, $selected_ids);

		//dd($employee_lists);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Employee List")
			->setSubject("Baqala Station - Employee List")
			->setDescription(
				"Baqala Station Employee List"
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Employee List");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true);
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
					'argb' => 'FFFFFF',
				],
				'endColor' => [
					'argb' => 'FFFFFF',
				],
			],
		];

		$spreadsheet->getActiveSheet()->getStyle('A1:BG1')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A2:BG2')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('CBDBF7');

		// $sheet = $spreadsheet->getActiveSheet()->getStyle('A3:AY3')->applyFromArray($styleArray)->getFill()
		// ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		// ->getStartColor()->setARGB('CBDBF7');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A1:BG1');
		$sheet->setCellValue('A1', 'Baqala Station Employee List');
		$sheet->setCellValue('A2', 'SR No.');
		$sheet->setCellValue('B2', 'Emp No');
		$sheet->setCellValue('C2', 'Sanat Al Amar');
		$sheet->setCellValue('D2', 'Full Name En');
		$sheet->setCellValue('E2', 'Full Name Ar');
		$sheet->setCellValue('F2', 'ID/Iqama No');
		$sheet->setCellValue('G2', 'Date Of Birth');
		$sheet->setCellValue('H2', 'Gender');
		$sheet->setCellValue('I2', 'Marital Status');
		$sheet->setCellValue('J2', 'Religion');
		$sheet->setCellValue('K2', 'Mobile No');
		$sheet->setCellValue('L2', 'Email');
		$sheet->setCellValue('M2', 'Joining Date');
		$sheet->setCellValue('N2', 'Status');
		$sheet->setCellValue('O2', 'Last Working Date');
		$sheet->setCellValue('P2', 'Name as per Iqama EN');
		$sheet->setCellValue('Q2', 'Name as per Iqama AR');
		$sheet->setCellValue('R2', 'Profession in Iqama');
		$sheet->setCellValue('S2', 'ID/Iqama Issue City');
		$sheet->setCellValue('T2', 'ID/Iqama Issue Date (Gregorian)');
		$sheet->setCellValue('U2', 'ID/Iqama Expiry Date (Gregorian)');
		$sheet->setCellValue('V2', 'Nationality');
		$sheet->setCellValue('W2', 'Passport Number');
		$sheet->setCellValue('X2', 'Passport Issue Date');
		$sheet->setCellValue('Y2', 'Passport Expiry Date');
		$sheet->setCellValue('Z2', 'Passport Issue Country');
		$sheet->setCellValue('AA2', 'Passport Issuing City');
		$sheet->setCellValue('AB2', 'Department');
		$sheet->setCellValue('AC2', 'Job Title');
		$sheet->setCellValue('AD2', 'Line Manager');
		$sheet->setCellValue('AE2', 'Direct Manager');
		$sheet->setCellValue('AF2', 'Department Head');
		$sheet->setCellValue('AG2', 'Employment Type');
		$sheet->setCellValue('AH2', 'Working Hours');
		$sheet->setCellValue('AI2', 'Working Days');
		$sheet->setCellValue('AJ2', 'Work Location ID');
		$sheet->setCellValue('AK2', 'Country ID');
		$sheet->setCellValue('AL2', 'City Id');
		$sheet->setCellValue('AM2', 'Bank');
		$sheet->setCellValue('AN2', 'Bank IBAN');
		$sheet->setCellValue('AO2', 'Basic Salary');
		$sheet->setCellValue('AP2', 'Housing Allowance');
		$sheet->setCellValue('AQ2', 'Transport Allowance');
		$sheet->setCellValue('AR2', 'Food Allowance');
		$sheet->setCellValue('AS2', 'Mobile Allowance');
		$sheet->setCellValue('AT2', 'Other Allowance');
		$sheet->setCellValue('AU2', 'Total Package');
		$sheet->setCellValue('AV2', 'Annual Leave Entitlement');
		$sheet->setCellValue('AW2', 'Camp');
		$sheet->setCellValue('AX2', 'Room No');
		$sheet->setCellValue('AY2', 'Bed');
		$sheet->setCellValue('AZ2', 'Employer ID');
		$sheet->setCellValue('BA2', 'Employer Name');
		$sheet->setCellValue('BB2', 'Employer CR No.');
		$sheet->setCellValue('BC2', 'Insurance Policy No');
		$sheet->setCellValue('BD2', 'Insurance Company Name');
		$sheet->setCellValue('BE2', 'Insurance Issue Date');
		$sheet->setCellValue('BF2', 'Insurance Expiry Date');
		$sheet->setCellValue('BG2', 'Qiwa Contract No');

		$rows = 3;
		$count = 1;
		foreach ($employee_lists as $report) {
			$sheet->setCellValue('A' . $rows, $count);
			$sheet->setCellValue('B' . $rows, $report['emp_no']);
			$sheet->setCellValue('C' . $rows, (empty($report['sanat_no'])) ? 'No' : 'Yes');
			$sheet->setCellValue('D' . $rows, ($report['full_name']));
			$sheet->setCellValue('E' . $rows, $report['employee_arabic_name']);
			$sheet->setCellValue('F' . $rows, $report['iqama_no']);
			$sheet->setCellValue('G' . $rows, ($report['dob'] !== '' && $report['dob'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['dob'])) : 'NA');
			$sheet->setCellValue('H' . $rows, ucfirst($report['gender']));
			$sheet->setCellValue('I' . $rows, $report['marital_status']);
			$sheet->setCellValue('J' . $rows, $report['religion']);
			$sheet->setCellValue('K' . $rows, $report['mobile']);
			$sheet->setCellValue('L' . $rows, $report['email']);
			$sheet->setCellValue('M' . $rows, ($report['work_joining_date'] !== '' && $report['work_joining_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['work_joining_date'])) : 'NA');
			$sheet->setCellValue('N' . $rows, ($report['status'] == 'Active') ? 'Active' : 'Terminated');
			$sheet->setCellValue('O' . $rows, ($report['last_working_date'] !== '' && $report['last_working_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['last_working_date'])) : 'NA');
			$sheet->setCellValue('P' . $rows, ucfirst($report['iqama_name_en']));
			$sheet->setCellValue('Q' . $rows, $report['iqama_name_ar']);
			$sheet->setCellValue('R' . $rows, $report['profession_name']);
			$sheet->setCellValue('S' . $rows, (!empty($report['iqama_issue_city'])) ? cityDetailHelper($report['iqama_issue_city'])->city_name : 'N/A');
			$sheet->setCellValue('T' . $rows, ($report['iqama_issue_date'] !== '' && $report['iqama_issue_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['iqama_issue_date'])) : 'NA');
			$sheet->setCellValue('U' . $rows, ($report['iqama_expiry_date'] !== '' && $report['iqama_expiry_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['iqama_expiry_date'])) : 'NA');
			$sheet->setCellValue('V' . $rows, $report['nationality_name']);
			$sheet->setCellValue('W' . $rows, $report['passport_no']);
			$sheet->setCellValue('X' . $rows, ($report['passport_issue_date'] !== '' && $report['passport_issue_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['passport_issue_date'])) : 'NA');
			$sheet->setCellValue('Y' . $rows, ($report['passport_expiry_date'] !== '' && $report['passport_expiry_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['passport_expiry_date'])) : 'NA');
			$sheet->setCellValue('Z' . $rows, (!empty($report['passport_issue_country'])) ? countryDetailHelper($report['passport_issue_country'])->name : 'N/A');
			$sheet->setCellValue('AA' . $rows, (!empty($report['passport_issue_city'])) ? cityDetailHelper($report['passport_issue_city'])->city_name : 'N/A');
			$sheet->setCellValue('AB' . $rows, ($report['department_name'] !== '') ? $report['department_name'] : 'N/A');
			$sheet->setCellValue('AC' . $rows, $report['designation_name']);
			$sheet->setCellValue('AD' . $rows, (!empty(employeeDetailHelper($report['work_line_manager']))) ? employeeDetailHelper($report['work_line_manager'])->full_name : 'N/A');
			$sheet->setCellValue('AE' . $rows, 'N/A');
			$sheet->setCellValue('AF' . $rows, (!empty(employeeDetailHelper($report['department_head']))) ? employeeDetailHelper($report['department_head'])->full_name : 'N/A');
			$sheet->setCellValue('AG' . $rows, $report['employment_type']);
			$sheet->setCellValue('AH' . $rows, $report['working_hours']);
			$sheet->setCellValue('AI' . $rows, ($report['working_days'] !== '' && $report['working_days'] !== '0') ? $report['working_days'] . ' Days' : 'NA');
			$sheet->setCellValue('AJ' . $rows, $report['location_name']);
			$sheet->setCellValue('AK' . $rows, $report['work_country_name']);
			$sheet->setCellValue('AL' . $rows, $report['work_city_name']);
			$paymentTypeDetail = (isset($report['payment_type_detail'])) ? json_decode($report['payment_type_detail']) : '';
			if ($report['payment_type'] == 'Bank') {
				$bank_name = $paymentTypeDetail->bank_name;
				$iban_no = $paymentTypeDetail->iban_no;
			} else {
				$bank_name = 'NA';
				$iban_no = 'NA';
			}
			$sheet->setCellValue('AM' . $rows, $bank_name);
			$sheet->setCellValue('AN' . $rows, $iban_no);
			$sheet->setCellValue('AO' . $rows, $report['basic_salary']);
			$sheet->setCellValue('AP' . $rows, $report['housing_allowance']);
			$sheet->setCellValue('AQ' . $rows, $report['transport_allowance']);
			$sheet->setCellValue('AR' . $rows, $report['food_allowance']);
			$sheet->setCellValue('AS' . $rows, $report['mobile_allowance']);
			$sheet->setCellValue('AT' . $rows, $report['other_allowance']);
			$sheet->setCellValue('AU' . $rows, $report['total_package']);
			$sheet->setCellValue('AV' . $rows, $report['annual_leave_entitlement']);
			$sheet->setCellValue('AW' . $rows, $report['camp_name']);
			$sheet->setCellValue('AX' . $rows, $report['room_name']);
			$sheet->setCellValue('AY' . $rows, $report['bed_name']);
			$sheet->setCellValue('AZ' . $rows, $report['employer_id']);
			$sheet->setCellValue('BA' . $rows, $report['employer_name']);
			$sheet->setCellValue('BB' . $rows, $report['employer_cr_no']);
			$sheet->setCellValue('BC' . $rows, ' ' . $report['employee_policy_no']);
			$sheet->setCellValue('BD' . $rows, $report['policy_company_name']);
			$sheet->setCellValue('BE' . $rows, (!empty($report['insurance_issue_date']) && $report['insurance_issue_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['insurance_issue_date'])) : 'NA');
			$sheet->setCellValue('BF' . $rows, (!empty($report['insurance_end_date']) && $report['insurance_end_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['insurance_end_date'])) : 'NA');
			$sheet->setCellValue('BG' . $rows, ' ' . $report['qiwa_contract_no']);

			$rows++;
			$count++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function voucherDetailExcel()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vouchers', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "voucher-logs-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$id = $this->input->get('id');
		$query = $this->Voucher_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['voucher_detail'] = $query->row();
			$data['voucher_list'] =  $this->Voucher_model->get_group_vouchers($id)->result_array();
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/sim/vouchers');
		}
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Recharge Voucher Detail")
			->setSubject("Baqala Station - Recharge Voucher Detail")
			->setDescription(
				"Baqala Station Recharge Voucher Detail."
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Recharge Voucher Detail");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
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
		$styleArray2 = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],

			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => [
					'argb' => 'F8CBAD',
				],
				'endColor' => [
					'argb' => 'F8CBAD',
				],
			],
		];
		$styleArray3 = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],

			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => [
					'argb' => 'DDDDDD',
				],
				'endColor' => [
					'argb' => 'DDDDDD',
				],
			],
		];

		$spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A6:H6')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A7:H7')->applyFromArray($styleArray3);
		$sheet = $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray2)->getFill();
		$sheet = $spreadsheet->getActiveSheet()->getStyle('A3:H3')->applyFromArray($styleArray2)->getFill();
		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:H4')->applyFromArray($styleArray2)->getFill();
		$sheet = $spreadsheet->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArray2)->getFill();
		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A1:H1');
		$spreadsheet->getActiveSheet()->mergeCells('A6:H6');
		$sheet->setCellValue('A1', 'Baqala Station Recharge Voucher Detail');
		$sheet->setCellValue('B2', 'Date Of Purchase');
		$sheet->setCellValue('B3', 'Service Provider');
		$sheet->setCellValue('B4', 'Total Vouchers Purchased');
		$sheet->setCellValue('B5', 'Expiry Date');

		$sheet->setCellValue('E2', 'Voucher Price');
		$sheet->setCellValue('E3', 'VAT');
		$sheet->setCellValue('E4', 'Voucher Price (inc Vat)');

		$sheet->setCellValue('A6', 'Vouchers Serial Numbers');
		$sheet->setCellValue('A7', 'S.No.');
		$sheet->setCellValue('B7', 'Voucher Serial Number');
		$sheet->setCellValue('C7', 'Usage Date');
		$sheet->setCellValue('D7', 'Mobile Number');
		$sheet->setCellValue('E7', 'Vehicle Number');
		$sheet->setCellValue('F7', 'Employee ID');
		$sheet->setCellValue('G7', 'User Name');
		$sheet->setCellValue('H7', 'Status');
		//print_r($data);exit();
		$rows = 8;
		$count = 1;
		$sheet->setCellValue('C2', date('d-m-Y', strtotime($data['voucher_detail']->purchase_date)));
		$sheet->setCellValue('C3', $data['voucher_detail']->network_name);
		$sheet->setCellValue('C4', $data['voucher_detail']->total_vouchers);
		$sheet->setCellValue('C5', date('d-m-Y', strtotime($data['voucher_detail']->expiry_date)));

		$sheet->setCellValue('F2', $data['voucher_detail']->voucher_value);
		$sheet->setCellValue('F3', $data['voucher_detail']->voucher_vat);
		$sheet->setCellValue('F4', $data['voucher_detail']->voucher_total);
		foreach ($data['voucher_list'] as $v_array) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $count);
			$sheet->setCellValue('B' . $rows, ' ' . $v_array['serial_no']);
			$sheet->setCellValue('C' . $rows, (isset($v_array['used_date'])) ? date('d-m-Y', strtotime($v_array['used_date'])) : 'NA');
			$sheet->setCellValue('D' . $rows, (isset($v_array['mobile_no'])) ? ' ' . $v_array['mobile_no'] : 'NA');
			$sheet->setCellValue('E' . $rows, (isset($v_array['vehicle_no'])) ? ' ' . $v_array['vehicle_no'] : 'NA');
			$sheet->setCellValue('F' . $rows, (isset($v_array['emp_no'])) ? ' ' . $v_array['emp_no'] : 'NA');
			$sheet->setCellValue('G' . $rows, (isset($v_array['emp_full_name'])) ? $v_array['emp_full_name'] : 'NA');
			if ($v_array['status'] == '0') {
				$status = 'New';
			}
			if ($v_array['status'] == '1') {
				$status = 'Used';
			}
			if ($v_array['status'] == '2') {
				$status = 'Expired';
			}
			$sheet->setCellValue('H' . $rows, $status);
			$rows++;
			$count++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
		//$writer->save("uploads/".$fileName);
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."/uploads/".$fileName);              
	}

	public function vehicleExport()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}

		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "master-vehicle-export-" . $date . ".xlsx";

		$vehicle_lists = $this->Export_model->vehicle_export();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Master Vehicle")
			->setSubject("Baqala Station - Master Vehicle")
			->setDescription("Baqala Station Master Vehicle")
			->setKeywords("office 2007 openxml php")
			->setCategory("Master Vehicle");

		// Auto size columns A to Z
		foreach (range('A', 'Z') as $col) {
			$spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		foreach (range('AA', 'AP') as $col) {
			$spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		$styleArray = [
			'font' => ['bold' => true],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startColor' => ['argb' => 'FFEB9C'],
				'endColor' => ['argb' => 'FFEB9C'],
			],
		];

		$spreadsheet->getActiveSheet()->getStyle('A2:AP2')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->mergeCells('A2:AP2');
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A2', 'Baqala Station Master Vehicle');

		$sheet->getStyle('A4:AP4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		// Set headers
		$headers = [
			'A4' => 'S.No',
			'B4' => 'Vehicle Ownership',
			'C4' => 'Vehicle Owner',
			'D4' => 'Vehicle Type',
			'E4' => 'Vehicle No.',
			'F4' => 'Vehicle Expiry Date',
			'G4' => 'Vehicle Year',
			'H4' => 'Vehicle Make',
			'I4' => 'Vehicle Model',
			'J4' => 'Vehicle Color',
			'K4' => 'Vehicle Category',
			'L4' => 'Purchase Date',
			'M4' => 'Chassis No',
			'N4' => 'Custom Card No',
			'O4' => 'Gasoline Chip Status',
			'P4' => 'Insurance No',
			'Q4' => 'Insurance Company',
			'R4' => 'Insurance Issue Date',
			'S4' => 'Insurance Expiry Date',
			'T4' => 'GPS Installed',
			'U4' => 'GPS IMEI',
			'V4' => 'GPS Mobile',
			'W4' => 'GPS Install Date',
			'X4' => 'GPS Expiry Date',
			'Y4' => 'Operation Card No',
			'Z4' => 'Op Card Issue Date',
			'AA4' => 'Op Card Expiry Date',
			'AB4' => 'Vehicle Status',
			'AC4' => 'Status Reason',
			'AD4' => 'Status Date',
			'AE4' => 'Registration Cert',
			'AF4' => 'Insurance Cert',
			'AG4' => 'Attached File',
			'AH4' => 'Tamm Attachment',
			'AI4' => 'Allot Emp ID',
			'AJ4' => 'Allot User',
			'AK4' => 'Allot Status',
			'AL4' => 'Sequel No.',
			'AM4' => 'Parking Lot',
			'AN4' => 'City of Operation',
			'AO4' => 'Created At',
			'AP4' => 'Updated At',
		];

		foreach ($headers as $cell => $value) {
			$sheet->setCellValue($cell, $value);
		}

		$rows = 5;
		$serial = 1;

		$status_map = [
			'active' => 'Active',
			'inactive' => 'Inactive',
			'discontinued' => 'Discontinued',
			'workshop' => 'Workshop',
		];

		foreach ($vehicle_lists as $item) {
			$allot_status = '';
			if ($item['allotment_status'] == 'alloted') {
				$allot_status = 'Alloted';
			} elseif ($item['allotment_status'] == 'unalloted') {
				$allot_status = 'Unalloted';
			} elseif ($item['allotment_status'] == 'return') {
				$allot_status = 'Return';
			}

			$sheet->setCellValue('A' . $rows, $serial++);
			$sheet->setCellValue('B' . $rows, ucfirst($item['vehicle_ownership']));
			$sheet->setCellValue('C' . $rows, ucfirst($item['owner_name_select']));
			$sheet->setCellValue('D' . $rows, ucfirst($item['vehicle_type']));
			$sheet->setCellValue('E' . $rows, ' ' . $item['vehicle_no']);
			$sheet->setCellValue('F' . $rows, (!empty($item['vehicle_expiry'] && $item['vehicle_expiry'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['vehicle_expiry'])) : 'NA'));
			$sheet->setCellValue('G' . $rows, $item['vehicle_year']);
			$sheet->setCellValue('H' . $rows, $item['make_name']);
			$sheet->setCellValue('I' . $rows, $item['vehicle_model']);
			$sheet->setCellValue('J' . $rows, $item['color_name']);
			$sheet->setCellValue('K' . $rows, $item['vehicle_category']);
			$sheet->setCellValue('L' . $rows, (!empty($item['purchase_date'] && $item['purchase_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['purchase_date'])) : 'NA'));
			$sheet->setCellValue('M' . $rows, ' ' . $item['chassis_no']);
			$sheet->setCellValue('N' . $rows, ' ' . $item['custom_card_no']);
			$sheet->setCellValue('O' . $rows, ($item['gasoline_chip_status'] == 'on') ? 'Yes' : 'No');
			$sheet->setCellValue('P' . $rows, ' ' . $item['insurance_policy_no']);
			$sheet->setCellValue('Q' . $rows, $item['insurance_company_names']);
			$sheet->setCellValue('R' . $rows, (!empty($item['insurance_issue_date'] && $item['insurance_issue_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['insurance_issue_date'])) : 'NA'));
			$sheet->setCellValue('S' . $rows, (!empty($item['insurance_expiry'] && $item['insurance_expiry'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['insurance_expiry'])) : 'NA'));
			$sheet->setCellValue('T' . $rows, ($item['gps_installed'] == 'on') ? 'Yes' : 'No');
			$sheet->setCellValue('U' . $rows, ' ' . $item['gps_device_serial']);
			$sheet->setCellValue('V' . $rows, ' ' . $item['gsp_mobile_no']);
			$sheet->setCellValue('W' . $rows, (!empty($item['gps_installation_date'] && $item['gps_installation_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['gps_installation_date'])) : 'NA'));
			$sheet->setCellValue('X' . $rows, (!empty($item['gps_expiry_date'] && $item['gps_expiry_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['gps_expiry_date'])) : 'NA'));
			$sheet->setCellValue('Y' . $rows, ' ' . $item['operation_card_no']);
			$sheet->setCellValue('Z' . $rows, (!empty($item['operation_card_issue_date'] && $item['operation_card_issue_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['operation_card_issue_date'])) : 'NA'));
			$sheet->setCellValue('AA' . $rows, (!empty($item['operation_card_expiry_date'] && $item['operation_card_expiry_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['operation_card_expiry_date'])) : 'NA'));
			$sheet->setCellValue('AB' . $rows, isset($status_map[$item['status']]) ? $status_map[$item['status']] : 'Unknown');
			$sheet->setCellValue('AC' . $rows, $item['status_reasons']);
			$sheet->setCellValue('AD' . $rows, (!empty($item['status_date'] && $item['status_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['status_date'])) : 'NA'));
			$sheet->setCellValue('AE' . $rows, (!empty($item['registration_certificate']) ? 'Uploaded' : 'Not Uploaded'));
			$sheet->setCellValue('AF' . $rows, (!empty($item['insurance_certificate']) ? 'Uploaded' : 'Not Uploaded'));
			$sheet->setCellValue('AG' . $rows, (!empty($item['attached_file']) ? 'Uploaded' : 'Not Uploaded'));
			$sheet->setCellValue('AH' . $rows, (!empty($item['tamm_attachment']) ? 'Uploaded' : 'Not Uploaded'));
			$sheet->setCellValue('AI' . $rows, $item['emp_no']);
			$sheet->setCellValue('AJ' . $rows, $item['alloted_user_name']);
			$sheet->setCellValue('AK' . $rows, $allot_status);
			$sheet->setCellValue('AL' . $rows, ' ' . $item['sequel_no']);
			$sheet->setCellValue('AM' . $rows, $item['parking_name']);
			$sheet->setCellValue('AN' . $rows, $item['operation_city']);
			$sheet->setCellValue('AO' . $rows, (!empty($item['created_at']) ? date('d-m-Y', strtotime($item['created_at'])) : 'NA'));
			$sheet->setCellValue('AP' . $rows, (!empty($item['updated_at'] && $item['updated_at'] !== '0000-00-00') ? date('d-m-Y', strtotime($item['updated_at'])) : 'NA'));

			$rows++;
		}

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}

		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
	}

	public function riderExport()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "master-rider-export-" . $date . ".xlsx";
		//$fileName = 'sim-list.xlsx';  
		$rider_list = $this->Export_model->rider_export();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Master Rider")
			->setSubject("Baqala Station - Master Rider")
			->setDescription(
				"Baqala Station Master Rider"
			)
			->setKeywords("office 2007 openxml php")
			->setCategory("Master Rider");
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
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

		$spreadsheet->getActiveSheet()->getStyle('A2:W2')->applyFromArray($styleArray);


		$sheet = $spreadsheet->getActiveSheet()->getStyle('A4:W4')->applyFromArray($styleArray)->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('F8CBAD');

		$sheet = $spreadsheet->getActiveSheet();
		$spreadsheet->getActiveSheet()->mergeCells('A2:W2');
		$sheet->setCellValue('A2', 'Baqala Station Master Riders');
		$sheet->setCellValue('A4', 'Sr. No');
		$sheet->setCellValue('B4', 'Emp No.');
		$sheet->setCellValue('C4', 'Employee Name');
		$sheet->setCellValue('D4', 'Iqama/National ID');
		$sheet->setCellValue('E4', 'Nationality');
		$sheet->setCellValue('F4', 'Mobile No');
		$sheet->setCellValue('G4', 'Registration Date');
		$sheet->setCellValue('H4', 'Activation Date');
		$sheet->setCellValue('I4', 'Platform ID');
		$sheet->setCellValue('J4', 'Platform');
		$sheet->setCellValue('K4', 'ID Type');
		$sheet->setCellValue('L4', 'Team Name');
		$sheet->setCellValue('M4', 'Housing');
		$sheet->setCellValue('N4', 'Vehicle No');
		$sheet->setCellValue('O4', 'Vehicle Sequel No');
		$sheet->setCellValue('P4', 'Vehicle Ownership');
		$sheet->setCellValue('Q4', 'Vehicle Type');
		$sheet->setCellValue('R4', 'Vehicle Brand');
		$sheet->setCellValue('S4', 'Vehicle Model');
		$sheet->setCellValue('T4', 'Vehicle Year');
		$sheet->setCellValue('U4', 'Monthly Target');
		$sheet->setCellValue('V4', 'Status');
		$sheet->setCellValue('W4', 'Created At');
		$rows = 5;
		$count = 1;
		foreach ($rider_list as $item) {
			//print_r($val);exit();
			$sheet->setCellValue('A' . $rows, $count);
			$sheet->setCellValue('B' . $rows, $item['emp_no']);
			$sheet->setCellValue('C' . $rows, $item['full_name']);
			$sheet->setCellValue('D' . $rows, $item['iqama_no']);
			$sheet->setCellValue('E' . $rows, $item['nationality_name']);
			$sheet->setCellValue('F' . $rows, ' ' . $item['mobile']);
			$sheet->setCellValue('G' . $rows, ($item['request_date'] !== '' && $item['request_date'] !== '0000-00-00' && $item['request_date'] !== NULL) ? date('d-m-Y', strtotime($item['request_date'])) : 'NA');
			$sheet->setCellValue('H' . $rows, ($item['activate_date'] !== '' && $item['activate_date'] !== '0000-00-00' && $item['activate_date'] !== NULL) ? date('d-m-Y', strtotime($item['activate_date'])) : 'NA');
			$sheet->setCellValue('I' . $rows, ' ' . $item['id_number']);
			$sheet->setCellValue('J' . $rows, (isset($item['food_company'])) ? $item['food_company'] : 'NA');
			$sheet->setCellValue('K' . $rows, $item['id_type']);
			$sheet->setCellValue('L' . $rows, $item['team_name']);
			$sheet->setCellValue('M' . $rows, $item['camp_name']);
			$sheet->setCellValue('N' . $rows, ' ' . $item['vehicle_no']);
			$sheet->setCellValue('O' . $rows, ' ' . $item['sequel_no']);
			$sheet->setCellValue('P' . $rows, (isset($item['vehicle_ownership'])) ? $item['vehicle_ownership'] : 'NA');
			$sheet->setCellValue('Q' . $rows, ' ' . ucfirst($item['vehicle_type']));
			$sheet->setCellValue('R' . $rows, ' ' . $item['vehicle_brand']);
			$sheet->setCellValue('S' . $rows, ' ' . $item['vehicle_model']);
			$sheet->setCellValue('T' . $rows, ' ' . $item['vehicle_year']);
			$sheet->setCellValue('U' . $rows, $item['monthly_target']);
			$sheet->setCellValue('V' . $rows, ucfirst($item['rider_status']));
			$sheet->setCellValue('W' . $rows, (isset($item['created_at'])) ? date('d-m-Y', strtotime($item['created_at'])) : 'NA');
			$rows++;
			$count++;
		}
		$writer = new Xlsx($spreadsheet);

		try {
			$writer = new Xlsx($spreadsheet);
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}
		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
	}

	// Active Employee Export

	public function activeEmployeeExport()
	{
		// Check user permissions
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		ini_set('memory_limit', '-1');

		// Generate a filename with timestamp
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "employee-export-" . $date . ".xlsx";

		// Fetch employee list data
		$employee_lists = $this->Export_model->employee_salary_export();

		// Initialize PhpSpreadsheet
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Employee List")
			->setSubject("Baqala Station - Employee List")
			->setDescription("Baqala Station Employee List")
			->setKeywords("office 2007 openxml php")
			->setCategory("Employee List");

		// Set column widths and headers
		$sheet = $spreadsheet->getActiveSheet();
		$columns = range('A', 'BP'); // Adjust this as needed
		foreach ($columns as $column) {
			$sheet->getColumnDimension($column)->setAutoSize(true);
		}

		// Style the header row
		$headerStyle = [
			'font' => ['bold' => true],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'CBDBF7'],
			],
		];
		$sheet->getStyle('A1:BP1')->applyFromArray($headerStyle);

		// Set header titles
		$headers = [
			'SR No.',
			'Emp ID',
			'Employee Name',
			'Iqama No',
			'Joining Date',
			'Designation',
			'Department',
			'Aggregator Name',
			'Aggregator ID No.',
			'Payment Mode',
			'Bank Name',
			'Bank IBAN No',
			'Package',
			'Monthly Target',
			'Target Achieve',
			'Progress',
			'Total Working Days',
			'Loss of Pay Days',
			'Actual Payable Days',
			'Payable Date',
			'Opening Balance',
			'New Loan',
			'Deduction',
			'Balance Due',
			'Basic Salary',
			'Food Allowance',
			'Housing Allowance',
			'Transportation Allowance',
			'Other Allowance',
			'Salary Earned',
			'Adjustments (Commission)',
			'Hunger Adjustment',
			'Online Hours Incentive',
			'Reimbursements',
			'Target Based Commission',
			'Tips',
			'Wallet Cash',
			'Total Earnings',
			'GOSI Employee',
			'Total Contribution',
			'Acceptance Penalties',
			'Accident Claim Fee',
			'Aggregator Penalty',
			'Compliance Penalty',
			'Jahez Debit',
			'Adjustments',
			'Bike Spare Parts',
			'Carry Forward Salary',
			'Basic Paid',
			'Cash Advance',
			'Contact Penalties',
			'Days Deduction',
			'Declined Penalties',
			'Hunger Cash Shortage',
			'ID Suspension Penalty',
			'Jahez Cash Shortage',
			'License Deduction',
			'Medical Expenses',
			'Mobile Deduction',
			'Noon Cash Shortage',
			'Online Hours Incentive Deduction',
			'Personal Sim Card',
			'Target Based Deduction',
			'Traffic Violation',
			'Unpaid Leave',
			'Wallet Balance',
			'Total Deduction',
			'Net Pay'
		];

		$columnIndex = 0;
		foreach ($headers as $header) {
			$columnLetter = Coordinate::stringFromColumnIndex(++$columnIndex); // Convert column index to letter
			$sheet->setCellValue($columnLetter . '1', $header); // Set header in the first row
		}

		// Populate rows with data
		$rows = 2;
		$count = 1;
		foreach ($employee_lists as $report) {
			$sheet->setCellValue('A' . $rows, $count);
			$sheet->setCellValue('B' . $rows, $report['emp_no']);
			$sheet->setCellValue('C' . $rows, ucfirst($report['full_name']));
			$sheet->setCellValue('D' . $rows, ' ' . $report['iqama_no']);
			$sheet->setCellValue('E' . $rows, ($report['work_joining_date'] !== '' && $report['work_joining_date'] !== '0000-00-00') ? date('d-m-Y', strtotime($report['work_joining_date'])) : 'NA');
			$sheet->setCellValue('F' . $rows, ($report['designation_name']));
			$sheet->setCellValue('G' . $rows, ($report['department_name'] !== '') ? $report['department_name'] : 'NA');
			$sheet->setCellValue('H' . $rows, ($report['aggregator_name'] !== '') ? $report['aggregator_name'] : 'NA');
			$sheet->setCellValue('I' . $rows, ($report['aggregator_id'] !== '') ? ' ' . $report['aggregator_id'] : 'NA');
			$sheet->setCellValue('J' . $rows, ucfirst($report['payment_type']));

			$paymentTypeDetail = (isset($report['payment_type_detail'])) ? json_decode($report['payment_type_detail']) : '';
			if ($report['payment_type'] == 'Bank') {
				$bank_name = $paymentTypeDetail->bank_name;
				$iban_no = $paymentTypeDetail->iban_no;
			} else {
				$bank_name = 'NA';
				$iban_no = 'NA';
			}
			$sheet->setCellValue('K' . $rows, $bank_name);
			$sheet->setCellValue('L' . $rows, $iban_no);

			// Fill columns with '0'
			$sheet->setCellValue('M' . $rows, '0');
			$monthlyTargetOrders = (isset($report['aggregator_id']) && !empty($report['incentive_id'])) ? $report['monthly_target'] : 0;
			$sheet->setCellValue('N' . $rows, $monthlyTargetOrders);
			$sheet->setCellValue('O' . $rows, '0');
			$sheet->setCellValue('P' . $rows, '0');
			$sheet->setCellValue('Q' . $rows, '0');
			$sheet->setCellValue('R' . $rows, '0');
			$sheet->setCellValue('S' . $rows, '0');
			$sheet->setCellValue('T' . $rows, '0');
			$sheet->setCellValue('U' . $rows, '0');
			$sheet->setCellValue('V' . $rows, '0');
			$sheet->setCellValue('W' . $rows, '0');
			$sheet->setCellValue('X' . $rows, '0');
			$sheet->setCellValue('Y' . $rows, $report['basic_salary']);
			$sheet->setCellValue('Z' . $rows, $report['food_allowance']);
			$sheet->setCellValue('AA' . $rows, $report['housing_allowance']);
			$sheet->setCellValue('AB' . $rows, $report['transport_allowance']);
			$sheet->setCellValue('AC' . $rows, $report['other_allowance']);
			$sheet->setCellValue('AD' . $rows, $report['total_package']);
			$sheet->setCellValue('AE' . $rows, '0');
			$sheet->setCellValue('AF' . $rows, '0');
			$sheet->setCellValue('AG' . $rows, '0');
			$sheet->setCellValue('AH' . $rows, '0');
			$sheet->setCellValue('AI' . $rows, '0');
			$sheet->setCellValue('AJ' . $rows, '0');
			$sheet->setCellValue('AK' . $rows, '0');
			$sheet->setCellValue('AL' . $rows, '0');
			$sheet->setCellValue('AM' . $rows, '0');
			$sheet->setCellValue('AN' . $rows, '0');
			$sheet->setCellValue('AO' . $rows, '0');
			$sheet->setCellValue('AP' . $rows, '0');
			$sheet->setCellValue('AQ' . $rows, '0');
			$sheet->setCellValue('AR' . $rows, '0');
			$sheet->setCellValue('AS' . $rows, '0');
			$sheet->setCellValue('AT' . $rows, '0');
			$sheet->setCellValue('AU' . $rows, '0');
			$sheet->setCellValue('AV' . $rows, '0');
			$sheet->setCellValue('AW' . $rows, '0');
			$sheet->setCellValue('AX' . $rows, '0');
			$sheet->setCellValue('AY' . $rows, '0');
			$sheet->setCellValue('AZ' . $rows, '0');
			$sheet->setCellValue('BA' . $rows, '0');
			$sheet->setCellValue('BB' . $rows, '0');
			$sheet->setCellValue('BC' . $rows, '0');
			$sheet->setCellValue('BD' . $rows, '0');
			$sheet->setCellValue('BE' . $rows, '0');
			$sheet->setCellValue('BF' . $rows, '0');
			$sheet->setCellValue('BG' . $rows, '0');
			$sheet->setCellValue('BH' . $rows, '0');
			$sheet->setCellValue('BI' . $rows, '0');
			$sheet->setCellValue('BJ' . $rows, '0');
			$sheet->setCellValue('BK' . $rows, '0');
			$sheet->setCellValue('BL' . $rows, '0');
			$sheet->setCellValue('BM' . $rows, '0');
			$sheet->setCellValue('BN' . $rows, '0');
			$sheet->setCellValue('BO' . $rows, '0');
			$sheet->setCellValue('BP' . $rows, '0');

			$rows++;
			$count++;
		}

		// Output the Excel file
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//Export Payroll Detail
	public function payrollDetailExport($id)
	{
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$payroll_detail = $this->Export_model->getPayrollDetails($id);
		$payrollMonth = strtoupper(date('M Y', strtotime($payroll_detail[1]['payroll_month'])));
		$filename = "payroll-report-" . $payrollMonth . ".xlsx";

		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Payroll Report")
			->setSubject("Baqala Station - Payroll Report")
			->setDescription("Baqala Station Payroll Report")
			->setKeywords("office 2007 openxml php")
			->setCategory("Payroll Report");

		// Auto-size columns dynamically from A to AU (starting from A)
		foreach (range('A', 'AU') as $col) {
			$spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Apply header style
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
				'startColor' => ['argb' => 'FFFFFF'],
				'endColor' => ['argb' => 'FFFFFF'],
			],
		];
		$spreadsheet->getActiveSheet()->getStyle('A1:AU1')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A2:AU2')->applyFromArray($styleArray)
			->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('CBDBF7');

		// Header row
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:AU1');
		$sheet->setCellValue('A1', 'Payroll Report - ' . $payrollMonth);

		// Define the column labels (no SR No. column)
		$columns = [
			'A'  => 'Emp ID',
			'B'  => 'Employee Name',
			'C'  => 'Basic Salary',
			'D'  => 'Housing',
			'E'  => 'Transportation',
			'F'  => 'Food',
			'G'  => 'Other',
			'H'  => 'Salary Earned',
			'I'  => 'Adjustments (Earning)',
			'J'  => 'Hunger Adjustment',
			'K'  => 'Online Hours Incentive',
			'L'  => 'Reimbursements',
			'M'  => 'Target Based Commission',
			'N'  => 'Tips',
			'O'  => 'Wallet Cash',
			'P'  => 'Total Earnings',
			'Q'  => 'GOSI Employee',
			'R'  => 'Total Contribution',
			'S'  => 'Acceptance Penalties',
			'T'  => 'Accident Claim',
			'U'  => 'Aggregator Penalty',
			'V'  => 'Compliance Penalty',
			'W'  => 'Jahez Debit',
			'X'  => 'Bike Spare Parts',
			'Y'  => 'Carry Forward Salary',
			'Z'  => 'Basic Paid',
			'AA' => 'Cash Advance',
			'AB' => 'Contact Penalties',
			'AC' => 'Days Deduction',
			'AD' => 'Declined Penalties',
			'AE' => 'Hunger Cash Shortage',
			'AF' => 'ID Suspension Penalty',
			'AG' => 'Jahez Cash Shortage',
			'AH' => 'License Deduction',
			'AI' => 'Medical Expenses',
			'AJ' => 'Mobile Deduction',
			'AK' => 'Personal Sim Card',
			'AL' => 'Target Deduction',
			'AM' => 'Traffic Violation',
			'AN' => 'Unpaid Leave',
			'AO' => 'Wallet Balance',
			'AP' => 'Company Adjustment',
			'AQ' => 'Total Deductions',
			'AR' => 'Monthly Target',
			'AS' => 'Target Achieve',
			'AT' => 'Progress',
			'AU' => 'Net Salary',
		];

		// Insert the column headers dynamically
		$colIndex = 0;
		foreach ($columns as $column => $label) {
			$sheet->setCellValue($column . '2', $label);
		}

		// Insert data rows dynamically (starting from row 3)
		$rows = 3;
		foreach ($payroll_detail as $report) {
			// Loop through each column and set values dynamically
			foreach ($columns as $column => $label) {
				$key = strtolower(str_replace(' ', '_', $label)); // Convert label to key
				$value = isset($report[$key]) ? $report[$key] : '0';
				$sheet->setCellValue($column . $rows, $value);
			}

			$rows++;
		}

		// Generate and download the file
		$writer = new Xlsx($spreadsheet);
		try {
			$writer->save(FILE_PATH_UPLOAD . $filename);
			$content = file_get_contents(FILE_PATH_UPLOAD . $filename);
		} catch (Exception $e) {
			exit($e->getMessage());
		}

		header("Content-Disposition: attachment; filename=" . $filename);
		unlink(FILE_PATH_UPLOAD . $filename);
		exit($content);
	}

	public function hungerTeamExport($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		list($team, $team_member) = $this->Export_model->getHungerTeam($id);
		$date = date('d-m-y-His');
		$filename = "hunger-team-export-{$date}.xlsx";

		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Hunger Team")
			->setSubject("Baqala Station - Hunger Team")
			->setDescription("Baqala Station Hunger Team")
			->setKeywords("office 2007 openxml php")
			->setCategory("Hunger Team");

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Hunger Team');

		// Add main heading in the first row
		$sheet->mergeCells('A1:K1');
		$sheet->setCellValue('A1', 'Maha Alfala Trading Est. - Riyadh, SA');
		$sheet->getStyle('A1')->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'D9E1F2'],
			],
		]);

		// Add team subheading
		$sheet->mergeCells('A2:K2');
		$sheet->setCellValue('A2', 'Hunger Team List');
		$sheet->getStyle('A2')->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFEB9C'], // Yellow background
			],
		]);

		// Add team details
		$sheet->setCellValue('A3', 'Team:')
			->setCellValue('B3', $team->name);
		$sheet->setCellValue('A4', 'Team Leader:')
			->setCellValue('B4', $team->full_name);
		$sheet->setCellValue('A5', 'Team Leader Mobile:')
			->setCellValue('B5', $team->mobile);
		$sheet->setCellValue('A6', 'Total Members:')
			->setCellValue('B6', count(json_decode($team->team)));

		// Style for team details
		$sheet->getStyle('A3:A6')->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
		]);

		// Auto-size columns dynamically
		$columns = range('A', 'K');
		foreach ($columns as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Table Header Styling
		$headerStyle = [
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFD966'], // Light orange background
			],
		];

		// Add table headers
		$sheet->setCellValue('A8', 'Sr. No')
			->setCellValue('B8', 'Emp No.')
			->setCellValue('C8', 'Employee Name')
			->setCellValue('D8', 'Iqama Number')
			->setCellValue('E8', 'Iqama Expiry')
			->setCellValue('F8', 'Mobile No')
			->setCellValue('G8', 'Platform ID')
			->setCellValue('H8', 'Platform')
			->setCellValue('I8', 'ID Type')
			->setCellValue('J8', 'Vehicle No')
			->setCellValue('K8', 'Status');
		$sheet->getStyle('A8:K8')->applyFromArray($headerStyle);

		// Populate data
		$row = 9;
		foreach ($team_member as $index => $member) {
			$data = [
				$index + 1,
				$member->emp_no,
				$member->full_name,
				$member->iqama_no,
				date('d-m-Y', strtotime($member->iqama_expiry_date)),
				' ' . $member->mobile,
				' ' . $member->hunger_id,
				$member->company_name,
				$member->id_type,
				$member->vehicle_no,
				$member->rider_status,
			];
			$sheet->fromArray($data, NULL, "A{$row}");
			$row++;
		}

		// Output File
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename={$filename}");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	//Export Aggregator Detail

	public function aggregatorDetailExport()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'logistic_ids', $this->action)) {
			redirect('admin/dashboard');
		}
		ini_set('memory_limit', '-1');
		$date = date('d-m-y-' . substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$aggregator_detail = $this->Export_model->exportAggregatorDetail();
		$filename = "aggreagtor-list-" . $date . ".xlsx";
		//dd($aggregator_detail);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Baqala Station")
			->setLastModifiedBy("Admin")
			->setTitle("Baqala Station - Aggregator List")
			->setSubject("Baqala Station - Aggregator List")
			->setDescription("Baqala Station - Aggregator List")
			->setKeywords("office 2007 openxml php")
			->setCategory("Aggregator List");

		// Auto-size columns dynamically from A to AG (starting from A)
		foreach (range('A', 'P') as $col) {
			$spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Apply header style
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
				'startColor' => ['argb' => 'FFFFFF'],
				'endColor' => ['argb' => 'FFFFFF'],
			],
		];
		$spreadsheet->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A2:P2')->applyFromArray($styleArray)
			->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setARGB('CBDBF7');

		// Header row
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->mergeCells('A1:P1');
		$sheet->setCellValue('A1', 'Aggregator List');

		// Table Header Styling
		$headerStyle = [
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFD966'], // Light orange background
			],
		];

		// Add table headers
		$sheet->setCellValue('A2', 'Sr. No')
			->setCellValue('B2', 'Owner Emp No.')
			->setCellValue('C2', 'Owner Employee Name')
			->setCellValue('D2', 'Iqama ID Number')
			->setCellValue('E2', 'Owner Flex No')
			->setCellValue('F2', 'Aggregator')
			->setCellValue('G2', 'Aggregator ID')
			->setCellValue('H2', 'Activation Date')
			->setCellValue('I2', 'Alloted To')
			->setCellValue('J2', 'Vehicle Type')
			->setCellValue('K2', 'Vehicle No')
			->setCellValue('L2', 'Opeartion Card No')
			->setCellValue('M2', 'Opeartion Card Issue Expiry')
			->setCellValue('N2', 'Opeartion Card Expiry Date')
			->setCellValue('O2', 'Sponsor ID')
			->setCellValue('P2', 'Status');
		$sheet->getStyle('A2:P2')->applyFromArray($headerStyle);

		// Populate data
		$row = 3;
		foreach ($aggregator_detail as $index => $member) {
			$data = [
				$index + 1,
				$member->emp_no,
				ucfirst($member->full_name),
				' ' . $member->iqama_no,
				($member->owner_flex_no == '') ? 'NA' : $member->owner_flex_no,
				$member->food_company,
				' ' . $member->id_number,
				($member->activation_date !== '' && $member->activation_date !== '0000-00-00') ? date('d-m-Y', strtotime($member->activation_date)) : 'NA',
				$member->alloted_to_emp_no . ' - ' . $member->alloted_to_name,
				ucfirst($member->alloted_vehicle_type),
				$member->alloted_vehicle_no,
				$member->operation_card_no,
				(isset($member->operation_card_issue_date) && $member->operation_card_issue_date !== '0000-00-00') ? date('d-m-Y', strtotime($member->operation_card_issue_date)) : 'NA',
				(isset($member->operation_card_issue_date) && $member->operation_card_issue_date !== '0000-00-00') ? date('d-m-Y', strtotime($member->operation_card_issue_date)) : 'NA',
				$member->sponsor_id . ' - ' . $member->sponsor_name,
				ucfirst($member->status),
			];
			$sheet->fromArray($data, NULL, "A{$row}");
			$row++;
		}

		// Output File
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename={$filename}");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	//Export Attendance Report

	public function riderAttendanceExport() {
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Fetch form inputs
		$rider_id = $this->input->post('emp_id') ?? FALSE;
		$month_of = $this->input->post('month', TRUE) ?? 'Jan 2025';
		$team_id = $this->input->post('team') ? $this->input->post('team') : FALSE;
	
		// Decode and validate the month
		$month_of = urldecode($month_of);
	
		// Fetch data
		$data['reports'] = $this->Export_model->monthly_attendance_report($month_of, $rider_id, $team_id);
		$filename = "Attendance-report-" . $month_of . ".xlsx";
		$search_team_name = !empty($data['reports']) ? $data['reports'][0]->team_name : null;
		//dd($data['reports']);
		// Initialize Spreadsheet
		$spreadsheet = new Spreadsheet();
	
		// Set document properties
		$spreadsheet->getProperties()
			->setCreator("Maha Al Fala")
			->setLastModifiedBy("Maha Al Fala")
			->setTitle("Monthly Attendance Report")
			->setSubject("Monthly Attendance Report")
			->setDescription("Monthly attendance data export.")
			->setKeywords("attendance excel report")
			->setCategory("Exported File");
	
		// Set the sheet
		$sheet = $spreadsheet->setActiveSheetIndex(0);
	
		// Merge the first row for the company name and report title
		$sheet->mergeCells('A1:H1'); // Company name and report title in one row
		$sheet->setCellValue('A1', 'Maha Alfala Trading Est., Riyadh, SA (VAT No: 310024077600003)');

		// Merge the second row for location and month
		$sheet->mergeCells('A2:H2'); // Location and month
		$sheet->setCellValue('A2', 'Monthly Attendance Report Days Wise');

		// Merge the third row for VAT information
		$sheet->mergeCells('A3:H3'); // VAT number
		$sheet->setCellValue('A3', 'Month of: ' . $month_of . ' | Team : '. (($search_team_name) ? $search_team_name : 'ALL'));

		// Apply left alignment for all merged cells
		$headerStyle = [
			'font' => ['bold' => true, 'size' => 12],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
		];
		$sheet->getStyle('A1:H3')->applyFromArray($headerStyle);

		// Add a blank row for spacing
		$sheet->setCellValue('A4', '');
	
		// Set table headers starting from row 5
		$sheet->setCellValue('A5', 'S.No')
			->setCellValue('B5', 'Emp ID')
			->setCellValue('C5', 'Employee Name');
	
		// Dynamic days for the month
		$date = DateTime::createFromFormat('M Y', $month_of);
		if (!$date) {
			throw new Exception("Invalid month format");
		}
		$num_days = (int)$date->format('t');
		$start_date = $date->format('Y-m-01');
	
		// Add dynamic day headers (e.g., Thu 01, Fri 02)
		$col = 'D';
		for ($i = 1; $i <= $num_days; $i++) {
			$dayName = DateTime::createFromFormat('Y-m-d', $start_date)->setDate(
				(int)$date->format('Y'),
				(int)$date->format('m'),
				$i
			)->format('D d');
			$sheet->setCellValue($col . '5', $dayName);
			$col++;
		}
	
		// Add headers for totals
		$sheet->setCellValue($col . '5', 'Absent Days');
		$sheet->setCellValue(++$col . '5', 'Present Days');
	
		// Style the table headers
		$tableHeaderStyle = [
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFD966'],
			],
		];
		$sheet->getStyle('A5:' . $col . '5')->applyFromArray($tableHeaderStyle);
	
		// Populate data rows
		$row = 6;
		$sno = 1;
	
		foreach ($data['reports'] as $record) {
			// Populate basic details
			$sheet->setCellValue('A' . $row, $sno++)
				->setCellValue('B' . $row, $record->emp_no)
				->setCellValue('C' . $row, strtoupper($record->employee_name));
	
			// Populate attendance data dynamically
			$col = 'D';
			foreach ($record->attendance as $day_status) {
				$sheet->setCellValue($col . $row, $day_status); // P/A
				$col++;
			}
	
			// Add total absent and present days
			$sheet->setCellValue($col . $row, $record->total_absent);
			$sheet->setCellValue(++$col . $row, $record->total_present);
			$row++;
		}
	
		// Auto-size columns
		foreach (range('A', $col) as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}
	
		// Output the file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename={$filename}");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	//Export Food Allowance Detail
	public function export_food_allowance_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$batch_no = $this->input->get('batch_no');
		$query = $this->Export_model->get_food_allowance($batch_no);

		if (count($query) > 0) {
			$data['batch_detail'] = $query;
			$data['batch_list'] = [
				'batch_no' => $data['batch_detail'][0]['batch_no'],
				'arrival_date' => $data['batch_detail'][0]['arrival_date'],
				'total_cvs' => count($query)
			];

			$filename = 'food-allowance-' . $data['batch_detail'][0]['batch_no'] . '.xlsx';
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Set document properties
			$spreadsheet->getProperties()
				->setCreator("Maha Al Fala")
				->setLastModifiedBy("Maha Al Fala")
				->setTitle("Food Allowance Report")
				->setSubject("Food Allowance Report")
				->setDescription("Food allowance data export.")
				->setKeywords("Food allowance excel report")
				->setCategory("Exported File");

			// Title Row
			$sheet->setCellValue('A1', 'FOOD ALLOWANCE DISTRIBUTION LIST');
			$sheet->mergeCells('A1:P1');
			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			// Batch details
			$sheet->setCellValue('A3', 'Batch No:');
			$sheet->setCellValue('B3', $data['batch_list']['batch_no']);
			$sheet->setCellValue('A4', 'Arrival Date:');
			$sheet->setCellValue('B4', date('d-m-Y', strtotime($data['batch_list']['arrival_date'])));
			$sheet->setCellValue('A5', 'Total CVs:');
			$sheet->setCellValue('B5', $data['batch_list']['total_cvs']);

			// Styling Batch Details
			$sheet->getStyle('A3:A5')->getFont()->setBold(true);
			$sheet->getStyle('A3:A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

			// Leave a blank row
			$row = 7;

			// Column Headers
			$headers = [
				'#',
				'CV No.',
				'Country',
				'H. Type',
				'Aggregator',
				'Pos. Applied for',
				'Full Name',
				'Passport No',
				'Salary Package',
				'Food Allowance',
				'1st Payment Date',
				'1st Payment Amount',
				'2nd Payment Date',
				'2nd Payment Amount',
				'3rd Payment Date',
				'3rd Payment Amount',
				'Total Payment'
			];

			$sheet->fromArray([$headers], NULL, 'A' . $row);

			// Style Headers
			$headerStyle = [
				'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
				'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '000000']],
				'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
			];

			$sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($headerStyle);

			// Start Data Rows
			$row++;
			$count = 1;
			$total_first_payment = 0;
			$total_second_payment = 0;
			$total_third_payment = 0;
			$grand_total_payment = 0;

			foreach ($data['batch_detail'] as $value) {
				$first_payment = isset($value['first_payment']) ? json_decode($value['first_payment'])->payment_amt : 0;
				$second_payment = isset($value['second_payment']) ? json_decode($value['second_payment'])->payment_amt : 0;
				$third_payment = isset($value['third_payment']) ? json_decode($value['third_payment'])->payment_amt : 0;
				$total_payment = $first_payment + $second_payment + $third_payment;

				$total_first_payment += $first_payment;
				$total_second_payment += $second_payment;
				$total_third_payment += $third_payment;
				$grand_total_payment += $total_payment;

				$sheet->fromArray([
					$count++,
					$value['cv_no'],
					$value['country_name'],
					$value['hiring_type'],
					$value['project_name'],
					$value['applied_for_job'],
					implode(' ', array_filter([$value['first_name'], $value['middle_name'], $value['third_name'], $value['surname']])),
					$value['passport_no'],
					$value['salary_package'],
					$value['food_allowance'],
					isset($value['first_payment']) ? date('d-m-Y', strtotime(json_decode($value['first_payment'])->payment_date)) : '-',
					$first_payment,
					isset($value['second_payment']) ? date('d-m-Y', strtotime(json_decode($value['second_payment'])->payment_date)) : '-',
					$second_payment,
					isset($value['third_payment']) ? date('d-m-Y', strtotime(json_decode($value['third_payment'])->payment_date)) : '-',
					$third_payment,
					$total_payment
				], NULL, 'A' . $row);
				$row++;
			}

			// Add total row
			$sheet->fromArray([
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'Total:',
				'',
				'',
				'',
				$total_first_payment,
				'',
				$total_second_payment,
				'',
				$total_third_payment,
				$grand_total_payment
			], NULL, 'A' . $row);

			// Style Total Row
			$totalRowStyle = [
				'font' => ['bold' => true, 'color' => ['rgb' => '000000']], // Black bold text
				'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']], // Light Gray background
				'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]
			];

			$sheet->getStyle('G' . $row . ':Q' . $row)->getFont()->setBold(true);
			$sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($totalRowStyle);

			// Generate Excel file
			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			$writer->save('php://output');
			exit;
		} else {
			$this->session->set_userdata('info', "2--Food allowance detail not found!");
			redirect('admin/hr/food-allowance/index');
		}
	}
}
