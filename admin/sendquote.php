<?php
ob_start();
include("../includes/connection.php");
include("../class.Email.php");
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
	$html2pdf->Output('quote/quote_'.$sessionid.'.pdf','F');
	
	
	/* SEND EMAIL */

$query  = db_query("SELECT * FROM `requestquote` WHERE sessionid='".$sessionid."' AND quantity !='0' "); 
while($row = mysqli_fetch_array($query)){
	$name 	= $row['name'];
	$email 	= $row['email'];
}

$message = $content;
//print $message;

$subject = "Quote Request from Intransit Technologies";		
				
$Sender 	= 	ADMINEMAIL;				
$Recipiant	= 	$email;
$Cc 		= 	"";
$Bcc		=	"";	
$msg 		= 	new Email($Recipiant, $Sender, $subject); 
$msg->Bcc 	= 	$Bcc;
$msg->Cc 	= 	$Cc;		
$htmlVersion=	"$message";
//$msg->Attach = SITEURL.'/admin/quote/quote_'.$sessionid.'.pdf';
$msg->TextOnly= false;
$msg->Content = $htmlVersion;		
//** send the email message.	
$SendSuccess = $msg->Send();


$msg = "Quote details sent successfully.";

//print $msg;

setcookie("msg", $msg, time() + 3);
print "<script>";
print "self.location = 'view_request_quote.php';";
print "</script>";
exit;



	
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}

?>