<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "banner";

$pg     = $connect->real_escape_string($_GET['page']);

if($pg =="aboutbanner"){
    $heading = "Manage About Page Banner";
}
if($pg =="newsbanner"){
    $heading = "Manage News Page Banner";
}
if($pg =="categorybanner"){
    $heading = "Manage Category Page Banner";
}
if($pg =="globalsourcingbanner"){
    $heading = "Manage Global Sourcing Page Banner";
}
if($pg =="industriesbanner"){
    $heading = "Manage Industries Page Banner";
}
if($pg =="linecardbanner"){
    $heading = "Manage LineCard Page Banner";
}
if($pg =="partsearchbanner"){
    $heading = "Manage PartSearch Page Banner";
}
if($pg =="productdetailsbanner"){
    $heading = "Manage Product Detail Page Banner";
}
if($pg =="qualitybanner"){
    $heading = "Manage Quality Page Banner";
}
if($pg =="requestquotebanner"){
    $heading = "Manage Request Quote Page Banner";
}
if($pg =="inventarybanner"){
    $heading = "Manage Sell Excess Inventary Page Banner";
}
if($pg =="servicesbanner"){
    $heading = "Manage Services Page Banner";
}
if($pg =="manufacturer"){
    $heading = "Manage Manufacturer Page Banner";
}


$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }

$maxsize = 10485760;
$allowed_extensions = array('gif', 'jpg','jpeg', 'png','bmp', 'GIF', 'JPG', 'PNG', 'JPEG','BMP');
$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {
   
    $description = str_replace("'", "&#39;", $_POST['description']);
    $page       = $connect->real_escape_string(trim($_POST['page']));
    $title_txt  = $connect->real_escape_string($_POST['title_txt']);
    $alt_txt    = $connect->real_escape_string($_POST['alt_txt']);
    $language   = $connect->real_escape_string($_POST['language']);

  if ($_FILES['image']['name'] != "") {
        $filenamenew = $_FILES['image']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_request_quote.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../banner";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img_name = trim($realname);
            $image = $img_name;
            $path3 = "../banner";
            $delpath1 = $path3 . "/" . $_POST['T2'];
            @unlink($delpath1);
        }
    }else {
        $image = trim($_POST['T2']);
    }
    
    
    $bannersql  = db_query("select * from `mng_inner_banner` where page='".$page."' and language='".$language."'");
    $bannerrow  = mysqli_num_rows($bannersql);
    if($bannerrow > 0){
        $sql = "update mng_inner_banner set image='".$image."', description='".$description."', title_txt='".$title_txt."', alt_txt='".$alt_txt."' where page='".$page."' and language = '".$language."'";
        db_query($sql);
        
    }else{
        $sql = "insert into mng_inner_banner set image='".$image."', description='".$description."', page='".$page."', title_txt='".$title_txt."', alt_txt='".$alt_txt."', language = '".$language."'";
        db_query($sql);
    }
    $msg = "Banner Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_inner_banners.php?page=$page&language=$language';";
    print "</script>";
    exit;
}

/*SELECT BANNER*/
$sql = "select * from mng_inner_banner where page='".$pg."' and language='".$language."'";
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


<script>
     

function chnageLang(val){
    self.location = "mng_inner_banners.php?language="+val+"&page=<?php print $pg; ?>";
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
          <h2><?php print $heading; ?></h2>
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
                        <input type="hidden" name="page" value="<?php print $pg; ?>">
                        <input type="hidden" name="language" value="<?php print $language; ?>">

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
                        <label class="col-sm-12 form-control-label">Banner Image</label>
                        <div class="col-sm-6">
                          <input type="file" class="form-control" name="image" value="">
              <span style="color: red">Please Upload image of jpeg ,gif & png format.Image Size : (1920px X 500px)</span>
                       <?php
                            if ($image != "") { ?>
                            <br><img src="../banner/<?php print $image; ?>" style="height: 100px;" />   
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
                        <label class="col-sm-12 form-control-label">Heading Description </label>
                        <div class="col-sm-6">
                       <textarea class="form-control" id="description" name="description" ><?php print $description;?></textarea>
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
