<?php 
include("includes/connection.php"); 
include("includes/recaptchalib.php");
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
$aboutactive = "class='active'";

$response = null;
$secret = "6Ldl89sZAAAAAPbWp-uk2j3g8xXrdfLO_Ut7wmEb";
$reCaptcha = new ReCaptcha($secret);

$stage 	=  $connect->real_escape_string(trim($_POST['stage']));

if($stage==2){
$response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);
	if ($response != null && $response->success){
		
		$fname		= $connect->real_escape_string(trim($_POST['fname']));
		$lname		= $connect->real_escape_string(trim($_POST['lname']));
		$email		= $connect->real_escape_string(trim($_POST['email']));
		$company	= $connect->real_escape_string(trim($_POST['company']));
		$phone		= $connect->real_escape_string(trim($_POST['phone']));
		$interested	= $connect->real_escape_string(trim($_POST['interested']));
		$message	= $connect->real_escape_string(trim($_POST['message']));
		$date		= date("Y-m-d H:m:s");
		db_query("INSERT INTO  `excess_inventary` set  
								date	=	'".$date."',
								fname	=	'".$fname."',
								lname	=	'".$lname."',
								email	=	'".$email."',
								company	=	'".$company."',
								phone	=	'".$phone."',
								interested	='".$interested."',
								message	=	'".$message."'");
								
		
		
		$msg = "Request Sent Successfully.";
		setcookie("msg", $msg, time() + 3);
		print "<script>";
		print "window.location='?success';";
		print "</script>";
		exit;
		
	}else{
		$msg = "Pleae check captcha Error!";
		setcookie("msg", $msg, time() + 3);
		print "<script>";
		print "window.location='?error';";
		print "</script>";
		exit;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['sell-excess-inventary']['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['sell-excess-inventary']['metakeywords']; ?>" />
<meta name="description" content="<?php echo $page_seo['sell-excess-inventary']['metadescription']; ?>"  />
<?php if(trim($page_seo['sell-excess-inventary']['moretags'])!=""){ echo $page_seo['excess-inventary']['moretags']; }?>
<?php include('css.php'); ?>
</head>
<body>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
  <?php 
        $sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='inventarybanner'");

        $numrow = mysqli_num_rows($sql);

        if($numrow==0){

        $sql = db_query("select * from mng_inner_banner where language='en' and page='inventarybanner'");

        }

        $res = mysqli_fetch_array($sql);

        ?>
<div class="inner-banner" style="background:url(banner/<?php echo $res['image']; ?>) no-repeat;">
    <div class="about-banner_text">
        <div class="container clearfix text-center">
            <?php

            if($numrow==0){

              echo googleTranslatetext(str_replace('../',SITEURL,$res['description']),$_SESSION['lan']); 
         }else{

              echo str_replace('../',SITEURL,$res['description']);
          
         }
         ?>
        </div>
    </div>  
</div>

<!-- //banner -->

<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- sell excess inventory section starts -->
<section class="sell_excess_inventory" style="margin-top:30px;">
<div class="container">
<div class="row ">
<div class="col-md-9 col-12 mx-auto">
<img  src="upload_page_images/<?php echo $home['sell-excess-inventary']['image']; ?>" alt="<?php echo $home['sell-excess-inventary']['alt_txt']?>" title="<?php echo $home['sell-excess-inventary']['title_txt'] ?>" class="img-fluid">
<h1 style="font-size: 30px;padding-top: 20px;"><?php echo $home['sell-excess-inventary']['heading']; ?></h1>
<?php echo $home['sell-excess-inventary']['description']?>
</div> 
</div>

<?php if (@$_COOKIE['msg']) { ?>
<div class="row" style="padding:30px 0 0 0;">
<div class="col-md-9 col-12 mx-auto text-center">
<div class="alert alert-success">
<a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
<?php print $_COOKIE['msg']; ?>
</div>
</div>
</div>
<?php } ?>

<div class="col-md-9 col-12 mx-auto text-center request_quote">
<form action="" method="POST" autocomplete="off">
<input type="hidden" value="2" name="stage">
 <h2 style="padding:60px 0 20px 0;">Contact Us</h2>
 <div class="row">
	  <div class="col-md-6 col-12 mx-auto mb-3">
		 <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
	  </div>
	  <div class="col-md-6 col-12 mx-auto mb-3">
		 <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" >
	  </div>
	  <div class="col-md-6 col-12 mx-auto mb-3">
		 <input type="email" class="form-control" id="emial" name="email" placeholder="Email" required>
	  </div>
	  <div class="col-md-6 col-12 mx-auto  mb-3">
		 <input type="text" class="form-control" id="company" name="company"  placeholder="Company Name" >
	  </div>
	  <div class="col-md-6 col-12 mx-auto  mb-3">
		 <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" >
	  </div>
	  
	  <div class="col-md-6 col-12 mx-auto  mb-3">
		 <select name="interested">
			<option value="">Interested In</option>
			<?php
			$query  = db_query("SELECT * FROM `interestedin` order by id "); 
			while($irow = mysqli_fetch_array($query)){
			?>
			<option value="<?php print $irow['text'];?>"><?php print $irow['text'];?></option>
			<?php } ?>
		 </select>
	  </div>

	  <div class="col-md-12 col-12 mx-auto  mb-3">
		<textarea class="form-control" rows="5" id="message" name="message" placeholder="Message" required></textarea>
	  </div>
	   <div class="col-md-6 col-12 mx-auto">
		 <div class="g-recaptcha" data-sitekey="6Ldl89sZAAAAAPAdbw6TkiX7ZEMRIVJplqNFlGP2" data-secretkey="6Ldl89sZAAAAAPbWp-uk2j3g8xXrdfLO_Ut7wmEb"></div>
	   </div>
		<div class="col-md-6 col-12 mx-auto">
<button type="submit" class="btn btn_send">Submit Request</button>
</div>
</div>
</form>	
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

</section>
<!-- sell excess inventory section ends -->

<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
</body>
</html>