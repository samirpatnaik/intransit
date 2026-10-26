<?php
/*
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;

$sessionid =  $connect->real_escape_string(trim($_GET['id']));
*/
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
<style>
<style>
@font-face {
  font-family: 'HelveticaWorld-Bold';
  src: url('fonts/HelveticaWorld-Bold.eot') format('embedded-opentype');
	src:url('fonts/HelveticaWorld-Bold.eot?#iefix') format('embedded-opentype'),
		url('fonts/HelveticaWorld-Bold.woff') format('woff'),
		url('fonts/HelveticaWorld-Bold.ttf') format('truetype'),
		url('fonts/HelveticaWorld-Bold.svg#flexslider-icon') format('svg');
  font-weight: normal;
  font-style: normal;
}
@font-face {
  font-family: 'HelveticaWorld-Regular';
  src: url('fonts/HelveticaWorld-Regular.eot') format('embedded-opentype');
	src:url('fonts/HelveticaWorld-Regular.eot?#iefix') format('embedded-opentype'),
		url('fonts/HelveticaWorld-Regular.woff') format('woff'),
		url('fonts/HelveticaWorld-Regular.ttf') format('truetype'),
		url('fonts/HelveticaWorld-Regular.svg#flexslider-icon') format('svg');
  font-weight: normal;
  font-style: normal;
}
</style>
<!--font-awesome Stylesheet-->
<?php 
//include_once('css.php');
?>
</head>
<body>

<!--main-container-part-->
<div style="background-color:#fff; width:100%;">
<!--main area--> 
<div class="container clearfix" style="background-color:#fff; width:100%;">
	<div style="width:100%;"> 
		<div style="width:100%;">
		
		<div style="width:1000px; padding: 50px 0; text-align:center;"><img src="<?php print SITEURL;?>/images/logo.png"></div>
		
		<h2>Quote Details</h2>
		<div style="width:100%;">
			<table style="width:750px; border:1px solid #ccc; background-color:#ccc;">
			  <thead>
				<tr>
				<th width="200" style="text-align:left; padding:10px; border-bottom:1px solid #ccc; " >Partnumber</th>
				<th width="200" style="text-align:left; padding:10px; border-bottom:1px solid #ccc;" >Manufacturer</th>
				<th width="200" style="text-align:left; padding:10px; border-bottom:1px solid #ccc;" >Quantity</th>
				<th width="200" style="text-align:left; padding:10px; border-bottom:1px solid #ccc;" >Price</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$c =0;
					$total =0;
					$query  = db_query("SELECT * FROM `requestquote` WHERE sessionid='".$sessionid."' AND quantity !='0' "); 
					while($row = mysqli_fetch_array($query)){
					$c++;
					$total +=$row['price'];
			  ?>
				<tr>
				  <td width="200" style="padding:10px; background-color:#fff;"><?php print $row['partnumber'];?></td>
				  <td width="200" style="padding:10px; background-color:#fff;"><?php print $row['manufacturer'];?></td>
				  <td width="200" style="padding:10px; background-color:#fff;"><?php print $row['quantity'];?></td>
				  <td width="200" style="padding:10px; background-color:#fff;">$ <?php print $row['price'];?></td>
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
			   <tr>
				  <td width="200" style="padding:10px; background-color:#fff;"></td>
				  <td width="200" style="padding:10px; background-color:#fff;"></td>
				  <td width="200" style="padding:10px; background-color:#fff;">Total:</td>
				  <td width="200" style="padding:10px; background-color:#fff;">$ <?php print $total;?></td>
				</tr>
			  </tbody>
			</table> 
			
			<h2>Address</h2>
			<div style="width:100%;">
			<div style="width:100%;">
			<div style="width:100%;">
				<table class="table d-flex flex-direction-row" style="width:100%;">
			  <tbody>
				<tr>
				  <td width="300"><b>Name: </b></td>
				  <td><?php print $name;?></td>
				</tr>
				
				<tr>
				  <td width="300"><b>Email: </b></td>
				  <td><?php print $email;?></td>
				</tr>
				
				<tr>
				  <td width="300"><b>Phone Number: </b></td>
				  <td><?php print $phone;?></td>
				</tr>
				
				<tr>
				  <td width="300"><b>Fax: </b></td>
				  <td><?php print $fdax;?></td>
				</tr>
				
				<tr>
				  <td width="300"><b>Company Name: </b></td>
				  <td><?php print $cname;?></td>
				</tr>
				
				<tr>
				  <td width="300"><b>Company Type: </b></td>
				  <td><?php print $ctype;?></td>
				</tr>
				
				<tr>
				  <td width="300"><b>Comment: </b></td>
				  <td><?php print $message;?></td>
				</tr>
				
			  </tbody>
			</table> 
			</div>
			</div>
			</div>
		</div> 
		
		
		</div>
	</div>      
</div>
<!--End-main area-->
</div>
</body>
</html>
