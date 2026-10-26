<?php 
include("includes/connection.php"); 
include("includes/recaptchalib.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
$sessionid = session_id();
$response = null;
$secret = "6Lfe8MAZAAAAAElduz_v8r3lQj5t1B6C1PG6l-fF";
$reCaptcha = new ReCaptcha($secret);

$stage 	=  $connect->real_escape_string(trim($_POST['stage']));

if($stage==2){
$response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);
if ($response != null && $response->success){
	$name 	= $connect->real_escape_string(trim($_POST['name']));
	$email 	= $connect->real_escape_string(trim($_POST['email']));
	$phone 	= $connect->real_escape_string(trim($_POST['phone']));
	$cname 	= $connect->real_escape_string(trim($_POST['companyname']));
	$ctype 	= $connect->real_escape_string(trim($_POST['companytype']));
	$fax 	= $connect->real_escape_string(trim($_POST['fax']));
	$message =$connect->real_escape_string(trim($_POST['message']));

	$pid	= $_POST['pid'];
	$part	= $_POST['part'];
	$manu	= $_POST['manu'];
	$qty	= $_POST['qty'];
	$price	= $_POST['price'];
	
	$date	= date("Y-m-d H:m:s");
	
	foreach($part as $i => $n ) {
		db_query("INSERT INTO `requestquote` set date='".$date."', sessionid='".$sessionid."', pid='".$pid[$i]."', partnumber='".$n."', manufacturer='".$manu[$i]."', quantity='".$qty[$i]."', price='".$price[$i]."', name='".$name."', email='".$email."', phone='".$phone."', cname='".$cname."', ctype='".$ctype."', fax='".$fax."', message='".$message."'");
		
		print "INSERT INTO `requestquote` set date='".$date."', sessionid='".$sessionid."', pid='".$pid[$i]."', partnumber='".$n."', manufacturer='".$manu[$i]."', quantity='".$qty[$i]."', price='".$price[$i]."', name='".$name."', email='".$email."', phone='".$phone."', cname='".$cname."', ctype='".$ctype."', fax='".$fax."', message='".$message."'";
		
	}
	db_query("DELETE from `addtoquote` where sessionid='".$sessionid."'");

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
<title><?php echo $page_seo['requestquote']['meta_title']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['requestquote']['metakeywords']; ?> " />
<meta name="description" content="<?php echo $page_seo['requestquote']['metadescription']; ?>"  />
<?php if(trim($page_seo['requestquote']['moretags'])!=""){ echo $page_seo['requestquote']['moretags']; }?>
<?php include('css.php'); ?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">

<style>
.ui-autocomplete-loading {
	background: white url("images/loading.gif") center center;
	background-repeat: no-repeat;
	background-size: 16px 16px;
}
</style>
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
<?php 
$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='requestquotebanner'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_inner_banner where language='en' and page='requestquotebanner'");
}
$res = mysqli_fetch_array($sql);
?>
<div class="inner-banner" style="background:url(banner/<?php echo $res['image']; ?>) no-repeat;">
	<div class="about-banner_text">
        <div class="container clearfix text-center">
        <?php
            if($numrow==0){
              echo googleTranslatetext($res['description'],$_SESSION['lan']); 
			}else{
              echo $res['description'];
			}
        ?>
        </div>
    </div>	
</div>
<!-- //banner -->

<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- request quote section starts -->
<?php if (@$_COOKIE['msg']) { ?>
<div class="row ">
<div class="col-md-9 col-12 mx-auto text-center" style="padding-top:30px;">
<div class="alert alert-success">
<a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
<?php print $_COOKIE['msg']; ?>
</div>
</div>
</div>
<?php } ?>

<section class="request_quote" style="margin-top:30px;">
    <div class="container">
        <div class="row ">
          <div class="col-md-9 col-12 mx-auto text-center">
              <?php
			  $qsql = db_query("SELECT heading, description from `quote_landing` where language='$lan'");
			  $numrow = mysqli_num_rows($qsql);
			  if($numrow==0){
				$qsql = db_query("select heading, description from `quote_landing` where language='en'");
				$qrow = mysqli_fetch_array($qsql);
				$heading = googleTranslatetext($qrow['heading'],$_SESSION['lan']);
				$detail  = googleTranslatetext(str_replace('../',SITEURL,$qrow['description']),$_SESSION['lan']);
			}else{
				$qrow = mysqli_fetch_array($qsql);
				$heading = $qrow['heading'];
				$detail  = str_replace('../',SITEURL,$qrow['description']);
			}
				
			  ?>
              <h2><?php echo $heading; ?></h2>
              <p><?php print $detail; ?></p>
			  
			<!--
            <form method="POST" action="" autocomplete="off">
			<input type="hidden" value="2" name="stage">
            <div class="table-responsive text-left" style="padding-top:40px;" id="quotereq">

			  <table class="table" id="prow">
                <thead>
                  <tr style="font-size: 13px;color:#029cfc;font-weight:bolder;">
                    <th>PART NUMBR</th>
                    <th>MANUFACTURER</th>
                    <th>QUANTITY</th>
                    <th>TARGET PRICE</th>
                    <th>NEED BY</th>
                  </tr>
                </thead>
                <tbody id="newbox">
				<?php 
				/*
				$c = 2;
				$qsql = db_query("SELECT id,manufacturer, partnumber, quantity from addtoquote WHERE sessionid='".$sessionid."'");
				$qnum = mysqli_num_rows($qsql);
				if($qnum > 0){
				while($qrow = mysqli_fetch_array($qsql)){
				?>
				<tr>
				<td>
				<input type="text" name="part[]" class="partsearch" id="<?php print $c;?>" value="<?php print $qrow['partnumber'];?>" style="border-radius: 10px; padding: 7px 15px;"> 
				<input type="hidden" id="pid<?php print $c;?>" name="pid[]" value="<?php print $qrow['id'];?>">
				</td>
				<td><input type="text" id="manu<?php print $c;?>" name="manu[]" value="<?php print $qrow['manufacturer'];?>" style="border-radius: 10px; padding: 7px 15px;">
				</td>
				<td><input type="text" name="qty[]" value="<?php print $qrow['quantity'];?>" style="width: 70px;border-radius: 10px; padding: 7px 15px;" onkeypress="return /[0-9]/i.test(event.key)"></td>
				<td><input type="text" name="price[]" value="" style="width:70px; border-radius:10px; padding: 7px 15px;" onkeypress="return /[0-9.]/i.test(event.key)"></td>
				<td>
				 <select name="needby[]" style="border-radius: 10px; padding: 7px 15px;">
				 <?php 
					$nsql = db_query("select text from `needby` order by id");
					while($nrow= mysqli_fetch_array($nsql)){
				 ?>
				  <option value="<?php print $nrow['text'];?>"><?php print $nrow['text'];?></option>
				<?php } ?>
				</select>
				</td>
			  </tr>
				
				<?php $c++; } } ?>
				   <tr>
					<td><input type="text" name="part[]" class="partsearch" id="<?php print $c;?>" value="" style="border-radius: 10px; padding: 7px 15px;"> 
					<input type="hidden" id="pid<?php print $c;?>" name="pid[]" value="">
					</td>
					<td><input type="text" id="manu<?php print $c;?>" name="manu[]" value="" style="border-radius: 10px; padding: 7px 15px;">
					</td>
					<td><input type="text" name="qty[]" value="" style="width: 70px;border-radius: 10px; padding: 7px 15px;" onkeypress="return /[0-9]/i.test(event.key)"></td>
					<td><input type="text" name="price[]" value="" style="width:70px; border-radius:10px; padding: 7px 15px;" onkeypress="return /[0-9.]/i.test(event.key)"></td>
					<td>
					 <select name="needby[]" style="border-radius: 10px; padding: 7px 15px;">
					 <?php 
						$nsql = db_query("select text from `needby` order by id");
						while($nrow= mysqli_fetch_array($nsql)){
					 ?>
					  <option value="<?php print $nrow['text'];?>"><?php print $nrow['text'];?></option>
					<?php }  */ ?>
					</select>
					</td>
				  </tr>
                </tbody>
              </table>
            </div>
			
			<button type="button" class="btn btn_request text-center" id="addnew">Add More Parts</button>&nbsp;&nbsp;
            <button type="button" class="btn btn_request1 text-center" id="remove">Remove Last Part</button>

			-->

            <h2 style="padding:60px 0 20px 0;">Contact Information</h2>

            <div class="row">
              <div class="col-md-6 col-12 mx-auto mb-3">
                 <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
              </div>
              <div class="col-md-6 col-12 mx-auto mb-3">
                 <input type="email" class="form-control" id="emial" name="email" placeholder="Email" required>
              </div>
              <div class="col-md-6 col-12 mx-auto  mb-3">
                 <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
              </div>
              <div class="col-md-6 col-12 mx-auto  mb-3">
                 <input type="text" class="form-control" id="company" name="companyname"  placeholder="Company Name" required>
              </div>
              <div class="col-md-6 col-12 mx-auto  mb-3">

				 <select name="companytype" class="form-control" style="height:50px;">
				 <option value="Not specified">SELECT ONE</option>
				 <option value="OEM">OEM</option>
				 <option value="Distributor">Distributor</option>
				 <option value="Broker">Broker</option>
				 <option value="CM">CM</option>
				 <option value="Government">Government</option>
				 <option value="Other">Other</option>
				 </select>
				 
				 
              </div>
              <div class="col-md-6 col-12 mx-auto  mb-3">
                 <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax" >
              </div>
              <div class="col-md-12 col-12 mx-auto  mb-3">
                <textarea class="form-control" rows="5" id="message" name="message" placeholder="Comments" required></textarea>
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
    </div>

    </div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</section>
<!-- request quote section ends -->


<!-- footer -->
<?php include('footer.php'); ?>
<!-- //footer -->
		
<!-- jQuery -->
<?php include('js.php'); ?>
<script src="js/jquery-ui.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script> 
<script>
$(document).ready(function() {
	needby = '<select name="needby[]" style="border-radius: 10px; padding: 7px 15px;">';
	<?php 
	$nsql = db_query("select text from `needby` order by id");
	while($nrow= mysqli_fetch_array($nsql)){
	?>
	needby += '<option value="<?php print $nrow[text];?>"><?php print $nrow[text];?></option>';
	<?php } ?>
	needby += '</select>';
	
	$("#addnew").click(function(e){
		e.preventDefault();
		var rowCount = $('#prow tr').length+1;
		$('#newbox').append('<tr><td><input id="'+rowCount+'" class="partsearch" type="text" name="part[]" value="" style="border-radius: 10px; padding: 7px 15px;"> <input id="pid'+rowCount+'" type="hidden" name="pid[]" value=""></td><td><input type="text" id="manu'+rowCount+'" name="manu[]" value="" style="border-radius: 10px; padding: 7px 15px;"></td><td><input type="text" name="qty[]" value="" style="width: 70px;border-radius: 10px; padding: 7px 15px;" onkeypress="return /[0-9]/i.test(event.key)"></td><td><input type="text" name="price[]" value="" style="width:70px; border-radius:10px; padding: 7px 15px;" onkeypress="return /[0-9.]/i.test(event.key)"></td><td>'+needby+'</td></tr>');
	});
	
	$('#remove').on("click", function(){
		var rowCount = $('#prow tr').length;
		if(rowCount >2){
			$('#prow tr:last').remove();
		}
	})
});

$(document).ready(function(){
	
var selector = 'input.partsearch';	

$(document).on('keydown.autocomplete', selector, function(){
  // Initialize jQuery UI autocomplete
  $(this).autocomplete({
   source: function(request, response) {
    $.ajax({
     url: "partsearch.php",
     type: 'post',
     dataType: "json",
     data: {
      search: request.term, request:1
     },
     success: function(data) {
      response(data);
     }
    });
   },
   select: function (event, ui) {
	var rowCount= $('#prow tr').length;
    $(this).val(ui.item.label);
	var divid 	= $(this).attr('id');
    var id 		= ui.item.value;
	var manu 	= ui.item.manu;
	   document.getElementById('pid'+divid).value 	= id;
       document.getElementById('manu'+divid).value 	= manu;
    return false;
   },
   minLength: 2,
   delay: 100,
   tokenLimit:10
  });
 });
 
});






  function removeQuote(){
	  var con = confirm("Are you sure to delete records?");
	  if(con){
		var del = new Array();
		$("input:checked").each(function() {
		   del.push($(this).val());
		});
		$.ajax({
			type: "POST",
			url: "removequote.php",
			data:{del:del},
			success: function(data){
				$("#quotereq").html(data);
			}
		});
		return false;
	  }
  }
</script>
</body>
</html>