<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "industries";

$alphabet = $connect->real_escape_string(trim($_GET['alphabet']));
if($alphabet=="") {$alphabet = "A"; }

$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {

  
    $industries_desc = str_replace("'", "&#39;", $_POST['industries_desc']);
    $metatitle = $connect->real_escape_string(trim($_POST['metatitle']));
    $metadescription = $connect->real_escape_string(trim($_POST['metadescription']));
   $metakeywords  = str_replace("'", "&#39;", $_POST['metakeywords']);
    $moretags  = str_replace("'", "&#39;", $_POST['moretags']);
    $page_url = $connect->real_escape_string(chageURL($_POST['page_url']));
    $link_name = $connect->real_escape_string(trim($_POST['link_name']));
    $alphabet   = $connect->real_escape_string($_POST['alphabet']);



    $bannersql  = db_query("select * from `mng_industries` where alphabet='".$alphabet."'");
    $bannerrow  = mysqli_num_rows($bannersql);
    if($bannerrow > 0){
        $sql = "update mng_industries set industries_desc='".$industries_desc."' where alphabet = '".$alphabet."'";
        db_query($sql);

     
        
    }else{
        $sql = "insert into mng_industries set industries_desc='".$industries_desc."', alphabet = '".$alphabet."'";
        db_query($sql);
       
    }


    $msg = "Industries Page Content Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_industries.php?alphabet=$alphabet';";
    print "</script>";
    exit;
}


$sql = "select * from mng_industries where alphabet = '".$alphabet."'";
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
    self.location = "mng_industries.php?alphabet="+val;
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
          <h2>Manage Industries Page Content</h2>
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
                    
                        <input type="hidden" name="alphabet" value="<?php print $alphabet; ?>">

              <div class="form-group row">
              <label class="col-sm-12 form-control-label">Select Alphabet</label>
              <div class="col-sm-6">
          <select name="alphabet" class="form-control" onchange="chnageLang(this.value)">
                                <?php 
                                $lsql = db_query("select * from mng_alphabet order by alphabet");
                                while($lrow = mysqli_fetch_array($lsql)){
                                    
                                ?>
                                <option value="<?php print $lrow['alphabet'];?>" <?php if($alphabet==$lrow['alphabet']){ print "selected"; }?>><?php print $lrow['alphabet'];?></option>
                                <?php } ?>
                            </select>
              </div>
            </div>

        
                <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Industries Content </label>
                        <div class="col-sm-6">
                       <textarea class="form-control" id="description" name="industries_desc" ><?php print $industries_desc;?></textarea>
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
