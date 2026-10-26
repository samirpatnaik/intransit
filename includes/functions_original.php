<?php
$secretKey   = "6LeUR-0UAAAAADjkDBcpdU_ovEJfVrDv6Dz3jAE3"; 
$sitekey     = "6LeUR-0UAAAAAOhdwU6lYrin5QAylWfTPxlTNs-W";
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
} 
function word_limiter($str, $limit = 100, $end_char = '&#8230;') {
    if (trim($str) == '') {
        return $str;
    }
    preg_match('/^\s*+(?:\S++\s*+){1,' . (int) $limit . '}/', trim(strip_tags($str)), $matches);
    if (strlen($str) == strlen($matches[0])) {
        $end_char = '';
    }
    return rtrim($matches[0]) . $end_char;
}
function removeSpchar($str) {
    $str = str_replace("%", "-", $str);
    $str = str_replace("#", "-", $str);
    $str = str_replace("!", "-", $str);
    $str = str_replace("@", "-", $str);
    $str = str_replace("^", "-", $str);
    $str = str_replace("*", "-", $str);
    $str = preg_replace('/\s\&+/', '-', $str);
    $str = preg_replace("/\s/", "-", $str);
    $str = preg_replace('/\-\-+/', '-', $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "-", $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "_", $str);
    $str = str_replace("_", "-", $str);
    $str = str_replace("&", "-", $str);
    $str = str_replace("'", "-", $str);
    $str = preg_replace('/\-\-+/', '-', $str);
    $str = rtrim($str, '-');
    return $str;
}
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
function short_str5($str, $len, $cut = true) {
    if (strlen($str) <= $len)
        return $str;
    return ( $cut ? substr($str, 0, $len) : substr($str, 0, strrpos(substr($str, 0, $len), ' ')) ) . '...';
}

function getLnt($zip){
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=
    ".urlencode($zip)."&sensor=false";
    $result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
    $result1[]=$result['results'][0];
    $result2[]=$result1[0]['geometry'];
    $result3[]=$result2[0]['location'];
    return $result3[0];
}

function priceChange($val){
    $price =  number_format($val, 2, '.', ',');
    return $price;
}

function timeAgo($time_ago){
$cur_time   = time();
$time_elapsed   = $cur_time - $time_ago;
$seconds    = $time_elapsed ;
$minutes    = round($time_elapsed / 60 );
$hours      = round($time_elapsed / 3600);
$days       = round($time_elapsed / 86400 );
$weeks      = round($time_elapsed / 604800);
$months     = round($time_elapsed / 2600640 );
$years      = round($time_elapsed / 31207680 );
// Seconds
if($seconds <= 60){
    echo "$seconds seconds ago";
}
//Minutes
else if($minutes <=60){
    if($minutes==1){
        echo "one minute ago";
    }
    else{
        echo "$minutes minutes ago";
    }
}
//Hours
else if($hours <=24){
    if($hours==1){
        echo "an hour ago";
    }else{
        echo "$hours hours ago";
    }
}
//Days
else if($days <= 7){
    if($days==1){
        echo "yesterday";
    }else{
        echo "$days days ago";
    }
}
//Weeks
else if($weeks <= 4.3){
    if($weeks==1){
        echo "a week ago";
    }else{
        echo "$weeks weeks ago";
    }
}
//Months
else if($months <=12){
    if($months==1){
        echo "a month ago";
    }else{
        echo "$months months ago";
    }
}
//Years
else{
    if($years==1){
        echo "one year ago";
    }else{
        echo "$years years ago";
    }
}
}


function myfilsSize($file, $type){
    $filesize = filesize($file);
    $fs = formatSizeUnits($filesize);
    return $fs;
}



function filter_inputs($data){
    $filter = trim(strip_tags($data));
    return $filter;
}

function commentCount($id){
    $sql = db_query("select id from comment where status='1' and news_id=".$id);
    $row = mysqli_num_rows($sql);
    return $row;
}



include 'recaptchalib.php';

// your secret key
$secret = "6LeObBAUAAAAAJJPwR4q_7iXDbk2aS-F0YleP5_N";
// empty response
$response = null;
// check secret key
$reCaptcha = new ReCaptcha($secret);


?>