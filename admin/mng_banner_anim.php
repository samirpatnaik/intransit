<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "home";

$banim = $connect->real_escape_string(filter_inputs($_POST['banim']));
if($banim !=""){
    
	db_query("TRUNCATE table `banimation`");
	db_query("INSERT INTO banimation set banim='".$banim."'");

    $msg = "Animation Set Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_banner_anim.php';";
    print "</script>";
    exit;
}

$sql 	= db_query("select * from banimation");
$row 	= mysqli_fetch_array($sql);
$banim 	= $row['banim'];
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
            <h2 style="display:inline-block; margin-bottom:30px">Banner Animation</h2>
            
            <?php if (@$_COOKIE['msg']) { ?>
                <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
                <?php print $_COOKIE['msg']; ?>
                </div>
            <?php } ?>
            </div> 
      
		<div class="admin_table">
			<div class="col-md-12">
			<form name="cms" method="POST" action="" autocomplete="off">
			<div class="form-group row">
			<label class="col-sm-3 form-control-label">Select Animation</label>
			<div class="col-sm-6">
			  <input type="radio" value="fade" name="banim" <?php if($banim == 'fade'){ print "checked";}?>> Fade
			  <input type="radio" value="slide" name="banim" <?php if($banim == 'slide'){ print "checked";}?>> Slide
			</div>
            </div>
			<div class="form-group row">
              <div class="col-sm-offset-2 col-sm-10">
              
                 <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
			</form>			
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
