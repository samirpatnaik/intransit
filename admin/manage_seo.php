<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "mseo";

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


$language = $connect->real_escape_string(trim($_GET['language']));

if($language=="") {$language = "en"; }

$cpage = $connect->real_escape_string(trim($_GET['page']));



$stage  = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {
  
  $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
  //print $captcha;
  
  if(!$captcha){
    $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'manage_seo.php;";
        print "</script>";
        exit;
  }
  
  // Build POST request:
    $recaptcha_url    = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret   = $secretKey;
    $recaptcha_response = $connect->real_escape_string($_POST['recaptchaResponse']);

    // Make and decode POST request:
    //$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = url_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);  
    $recaptcha = json_decode($recaptcha);
$recaptcha->score = 1;
  if ($recaptcha->score = 0.5) {
  
  $language   = $connect->real_escape_string(trim($_POST['language']));
  $metatitle  = $connect->real_escape_string(trim($_POST['meta_title']));
  $metadescription = $connect->real_escape_string(trim($_POST['meta_desc']));
  $metakeywords = $connect->real_escape_string(trim($_POST['keywords']));
  $moretags   = str_replace("'", "&#39;", $_POST['meta_tags']);
  $linkname   = $connect->real_escape_string(trim($_POST['link_name']));
  $pageurl    = $connect->real_escape_string(chageURL($_POST['page_url']));
  $cpage      = $connect->real_escape_string(chageURL($_POST['cpage']));
  
    $query = db_query("select * from `all_seo` where `language`='".$language."' and cpage='".$cpage."'");
  $result = mysqli_num_rows($query);
  
  
  if($result > 0){
  $sql = "update all_seo set meta_title='".$metatitle."',meta_desc='".$metadescription."', keywords='".$metakeywords."', meta_tags='".$moretags."', link_name='".$linkname."', page_url='".$pageurl."' where language='".$language."' and cpage ='".$cpage."' ";
    db_query($sql);
  }else{  
    $sql = "insert into all_seo set meta_title='".$metatitle."',meta_desc='".$metadescription."',keywords='".$metakeywords."',meta_tags='".$moretags."',link_name='".$linkname."',page_url='".$pageurl."',language='".$language."',cpage ='".$cpage."'";

    db_query($sql);
  }
  include("pagemanipulate.php");
  
    $msg = "Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'manage_seo.php?language=$language&page=$cpage';";
    print "</script>";
    exit;
}else{
    $msg = "Please check the captcha.";
    print "<script>";
        print "self.location = 'manage_seo.php';";
        print "</script>";
  }
}

/*SELECT Content*/

$sql = "select * from all_seo where language='".$language."' and cpage='".$cpage."'";
$res = mysqli_fetch_assoc(db_query($sql));
@extract($res);


if($cpage == "landing-page"){
  $pagetitle = "landing-page";
}
else if($cpage == "parts-search"){
  $pagetitle = "parts-search";
}
else if($cpage == "product-detail"){
  $pagetitle = "product-detail";
}
else if($cpage == "request-quote"){
  $pagetitle = "request-quote";
}
else if($cpage == "request-quote"){
  $pagetitle = "request-quote";
}
else if($cpage == "news"){
  $pagetitle = "news";
}
else if($cpage == "manufacturer"){
  $pagetitle = "Manufacturer";
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
  cpage = $("#cpage").val();
  self.location = 'manage_seo.php?language='+val+'&page='+cpage;
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
          <h2>Manage SEO - <?php print $pagetitle; ?></h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
                    <form name="cms" method="POST" action="" onSubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
          
                      <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                      <input type="hidden" name="stage" value="2">
                    
                        

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
                        <label class="col-sm-12 form-control-label">Meta Title</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $res['meta_title'] ; ?>" class="form-control" name="meta_title" placeholder="Enter Meta Title" >

                         <input type="hidden" class="form-control" value="<?php print $cpage;?>" name="cpage" id="cpage">
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Meta Description</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php print $res['meta_desc'];?>" name="meta_desc" placeholder="Enter Meta Description"  >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Meta Keywords</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php print $res['keywords'];?>" name="keywords" placeholder="Enter Meta Keywords" >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Link Name</label>
                        <div class="col-sm-6">
                             <input type="text" value="<?php print $res['link_name']; ?>" class="form-control" name="link_name" placeholder="Enter Link Name" >
                        </div>
            </div>
                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Page URL</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php print $res['page_url'];?>" name="page_url" />
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Additional Meta Tags (if any)</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="meta_tags" ><?php print $res['meta_tags'];?></textarea>
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
