<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "home";

$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }

$stage = $connect->real_escape_string(@$_POST['stage']);
$maxsize = 10485760;
$allowed_extensions = array('jpeg', 'jpg','png');
// $allowed_vid_extensions = array('mp4', 'avi','3gp', 'webm', 'ogv', 'ogg');
if ($stage == 1) {
    // print_r($_POST);exit();
    
    $heading= $connect->real_escape_string($_POST['heading']);
    $description = $connect->real_escape_string($_POST['description']);
    $language = $connect->real_escape_string($_POST['language']);
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
	if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_abt_content.php;";
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
    $mysql = "select count(0) cnt from our_services where language='$language'";
    $query = db_query($mysql);
    $res = mysqli_fetch_array($query);
    $exist_count=$res['cnt'];
    //echo $exist_count;
    if($exist_count==0){
    $mysql = "Insert into our_services set heading='$heading',description='$description',language='$language'";
    }
    else{
    $mysql = "update our_services set heading='$heading',description='$description' where language='$language'";
    }
    $query = db_query($mysql);
    $msg = "Data Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    if(isset($_GET['language'])){
      print "self.location = 'mng_our_services.php?language=".$_GET['language']."';";
    }
    else{
     print "self.location = 'mng_our_services.php';";
    }
    //print "self.location = 'mng_aboutus.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_our_services.php';";
        print "</script>";
    }
    
}
if(isset($_GET['language'])){
$lan=$_GET['language'];
}
else{
$lan='en';
}
$sql = db_query("select * from our_services where language='".$lan."'");
$row = mysqli_fetch_array($sql);
$img1 = $row['image_1'];
$img2 = $row['image_2'];
$img3 = $row['image_3'];
$heading= $row['heading'];
$description = $row['description'];
    

   
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
  self.location = 'mng_our_services.php?language='+val;
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
          <h2>Our Services </h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <strong>Notification!</strong> <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
                    <form name="pwd" method="POST" action="" onSubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="stage" value="1">
            <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                      
            <div class="form-group row">
              <label class="col-sm-12 form-control-label">Select Language</label>
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
                        <label class="col-sm-12 form-control-label">Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $heading; ?>" class="form-control" name="heading" placeholder="Enter Title" required>
                        </div>
            </div>
            
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Content </label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="description" id="description" placeholder="Enter Description"><?php print $description; ?></textarea>
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
<script type="text/javascript">
    function ValidateFileUpload(){
         var fuData = document.getElementById('video');
         var fileext = document.getElementById('video').value;
        // file.type;
        var FileSize = fuData.files[0].size / 1024 / 1024; // in MB
        
        
        extentions = fileext.split('.').pop();

        if (extentions != 'mp4') {
            alert('Please select mp4 format video');

        }else{
            if(FileSize > 10){
               // alert('File size exceeds 10 MB');
               alert(FileSize);
           // $(file).val(''); //for clearing with Jquery
           return false; 
            }
            
        }
        
        
    }
</script>
<script type="text/javascript">
    function ValidateFileUploadogg(){
         var fuData = document.getElementById('ogg');
         var fileext = document.getElementById('ogg').value;
        // file.type;
        var FileSize = fuData.files[0].size / 1024 / 1024; // in MB
        
        
        extentions = fileext.split('.').pop();

        if (extentions != 'ogg') {
            alert('Please select ogg format video');

        }else{
            if(FileSize > 10){
               alert('File size exceeds 10 MB');
           // $(file).val(''); //for clearing with Jquery
           return false; 
            }
            
        }
        
        
    } 
</script>
<script type="text/javascript">
    function ValidateFileUploadwebm(){
         var fuData = document.getElementById('webm');
         var fileext = document.getElementById('webm').value;
        // file.type;
        var FileSize = fuData.files[0].size / 1024 / 1024; // in MB
        
        
        extentions = fileext.split('.').pop();

        if (extentions != 'webm') {
            alert('Please select webm format video');

        }else{
            if(FileSize > 10){
               alert('File size exceeds 10 MB');
           // $(file).val(''); //for clearing with Jquery
           return false; 
            }
            
        }
        
        
    }
</script>
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
