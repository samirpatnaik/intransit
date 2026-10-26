<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "pages";


$stage = $connect->real_escape_string(@$_POST['stage']);
$maxsize = 10485760;
$allowed_extensions = array('jpeg', 'jpg','png');
if ($stage == 1) {
    // print_r($_POST);exit();
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
	$msg = "Please check the captcha form.";
	setcookie("msg", $msg, time() + 3);
	print "<script>";
	print "self.location = 'mng_menu.php;";
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
    db_query("TRUNCATE TABLE `mng_menu`");

    for($j=1; $j<=6; $j++){
    $item1 = $connect->real_escape_string($_POST['item'.$j]);
    $submenu_cnt1 = $connect->real_escape_string($_POST['submenu_cnt'.$j]);
    
	if($item1=='About Us'){ $page_type='1';}
    elseif($item1=='Services'){ $page_type='2';}
    elseif($item1=='Industries'){ $page_type='3'; }
    elseif($item1=='Line Card'){ $page_type='4'; }
	elseif($item1=='News'){ $page_type='5'; }
	elseif($item1=='Products'){ $page_type='6'; }
	else{ $page_type='7'; }

    if($page_type=='7'){
     $page_id = $item1;
     $sql = db_query("select link_name from mng_pages where id='$item1'");
     $res = mysqli_fetch_array($sql);
     $link_name=$res['link_name'];
    }else{
     $page_id	=	'0';
     $link_name	=	$item1;
    }

    $mysql = "Insert into mng_menu set position='item$j',type='parent',name='$link_name',page_type='$page_type',page_id='$page_id',parent=''";

    $query = db_query($mysql);

	for($i=1;$i<$submenu_cnt1;$i++){
     if(isset($_POST['item'.$j.'submenu'.$i])){
     $submenu = $connect->real_escape_string($_POST['item'.$j.'submenu'.$i]);

     if($submenu=='About Us'){ $subpage_type='1'; }
     elseif($submenu=='Services'){ $subpage_type='2'; }
     elseif($submenu=='Industries'){ $subpage_type='3';}
     elseif($submenu=='Line Card'){ $subpage_type='4';}
     elseif($submenu=='News'){ $subpage_type='5';}
     elseif($submenu=='Products'){ $subpage_type='6';}
     else{ $subpage_type='7'; }

     if($subpage_type=='7'){
		$subpage_id=$submenu;
		$sql = db_query("select link_name from mng_pages where id='$submenu'");
		$res = mysqli_fetch_array($sql);
		$sublink_name=$res['link_name'];
     }else{
		$subpage_id = '0';
		$sublink_name = $submenu;
     }
	 
     $mysql = "Insert into mng_menu set position='item$j',type='child',name='$sublink_name',page_type='$subpage_type',page_id='$subpage_id',parent='$item1'";
     $query = db_query($mysql);
    }
  }
}

    $msg = "Menu Updated Successfully.";
    setcookie("msg", $msg, time() + 3);
		print "<script>";
		print "self.location = 'mng_menu.php';";
		print "</script>";
		exit;
    }else{
        $msg = "Please check the captcha.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_menu.php';";
        print "</script>";
    }
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
          <h2>Manage Menu</h2>
          <?php if (@$_COOKIE['msg']) { ?>
			<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
			<?php print $_COOKIE['msg']; ?>
			</div>
		  <?php } ?>
      
		<div class="col-md-12">
		<div class="member_list">
		<form name="pwd" method="POST" action="mng_menu.php" onSubmit="return validate();" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="stage" value="1">
            <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
            <?php
            for($i=1;$i<=6;$i++){
            $sql = db_query("select name from mng_menu where position='item$i' and type='parent'");
            $row = mysqli_fetch_array($sql);
            $parent_name = $row['name'];
            ?>
            <div class="form-group row">
              <label class="col-sm-12 form-control-label">Item <?php echo $i;?></label>
              <div class="col-sm-6">
<select class="form-control" name="item<?php echo $i;?>" >
<option value="" selected>Select Page</option>
<option <?php if($parent_name=="About Us"){ print 'selected'; }?>>About Us</option>
<option <?php if($parent_name=="Products"){ print 'selected'; }?>>Products</option>
<option <?php if($parent_name=="Services"){ print 'selected'; }?>>Services</option>
<option <?php if($parent_name=="Industries"){ print 'selected'; }?>>Industries</option>
<option <?php if($parent_name=="Line Card"){ print 'selected'; }?>>Line Card</option>
<option <?php if($parent_name=="News"){ print 'selected'; }?>>News</option>				
<?php
$sql = db_query("select * from mng_pages");
while($res = mysqli_fetch_array($sql)){
?>
<option value="<?php echo $res['id'];?>" <?php if($res['link_name']==$parent_name){ print "selected"; }?>><?php print $res['link_name'];?></option>
<?php } ?>

</select>


<?php
$sql = db_query("select count(0) cnt from mng_menu where position='item$i' and type='child'");
$row = mysqli_fetch_array($sql);
$cnt = $row['cnt'];
$cnt++;
?>
<input type="hidden" id="submenu_cnt<?php echo $i;?>" name="submenu_cnt<?php echo $i;?>" value="<?php echo $cnt;?>">
</div>
<div class="col-sm-6"><a href="javascript:void(0)" class="btn btn-primary" onclick="set_submenu1('<?php echo $i;?>')">Add Submenu</a></div>
<div class="col-sm-12" id="submenu_list<?php echo $i;?>">
<?php
 $val=1;
 $sql = db_query("select * from mng_menu where position='item$i' and type='child'");
 while($row = mysqli_fetch_array($sql)){
 $child_name = $row['name'];
 ?>
 <div id="item<?php echo $i;?>submenu_div<?php echo $val;?>" style="margin-bottom:10px;">
 <br>
 <div class="col-sm-4">
 <select class="form-control" name="item<?php echo $i;?>submenu<?php echo $val;?>" >
<option value="" selected>Select Page</option>
<option <?php if($child_name=="About Us"){ print 'selected'; }?>>About Us</option>
<option <?php if($child_name=="Products"){ print 'selected'; }?>>Products</option>
<option <?php if($child_name=="Services"){ print 'selected'; }?>>Services</option>
<option <?php if($child_name=="Industries"){ print 'selected'; }?>>Industries</option>
<option <?php if($child_name=="Line Card"){ print 'selected'; }?>>Line Card</option>
<option <?php if($child_name=="News"){ print 'selected'; }?>>News</option>				
<?php
$sql2 = db_query("select * from mng_pages");
while($res2 = mysqli_fetch_array($sql2)){
?>
<option value="<?php echo $res2['id'];?>" <?php if($res2['link_name']==$child_name){ print "selected"; }?>>
<?php echo $res2['link_name'];?></option>
<?php } ?>
</select>
<input type="hidden" id="submenu_cnt1" value="0">
</div>
<div class="col-sm-4"><a href="javascript:void(0)" class="btn btn-danger" onclick="delete_submenu1('item<?php echo $i;?>','<?php echo $val;?>')">X</a></div>
<br>
</div>
<?php
 $val++;
 }
?>
</div>
</div>
<?php } ?>
<div class="form-group row">
  <div class="col-sm-offset-4 col-sm-10">
	<button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>
</form>
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
function set_submenu1(menu_id){
val=$("#submenu_cnt"+menu_id).val();
  $.ajax({
	type:'post',
		 url:'submenu_data.php',
		 data:{"val":val,"menu":"item"+menu_id},
		 success:function(data){
			//$("#submenu_list"+menu_id).html($("#submenu_list"+menu_id).html()+data);
			$("#submenu_list"+menu_id).append(data);
			$("#submenu_cnt"+menu_id).val(parseInt(val)+1);
		 }
  });
}
function delete_submenu1(menu,val){
 $("#"+menu+"submenu_div"+val).html("");
}
</script>

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
