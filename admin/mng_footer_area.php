<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "newpwd";

$stage = $connect->real_escape_string(@$_POST['stage']);
$maxsize = 10485760;
$allowed_extensions = array('jpeg', 'jpg','png');
// $allowed_vid_extensions = array('mp4', 'avi','3gp', 'webm', 'ogv', 'ogg');
if ($stage == 1) {
    // print_r($_POST);exit();
    
    
    $desc1 =  str_replace("'", "&#39;", $_POST['desc1']);
    $desc2 = str_replace("'", "&#39;", $_POST['desc2']);
    $desc3 = str_replace("'", "&#39;", $_POST['desc3']);
    $desc4 = str_replace("'", "&#39;", $_POST['desc4']);
    $alt_txt = $connect->real_escape_string($_POST['alt_txt']);
    $title_txt = $connect->real_escape_string($_POST['title_txt']);
    $copyright_txt = $connect->real_escape_string($_POST['copyright_txt']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $email = $connect->real_escape_string($_POST['email']);

    if ($_FILES['image']['name'] != "") {
        $filenamenew = $_FILES['image']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_footer_area.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../upload_page_images";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $img = $img_name;
            $path3 = "../upload_page_images";
            $delpath1 = $path3 . "/" . $_POST['T2'];
            @unlink($delpath1);
        }
    }else {
        $img = trim($_POST['T2']);
    }
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_footer_area.php;";
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
    
    if ($recaptcha->score = 0.5) {
     db_query("TRUNCATE TABLE `footer_area`");

    $mysql = "Insert into footer_area set desc1='$desc1',desc2='$desc2',desc3='$desc3',desc4='$desc4',image='$img',alt_txt='$alt_txt',title_txt='$title_txt',copyright_txt='$copyright_txt',phone='$phone',email='$email'";
    
    $query = db_query($mysql);
    $msg = "Data Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_footer_area.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_footer_area.php';";
        print "</script>";
    }

}
$sql = db_query("select * from footer_area ");
$row = mysqli_fetch_array($sql);

$desc1 = $row['desc1'];
$desc2 = $row['desc2'];
$desc3 = $row['desc3'];
$desc4 = $row['desc4'];
$image = $row['image'];
$alt_txt = $row['alt_txt'];
$title_txt = $row['title_txt'];
$copyright_txt = $row['copyright_txt'];
$phone = $row['phone'];
$email = $row['email'];
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
          <h2>Footer Area Management</h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
                    <form name="pwd" method="POST" action="" onSubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="stage" value="1">
            <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                      
            
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Footer Description 1</label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="desc1" id="description"><?php print $desc1; ?></textarea>
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Footer Description 2</label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="desc2" id="description"><?php print $desc2; ?></textarea>
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Footer Description 3</label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="desc3" id="description"><?php print $desc3; ?></textarea>
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Footer Description 4</label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="desc4" id="description"><?php print $desc4; ?></textarea>
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Upload Footer Image</label>
                        <div class="col-sm-6">
                          <input type="file" class="form-control" name="image" value="">
              <span style="color: red">Please Upload image of jpeg ,gif & png format.Image Size (130px X 47px)</span>
                          <?php
                            if ($image != "") { ?>
                            <br><img src="../upload_page_images/<?php print $image; ?>" style="height: 100px;" />   
              <input type="hidden" name="T2" value="<?php print $image; ?>">
                            <?php } ?>
                            
                         

                        </div>
                       
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Alt Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $alt_txt; ?>" class="form-control" name="alt_txt" placeholder="Enter Alt Text" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Title Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title_txt; ?>" class="form-control" name="title_txt" placeholder="Enter Title  Text" required>
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Copyright Text</label>
                        <div class="col-sm-6">
                          <textarea class="form-control" name="copyright_txt" placeholder="Enter Copyright Text" required><?php print $copyright_txt; ?></textarea>
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Top Bar Phone</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $phone; ?>" class="form-control" name="phone" placeholder="Enter phone" required>
                        </div>
            </div>
              <div class="form-group row" style="display:none;">
                        <label class="col-sm-12 form-control-label">Top Bar Email</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $email; ?>" class="form-control" name="email" placeholder="Enter Email" required>
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
