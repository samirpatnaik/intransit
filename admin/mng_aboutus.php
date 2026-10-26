<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "pages";

$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }

$maxsize = 10485760;
$allowed_extensions = array('gif', 'jpg','jpeg', 'png','bmp', 'GIF', 'JPG', 'PNG', 'JPEG','BMP');
$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {

    $heading_1 =  $connect->real_escape_string(trim($_POST['heading_1']));
    $description_1 = str_replace("'", "&#39;", $_POST['description_1']);
    $title_txt_1  = $connect->real_escape_string($_POST['title_txt_1']);
    $alt_txt_1    = $connect->real_escape_string($_POST['alt_txt_1']);
    $heading_2 =  $connect->real_escape_string(trim($_POST['heading_2']));
    $description_2 = str_replace("'", "&#39;", $_POST['description_2']);
    $btn_txt_1 = $connect->real_escape_string(trim($_POST['btn_txt_1']));
    $btn_link_1 = $connect->real_escape_string(trim($_POST['btn_link_1']));
    $title_txt_2  = $connect->real_escape_string($_POST['title_txt_2']);
    $alt_txt_2    = $connect->real_escape_string($_POST['alt_txt_2']);
    $heading_3 =  $connect->real_escape_string(trim($_POST['heading_3']));
    $description_3 = str_replace("'", "&#39;", $_POST['description_3']);
    $btn_txt_2 = $connect->real_escape_string(trim($_POST['btn_txt_2']));
    $btn_link_2 = $connect->real_escape_string(trim($_POST['btn_link_2']));
    $metatitle = $connect->real_escape_string(trim($_POST['metatitle']));
    $metadescription = $connect->real_escape_string(trim($_POST['metadescription']));
   $metakeywords  = str_replace("'", "&#39;", $_POST['metakeywords']);
    $moretags  = str_replace("'", "&#39;", $_POST['moretags']);
    $page_url = $connect->real_escape_string(chageURL($_POST['page_url']));
    $link_name = $connect->real_escape_string(trim($_POST['link_name']));
    $language   = $connect->real_escape_string($_POST['language']);

  if ($_FILES['image_1']['name'] != "") {
        $filenamenew = $_FILES['image_1']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrect file extension.');
            $msg = "Incorrect file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'mng_aboutus.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../upload_page_images";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image_1']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image_1']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img1 = trim($realname);
           
            $path3 = "../upload_page_images";
            $delpath1 = $path3 . "/" . $_POST['T2'];
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
            print "self.location = 'mng_aboutus.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "../upload_page_images";
            $s1 = rand();
            $realname = removeSpchar($_FILES['image_2']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['image_2']['tmp_name'],$dest);
            // copy($_FILES['image']['tmp_name'], $dest);
            $img2 = trim($realname);
           
            $path3 = "../upload_page_images";
            $delpath1 = $path3 . "/" . $_POST['T3'];
            @unlink($delpath1);
        }
    }else {
        $img2 = trim($_POST['T3']);
    }
    
    
    $bannersql  = db_query("select * from `mng_aboutus` where language='".$language."'");
    $bannerrow  = mysqli_num_rows($bannersql);
    if($bannerrow > 0){
        $sql = "update mng_aboutus set heading_1='".$heading_1."', description_1='".$description_1."', image_1='".$img1."', alt_txt_1='".$alt_txt_1."', title_txt_1='".$title_txt_1."', heading_2='".$heading_2."', description_2='".$description_2."', btn_txt_1='".$btn_txt_1."', btn_link_1='".$btn_link_1."', image_2='".$img2."', alt_txt_2='".$alt_txt_2."', title_txt_2='".$title_txt_2."', heading_3='".$heading_3."', description_3='".$description_3."', btn_txt_2='".$btn_txt_2."', btn_link_2='".$btn_link_2."', metatitle='".$metatitle."', metadescription='".$metadescription."', metakeywords='".$metakeywords."', moretags='".$moretags."', page_url='".$page_url."', link_name='".$link_name."' where language = '".$language."'";
        db_query($sql);
      
     
        
    }else{
        $sql = "insert into mng_aboutus set heading_1='".$heading_1."', description_1='".$description_1."', image_1='".$img1."', alt_txt_1='".$alt_txt_1."', title_txt_1='".$title_txt_1."', heading_2='".$heading_2."', description_2='".$description_2."', btn_txt_1='".$btn_txt_1."', btn_link_1='".$btn_link_1."', image_2='".$img2."', alt_txt_2='".$alt_txt_2."', title_txt_2='".$title_txt_2."', heading_3='".$heading_3."', description_3='".$description_3."', btn_txt_2='".$btn_txt_2."', btn_link_2='".$btn_link_2."', metatitle='".$metatitle."', metadescription='".$metadescription."', metakeywords='".$metakeywords."', moretags='".$moretags."', page_url='".$page_url."', link_name='".$link_name."', language = '".$language."'";
        db_query($sql);
       
    }

    include("pagemanipulate.php");

    $msg = "About Us Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_aboutus.php?language=$language';";
    print "</script>";
    exit;
}


$sql = "select * from mng_aboutus where language = '".$language."'";
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
    self.location = "mng_aboutus.php?language="+val;
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
          <h2>Manage About Us Page Content</h2>
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
                        <label class="col-sm-12 form-control-label">Section 1 Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $heading_1; ?>" class="form-control" name="heading_1" placeholder="Enter Heading" >
                        </div>
            </div>

               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 1 Description </label>
                        <div class="col-sm-6">
                       <textarea class="form-control" id="description" name="description_1" ><?php print $description_1;?></textarea>
                        </div>
            </div>

                  <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 2 Image Upload</label>
                        <div class="col-sm-6">
                          <input type="file" class="form-control" name="image_1" value="">
              <span style="color: red">&nbsp;Size : (690px X 520px)</span>
                    
                         <?php
                         $img1 = $res['image_1'];
                            if ($img1 != "") {?>
                            <br><img src="../upload_page_images/<?php print $img1; ?>" style="height: 100px;" />   
              <input type="hidden" name="T2" value="<?php print $img1;?>">
                         <?php }?>
 
                        </div>
           
 
            </div>

                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Alt Text </label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $alt_txt_1; ?>" class="form-control" name="alt_txt_1" placeholder="Enter Alt Text" >
                        </div>
            </div>

            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Title Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title_txt_1; ?>" class="form-control" name="title_txt_1" placeholder="Enter Title Text" >
                        </div>
            </div>

              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 2 Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $heading_2; ?>" class="form-control" name="heading_2" placeholder="Enter Heading" >
                        </div>
            </div>

             <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 2 Description</label>
                        <div class="col-sm-6">
                         <textarea class="form-control" id="description" name="description_2" ><?php print $description_2;?></textarea>
                        </div>
            </div>
        
                 <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 2 Button Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $btn_txt_1; ?>" class="form-control" name="btn_txt_1" placeholder="Enter Button Text" >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 2 Button Link</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $btn_link_1; ?>" class="form-control" name="btn_link_1" placeholder="Enter Button Link" >
                        </div>
            </div>
                     <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 3 Image Upload</label>
                        <div class="col-sm-6">
                          <input type="file" class="form-control" name="image_2" value="">
              <span style="color: red">&nbsp;Size : (690px X 520px)</span>
                  <?php
                   $img2 = $res['image_2'];
                            if ($img2 != "") { ?>
                            <br><img src="../upload_page_images/<?php print $img2; ?>" style="height: 100px;" />   
              <input type="hidden" name="T3" value="<?php print $img2;?>">
                            <?php } ?>
 
                        </div>
                       
            </div>
             <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Alt Text </label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $alt_txt_2; ?>" class="form-control" name="alt_txt_2" placeholder="Enter Alt Text" >
                        </div>
            </div>

            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Title Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $title_txt_2; ?>" class="form-control" name="title_txt_2" placeholder="Enter Title Text" >
                        </div>
            </div>

              <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 3 Heading</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $heading_3; ?>" class="form-control" name="heading_3" placeholder="Enter Heading" >
                        </div>
            </div>

             <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 3 Description</label>
                        <div class="col-sm-6">
                         <textarea class="form-control" id="description" name="description_3" ><?php print $description_3;?></textarea>
                        </div>
            </div>
        
                 <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 3 Button Text</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $btn_txt_2; ?>" class="form-control" name="btn_txt_2" placeholder="Enter Button Text" >
                        </div>
            </div>
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Section 3 Button Link</label>
                        <div class="col-sm-6">
                          <input type="text" value="<?php print $btn_link_2; ?>" class="form-control" name="btn_link_2" placeholder="Enter Button Link" >
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
