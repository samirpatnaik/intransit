<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "brand text";
$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }

$stage = $connect->real_escape_string(@$_POST['stage']);


if ($stage == 1) {
    $language = $connect->real_escape_string($_POST['language']);
    $heading = $connect->real_escape_string($_POST['heading']);
    $description = $connect->real_escape_string($_POST['description']);
  

 
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_text.php;";
        print "</script>";
        exit;
    }
    // Build POST request:
    $recaptcha_url      = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret   = $secretKey;
    $recaptcha_response = $connect->real_escape_string($_POST['recaptchaResponse']);

    // Make and decode POST request:
    //$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = url_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);    
    $recaptcha = json_decode($recaptcha);
    $recaptcha->score = 1;
    if ($recaptcha->score = 0.5) {
    $mysql = "Insert into brand_text set heading='$heading',description='$description',language='$language'";
    
    // $mysql = "Insert into about set uname='$uname' ,desig='$desig',title='$title',description='$description'";
    $query = db_query($mysql);
    $msg = "Data Inserted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    if(isset($_GET['language'])){
      print "self.location = 'mng_brand_text.php?language=".$_GET['language']."';";
    }
    else{
     print "self.location = 'mng_brand_text.php';";
    }
    //print "self.location = 'mng_aboutus.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_text.php';";
        print "</script>";
    }
}
if ($stage == 2) {
    $language = $connect->real_escape_string($_POST['language']);
    $heading = $connect->real_escape_string($_POST['heading']);
    $description = $connect->real_escape_string($_POST['description']);
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_text.php;";
        print "</script>";
        exit;
    }
    // Build POST request:
    $recaptcha_url      = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret   = $secretKey;
    $recaptcha_response = $connect->real_escape_string($_POST['recaptchaResponse']);

    // Make and decode POST request:
    //$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = url_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);    
    $recaptcha = json_decode($recaptcha);
    $recaptcha->score=1;
    if ($recaptcha->score = 0.5) {
    $mysql = "UPDATE brand_text set heading='$heading',description='$description' where language='$language'";
    // print $mysql;exit();
    $query = db_query($mysql);
    $msg = "Data Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    if(isset($_GET['language'])){
      print "self.location = 'mng_brand_text.php?language=".$_GET['language']."';";
    }
    else{
     print "self.location = 'mng_brand_text.php';";
    }
    //print "self.location = 'mng_aboutus.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_text.php';";
        print "</script>";
    }
    
}
if($language){
$sql = db_query("select * from `brand_text` where language='$language'");
$row = mysqli_fetch_array($sql);
$heading = $row['heading'];
$details = $row['description'];
$lan = $row['language'];
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
          <h2>Brand Text Management</h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
                    <form name="pwd" method="POST" action="" onSubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
           <?php if($id==""){ ?>
                            <input type="hidden" name="stage" value="2">
                      <?php }else{ ?>
                            <input type="hidden" name="stage" value="3">
                      <?php } ?>
                      <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
            <div class="form-group row">
              <label class="col-sm-12 form-control-label">Select language</label>
              <div class="col-sm-6">
       <select name="language" class="form-control" onchange="chnageLang(this.value)">
                <?php 
                $lsql = db_query("select * from mng_language order by language");
                while($lrow = mysqli_fetch_array($lsql)){
                  
                ?>
                <option value="<?php print $lrow['lcode'];?>" <?php if($language==$lrow['lcode']){ print "selected"; }?>><?php print $lrow['language'];?></option>
                <?php } ?>
              </select>
              </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Brand Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $heading; ?>" class="form-control" name="heading" placeholder="Enter Heading" required>
                        </div>
            </div>
        
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Brand Description </label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="description" id="description" placeholder="Enter Description"><?php print $details; ?></textarea>
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
