<?php
require_once(dirname(__FILE__).'/tcpdf/tcpdf.php');
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
//		// Logo
//		$image_file = dirname(Yii::app()->request->scriptFile).'/themes/isoft/images/logo.png';
//		$this->Image($image_file, 
//			1, 0.5, 4, '', 
//			'PNG', 'JPG', 'T', false, 300, '', false, false, 0, false, false, false);
//		// Title
//		//$this->SetFont('helvetica', 'B', 16);
//		//$this->Cell(8,1, Yii::app()->params['companyName'], 1, false, 'C', 0, '', 0, false, 'T', 'M');
//
//		$this->SetFont('helvetica', 'I', 8);
//		$this->Cell(0,0, Yii::app()->params['companyAddress'] , 0, 2, 'R', 0, '', 0, false, 'T', 'M');
//		$this->Cell(0,0, Yii::app()->params['companyAddress2'] , 0, 2, 'R', 0, '', 0, false, 'T', 'M');
//		$this->Cell(0,0, 'Tel ' . Yii::app()->params['companyTel'] , 0, 2, 'R', 0, '', 0, false, 'T', 'M');
//		$this->Cell(0,0, 'Fax ' . Yii::app()->params['companyFax'] , 0, 2, 'R', 0, '', 0, false, 'T', 'M');
//		$this->Cell(0,0, 'Email ' . Yii::app()->params['companyEmail'] , 0, 2, 'R', 0, '', 0, false, 'T', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
//		$this->SetY(-1);
//		// Set font
//		$this->SetFont('helvetica', 'I', 8);
//		// Page number
//		$this->Cell(0, 1, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', false, 'C', 0, '', 0, false, 'T', 'M');
		
	}

}?>