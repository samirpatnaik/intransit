<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "requestquote";
$sessionid =  $connect->real_escape_string(trim($_GET['id']));

$stage 	=  $connect->real_escape_string(trim($_POST['stage']));

if($stage==2){
	$sessionid 	=  $connect->real_escape_string(trim($_POST['sessionid']));
	
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
	
	db_query("DELETE from `requestquote` where sessionid='".$sessionid."'");
	
	foreach($part as $i => $n ) {
		db_query("INSERT INTO `requestquote` set date='".$date."', sessionid='".$sessionid."', pid='".$pid[$i]."', partnumber='".$n."', manufacturer='".$manu[$i]."', quantity='".$qty[$i]."', price='".$price[$i]."', name='".$name."', email='".$email."', phone='".$phone."', cname='".$cname."', ctype='".$ctype."', fax='".$fax."', message='".$message."'");
	}


	$msg = "Request Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "window.location='view_request_quote.php?success';";
    print "</script>";
	exit;
}



?>
<!DOCTYPE HTML>
<!--[if lt IE 9]><html class="lt-ie9"><![endif]-->
<!--[if gt IE 9]><html><![endif]-->
<!--[if !IE]>--> <html> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<title>Intransit || Admin</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!--font-awesome Stylesheet-->
<?php 
include_once('css.php');
?>

<script src="tinymce/tinymce.min.js"></script>
<script src="tinymcejs.js"></script>

</head>
<body>
<!--left-side-->
<div id="left">
<!--logo-->

<!--end logo-->
<!--sidebar-menu-->
<?php include("sidebar.php");?>
<!--sidebar-menu-->
<!--copy-->

<!--end copy-->
</div>
<!--end left-side-->

<!--main-container-part-->
<div id="content">
<!--main area--> 
<div class="container clearfix">
  <div class="row clearfix">
        <div class="admin_top">
            <ul>
                <li><a href="#null">Hi Admin</a></li>
            </ul>
        </div>            
        <div class="admin_cont">
          <div class="col-md-12">
          <h2>View Request Quote</h2>
		  <a href="view_request_quote.php" class="pull-right btn btn-primary" style="">Back</a>

		  
		  
        <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
		<div class="col-md-12">
		<form method="POST" action="" autocomplete="off">
		<input type="hidden" value="2" name="stage">
		<input type="hidden" value="<?php print $sessionid; ?>" name="sessionid">
		
		<div class="member_list">
			<table class="table d-flex flex-direction-row" width="50%">
			  <thead>
				<tr>
				<th width="25%">Partnumber</th>
				<th width="25%">Manufacturer</th>
				<th width="25%">Quantity</th>
				<th width="25%">Price</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$c =0;
					$query  = db_query("SELECT * FROM `requestquote` WHERE sessionid='".$sessionid."' AND quantity !='0' "); 
					while($row = mysqli_fetch_array($query)){
					$c++;
			  ?>
				<tr>
				  <td>
				  <input type="text" name="part[]" class="partsearch" id="<?php print $c;?>" value="<?php print $row['partnumber'];?>" style="border-radius: 10px; padding: 7px 15px;">
				  <input type="hidden" id="pid<?php print $c;?>" name="pid[]" value="<?php print $row['id'];?>">
				  
				  </td>
				  <td><input type="text" id="manu<?php print $c;?>" name="manu[]" value="<?php print $row['manufacturer'];?>" style="border-radius: 10px; padding: 7px 15px;"></td>
				  <td><input type="text" name="qty[]" value="<?php print $row['quantity'];?>" style="width: 70px;border-radius: 10px; padding: 7px 15px;" onkeypress="return /[0-9]/i.test(event.key)"></td>
				  <td><input type="text" name="price[]" value="<?php print $row['price'];?>" style="width:70px; border-radius:10px; padding: 7px 15px;" onkeypress="return /[0-9.]/i.test(event.key)"></td>
				</tr>
			   <?php
					$name 	= $row['name'];
					$email 	= $row['email'];
					$phone 	= $row['phone'];
					$cname 	= $row['cname'];
					$ctype 	= $row['ctype'];
					$fax 	= $row['fax'];
					$message = $row['message'];
				}
			   ?>
			  </tbody>
			</table> 
			
			<h2>Address</h2>
			<div class="row">
			<div class="col-md-12">
			<div class="member_list">
				<table class="table d-flex flex-direction-row">
			  <tbody>
				<tr>
				  <td style="width:20% !important;"><b>Name: </b></td>
				  <td><input type="text" class="form-control" id="name" value="<?php print $name;?>" name="name" placeholder="Your Name" required /></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Email: </b></td>
				  <td><input type="email" class="form-control" id="emial" name="email" value="<?php print $email;?>" placeholder="Email" required /></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Phone Number: </b></td>
				  <td><input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?php print $phone;?>" required /></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Fax: </b></td>
				  <td>
				  <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax" value="<?php print $fax;?>" ></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Company Name: </b></td>
				  <td>
				  <input type="text" class="form-control" id="company" name="companyname"  placeholder="Company Name" value="<?php print $cname;?>" required />
				  </td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Company Type: </b></td>
				  <td><input type="text" class="form-control" id="companyt" name="companytype" placeholder="Company Type" value="<?php print $ctype;?>" required /></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Comment: </b></td>
				  <td><textarea class="form-control" rows="5" id="message" name="message" placeholder="Comments" required ><?php print $message;?></textarea></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"></td>
				  <td><button type="submit" class="btn btn-primary">Submit</button></td>
				</tr>
				
			  </tbody>
			</table> 
			</div>
			</div>
			</div>

		</div> 
		</form>
		</div>
                      
            <div class="clearfix"></div>

            </div>            
            <div class="clearfix"></div>
        </div>
        
    </div>      
</div>
<!--End-main area-->
   
</div>
<!--end-main-container-part-->
<script src="https://www.google.com/recaptcha/api.js?render=<?php print $sitekey; ?>"></script>
<script>
grecaptcha.ready(function () {
    grecaptcha.execute('<?php print $sitekey; ?>',{action:'login'}).then(function(token){
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
    });
});
</script>

<script src="js/matrix.js"></script>
</body>
</html>
