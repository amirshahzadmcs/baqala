<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_salary_structure extends TCPDF
{
	function __construct() { parent::__construct(); }
	protected $last_page_flag = false;

	public function Close() {
		$this->last_page_flag = true;
		parent::Close();
	}
	var $htmlFooter;
	public function setHtmlFooter($htmlFooter) {
        $this->htmlFooter = $htmlFooter;
    }
	
	//Page header
	var $htmlHeader;
	var $htmlHeader2;
    public function setHtmlHeader($htmlHeader) {
        $this->htmlHeader = $htmlHeader;
    }
	public function setHtmlHeader2($htmlHeader2) {
        $this->htmlHeader2 = $htmlHeader2;
    }

	// Watermark functionality
    protected $show_watermark = false;
    protected $watermark_text = 'APPROVAL PENDING';
    protected $watermark_image = null;
	public $showBackground = false;

    public function setWatermark($imagePath) {
        if (file_exists($imagePath)) {
            $this->watermark_image = $imagePath;
            $this->show_watermark = true; // ✅ Enable watermark display
        } else {
            error_log("Watermark image NOT FOUND: " . $imagePath);
        }
    }

	
	public function Header()
	{
		//$img_file = K_PATH_IMAGES.'header.jpg';
		//$this->Image('@'.file_get_contents($img_file),8,5,0,15.5);
		// Draw watermark if enabled
		if ($this->showBackground) {
			$width = $this->getPageWidth();
			$height = $this->getPageHeight();

			// Use file system path instead of base_url
			$img_file = FCPATH . 'admin_assets/images/pdf-bg.png';

			if (file_exists($img_file)) {
				$this->Image($img_file, 0, 0, $width, $height + 2, '', '', '', false, 300, '', false, false, 0);
			} else {
				error_log("PDF background image NOT FOUND at: " . $img_file);
			}
		}


        if ($this->show_watermark) {
			// Set transparency
            $this->SetAlpha(1);
            
            // Get page dimensions
            $pageWidth = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();

            // Add watermark image centered
            $this->Image(
                $this->watermark_image,
                ($pageWidth - 180),  // x position (adjust based on image size)
                ($pageHeight - 50), // y position
                50,                     // width in mm (adjust as needed)
                0,                       // height (auto-scale)
                '', '', '', false, 300, '', false, false, 0
            );

            $this->SetAlpha(1); // Reset transparency
		}
		if ($this->page == 1) {
		    $this->SetFont('aealarabiya', 'I', 8);
            $this->writeHTMLCell(
            $w = 0, $h = 0, $x = '4', $y = '0',
            $this->htmlHeader, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'top', $autopadding = true);
			$this->SetTopMargin(28);
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        } else {
			$this->SetFont('aealarabiya', 'I', 8);
            $this->writeHTMLCell(
            $w = 0, $h = 0, $x = '4', $y = '0',
            $this->htmlHeader2, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'top', $autopadding = true);
			$this->SetTopMargin(28);
			//$this->SetMargins(1, 60, 4, true);
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			
        }
		
		/*
		$this->SetFont('helvetica','B',20);
		$this->Cell(80);
		$this->Cell(0,0, '','',0,'R');
		$this->Ln(8);
		$this->SetFont('helvetica','',10);
		$this->Cell(0,0, '','',0,'R');
		$this->Ln(10);
		*/
	}
	
    // Page footer
    public function Footer() {
		if($this->last_page_flag){
			$last_footer = $this->htmlFooter;
			$this->writeHTMLCell(
            $w = 0, $h = 0, $x = '4', $y = '-30',
            $last_footer, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'bottom', $autopadding = true);
			//$this->writeHTML($last_footer, false, true, false, true);
		}
       // margini del footer
		$this->SetY(-10);
		// Set font
        $this->SetFont('aealarabiya', 'I', 8);
		// Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
    }
}
