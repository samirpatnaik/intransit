<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "newpwd";



$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {
    
   
    $facebook = $connect->real_escape_string($_POST['facebook']);
$twitter = $connect->real_escape_string($_POST['twitter']);
$instagram = $connect->real_escape_string($_POST['instagram']);
$youtube = $connect->real_escape_string($_POST['youtube']);
        
   
     db_query("TRUNCATE TABLE `social_links`");

    $sql = "Insert into social_links set facebook='$facebook',twitter='$twitter',instagram='$instagram',youtube='$youtube'";

  /*  echo $sql;*/
    db_query($sql);
 
    include("pagemanipulate.php");

    $msg = "Social Media Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_social_links.php';";
    print "</script>";
    exit;
}



$sql = "select * from social_links";

$res = mysqli_fetch_assoc(db_query($sql));
@extract($res);


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
          <h2>Manage Social Media Content</h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
                    <form name="pwd" method="POST" action="" onSubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
          
                      <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                      <input type="hidden" name="stage" value="2">
              

             <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Facebook URL </label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $facebook; ?>" class="form-control" name="facebook" placeholder="Enter Facebook URL" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Twitter URL</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $twitter; ?>" class="form-control" name="twitter" placeholder="Enter Twitter URL" >
                        </div>
            </div>
            

            
            
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Instagram URL</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $instagram; ?>" class="form-control" name="instagram" placeholder="Enter Instagram URL" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">YouTube URL</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $youtube; ?>" class="form-control" name="youtube" placeholder="Enter YouTube URL" >
                        </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-offset-4 col-sm-10">
              
                 <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            </form>
                      
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
