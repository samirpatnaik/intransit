<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "pages";


$stage = $connect->real_escape_string($_POST['stage']);
$allowed_extensions = array('gif', 'jpg','jpeg', 'png','bmp', 'GIF', 'JPG', 'PNG', 'JPEG','BMP');

if ($stage == 2) {
	
	if ($_FILES['bannerimage']['name'] != "") {
        $filenamenew = $_FILES['bannerimage']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrent file extension.');
            $msg = "Incorrent file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'aboutusbanner.php';";
            print "</script>";
            exit;
        } else {

            $path2 = "../banner";
            $s1 = rand();
            $realname = removeSpchar($_FILES['bannerimage']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            copy($_FILES['bannerimage']['tmp_name'], $dest);
            $bannerimage = trim($realname);
            $path3 = "../banner";
            $delpath1 = $path3 . "/" . $_POST['T2'];
            @unlink($delpath1);
        }
    } else {
        $bannerimage = $connect->real_escape_string(trim($_POST['T2']));
    }

	$bannertext = str_replace("'", "&#39;", $_POST['bannertext']);
	$page 		= $connect->real_escape_string(trim($_POST['page']));
	$title_txt 	= $connect->real_escape_string($_POST['title_txt']);
    $alt_txt 	= $connect->real_escape_string($_POST['alt_txt']);
	
	$content  	= str_replace("'", "&#39;", $_POST['content']);
	
	$metatitle 	= $connect->real_escape_string(trim($_POST['metatitle']));
	$metadescription = $connect->real_escape_string(trim($_POST['metadescription']));
	$metakeywords = $connect->real_escape_string(trim($_POST['metakeywords']));
	$moretags  	= str_replace("'", "&#39;", $_POST['moretags']);
	$page_url 	= $connect->real_escape_string(chageURL($_POST['page_url']));
	$link_name 	= $connect->real_escape_string($_POST['link_name']);
	$language 	= $connect->real_escape_string($_POST['language']);
	
    $sql = "insert into mng_pages set bannerimage='".$bannerimage."', bannertext='".$bannertext."', title_txt='".$title_txt."', alt_txt='".$alt_txt."', content='".$content."', metatitle='".$metatitle."',metadescription='".$metadescription."', metakeywords='".$metakeywords."', moretags='".$moretags."', page_url='".$page_url."',link_name='".$link_name."',language='".$language."'";
    db_query($sql);
	
	include("pagemanipulate.php");
	
    $msg = "Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_pages.php';";
    print "</script>";
    exit;
}

if ($stage == 3) {
	
	if ($_FILES['bannerimage']['name'] != "") {
        $filenamenew = $_FILES['bannerimage']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            //die('File #'.$i.': Incorrent file extension.');
            $msg = "Incorrent file extension, Please upload a valid image file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'aboutusbanner.php';";
            print "</script>";
            exit;
        } else {

            $path2 = "../banner";
            $s1 = rand();
            $realname = removeSpchar($_FILES['bannerimage']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            copy($_FILES['bannerimage']['tmp_name'], $dest);
            $bannerimage = trim($realname);
            $path3 = "../banner";
            $delpath1 = $path3 . "/" . $_POST['T2'];
            @unlink($delpath1);
        }
    } else {
        $bannerimage = $connect->real_escape_string(trim($_POST['T2']));
    }

	$bannertext = str_replace("'", "&#39;", $_POST['bannertext']);
	$page 		= $connect->real_escape_string(trim($_POST['page']));
	$title_txt 	= $connect->real_escape_string($_POST['title_txt']);
    $alt_txt 	= $connect->real_escape_string($_POST['alt_txt']);
    $id 		= $connect->real_escape_string($_POST['id']);
	
	$content  	= str_replace("'", "&#39;", $_POST['content']);
	
	$metatitle 	= $connect->real_escape_string(trim($_POST['metatitle']));
	$metadescription = $connect->real_escape_string(trim($_POST['metadescription']));
	$metakeywords = $connect->real_escape_string(trim($_POST['metakeywords']));
	$moretags  	= str_replace("'", "&#39;", $_POST['moretags']);
	$page_url 	= $connect->real_escape_string(chageURL($_POST['page_url']));
	$link_name 	= $connect->real_escape_string($_POST['link_name']);
	$language 	= $connect->real_escape_string($_POST['language']);
	
    $sql = "update mng_pages set bannerimage='".$bannerimage."', bannertext='".$bannertext."', title_txt='".$title_txt."', alt_txt='".$alt_txt."', content='".$content."', metatitle='".$metatitle."',metadescription='".$metadescription."', metakeywords='".$metakeywords."', moretags='".$moretags."', page_url='".$page_url."',link_name='".$link_name."',language='".$language."' where id='".$id."'";
    db_query($sql);
	
	include("pagemanipulate.php");
	
    $msg = "Content updated Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_pages.php';";
    print "</script>";
    exit;
}



$id = $connect->real_escape_string($_GET['id']);
if($id){
$sql = "select * from mng_pages where id='".$id."'";
$res = mysqli_fetch_assoc(db_query($sql));
@extract($res);
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
          <h2>Manage Pages</h2>
		  <a href="mng_pages.php" class="btn btn-primary pull-right">Back</a>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
		<div class="col-md-12">
            	<form name="ofc_form" method="POST" action="" enctype="multipart/form-data">

                  <input type="hidden" name="stage" value="2">
				  <?php if($id){ ?>
                  <input type="hidden" name="stage" value="3">
                  <input type="hidden" name="id" value="<?php print $id; ?>">
				  <?php } ?>
				  
				  <div class="form-row">
				  <div class="form-group col-md-6">
				  <label>Select language</label>
				  <select name="language" class="form-control">
						<?php 
						$lsql = db_query("select * from mng_language order by language");
						while($lrow = mysqli_fetch_array($lsql)){
							
						?>
						<option value="<?php print $lrow['lcode'];?>" <?php if($language==$lrow['lcode']){ print "selected"; }?>><?php print $lrow['language'];?></option>
						<?php } ?>
					</select>
				  </div>
				  
				</div>
				  <div class="clearfix"></div>
				  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Banner Image</label>
                      <input type="file" class="form-control" id="bannerimage" name="bannerimage" placeholder="Banner">
					   <b><font color="red">&nbsp;Size : (1920px X 500px)</font></b>
                    </div>
                  </div>
				  <?php if ($bannerimage != "") { ?>
				   <div class="clearfix"></div>
				  <div class="form-row">
                      <div class="form-group col-md-6">
                      <img src="../banner/<?php print $bannerimage; ?>" class="img-responsive" />  
                      </div>
                  </div>
				  <?php } ?>
				  <input type="hidden" name="T2" value="<?php print $bannerimage; ?>">
				  <div class="clearfix"></div>
 				  <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputAddress">Alt Text</label>
                        <input type="text" name="alt_txt" value="<?php print $alt_txt?>" class="form-control" placeholder="Enter Alt Text">
                      </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputAddress">Title Text</label>
                        <input type="text" name="title_txt" value="<?php print $title_txt?>" class="form-control" placeholder="Enter Title Text">
                      </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputAddress">Banner Text</label>
						<textarea class="form-control" id="bannertext" name="bannertext" ><?php print $bannertext?></textarea>
                      </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Content</label>
                      <textarea class="form-control" id="detail" name="content" ><?php print $content;?></textarea>
                    </div>
                  </div>
				  
				  <div class="form-row">
                      <div class="form-group col-md-12">
                        <h3>Manage SEO - Meta Tags</h3>
                      </div>
                  </div>
				  
				  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputAddress">Meta Title</label>
						<input type="text" class="form-control" value="<?php print $metatitle;?>" name="metatitle" required>
						
                      </div>
                  </div>
				  
				  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputAddress">Meta Description</label>
						<input type="text" class="form-control" value="<?php print $metadescription;?>" name="metadescription" required>
						
                      </div>
                  </div>
				  
				  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputAddress">Keywords</label>
						<input type="text" class="form-control" value="<?php print $metakeywords;?>" name="metakeywords" >
						
                      </div>
                  </div>
				  
				  <div class="form-row">                        
                        <div class="form-group col-md-12">
                          <label for="inputAddress">Link Name</label>
                          <input type="text" value="<?php print $link_name; ?>" class="form-control" name="link_name" placeholder="Link Name" required>
                        </div>
				</div>
				  
				  <div class="form-row">                        
                        <div class="form-group col-md-12">
                          <label for="inputAddress">Page URL</label>
                          <input type="text" value="<?php print $page_url; ?>" class="form-control" name="page_url" placeholder="Enter Page Name / URL" required>
                        </div>
				</div>
				
				
				  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="inputAddress">Additional Meta Tags (if any)</label>
						<textarea class="form-control" name="moretags" ><?php print $moretags;?></textarea>
                      </div>
                  </div>
				  
				  
                  <div class="form-row">
                      <div class="form-group col-md-12"><button type="submit" class="btn btn-primary">Submit</button></div>
                  </div>
                </form>
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
