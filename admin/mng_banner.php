<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "home";
$language = $connect->real_escape_string(trim($_GET['language']));

$stage = $connect->real_escape_string(@$_POST['stage']);
$maxsize = 10485760;
$allowed_extensions = array('jpeg', 'jpg','png');
$allowed_extensions1 = array('mp4');
$id = $connect->real_escape_string(filter_inputs($_GET['id']));


if($language=="") {$language = "en"; }

if ($stage == 2) {
    $language 	= $connect->real_escape_string($_POST['language']);
    $title 		= $connect->real_escape_string($_POST['title']);
    $description= $connect->real_escape_string($_POST['description']);
    $alt_txt 	= $connect->real_escape_string($_POST['alt_txt']);
    $title_txt 	= $connect->real_escape_string($_POST['title_txt']);
    $btn_txt 	= $connect->real_escape_string($_POST['btn_txt']);
    $btn_link 	= $connect->real_escape_string($_POST['btn_link']);
    $sort_order = $connect->real_escape_string($_POST['sort_order']);
    $btype 		= $connect->real_escape_string($_POST['btype']);

    if ($_FILES['image']['name'] != "") {
        $filenamenew = $_FILES['image']['name'];
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
	
	if ($_FILES['video']['name'] != "") {
        $filenamenew = $_FILES['video']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions1);

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
            $realname = removeSpchar($_FILES['video']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['video']['tmp_name'],$dest);
            $img_name = trim($realname);
            $video = $img_name;
            $path3 = "../uploadimages";
            $delpath1 = $path3 . "/" . $_POST['T3'];
            @unlink($delpath1);
        }
    }else {
        $video = trim($_POST['T3']);
    }
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_list_banner.php;";
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
    $mysql = "Insert into banner set title='$title', description='$description', image='$img', alt_txt='$alt_txt', title_txt='$title_txt', language='$language', btn_txt='$btn_txt', btype='$btype', video='$video', sort_order='$sort_order'";
    // $mysql = "Insert into about set uname='$uname' ,desig='$desig',title='$title',description='$description'";
    $query = db_query($mysql);
    $msg = "Data Inserted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_list_banner.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_list_banner.php';";
        print "</script>";
    }
}
if ($stage == 3) {
    $language 	= $connect->real_escape_string($_POST['language']);
    $title 		= $connect->real_escape_string($_POST['title']);
    $description= $connect->real_escape_string($_POST['description']);
    $alt_txt 	= $connect->real_escape_string($_POST['alt_txt']);
    $title_txt 	= $connect->real_escape_string($_POST['title_txt']);
    $btn_txt 	= $connect->real_escape_string($_POST['btn_txt']);
    $btn_link 	= $connect->real_escape_string($_POST['btn_link']);
    $sort_order = $connect->real_escape_string($_POST['sort_order']);
    $btype 		= $connect->real_escape_string($_POST['btype']);

    if ($_FILES['image']['name'] != "") {
        $filenamenew = $_FILES['image']['name'];
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
	
	if ($_FILES['video']['name'] != "") {
        $filenamenew = $_FILES['video']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions1);

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
            $realname = removeSpchar($_FILES['video']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['video']['tmp_name'],$dest);
            $img_name = trim($realname);
            $video = $img_name;
            $path3 = "../uploadimages";
            $delpath1 = $path3 . "/" . $_POST['T3'];
            @unlink($delpath1);
        }
    }else {
        $video = trim($_POST['T3']);
    }
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_list_banner.php;";
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
    $mysql = "UPDATE banner set title='$title',description='$description',image='$img',alt_txt='$alt_txt',title_txt='$title_txt',btn_txt='$btn_txt',btn_link='$btn_link', language='$language', btype='$btype', video='$video', sort_order='$sort_order' where id='$id'";
    // print $mysql;exit();
    $query = db_query($mysql);
    $msg = "Data Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_list_banner.php';";
    print "</script>";
    exit;
    }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_list_banner.php';";
        print "</script>";
    }
    
}
if($language){
$sql = db_query("select * from `banner` where id='$id'");
$row 	= mysqli_fetch_array($sql);
$image 	= $row['image'];
$title 	= $row['title'];
$details = $row['description'];

$alt_txt = $row['alt_txt'];
$title_txt = $row['title_txt'];
$lan 	= $row['language'];
$btn_txt = $row['btn_txt'];
$btn_link = $row['btn_link'];
$sort_order = $row['sort_order'];
$btype = $row['btype'];
$video = $row['video'];
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

<!-- <script type="text/javascript">
function chnageLang(val){
    self.location = "mng_banner.php?language="+val+"&id=<?php print $id; ?>";
}
</script> -->
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
          <h2>Banner Management</h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <strong>Notification!</strong> <?php print $_COOKIE['msg']; ?>
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
                 <select class="form-control" name="language"   required>
                   <option value="" selected diabled>Select language</option>
                   <?php
                   $sql = db_query("select * from mng_language order by language");
                   while($res = mysqli_fetch_array($sql)){
                   if($lan==$res['lcode']){
                   ?>
                   <option value="<?php echo $res['lcode'];?>" selected><?php echo $res['language'];?></option>
                   <?php
                   }
                   else{
                   ?>
                   <option value="<?php echo $res['lcode'];?>" ><?php echo $res['language'];?></option>
                   <?php
                   }
                   }
                   ?>
                 </select>
              </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Banner Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title; ?>" class="form-control" name="title" placeholder="Enter Title" required>
                        </div>
            </div>
			
			<div class="form-group row">
				<label class="col-sm-12 form-control-label">Banner Type</label>
				<div class="col-sm-6">
				  <input type="radio" value="image" name="btype" onclick="show('typeimg')" <?php if($btype=='image'){?> checked <?php } ?>> Image &nbsp;&nbsp;&nbsp;
				  <input type="radio" value="video" name="btype" onclick="show('typevideo')" <?php if($btype=='video'){?> checked <?php } ?>> Video
				</div>
            </div>
			<div id="typeimg" <?php if($btype=='video'){?> style="display:none;"<?php } ?>>
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
                        <label class="col-sm-12 form-control-label">Button Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $btn_txt; ?>" class="form-control" name="btn_txt" placeholder="Enter Button Text" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Button Link</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $btn_link; ?>" class="form-control" name="btn_link" placeholder="Enter Button Link" >
                        </div>
            </div>
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Content </label>
                        <div class="col-sm-6">
                          
                          <textarea class="form-control" name="description" id="description" placeholder="Enter Description"><?php print $details; ?></textarea>
                        </div>
            </div>
            </div>
			
			
			<div id="typevideo" <?php if($btype=='image'){?> style="display:none;"<?php } ?>>
            <div class="form-group row">
				<label class="col-sm-12 form-control-label">Upload Video</label>
                <div class="col-sm-6">
                <input type="file" class="form-control" name="video" value="">
				<span style="color: red">Please Upload Video of mp4 </span>
                <?php
                if ($video != "") { ?><br><?php print $video; ?>  
				<input type="hidden" name="T3" value="<?php print $video; ?>">
                <?php } ?>
				</div>
            </div>
            </div>
			
			<div class="form-group row">
				<label class="col-sm-12 form-control-label">Sort Order </label>
				<div class="col-sm-6">
				<input type="text" value="<?php print $sort_order; ?>" class="form-control" name="sort_order" placeholder="Sort Order" onkeypress="return /[0-9]/i.test(event.key)" required>
				</div>
            </div>

            
            <div class="form-group row">
              <div class="col-sm-offset-4 col-sm-19">
                <a href="mng_list_banner.php"><button type="button" class="btn btn-primary">Back
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
function show(val){
	$("#typeimg").hide();
	$("#typevideo").hide();
	$("#"+val).show();
}
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
