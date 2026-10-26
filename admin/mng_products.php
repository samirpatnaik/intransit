<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "products";

$delid = $connect->real_escape_string(filter_inputs($_GET['delid']));
if($delid !=""){
	db_query("DELETE from `products` where id=".$delid);
    $msg = "Product Deleted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_products.php';";
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

<script>
function chnageLang(val){
  self.location = 'mng_brand_text.php?language='+val;
}
</script>
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
          <h2>Manage Products</h2>
		  
		<a href="add_products.php" class="btn btn-primary pull-right">Add New</a>
		  
      <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
		<table id="products" class="table table-bordered" style="width:100%">
		<thead>
			<tr class="bg-info">
				<th><span>Part #</span></th>
				<th><span>Manufacturer</span></th>
				<th><span>Quantity</span></th>
				<th><span>Datasheet</span></th>
				<th style="width: 80px;"><span>&nbsp;</span></th>                                            
			</tr>
		</thead>
		<tbody>		  
	</tbody>
	</table>
		
                      
      <div class="clearfix"></div>
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

<script>

$(document).ready(function(){
    $('#products').DataTable({
        "processing": true,
        "serverSide": true,
		"pageLength": 25,
        "ajax": "products_ajax.php"
    });
});
</script>
<script src="js/datatables.js"></script>
<script src="js/matrix.js"></script>
</body>
</html>
