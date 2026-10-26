<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "newpwd";



$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {
    
   
    $secret_key =  $connect->real_escape_string(trim($_POST['secret_key']));
    $site_key = $connect->real_escape_string(trim($_POST['site_key']));
    $lang_key = $connect->real_escape_string(trim($_POST['lang_key']));
    $google_analytics  = str_replace("'", "&#39;", $_POST['google_analytics']);
  
        
   
    db_query("TRUNCATE TABLE `google_key`");

    $sql = "insert into google_key set secret_key='".$secret_key."',site_key='".$site_key."',lang_key='".$lang_key."',google_analytics='".$google_analytics."'";

    /*echo $sql;*/
    db_query($sql);
       
    

    include("pagemanipulate.php");

    $msg = "Google Key Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_google_key.php';";
    print "</script>";
    exit;
}



$sql = "select * from google_key";

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
          <h2>Manage Google Key Content</h2>
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
                        <label class="col-sm-12 form-control-label">Secret Key</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $secret_key; ?>" class="form-control" name="secret_key" placeholder="Enter Secret Key" >
                        </div>
            </div>

               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Site Key </label>
                        <div class="col-sm-6">
                         <input type="text" value="<?php print $site_key; ?>" class="form-control" name="site_key" placeholder="Enter Site Key" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Language Key </label>
                        <div class="col-sm-6">
                         <input type="text" value="<?php print $lang_key; ?>" class="form-control" name="lang_key" placeholder="Enter Language Key" >
                        </div>
            </div>
          
   <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Google Analytics </label>
                        <div class="col-sm-6">
                         <textarea class="form-control" id="google_analytics" name="google_analytics" ><?php print $google_analytics;?></textarea>
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
