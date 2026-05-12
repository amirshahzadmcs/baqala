<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load TCPDF base
require_once(APPPATH . 'libraries/Pdf.php');

// Load FPDI dependencies
require_once(APPPATH . 'libraries/fpdi/src/autoload.php'); // or manually load classes if no autoloader

use setasign\Fpdi\Tcpdf\Fpdi;

class PdfFpdi extends Fpdi
{
	public $footer_title = '';
    public function __construct()
    {
        parent::__construct();
    }

	public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 9);

        // Footer content: Left (title), Right (page number)
        //$this->Cell(0, 5, $this->footer_title, 0, 0, 'L'); // Title on the left
        //$this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R'); // Page number on right
    }
}
