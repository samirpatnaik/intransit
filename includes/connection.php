<?php
error_reporting(0);
//global $connection;
function db_connect() {
    static $connection;
    $username   = "root";
    $password   = "";
    $dbname     = "intransi_intransit";
    $host       = "localhost";

    if(!isset($connection)) {
        $connection = mysqli_connect($host,$username,$password,$dbname);
    }
    if($connection === false) {
        return mysqli_connect_error();
    }
    return $connection;
}

function db_query($query) {
    $connection = db_connect();
    $result = mysqli_query($connection,$query);
    return $result;
}

function db_error() {
    $connection = db_connect();
    return mysqli_error($connection);
}

$connect = db_connect();

@session_start();
set_time_limit(0);

function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}
define('SITEURL', siteURL());


// define('SITEURL', $sspath);

define('ADMINEMAIL', 'debasis@thoughtmedia.com');

include 'pagination.inc.php';
include 'functions.php';
?>
