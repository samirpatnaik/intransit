<?php
ob_start();
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;

$sessionid =  $connect->real_escape_string(trim($_GET['id']));
	
include('pdfquote.php');
$content = ob_get_clean();

// convert in PDF
require_once('html2pdf/html2pdf.class.php');
//require_once('html2pdf/src/Html2Pdf.php');
try
{
	$html2pdf = new HTML2PDF('L', 'A4', 'en');
//  $html2pdf->setModeDebug();
	$html2pdf->setDefaultFont('helvetica');
	$html2pdf->writeHTML($content);
	$html2pdf->Output('quote_'.$sessionid.'.pdf','D');
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>