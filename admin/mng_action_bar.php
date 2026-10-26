<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "actionbar";

$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }


$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2) {

	$language 	= $connect->real_escape_string($_POST['language']);
    $text 		= str_replace("'","&#39;",$_POST['content']);
    $barcolor 	= $connect->real_escape_string($_POST['barcolor']);
    $status 	= $connect->real_escape_string($_POST['status']);

    $bannersql  = db_query("select * from `action_bar` where language='".$language."'");
    $bannerrow  = mysqli_num_rows($bannersql);
    if($bannerrow > 0){
        $sql = "UPDATE action_bar set content='$text', barcolor='$barcolor', status='$status' where language='$language'";
        db_query($sql);
    }else{
        $sql = "INSERT into action_bar set content='$text', barcolor='$barcolor', status='$status',language='$language'";
        db_query($sql);
    }

    include("pagemanipulate.php");

    $msg = "Action Bar Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_action_bar.php?language=$language';";
    print "</script>";
    exit;
}


$sql = "select * from action_bar where language = '".$language."'";
$res = mysqli_fetch_assoc(db_query($sql));
@extract($res);

$status = $res['status']; 



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
    self.location = "mng_action_bar.php?language="+val;
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
          <h2>Action Bar Management</h2>
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
                        <label class="col-sm-12 form-control-label">Enter Text</label>
                        <div class="col-sm-6">
                          <textarea type="text" id="detail" class="form-control" name="content" placeholder="Enter Heading" required><?php print $res['content']; ?></textarea>
                        </div>
			   </div>
				
               <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Bar BG Color</label>
                        <div class="col-sm-6">
                          <input type="color" value="<?php print $res['barcolor']; ?>" class="form-control2" name="barcolor" placeholder="Enter Color" required />
                        </div>
			   </div>				
				
            <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Click To Show/Hide </label>
                        <div class="col-sm-6">
                         <input type="radio" name="status" value="Active" 
                         <?php 
                           if($res['status'] == 'Active'){
                              echo "checked";
                           } ?> > Show 
                         &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="status" value="Inactive"
                          
                            <?php 
                           if($res['status'] == 'Inactive'){
                              echo "checked";
                           }
                         ?> > Hide
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
