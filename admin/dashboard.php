<?php
ob_start();
header('Cache-Control: public, s-maxage=600');
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    if (ob_get_level() > 0) {
        ob_clean();
    }
    header("Location: index.php");
    exit;
endif;
$page = "dashboard";
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
<style>

.box {
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    display: block;
	height: 320px;
	overflow-y: auto;
	margin-bottom: 40px;
}
</style>

</head>
<body>
<!--left-side-->
<div id="left">
<!--logo-->
<!-- <div class="clearfix">
    <div class="text-center logo"><img src="images/logo-small.png" alt=""></div>
</div> -->
<!--end logo-->
<!--sidebar-menu-->
<?php include("sidebar.php");?>
<!--sidebar-menu-->

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
        <div class="admin_cont" style="min-height: 600px;">
            <div class="col-md-12">
                <h1>Welcome Admin</h1>
            </div>            
            <div class="clearfix"></div>
			<div class="row col-md-12">
            <div class="col-md-4">
            <div class="box">
			<h2 style="display:inline-block; margin-bottom:30px;">Manage News</h2>
			<span style="float:right;"><a href="mng_list_blog.php">View All</a></span>
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="80%">News Title</th>
				<th>&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php 
					$query  = db_query("SELECT * FROM mng_blog order by id desc "); 
					while($resuser = mysqli_fetch_array($query)){
					
						
				?>
				<tr>
				  <td style="width: 10% !important;"><?php echo $resuser['title']?></td>
				  <td>
				  <a href="mng_blog.php?id=<?php print $resuser['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

				  <a href="mng_blog.php?delid=<?php print $resuser['id']; ?>" onclick="return confirm('Are you sure to delete this blog?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table>
			</div> 
			</div> 

			
            <div class="col-md-4">
            <div class="box">
			<h2 style="display:inline-block; margin-bottom:30px">Manage Products</h2>
			<span style="float:right;"><a href="mng_products.php">View All</a></span>
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="80%">Part Number</th>
				<th>&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php 
				$query  = db_query("SELECT id,partnumber,manufacturer FROM products  limit 5"); 
				while($row = mysqli_fetch_array($query)){
				?>
				<tr>
				  <td><?php echo $row['partnumber']?></td>
				  <td>
				  <a href="add_products.php?id=<?php print $row['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

				  <a href="add_products.php?delid=<?php print $row['id']; ?>" onclick="return confirm('Are you sure to delete this product?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table>
			</div> 
			</div> 
			
			
			
            <div class="col-md-4">
            <div class="box">
			<h2 style="display:inline-block; margin-bottom:30px">Manage Manufactuers</h2>
			<span style="float:right;"><a href="mng_manufacturers.php">View All</a></span>
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="80%">Manufacturer</th>
				<th>&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php 
				$query  = db_query("SELECT id,mname FROM manufacturers limit 5"); 
				while($row = mysqli_fetch_array($query)){
				?>
				<tr>
				  <td><?php echo $row['mname']?></td>
				  <td>
				  <a href="add_manufacturers.php?id=<?php print $row['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

				  <a href="add_manufacturers.php?delid=<?php print $row['id']; ?>" onclick="return confirm('Are you sure to delete this manufacturer?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table>
			
			</div> 
            </div> 
			</div>
			
			<div class="row col-md-12">
            <div class="col-md-6">
            <div class="box">
			<h2 style="display:inline-block; margin-bottom:30px">Excess Inventory Sale Requests</h2>
			<span style="float:right;"><a href="view_excess_inventary.php">View All</a></span>
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="20%">Date</th>
				<th width="35%">Name</th>
				<th width="35%">Email</th>
				<th>&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$c =0;
					$query  = db_query("SELECT * FROM `excess_inventary` order by date desc "); 
					while($row = mysqli_fetch_array($query)){
					$c++;
						
				?>
				<tr>
				  <td>
					<?php print date('Y-m-d',strtotime($row['date'])); ?>
				  </td>
				  <td><?php print $row['fname']." ".$row['lname'];?></td>
				  <td><?php print $row['email'];?></td>
				  <td>
				  <a href="view_excess_inventary.php?delid=<?php print $row['id']; ?>" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table>
			
			
			</div> 
			</div> 
			
			
            <div class="col-md-6">
            <div class="box">
			<h2 style="display:inline-block; margin-bottom:30px">Parts Quote Requests</h2>
			<span style="float:right;"><a href="view_request_quote.php">View All</a></span>
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="20%">Date</th>
				<th width="35%">Name</th>
				<th width="35%">Email</th>
				<th>&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$c =0;
					$query  = db_query("SELECT * FROM `requestquote` group by sessionid order by date desc "); 
					while($row = mysqli_fetch_array($query)){
					$c++;
			  ?>
				<tr>
				  <td>
					<?php print date('Y-m-d',strtotime($row['date'])); ?>
				  </td>
				  <td><?php print $row['name'];?></td>
				  <td><?php print $row['email'];?></td>
				  <td>
				  <a href="quote_edit.php?id=<?php print $row['sessionid']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;
				  <a href="quote_detail.php?id=<?php print $row['sessionid']; ?>"><i class="fa fa-eye" aria-hidden="true"></i>
</a> &nbsp;
				  <a href="downloadquote.php?id=<?php print $row['sessionid']; ?>"><i class="fa fa-download" aria-hidden="true"></i>
</a> &nbsp;
				  <a href="quote_detail.php?delid=<?php print $row['sessionid']; ?>" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table>
			</div> 
            </div>
        </div>
          
    </div>      
</div>
<!--End-main area-->
   
</div>
<!--end-main-container-part-->

<script src="js/matrix.js"></script>
</body>
</html>
