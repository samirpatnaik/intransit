<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "requestquote";


$sessionid =  $connect->real_escape_string(trim($_GET['id']));


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
		  <a href="downloadquote.php?id=<?php print $sessionid; ?>" class="pull-right btn btn-primary" style="margin-right:10px;">Download</a> 
		  
		  <a href="sendquote.php?id=<?php print $sessionid; ?>" class="pull-right btn btn-primary" style="margin-right:10px;">Send Quote</a> 
		  
		  
        <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
		<div class="col-md-12">
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
				  <td><?php print $row['partnumber'];?></td>
				  <td><?php print $row['manufacturer'];?></td>
				  <td><?php print $row['quantity'];?></td>
				  <td>$ <?php print $row['price'];?></td>
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
				  <td><?php print $name;?></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Email: </b></td>
				  <td><?php print $email;?></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Phone Number: </b></td>
				  <td><?php print $phone;?></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Fax: </b></td>
				  <td><?php print $fdax;?></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Company Name: </b></td>
				  <td><?php print $cname;?></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Company Type: </b></td>
				  <td><?php print $ctype;?></td>
				</tr>
				
				<tr>
				  <td style="width:20% !important;"><b>Comment: </b></td>
				  <td><?php print $message;?></td>
				</tr>
				
			  </tbody>
			</table> 
			</div>
			</div>
			</div>
			
			
			
		</div> 
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
