<?php
session_start();
include("../includes/connection.php");


if (isset($_SESSION['nm'])):
    header("location:dashboard.php");
endif;

$act = $connect->real_escape_string(@$_GET['act']);
// print $act;
// print $_SESSION["vercode"] ;
if ($act == 1) {
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
    //print $captcha;
    
    if(!$captcha){
        $msg = "Please check the captcha form.";
        print "<script>";
        print "self.location = 'index.php?strmsg=$msg';";
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
    
    
    $username = $connect->real_escape_string($_POST['uname']);
    $password = $connect->real_escape_string(trim($_POST['pwd']));
    // print $username.''.$password;exit();
    $sql = db_query("select * from admin_login where uname='$username' && pwd='$password'");
    $res = mysqli_fetch_object($sql);  
    $co= mysqli_num_rows($sql);
    // print $connect->real_escape_string(trim($res->pwd)) ;exit(); 
    if (mysqli_num_rows($sql))
     {
        if ($res->uname == $username && $connect->real_escape_string(trim($res->pwd)) == $password) 
        {
            
            if ($_POST["vercode"] != $_SESSION["vercode"] or $_SESSION["vercode"] == '')
             {
                $str = "Sorry, Incorrect verification code.";
                //header("location:index.php?strmsg=$str");
                print "<script>";
                print "self.location = 'index.php?strmsg=$str';";
                print "</script>";
                exit;
            } else {
                
                    
                $restime = mysqli_fetch_array(db_query("SELECT * FROM chk_session WHERE ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'"));
                $entertime = strtotime($restime['atime']);
                $now = strtotime(date('Y-m-d H:i:s'));
                $remaintime = round(abs($now - $entertime) / 60, 2);

                if ($restime['no_of_attempts'] > 4) {
                    if (($remaintime > 60)) {
                        db_query("DELETE FROM chk_session WHERE ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'");
                        $_SESSION['nm'] = $res->uname;


                        if ($res->user_type == "super") {
                            $_SESSION['admin_type'] = $res->user_type;
                            $_SESSION['admin_id'] = $res->id;
                            $_SESSION['admin_status'] = $res->admin_status;
                        } else {
                            $_SESSION['admin_type'] = $res->user_type;
                            $_SESSION['user_id'] = $res->id;
                            $_SESSION['admin_status'] = $res->admin_status;
                            $insert_logsql = "insert into mng_subadmin_sessionlogs set 
                                            id_admin='" . $res->id . "',
                                            admin_name='" . str_replace("'", "&#39;", $res->uname) . "',    
                                            login_time=NOW(),
                                            session_id='" . $sessid . "',    
                                            ip='" . $_SERVER['REMOTE_ADDR'] . "'    
                                            ";
                            db_query($insert_logsql);
                        }



                        //header("location:dashboard.php");
                        print "<script>";
                        print "self.location = 'dashboard.php';";
                        print "</script>";
                        exit;
                        exit;
                    } else {
                        $msg = "Please try after 60 mins";
                        print "<script>";
                        print "self.location = 'index.php?strmsg=$msg';";
                        print "</script>";
                    }
                } else {
                    db_query("DELETE FROM chk_session WHERE ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'");
                    $_SESSION['nm'] = $res->uname;
                    if ($res->user_type == "super") {
                        $_SESSION['admin_type'] = $res->user_type;
                        $_SESSION['admin_id'] = $res->id;
                        $_SESSION['admin_status'] = $res->admin_status;
                    } else {
                        $_SESSION['admin_type'] = $res->user_type;
                        $_SESSION['user_id'] = $res->id;
                        $_SESSION['admin_status'] = $res->admin_status;
                        $insert_logsql = "insert into mng_subadmin_sessionlogs set 
                                            id_admin='" . $res->id . "',
                                            admin_name='" . str_replace("'", "&#39;", $res->uname) . "',    
                                            login_time=NOW(),
                                            session_id='" . $sessid . "',    
                                            ip='" . $_SERVER['REMOTE_ADDR'] . "'    
                                            ";
                        db_query($insert_logsql);
                    }
                    //header("location:dashboard.php");
                    print "<script>";
                    print "self.location = 'dashboard.php';";
                    print "</script>";
                    exit;
                }
            }
        } else {
            $msg = "Invalid UserName/Password.";
            $extractip = db_query("select * from chk_session where ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'") or die("ERROR" . mysqli_error());
            $fetchip = mysqli_fetch_array($extractip);
            if ($fetchip['no_of_attempts'] != 5) {
                if (mysqli_num_rows($extractip) == 0) {
                    $insertchk = db_query("INSERT INTO chk_session SET no_of_attempts=1,ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'");
                } else {
                    $no_of_attempts = $fetchip['no_of_attempts'] + 1;
                    $updatechk = db_query("UPDATE chk_session SET atime=now(),no_of_attempts=" . $no_of_attempts . " WHERE ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'");
                }
                $msg = "Invalid UserName/Password, " . (5 - $fetchip['no_of_attempts']) . " attempt(s) left";
            } else {
                //$updatechk=db_query("UPDATE chk_session SET status=0 WHERE ip_addr='".$_SERVER['REMOTE_ADDR']."'");
                $msg = "Please try after 60 mins";
            }
            print "<script>";
            print "self.location = 'index.php?strmsg=$msg';";
            print "</script>";
        }
    } else {
        $extractip = db_query("select * from chk_session where ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'") or die("ERROR" . mysqli_error());
        $fetchip = mysqli_fetch_array($extractip);
        if ($fetchip['no_of_attempts'] != 5) {
            if (mysqli_num_rows($extractip) == 0) {
                $insertchk = db_query("INSERT INTO chk_session SET no_of_attempts=1,ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'");
            } else {
                $no_of_attempts = $fetchip['no_of_attempts'] + 1;
                $updatechk = db_query("UPDATE chk_session SET atime=now(),no_of_attempts=" . $no_of_attempts . " WHERE ip_addr='" . $_SERVER['REMOTE_ADDR'] . "'");
            }
            $msg = "Invalid UserName/Password, " . (4 - $fetchip['no_of_attempts']) . " attempt(s) left";
        } else {
            //$updatechk=db_query("UPDATE chk_session SET status=0 WHERE ip_addr='".$_SERVER['REMOTE_ADDR']."'");
            $msg = "Please try after 60 mins";
        }
        //print_r($extractip);exit; 
        print "<script>";
        print "self.location = 'index.php?strmsg=$msg';";
        print "</script>";
    }
    }else{
        $msg = "Please check the captcha.";
        print "<script>";
        print "self.location = 'index.php?strmsg=$msg';";
        print "</script>";
    }
}

?>
<!DOCTYPE HTML>
<!--[if lt IE 9]><html class="lt-ie9"><![endif]-->
<!--[if gt IE 9]><html><![endif]-->
<!--[if !IE]>-->
<html>
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
    <title>Intransit || Admin</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
   <?php include_once('css.php');?>
</head>

<body id="body" style="background:#fff !important;">
    <section>
        <div class="container">
            <div style="margin:8% auto 0; max-width:600px; width:100%;">
                <div class="text-center margin-bottom-20"><img src="images/logo.png"></div>
                <div class="text-center"><img src="images/login_bg.png"></div>
                <div class="text-center" style="margin:10px 0 15px 0; font-size:20px; color:#02549f; text-transform:uppercase;">Admin Login</div>
                <div class="login_page">
                    <?php if (isset($_GET['strmsg'])) { ?><center><span style="color:red;"><?php echo $_GET['strmsg']; ?></span></center><?php } ?>
                    <form action="index.php?act=1" method="post" name="form1">
                        <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                        <div class="input-group margin-bottom-20">
                            <input type="text" class="form-control" placeholder="Username" name="uname" required>
                        </div>
                        <div class="input-group margin-bottom-20">
                            <input type="password" class="form-control" placeholder="Password" name="pwd" required="">
                        </div>
                        <div class="input-group margin-bottom-20">
                            <img src="captcha.php" style="margin-right:15px;">
                            <!-- <img src="images/cms_login_11.png" style="margin-right:15px;"> -->
                            <input type="text" class="form-control" placeholder="Enter Text" name="vercode">
                        </div>
                        <div class="clearfix margin-bottom-20">
                            <div class="btn-group text-center">
                                <button class="btn btn_login"  type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </section>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php print $sitekey; ?>"></script>
<script>
grecaptcha.ready(function () {
    grecaptcha.execute('<?php print $sitekey; ?>',{action:'login'}).then(function(token){
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
    });
});
</script>
</body>

</html>