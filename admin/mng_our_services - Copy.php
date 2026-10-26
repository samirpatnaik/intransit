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
    $alt_txt_1 = $connect->real_escape_string($_POST['alt_txt_1']);
    $title_txt_1 = $connect->real_escape_string($_POST['title_txt_1']);
    $image_title_1 = $connect->real_escape_string($_POST['image_title_1']);
    $image_desc_1 = $connect->real_escape_string($_POST['image_desc_1']);
    $read_more_txt_1 = $connect->real_escape_string($_POST['read_more_txt_1']);
    $read_more_link_1 = $connect->real_escape_string($_POST['read_more_link_1']);
    
    $alt_txt_2 = $connect->real_escape_string($_POST['alt_txt_2']);
    $title_txt_2 = $connect->real_escape_string($_POST['title_txt_2']);
    $image_title_2 = $connect->real_escape_string($_POST['image_title_2']);
    $image_desc_2 = $connect->real_escape_string($_POST['image_desc_2']);
    $read_more_txt_2 = $connect->real_escape_string($_POST['read_more_txt_2']);
    $read_more_link_2 = $connect->real_escape_string($_POST['read_more_link_2']);

    $alt_txt_3 = $connect->real_escape_string($_POST['alt_txt_3']);
    $title_txt_3 = $connect->real_escape_string($_POST['title_txt_3']);
    $image_title_3 = $connect->real_escape_string($_POST['image_title_3']);
    $image_desc_3 = $connect->real_escape_string($_POST['image_desc_3']);
    $read_more_txt_3 = $connect->real_escape_string($_POST['read_more_txt_3']);
    $read_more_link_3 = $connect->real_escape_string($_POST['read_more_link_3']);

    $language = $connect->real_escape_string($_POST['language']);

      if ($_FILES['image_1']['name'] != "") {
        $filenamenew = $_FILES['image_1']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_banner.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../uploadimages";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image_1']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image_1']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $img1 = $img_name;
            $path2 = "../uploadimages";
            $delpath1 = $path2 . "/" . $_POST['T2'];
            @unlink($delpath1);
        }
    }else {
        $img1 = trim($_POST['T2']);
    }



    if ($_FILES['image_2']['name'] != "") {
        $filenamenew = $_FILES['image_2']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_our_services.php';";
            print "</script>";
            exit;
        } else {
            $path3 = "../uploadimages";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image_2']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path3 . "/" . $realname;
            move_uploaded_file($_FILES['image_2']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $img2 = $img_name;
            $path3 = "../uploadimages";
            $delpath1 = $path3 . "/" . $_POST['T3'];
            @unlink($delpath1);
        }
    }else {
        $img2 = trim($_POST['T3']);
    }


    if ($_FILES['image_3']['name'] != "") {
        $filenamenew = $_FILES['image_3']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_our_services.php';";
            print "</script>";
            exit;
        } else {
            $path4 = "../uploadimages";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image_3']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path4 . "/" . $realname;
            move_uploaded_file($_FILES['image_3']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $img3 = $img_name;
            $path4 = "../uploadimages";
            $delpath1 = $path4 . "/" . $_POST['T4'];
            @unlink($delpath1);
        }
    }else {
        $img3 = trim($_POST['T4']);
    }
    
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
    $mysql = "Insert into our_services set heading='$heading',description='$description',image_1='$img1',alt_txt_1='$alt_txt_1',title_txt_1='$title_txt_1',image_title_1='$image_title_1',image_desc_1='$image_desc_1',read_more_txt_1='$read_more_txt_1',read_more_link_1='$read_more_link_1',image_2='$img2',alt_txt_2='$alt_txt_2',title_txt_2='$title_txt_2',image_title_2='$image_title_2',image_desc_2='$image_desc_2',read_more_txt_2='$read_more_txt_2',read_more_link_2='$read_more_link_2',image_3='$img3',alt_txt_3='$alt_txt_3',title_txt_3='$title_txt_3',image_title_3='$image_title_3',image_desc_3='$image_desc_3',read_more_txt_3='$read_more_txt_3',read_more_link_3='$read_more_link_3',language='$language'";
    }
    else{
    $mysql = "update our_services set heading='$heading',description='$description',image_1='$img1',alt_txt_1='$alt_txt_1',title_txt_1='$title_txt_1',image_title_1='$image_title_1',image_desc_1='$image_desc_1',read_more_txt_1='$read_more_txt_1',read_more_link_1='$read_more_link_1',image_2='$img2',alt_txt_2='$alt_txt_2',title_txt_2='$title_txt_2',image_title_2='$image_title_2',image_desc_2='$image_desc_2',read_more_txt_2='$read_more_txt_2',read_more_link_2='$read_more_link_2',image_3='$img3',alt_txt_3='$alt_txt_3',title_txt_3='$title_txt_3',image_title_3='$image_title_3',image_desc_3='$image_desc_3',read_more_txt_3='$read_more_txt_3',read_more_link_3='$read_more_link_3' where language='$language'";
    }
    //echo $mysql;
    //die();
    //$mysql = "Insert into about_content  set title='$title',heading_txt='$heading_txt',description='$description',image='$img',alt_txt='$alt_txt',title_txt='$title_txt'";
    // $mysql = "Insert into about set uname='$uname' ,desig='$desig',title='$title',description='$description'";
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
    $alt_txt_1 = $row['alt_txt_1'];
    $title_txt_1 = $row['title_txt_1'];
    $image_title_1 = $row['image_title_1'];
    $image_desc_1 = $row['image_desc_1'];
    $read_more_txt_1 = $row['read_more_txt_1'];
    $read_more_link_1 = $row['read_more_link_1'];
    
    $alt_txt_2 = $row['alt_txt_2'];
    $title_txt_2 = $row['title_txt_2'];
    $image_title_2 = $row['image_title_2'];
    $image_desc_2 = $row['image_desc_2'];
    $read_more_txt_2 = $row['read_more_txt_2'];
    $read_more_link_2 = $row['read_more_link_2'];

    $alt_txt_3 = $row['alt_txt_3'];
    $title_txt_3 = $row['title_txt_3'];
    $image_title_3 = $row['image_title_3'];
    $image_desc_3 = $row['image_desc_3'];
    $read_more_txt_3 = $row['read_more_txt_3'];
    $read_more_link_3 = $row['read_more_link_3'];

   
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
                        <label class="col-sm-12 form-control-label">Upload Image1</label>
                           <div class="col-sm-6">
                          <input type="file" class="form-control" name="image_1" value="">
              <span style="color: red">Please Upload image of jpeg ,gif & png format.Image Size (1920px X 545px)</span>
                          <?php
                            if ($img1 != "") { ?>
                            <br><img src="../uploadimages/<?php print $img1; ?>" style="height: 100px;" />   
              <input type="hidden" name="T2" value="<?php print $img1; ?>">
                            <?php } ?>
                            
                         

                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Alt Text 1</label>
                        <div class="col-sm-6">
                    <input type="text" value="<?php print $alt_txt_1; ?>" class="form-control" name="alt_txt_1" placeholder="Alt Text 1" required>
                  </div>
                       
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Title Text 1</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title_txt_1; ?>" class="form-control" name="title_txt_1" placeholder="Enter Alt Text" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Image Title 1</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $image_title_1; ?>" class="form-control" name="image_title_1" placeholder="Enter Title Text" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Image desc 1</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $image_desc_1; ?>" class="form-control" name="image_desc_1" placeholder="Enter Title Text" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Read More Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $read_more_txt_1; ?>" class="form-control" name="read_more_txt_1" placeholder="Enter Title Text" >
                        </div>
            </div>
                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Read More Link</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $read_more_link_1; ?>" class="form-control" name="read_more_link_1" placeholder="Enter Title Text" >
                        </div>
            </div>
                 <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Upload Image2</label>
                           <div class="col-sm-6">
                          <input type="file" class="form-control" name="image_2" value="">
              <span style="color: red">Please Upload image of jpeg ,gif & png format.Image Size (1920px X 545px)</span>
                          <?php
                            if ($img2 != "") { ?>
                            <br><img src="../uploadimages/<?php print $img2; ?>" style="height: 100px;" />   
              <input type="hidden" name="T3" value="<?php print $img2; ?>">
                            <?php } ?>
                            
                         

                        </div>
            </div>

                        <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Alt Text 2</label>
                        <div class="col-sm-6">
                    <input type="text" value="<?php print $alt_txt_2; ?>" class="form-control" name="alt_txt_2" placeholder="Alt Text 2" required>
                    </div>   
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Title Text 2</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title_txt_2; ?>" class="form-control" name="title_txt_2" placeholder="Enter Alt Text" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Image Title 2</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $image_title_2; ?>" class="form-control" name="image_title_2" placeholder="Enter Title Text" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Image desc 2</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $image_desc_2; ?>" class="form-control" name="image_desc_2" placeholder="Enter Title Text" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Read More Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $read_more_txt_2; ?>" class="form-control" name="read_more_txt_2" placeholder="Enter Title Text" >
                        </div>
            </div>
                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Read More Link</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $read_more_link_2; ?>" class="form-control" name="read_more_link_2" placeholder="Enter Title Text" >
                        </div>
            </div>
        <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Upload Image3</label>
                           <div class="col-sm-6">
                          <input type="file" class="form-control" name="image_3" value="">
              <span style="color: red">Please Upload image of jpeg ,gif & png format.Image Size (1920px X 545px)</span>
                          <?php
                            if ($img3 != "") { ?>
                            <br><img src="../uploadimages/<?php print $img3; ?>" style="height: 100px;" />   
              <input type="hidden" name="T4" value="<?php print $img3; ?>">
                            <?php } ?>
                            
                         

                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Alt Text 3</label>
                        <div class="col-sm-6">
                    <input type="text" value="<?php print $alt_txt_3; ?>" class="form-control" name="alt_txt_3" placeholder="Alt Text 3" required>
                     </div>  
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Title Text 3</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title_txt_3; ?>" class="form-control" name="title_txt_3" placeholder="Enter Alt Text" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Image Title 3</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $image_title_3; ?>" class="form-control" name="image_title_3" placeholder="Enter Title Text" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Image desc 3</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $image_desc_3; ?>" class="form-control" name="image_desc_3" placeholder="Enter Title Text" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Read More Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $read_more_txt_3; ?>" class="form-control" name="read_more_txt_3" placeholder="Enter Title Text" >
                        </div>
            </div>
                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Read More Link</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $read_more_link_3; ?>" class="form-control" name="read_more_link_3" placeholder="Enter Title Text" >
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
