<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "quoterequest";

$language = $connect->real_escape_string(trim($_GET['language']));
if($language=="") {$language = "en"; }

$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 2){
    $text =  $connect->real_escape_string(trim($_POST['text']));
    db_query("insert into `needby` set `text`='".$text."'");

    $msg = "Need By Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_needby.php';";
    print "</script>";
    exit;
}

if ($stage == 3){
    $id =  $connect->real_escape_string(trim($_POST['id']));
    $text =  $connect->real_escape_string(trim($_POST['text']));
    db_query("UPDATE `needby` set `text`='".$text."' where id='".$id."'");

    $msg = "Need By Added Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_needby.php';";
    print "</script>";
    exit;
}

$delid =  $connect->real_escape_string(trim($_GET['delid']));
if($delid){
	db_query("DELETE from needby WHERE id='".$delid."'");
}


$id =  $connect->real_escape_string(trim($_GET['id']));
if($id){
$sql = "select text from needby where id = '".$id."'";
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

<script>
function chnageLang(val){
    self.location = "mng_quote_landing.php?language="+val;
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
          <h2>Manage Quote Page Need By</h2>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
			<form name="pwd" method="POST" action="" enctype="multipart/form-data" autocomplete="off">

			  <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
			  <input type="hidden" name="stage" value="2">
			  <?php if($id){ ?>
			  <input type="hidden" name="stage" value="3">
			  <input type="hidden" name="id" value="<?php print $id;?>">
			  <?php } ?>
                    

			<div class="form-group row">
			<label class="col-sm-12 form-control-label">Need By</label>
			<div class="col-sm-6">
			  <input type="text" value="<?php print $text; ?>" class="form-control" name="text" placeholder="Enter Need By Text" required>
			</div>
            </div>


            <div class="form-group row">
              <div class="col-sm-offset-2 col-sm-10">
              
                 <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            </form>
                      
             <div class="clearfix"></div>    
        </div>

		<div class="col-md-6">
		
		<div class="member_list">
			<table class="table d-flex flex-direction-row">
			  <thead>
				<tr>
				<th width="10%">#</th>
				<th width="80%">Text</th>
				  <th>&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$c =0;
					$query  = db_query("SELECT * FROM needby order by id "); 
					while($resuser = mysqli_fetch_array($query)){
					$c++;
						
				?>
				<tr>
				  <td>
					<?php echo $c; ?>
				  </td>
				  <td><?php print $resuser['text'];?></td>
				  <td>
				  <a href="mng_needby.php?id=<?php print $resuser['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				  <a href="?delid=<?php print $resuser['id']; ?>" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				  </td>
				</tr>
			   <?php
				}
			   ?>
			  </tbody>
			</table> 
		</div> 
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
