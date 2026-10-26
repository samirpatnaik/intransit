<?php
session_start();
//include("../includes/connection.php");
$text = '';
$text .= rand(1000, 9999);
$_SESSION["vercode"] = $text;

$height = 40;
$width = 60;

$image_p = imagecreate($width, $height);
$black = imagecolorallocate($image_p, 71, 71, 71);
$white = imagecolorallocate($image_p, 255, 255, 255);
$font_size = 20;
imagestring($image_p, $font_size, 15, 10, $text, $white);
imagejpeg($image_p, null, 80);
?>