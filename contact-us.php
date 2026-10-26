<?php 

include("includes/connection.php"); 


$url_arr=pageurl();

$page_seo=pageSEO();

$home=Translatetext();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['contact_us']['metatitle']?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['contact_us']['metakeywords']?>" />
<meta name="description" content="<?php echo $page_seo['contact_us']['metadescription']; ?>"  />
<?php if(trim($page_seo['contact_us']['moretags'])!=""){ echo $page_seo['contact_us']['moretags']; }?>

<?php include('css.php'); ?>

</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
<div class="contact_banner">
	<iframe src="https://www.google.com/maps/<?php echo $home['contact_us']['map_code'] ?>" frameborder="0" style="border:0;width:100%;height:330px;"></iframe>	
</div>
<!-- //banner -->

<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- contact us form program starts-->
<?php
if(isset($_POST['email_id'])) {
 
    
    $email_to = $home['contact_us']['email_id'];
    $email_subject = "Contact Form Details";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email_id']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['message'])){
      
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $name = $_POST['name']; // required
    $email_from = $_POST['email_id']; // required
    $contact_no = $_POST['phone']; // not required
    $message = $_POST['message']; // required
 
    $error_message = "";
 /*   $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';*/
 
 /* if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }*/
 
    /*$string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$fullname)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }*/
 

 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Contact No.: ".clean_string($contact_no)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

 

 $msg = "Thank you for contacting us. We will be in touch with you very soon.";
  
  


  
}
 
?>


<!-- contact us form program ends-->

<!-- Contact Us section starts -->
<section class="contact_us" style="margin:40px 0">
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-12 mx-auto d-flex justify-content-center align-items-center flex-column">
                <h1><?php echo $home['contact_us']['heading']?></h1>
                 <?php echo $home['contact_us']['description']?>
            </div>
        </div>
        
            <div class="col-md-11 col-12 mx-auto" style="padding-top: 40px;">
            <div class="row">
            <div class="col-md-6 col-12 mx-auto contact_us_right">
            <?php echo $home['contact_us']['address']; ?>
            </div>
             <div class="col-md-6 col-12 mx-auto">
            
      
       
       
     
    

                 <h1><?php echo $home['contact_us']['form_heading']; ?></h1>
                  <?php print $msg; ?>
  <form name="contactform" action="" method="post">
  <div class="mb-3">
   
    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
    
  </div>
  <div class="mb-3">
  
    <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email Address" required>
  </div>
<div class="mb-3">
  
    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" required>
  </div>
  <div class="mb-3">
  
  <textarea class="form-control" rows="5" name="message" id="message"  placeholder="Message" required></textarea>
  </div>
   <div class="g-recaptcha" data-sitekey="6Ldl89sZAAAAAPAdbw6TkiX7ZEMRIVJplqNFlGP2" data-secretkey="6Ldl89sZAAAAAPbWp-uk2j3g8xXrdfLO_Ut7wmEb"></div>
 
  <button type="submit" class="btn btn-primary btn-block" name="send-message" id="send-message">Send</button>
</form>

             </div>
             </div>
             </div>
        
    </div>


</section>
<!-- Contact Us section ends -->


<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
<script src='https://www.google.com/recaptcha/api.js'></script> 		
</body>
</html>