<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "pages";


$delid 	= $connect->real_escape_string($_GET['delid']);

if ($delid != "") {
    $sql = "delete from `mng_pages` where id='".$delid."'";
    db_query($sql);
	include("pagemanipulate.php");
    $msg = "Page Deleted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_pages.php';";
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
          <h2>Manage Pages</h2>
		  <a href="mng_add_page.php" class="btn btn-primary pull-right">Add New</a>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
		<div class="col-md-12">
		<div class="member_list">
		<table class="table">
				  <thead>
					<tr>
					<th width="10%">#</th>
					<th width="40%">Page Name</th>
					<th width="40%">Page URL</th>
					<th>&nbsp;</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php 
					$c = 0;
					$query  = db_query("SELECT * FROM mng_pages order by id desc "); 
					while($resuser = mysqli_fetch_array($query)){
					$c++;
				  ?>
					<tr>
					<td><?php print $c; ?></td>
					<td><?php print $resuser['metatitle']; ?></td>
					<td><?php print SITEURL.$resuser['page_url'];?></td>    
					  <td>

					  <a href="<?php print SITEURL.$resuser['page_url'];?>" target="_blank" alt="Preview"><i class="fa fa-eye" aria-hidden="true"></i></a>
					  
					  <a href="mng_add_page.php?id=<?php print $resuser['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

					  <a href="?delid=<?php print $resuser['id']; ?>" onclick="return confirm('Are you sure to delete this Page?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
					  
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
