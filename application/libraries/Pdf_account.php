<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_account extends TCPDF
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
	
	public function Header()
	{
		if ($this->page == 1) {
            $this->writeHTMLCell(
            $w = 0, $h = 0, $x = '4', $y = '0',
            $this->htmlHeader, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'top', $autopadding = true);
			$this->SetTopMargin(15);
        } else {
			//$this->SetFont('aealarabiya', 'I', 8);
            $this->writeHTMLCell(
            $w = 0, $h = 0, $x = '4', $y = '0',
            $this->htmlHeader2, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'top', $autopadding = true);
			$this->SetTopMargin(15);
			
        }
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
