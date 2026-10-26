<?php
include("../includes/connection.php");
session_start();
if (isset($_SESSION['nm'])):
    /*if ($_SESSION['admin_type'] != "super") {
        $upd_logsql = "update  mng_subadmin_sessionlogs set 
		 logout_time=NOW(),
                session_id='" . $sessid . "',    
                ip='" . $_SERVER['REMOTE_ADDR'] . "'
                 where 	session_id ='{$sessid}' and id_admin={$_SESSION['user_id']}    
                ";
        mysql_query($upd_logsql);
    }*/
    session_regenerate_id();
    unset($_SESSION['admin_id]']);
    unset($_SESSION['admin_type]']);
    unset($_SESSION['nm]']);
    session_unset();
endif;
print "<script>";
$msg = "You have logged out  successfully.";
print "self.location='index.php?strmsg=$msg';";
print "</script>";
?>
