<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "requestquote";


$delid =  $connect->real_escape_string(trim($_GET['delid']));
if($delid){
	db_query("DELETE from `requestquote`  WHERE sessionid='".$delid."'");
	
	$msg = "Record Deleted Successfully!";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = '?success';";
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
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
		<div class="col-md-12">
		<div class="member_list">
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="10%">Date</th>
				<th width="20%">Name</th>
				<th width="20%">Email</th>
				<th width="15%">Company</th>
				<th width="10%">Phone</th>
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
				  <td><?php print $row['cname'];?></td>
				  <td><?php print $row['phone'];?></td>
				  <td>
				  <a href="quote_edit.php?id=<?php print $row['sessionid']; ?>">Edit</a> &nbsp;
				  <a href="quote_detail.php?id=<?php print $row['sessionid']; ?>">View</a> &nbsp;
				  <a href="downloadquote.php?id=<?php print $row['sessionid']; ?>">Download</a> &nbsp;
				  <a href="?delid=<?php print $row['sessionid']; ?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table> 
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
