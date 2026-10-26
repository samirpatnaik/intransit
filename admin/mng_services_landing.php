<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "services";

$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }

$maxsize = 10485760;
$allowed_extensions = array('gif', 'jpg','jpeg', 'png','bmp', 'GIF', 'JPG', 'PNG', 'JPEG','BMP');
$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {

    $heading =  $connect->real_escape_string(trim($_POST['heading']));
    $description = str_replace("'", "&#39;", $_POST['description']);
    $metatitle = $connect->real_escape_string(trim($_POST['metatitle']));
    $metadescription = $connect->real_escape_string(trim($_POST['metadescription']));
   $metakeywords  = str_replace("'", "&#39;", $_POST['metakeywords']);
    $moretags  = str_replace("'", "&#39;", $_POST['moretags']);
    $page_url = $connect->real_escape_string(chageURL($_POST['page_url']));
    $link_name = $connect->real_escape_string(trim($_POST['link_name']));
    $language   = $connect->real_escape_string($_POST['language']);



    $bannersql  = db_query("select * from `service_landing` where language='".$language."'");
    $bannerrow  = mysqli_num_rows($bannersql);
    if($bannerrow > 0){
        $sql = "update service_landing set heading='".$heading."', description='".$description."', metatitle='".$metatitle."', metadescription='".$metadescription."', metakeywords='".$metakeywords."', moretags='".$moretags."', page_url='".$page_url."', link_name='".$link_name."' where language = '".$language."'";
        db_query($sql);

     
        
    }else{
        $sql = "insert into service_landing set heading='".$heading."', description='".$description."', metatitle='".$metatitle."', metadescription='".$metadescription."', metakeywords='".$metakeywords."', moretags='".$moretags."', page_url='".$page_url."', link_name='".$link_name."', language = '".$language."'";
        db_query($sql);
       
    }

    include("pagemanipulate.php");

    $msg = "Service Landing Page Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_services_landing.php?language=$language';";
    print "</script>";
    exit;
}


$sql = "select * from service_landing where language = '".$language."'";
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
    self.location = "mng_services_landing.php?language="+val;
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
          <h2>Manage Services Landing Page Content</h2>
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
                        <label class="col-sm-12 form-control-label">Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $heading; ?>" class="form-control" name="heading" placeholder="Enter Heading" >
                        </div>
            </div>

               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Description </label>
                        <div class="col-sm-6">
                       <textarea class="form-control" id="description" name="description" ><?php print $description;?></textarea>
                        </div>
            </div>

             <div class="form-group row">
                      <div class="col-sm-12">
                        <h3>Manage SEO - Meta Tags</h3>
                      </div>
                  </div>
                 <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Meta Title</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $metatitle; ?>" class="form-control" name="metatitle" placeholder="Enter Meta Title" >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Meta Description</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php print $metadescription;?>" name="metadescription" placeholder="Enter Meta Description"  >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Meta Keywords</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php print $metakeywords;?>" name="metakeywords" placeholder="Enter Meta Keywords" >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Link Name</label>
                        <div class="col-sm-6">
                             <input type="text" value="<?php print $link_name; ?>" class="form-control" name="link_name" placeholder="Enter Link Name" >
                        </div>
            </div>
                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Page URL</label>
                        <div class="col-sm-6">
                             <input type="text" value="<?php print $page_url; ?>" class="form-control" name="page_url" placeholder="Enter URL" >
                        </div>
            </div>
              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Additional Meta Tags (if any)</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="moretags" ><?php print $moretags;?></textarea>
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
