<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_employee_contract extends TCPDF
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

    public function setWatermark($text = 'APPROVAL PENDING') {
        $this->show_watermark = true;
        $this->watermark_text = $text;
    }

	public function Header()
	{
		if ($this->show_watermark) {
			$this->SetAlpha(0.2); // Transparency

			$this->SetFont('helvetica', 'B', 50);
			$this->SetTextColor(150, 150, 150);

			// Get page dimensions
			$pageWidth = $this->getPageWidth();
			$pageHeight = $this->getPageHeight();

			// Center position (adjust Y slightly for vertical alignment)
			$x = $pageWidth / 2;
			$y = $pageHeight / 2;

			$this->StartTransform();
			$this->Rotate(50, $x, $y);
			$this->Text($x - 100, $y - 20, $this->watermark_text);
			$this->StopTransform();

			$this->SetAlpha(1); // Reset transparency
		}
		//$img_file = K_PATH_IMAGES.'header.jpg';
		//$this->Image('@'.file_get_contents($img_file),8,5,0,15.5);
		$this->writeHTMLCell(
            $w = 0, $h = 0, $x = '4', $y = '0',
            $this->htmlHeader, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'top', $autopadding = true);
			$this->SetTopMargin(10);
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	}
	
    // Page footer
    public function Footer() {
		// Set position 10mm from bottom
		$this->SetY(-10);

		// Set font
		$this->SetFont('helvetica', '', 8); // Adjust font as needed

        // ✅ Set font color (R, G, B) — change as needed
        $this->SetTextColor(100, 100, 100); // Example: gray

		// Left side: Page number
		$pageText = $this->getAliasNumPage() . ' | Page';

		// Right side: 2nd Party Initials with line
		$initialsText = '2nd Party Initials';
		$lineLength = 30; // Adjust as needed

		// Get page width
		$pageWidth = $this->getPageWidth();

		// Calculate positions
		$margin = 10;
		$leftX = $margin;
		$rightX = $pageWidth - $margin - $lineLength;

		// Output page number on the left
		$this->SetXY($leftX, -10);
		$this->Cell(50, 5, $pageText, 0, 0, 'L');

		// Output initials text and line on the right
		$this->SetXY($rightX - 35, -10); // Move to the left of the line
		$this->Cell(35, 5, $initialsText, 0, 0, 'R');

		// Draw line
		$this->Line($rightX, $this->GetY() + 4.5, $rightX + $lineLength, $this->GetY() + 4.5);
	}

}
