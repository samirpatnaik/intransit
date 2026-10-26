<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "home";
$language = $connect->real_escape_string(trim($_GET['language']));
$id = $connect->real_escape_string(filter_inputs($_GET['id']));
$stage = $connect->real_escape_string(@$_POST['stage']);
$maxsize = 10485760;
$allowed_extensions = array('jpeg', 'jpg','png');

if($language=="") {$language = "en"; }

if ($stage == 2) {
 
     $alt_txt = $connect->real_escape_string($_POST['alt_txt']);
    $title_txt = $connect->real_escape_string($_POST['title_txt']);

     if ($_FILES['image']['name'] != "") {
        $filenamenew = $_FILES['image']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_brand_images.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../uploadimages";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $img = $img_name;
            $path3 = "../uploadimages";
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
        print "self.location = 'mng_brand_images_list.php;'";
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
$mysql = "Insert into brand_image set image='$img',alt_txt='$alt_txt',title_txt='$title_txt'";
    
    // $mysql = "Insert into about set uname='$uname' ,desig='$desig',title='$title',description='$description'";
    $query = db_query($mysql);
    $msg = "Data Inserted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_brand_images_list.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_images_list.php';";
        print "</script>";
    }
}
if ($stage == 3) {
    
    $alt_txt = $connect->real_escape_string($_POST['alt_txt']);
    $title_txt = $connect->real_escape_string($_POST['title_txt']);

       if ($_FILES['image']['name'] != "") {
        $filenamenew = $_FILES['image']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_brand_images.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../uploadimages";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $img = $img_name;
            $path3 = "../uploadimages";
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
        print "self.location = 'mng_brand_images_list.php;";
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
    $mysql = "UPDATE brand_image set image='$img',alt_txt='$alt_txt',title_txt='$title_txt'where id='$id'";
    // print $mysql;exit();
    $query = db_query($mysql);
    $msg = "Data Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
     print "<script>";
    print "self.location = 'mng_brand_images_list.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_images.php';";
        print "</script>";
    }
    
}
if($language){
$sql = db_query("select * from brand_image where id='$id'");
$row = mysqli_fetch_array($sql);
$image = $row['image'];
$alt_txt = $row['alt_txt'];
$title_txt = $row['title_txt'];

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
          <h2>Brand Image Management</h2>
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
                        <label class="col-sm-12 form-control-label">Upload Banner Image</label>
                        <div class="col-sm-6">
                          <input type="file" class="form-control" name="image" value="">
              <span style="color: red">Please Upload image of jpeg ,gif & png format.Image Size (1350px X 540px)</span>
                          <?php
                            if ($image != "") { ?>
                            <br><img src="../uploadimages/<?php print $image; ?>" style="height: 100px;" />   
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
                          <input type="text" value="<?php print $title_txt; ?>" class="form-control" name="title_txt" placeholder="Enter Title Text" >
                        </div>
            </div>

            
            <div class="form-group row">
             <div class="col-sm-offset-2 col-sm-19">
                <a href="mng_brand_images_list.php"><button type="button" class="btn btn-primary">Back
                </button></a>
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
