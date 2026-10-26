<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "newpwd";

$stage = $connect->real_escape_string($_POST['stage']);

if ($stage == 1) {
    $uname = $connect->real_escape_string($_POST['uname']);
    $oldpwd = $connect->real_escape_string($_POST['T2']);
    $newpwd = $connect->real_escape_string($_POST['T3']);

    $mysql = "select pwd from admin_login where uname='" . $uname . "'";
    $query = db_query($mysql);
    $row = mysqli_fetch_row($query);

    if ($connect->real_escape_string(trim($row[0])) != $oldpwd) {

        $msg = "Invalid Old Password, Please Try Again.";
		setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location ='changepassword.php';";
        print "</script>";
    } else {

        $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'changepassword.php;";
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
    
    if ($recaptcha->score = 0.5) {
        $strsql1 = "update admin_login set pwd='" . $newpwd . "' where uname = '" . $uname . "'";
        $result2 = db_query($strsql1);

        $msg = "Password changed successfully.";
		setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'changepassword.php';";
        print "</script>";
        }else{
        $msg = "Please check the captcha.";
         setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'changepassword.php';";
        print "</script>";
    }
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
<SCRIPT language="JavaScript">
	function validate(){
		if (document.pwd.T2.value == "") {
			alert("Enter Your Old Password.");
			document.pwd.T2.focus();
			return false;
		}
		if (document.pwd.T3.value == "") {
			alert("Enter Your New Password.");
			document.pwd.T3.focus();
			return false;
		}
		if (document.pwd.T4.value == "") {
			alert("Retype Your New Password.");
			document.pwd.T4.focus();
			return false;

		}
		if (document.pwd.T3.value != "" && document.pwd.T4.value != "")
		{
			if (document.pwd.T3.value != document.pwd.T4.value)
			{
				alert("New Password Mismatched.");
				document.pwd.T4.focus(); 
				return false;
			}
		}
	}
</SCRIPT>

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
        	<h2 >Change Password</h2>
            <?php if ($_COOKIE['msg']) { ?>
				<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
				<strong>Notification!</strong> <?php print $_COOKIE['msg']; ?>
				</div>
			<?php } ?>
			
			<div class="wbox1" style="padding-top:25px;"> 
                    <form name="pwd" method="POST" action="" onSubmit="return validate();" enctype="multipart/form-data">
					  <input type="hidden" name="stage" value="1">
					  <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                      <div class="form-group row">
                        <label class="col-sm-12 form-control-label">User Name</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="uname" placeholder="Enter User Name" value="<?php print $_SESSION['nm']; ?>" required readonly>
                        </div>
                      </div>
					  
					  
					   <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Old Password</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name="T2" placeholder="Enter Old Password" required>
                        </div>
                      </div>
					  
					  <div class="form-group row">
                        <label class="col-sm-12 form-control-label">New Password</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name="T3" placeholder="Enter New Password" required>
                        </div>
                      </div>
					  
					  <div class="form-group row">
                        <label class="col-sm-12 form-control-label">Re Enter New Password</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name="T4" placeholder="Enter New Password Again" required>
                        </div>
                      </div>

                     <!--   <div class="form-group row">

                          
                            <img src="captcha.php" class="pull-left" style="margin-left:15px;"> &nbsp;
                            <div style="width:447px;display:inline-block;">
                            <input type="text" class="form-control" placeholder="Enter Text" name="vercode">
                            </div>
                        </div> -->
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
