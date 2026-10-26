<?php

/*if(!isset($_SESSION['lan'])){
    $lan="en";
}
else{
    $lan=$_SESSION['lan'];
}*/

if(isset($_GET['lan'])){
$_SESSION['lan']=$_GET['lan'];
}
if(!isset($_SESSION['lan'])){
 $lan='en';
}

function googleTranslatetext($string,$to){
    $from='en';

    if($to=='en' or $to==''){
     return $string;
    }
    else{
    $sql = db_query("select * from google_key");
    $row = mysqli_fetch_array($sql);
    $apiKey = $row['lang_key'];
    $url = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='. rawurlencode($string).'&source='.$from.'&target='.$to;
    //echo $url."<br><br>";
    //die();
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    $responseDecoded = json_decode($response, true);
    curl_close($handle);
    return $responseDecoded['data']['translations'][0]['translatedText'];
    }
}

function Translatetext(){
if(!isset($_SESSION['lan'])){
    $lan=$_SESSION['lan'];
}
else{
    $lan=$_SESSION['lan'];
}
/*action bar starts*/
$sql = db_query("select * from action_bar where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from action_bar where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){
$home['action_bar']['content']  = googleTranslatetext($row['content'],$lan);
}
else{
$home['action_bar']['content']  = $row['content'];
}
/*action bar ends*/

/*Banner starts*/

$sql = db_query("select * from banner where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from banner where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){
$home['banner']['title']  = googleTranslatetext($row['title'],$lan);
$home['banner']['description']  = googleTranslatetext($row['description'],$lan);
$home['banner']['image']  = $row['image'];
$home['banner']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['banner']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
$home['banner']['btn_txt']  = googleTranslatetext($row['btn_txt'],$lan);
$home['banner']['btn_link']  = googleTranslatetext($row['btn_link'],$lan);
}
else{
$home['banner']['title']  = $row['title'];
$home['banner']['description']  = $row['description'];
$home['banner']['image']  = $row['image'];
$home['banner']['alt_txt']  = $row['alt_txt'];
$home['banner']['title_txt']  = $row['title_txt'];
$home['banner']['btn_txt'] = $row['btn_txt'];
$home['banner']['btn_link'] = $row['btn_link'];
}

/*Banner ends*/

/*Service Section starts*/

$sql = db_query("select * from our_services where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from our_services where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){
$home['our_services']['heading']  = googleTranslatetext($row['title'],$lan);
$home['our_services']['description']  = googleTranslatetext($row['description'],$lan);
$home['our_services']['image_1']  = $row['image_1'];
$home['our_services']['alt_txt_1']  = googleTranslatetext($row['alt_txt'],$lan);
$home['our_services']['title_txt_1']  = googleTranslatetext($row['title_txt'],$lan);
$home['our_services']['image_title_1']  = googleTranslatetext($row['btn_txt'],$lan);
$home['our_services']['image_desc_1']  = googleTranslatetext($row['btn_link'],$lan);
$home['our_services']['read_more_txt_1']  = googleTranslatetext($row['btn_link'],$lan);
$home['our_services']['read_more_link_1']  = googleTranslatetext($row['btn_link'],$lan);
$home['our_services']['image_2']  = $row['image_2'];
$home['our_services']['alt_txt_2']  = googleTranslatetext($row['alt_txt_2'],$lan);
$home['our_services']['title_txt_2']  = googleTranslatetext($row['title_txt_2'],$lan);
$home['our_services']['image_title_2']  = googleTranslatetext($row['image_title_2'],$lan);
$home['our_services']['image_desc_2']  = googleTranslatetext($row['image_desc_2'],$lan);
$home['our_services']['read_more_txt_2']  = googleTranslatetext($row['read_more_txt_2'],$lan);
$home['our_services']['read_more_link_2']  = googleTranslatetext($row['read_more_link_2'],$lan);
$home['our_services']['image_3']  = $row['image_3'];
$home['our_services']['alt_txt_3']  = googleTranslatetext($row['alt_txt_3'],$lan);
$home['our_services']['title_txt_3']  = googleTranslatetext($row['title_txt_3'],$lan);
$home['our_services']['image_title_3']  = googleTranslatetext($row['image_title_3'],$lan);
$home['our_services']['image_desc_3']  = googleTranslatetext($row['image_desc_3'],$lan);
$home['our_services']['read_more_txt_3']  = googleTranslatetext($row['read_more_txt_3'],$lan);
$home['our_services']['read_more_link_3']  = googleTranslatetext($row['read_more_link_3'],$lan);
}
else{
$home['our_services']['heading']  = $row['heading'];
$home['our_services']['description']  = $row['description'];
$home['our_services']['image_1']  = $row['image_1'];
$home['our_services']['alt_txt_1']  = $row['alt_txt_1'];
$home['our_services']['title_txt_1']  = $row['title_txt_1'];
$home['our_services']['image_title_1']  = $row['image_title_1'];
$home['our_services']['image_desc_1']  = $row['image_desc_1'];
$home['our_services']['read_more_txt_1']  = $row['read_more_txt_1'];
$home['our_services']['read_more_link_1']  = $row['read_more_link_1'];
$home['our_services']['image_2']  = $row['image_2'];
$home['our_services']['alt_txt_2']  = $row['alt_txt_2'];
$home['our_services']['title_txt_2']  = $row['title_txt_2'];
$home['our_services']['image_title_2']  = $row['image_title_2'];
$home['our_services']['image_desc_2']  = $row['image_desc_2'];
$home['our_services']['read_more_txt_2']  = $row['read_more_txt_2'];
$home['our_services']['read_more_link_2']  = $row['read_more_link_2'];
$home['our_services']['image_3']  = $row['image_3'];
$home['our_services']['alt_txt_3']  = $row['alt_txt_3'];
$home['our_services']['title_txt_3']  = $row['title_txt_3'];
$home['our_services']['image_title_3']  = $row['image_title_3'];
$home['our_services']['image_desc_3']  = $row['image_desc_3'];
$home['our_services']['read_more_txt_3']  = $row['read_more_txt_3'];
$home['our_services']['read_more_link_3']  = $row['read_more_link_3'];
}

/*Service Section ends*/

/*Popular manufactures and brands starts*/

$sql = db_query("select * from brand_text where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from brand_text where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['brand_text']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['brand_text']['description']  = googleTranslatetext($row['description'],$lan);
}
else{
$home['brand_text']['heading']  =  $row['heading'];
$home['brand_text']['description']  = $row['description'];

}

$sql = db_query("select * from brand_image");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from brand_image");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['brand_image']['image']  = $row['image'];
$home['brand_image']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['brand_image']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
}
else{
$home['brand_image']['image']  =  $row['image'];
$home['brand_image']['alt_txt']  = $row['alt_txt'];
$home['brand_image']['title_txt'] = $row['title_txt'];
}

/*Popular manufactures and brands ends*/

/* footer area starts*/

$sql = db_query("select * from footer_area");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from footer_area");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['footer_area']['desc1']  = googleTranslatetext($row['desc1']);
$home['footer_area']['desc2']  = googleTranslatetext($row['desc2']);
$home['footer_area']['desc3']  = googleTranslatetext($row['desc3']);
$home['footer_area']['desc4']  = googleTranslatetext($row['desc4']);
$home['footer_area']['alt_txt']  = googleTranslatetext($row['alt_txt']);
$home['footer_area']['title_txt']  = googleTranslatetext($row['title_txt']);
$home['footer_area']['copyright_txt']  = googleTranslatetext($row['copyright_txt']);
$home['footer_area']['phone']  = googleTranslatetext($row['phone']);
$home['footer_area']['email']  = googleTranslatetext($row['email']);
$home['footer_area']['image']  = $row['image'];
}
else{
$home['footer_area']['desc1']  = $row['desc1'];
$home['footer_area']['desc2']  = $row['desc2'];
$home['footer_area']['desc3']  = $row['desc3'];
$home['footer_area']['desc4']  = $row['desc4'];
$home['footer_area']['alt_txt']  = $row['alt_txt'];
$home['footer_area']['title_txt']  = $row['title_txt'];
$home['footer_area']['copyright_txt']  = $row['copyright_txt'];
$home['footer_area']['phone']  = $row['phone'];
$home['footer_area']['email']  = $row['email'];
$home['footer_area']['image']  = $row['image'];
}

/* footer area ends*/

/* manage about us starts*/


$sql = db_query("select * from mng_aboutus where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_aboutus where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['about']['heading_1']  = googleTranslatetext($row['heading_1'],$lan);
$home['about']['description_1']  = googleTranslatetext($row['description_1'],$lan);
$home['about']['image_1']  = $row['image_1'];
$home['about']['alt_txt_1']  = googleTranslatetext($row['alt_txt_1'],$lan);
$home['about']['title_txt_1']  = googleTranslatetext($row['title_txt_1'],$lan);
$home['about']['heading_2']  = googleTranslatetext($row['heading_2'],$lan);
$home['about']['description_2']  = googleTranslatetext($row['description_2'],$lan);
$home['about']['btn_txt_1']  = googleTranslatetext($row['btn_txt_1'],$lan);
$home['about']['btn_link_1']  = googleTranslatetext($row['btn_link_1'],$lan);
$home['about']['image_2']  = $row['image_2'];
$home['about']['alt_txt_2']  = googleTranslatetext($row['alt_txt_2'],$lan);
$home['about']['title_txt_2']  = googleTranslatetext($row['title_txt_2'],$lan);
$home['about']['heading_3']  = googleTranslatetext($row['heading_3'],$lan);
$home['about']['description_3']  = googleTranslatetext($row['description_3'],$lan);
$home['about']['btn_txt_2']  = googleTranslatetext($row['btn_txt_2'],$lan);
$home['about']['btn_link_2']  = googleTranslatetext($row['btn_link_2'],$lan);

}

else{
$home['about']['heading_1']  = $row['heading_1'];
$home['about']['description_1']  = $row['description_1'];
$home['about']['image_1']  = $row['image_1'];
$home['about']['alt_txt_1']  = $row['alt_txt_1'];
$home['about']['title_txt_1']  = $row['title_txt_1'];
$home['about']['heading_2']  = $row['heading_2'];
$home['about']['description_2']  = $row['description_2'];
$home['about']['btn_txt_1']  = $row['btn_txt_1'];
$home['about']['btn_link_1']  =  $row['btn_link_1'];
$home['about']['image_2']  = $row['image_2'];
$home['about']['alt_txt_2']  = $row['alt_txt_2'];
$home['about']['title_txt_2']  = $row['title_txt_2'];
$home['about']['heading_3']  = $row['heading_3'];
$home['about']['description_3']  = $row['description_3'];
$home['about']['btn_txt_2']  = $row['btn_txt_2'];
$home['about']['btn_link_2']  = $row['btn_link_2'];

}

/* manage about us ends*/

/* manage qulity starts*/


$sql = db_query("select * from mng_quality where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_quality where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['mng_quality']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['mng_quality']['description']  = googleTranslatetext($row['description'],$lan);
$home['mng_quality']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['mng_quality']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
$home['mng_quality']['image']  = $row['image'];
}
else{
$home['mng_quality']['heading']  =  $row['heading'];
$home['mng_quality']['description']  = $row['description'];
$home['mng_quality']['image']  = $row['image'];
$home['mng_quality']['alt_txt']  = $row['alt_txt'];
$home['mng_quality']['title_txt']  = $row['title_txt'];

}

/* manage qulity ends*/

/* manage line card starts*/

$sql = db_query("select * from mng_line_card where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_line_card where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['mng_line_card']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['mng_line_card']['description']  = googleTranslatetext($row['description'],$lan);
$home['mng_line_card']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['mng_line_card']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
$home['mng_line_card']['image']  = $row['image'];
}
else{
$home['mng_line_card']['heading']  =  $row['heading'];
$home['mng_line_card']['description']  = $row['description'];
$home['mng_line_card']['image']  = $row['image'];
$home['mng_line_card']['alt_txt']  = $row['alt_txt'];
$home['mng_line_card']['title_txt']  = $row['title_txt'];

}
/* manage line card ends*/

/* manage sell excess inventary starts */

$sql = db_query("select * from mng_excess_inventory where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_excess_inventory where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['sell-excess-inventary']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['sell-excess-inventary']['description']  = googleTranslatetext($row['description'],$lan);
$home['sell-excess-inventary']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['sell-excess-inventary']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
$home['sell-excess-inventary']['image']  = $row['image'];
}
else{
$home['sell-excess-inventary']['heading']  =  $row['heading'];
$home['sell-excess-inventary']['description']  = $row['description'];
$home['sell-excess-inventary']['image']  = $row['image'];
$home['sell-excess-inventary']['alt_txt']  = $row['alt_txt'];
$home['sell-excess-inventary']['title_txt']  = $row['title_txt'];

}

/* manage sell excess inventary ends */
/*manage industries starts*/

$sql = db_query("select * from industries_landing");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from industries_landing");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['industries_landing']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['industries_landing']['description']  = googleTranslatetext($row['description'],$lan);

}
else{
$home['industries_landing']['heading']  =  $row['heading'];
$home['industries_landing']['description']  = $row['description'];

}

$sql = db_query("select * from mng_industries");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_industries");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['mng_industries']['industries_desc']  = googleTranslatetext($row['industries_desc'],$lan);
$home['mng_industries']['alphabet']  = googleTranslatetext($row['alphabet'],$lan);

}
else{
$home['mng_industries']['industries_desc']  =  $row['industries_desc'];
$home['mng_industries']['alphabet']  = $row['alphabet'];

}


/*manage industries ends*/
/*contact us starts*/
$sql = db_query("select * from contact_us where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from contact_us where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['contact_us']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['contact_us']['description']  = googleTranslatetext($row['description'],$lan);
$home['contact_us']['address']  = googleTranslatetext($row['address'],$lan);
$home['contact_us']['map_code']  = googleTranslatetext($row['map_code'],$lan);
$home['contact_us']['form_heading']  = googleTranslatetext($row['form_heading'],$lan);
$home['contact_us']['email_id']  = googleTranslatetext($row['email_id'],$lan);
}
else{
$home['contact_us']['heading']  =  $row['heading'];
$home['contact_us']['description']  = $row['description'];
$home['contact_us']['address']  = $row['address'];
$home['contact_us']['map_code']  = $row['map_code'];
$home['contact_us']['form_heading']  = $row['form_heading'];
$home['contact_us']['email_id']  = $row['email_id'];

}

/*contact us ends*/
/*technical support starts*/

$sql = db_query("select * from tech_support where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from tech_support where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['tech_support']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['tech_support']['description']  = googleTranslatetext($row['description'],$lan);
$home['tech_support']['image']  = googleTranslatetext($row['image'],$lan);
$home['tech_support']['btn_txt']  = googleTranslatetext($row['btn_txt'],$lan);
$home['tech_support']['btn_link']  = googleTranslatetext($row['btn_link'],$lan);
$home['tech_support']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['tech_support']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
}
else{
$home['tech_support']['heading']  =  $row['heading'];
$home['tech_support']['description']  = $row['description'];
$home['tech_support']['image'] = $row['image'];
$home['tech_support']['btn_txt']  = $row['btn_txt'];
$home['tech_support']['btn_link']  = $row['btn_link'];
$home['tech_support']['alt_txt']  = $row['alt_txt'];
$home['tech_support']['title_txt']  = $row['title_txt'];
}

/*technical support ends*/

/*service starts*/

$sql = db_query("select * from service_landing where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from service_landing where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['service_landing']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['service_landing']['description']  = googleTranslatetext($row['description'],$lan);

}
else{
$home['service_landing']['heading']  =  $row['heading'];
$home['service_landing']['description']  = $row['description'];

}
/*service ends*/

/*service detail starts*/
$sql = db_query("select * from service_detail where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from service_detail where language='en'");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['service_detail']['heading']  = googleTranslatetext($row['heading'],$lan);
$home['service_detail']['description']  = googleTranslatetext($row['description'],$lan);
$home['service_detail']['icon_image']  =  $row['icon_image'];
$home['service_detail']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['service_detail']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
$home['service_detail']['btn_txt']  = googleTranslatetext($row['btn_txt'],$lan);
$home['service_detail']['btn_link']  = googleTranslatetext($row['btn_link'],$lan);
$home['service_detail']['banner_image']  = $row['banner_image'];
$home['service_detail']['alt_txt_1']  = googleTranslatetext($row['alt_txt_1'],$lan);
$home['service_detail']['title_txt_1']  = googleTranslatetext($row['title_txt_1'],$lan);
$home['service_detail']['banner_desc']  = googleTranslatetext($row['banner_desc'],$lan);
$home['service_detail']['heading_1']  = googleTranslatetext($row['heading_1'],$lan);
$home['service_detail']['image_1']  = $row['image_1'];
$home['service_detail']['alt_txt_2']  = googleTranslatetext($row['alt_txt_2'],$lan);
$home['service_detail']['title_txt_2']  = googleTranslatetext($row['title_txt_2'],$lan);
$home['service_detail']['detail_desc']  = googleTranslatetext($row['detail_desc'],$lan);

}
else{

$home['service_detail']['heading']  =  $row['heading'];
$home['service_detail']['description']  = $row['description'];
$home['service_detail']['icon_image']  = $row['icon_image'];
$home['service_detail']['alt_txt']  = $row['alt_txt'];
$home['service_detail']['title_txt']  = $row['title_txt'];
$home['service_detail']['btn_txt']  = $row['btn_txt'];
$home['service_detail']['btn_link'] = $row['btn_link'];
$home['service_detail']['banner_image']  = $row['banner_image'];
$home['service_detail']['alt_txt_1']  = $row['alt_txt_1'];
$home['service_detail']['title_txt_1']  = $row['title_txt_1'];
$home['service_detail']['banner_desc']  = $row['banner_desc'];
$home['service_detail']['heading_1']  = $row['heading_1'];
$home['service_detail']['image_1']  = $row['image_1'];
$home['service_detail']['alt_txt_2']  = $row['alt_txt_2'];
$home['service_detail']['title_txt_2']  = $row['title_txt_2'];
$home['service_detail']['detail_desc']  = $row['detail_desc'];
}

/*service detail ends*/

/*blog page starts*/
$sql = db_query("select * from mng_blog");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_blog");
}
$row = mysqli_fetch_array($sql);

if($numrow==0){

$home['service_detail']['image']  =  $row['image'];
$home['service_detail']['title']  = googleTranslatetext($row['title'],$lan);
$home['service_detail']['alt_txt']  = googleTranslatetext($row['alt_txt'],$lan);
$home['service_detail']['title_txt']  = googleTranslatetext($row['title_txt'],$lan);
$home['service_detail']['publish_date']  = googleTranslatetext($row['publish_date'],$lan);
$home['service_detail']['author_name']  = googleTranslatetext($row['author_name'],$lan);
$home['service_detail']['description']  = googleTranslatetext($row['description'],$lan);
}
else{

$home['service_detail']['image']  =  $row['image'];
$home['service_detail']['title']  = $row['title'];
$home['service_detail']['alt_txt']  = $row['alt_txt'];
$home['service_detail']['title_txt']  = $row['title_txt'];
$home['service_detail']['publish_date']  = $row['publish_date'];
$home['service_detail']['author_name']  = $row['author_name'];
$home['service_detail']['description']  = $row['description'];
}

/*blog page ends*/

return $home;

}
function pageSEO(){
if(!isset($_SESSION['lan'])){
    $lan=$_SESSION['lan'];
}
else{
    $lan=$_SESSION['lan'];
}
$sql = db_query("select * from all_seo where cpage='product-detail' and language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from all_seo where cpage='product-detail' and language='en'");
$row = mysqli_fetch_array($sql);
$page_seo['product-detail']['meta_title'] = googleTranslatetext($row['meta_title'],$lan);
$page_seo['product-detail']['meta_desc'] = googleTranslatetext($row['meta_desc'],$lan);
$page_seo['product-detail']['keywords'] = googleTranslatetext($row['keywords'],$lan);
$page_seo['product-detail']['meta_tags'] = googleTranslatetext($row['meta_tags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['product-detail']['meta_title'] = $row['meta_title'];
$page_seo['product-detail']['meta_desc'] = $row['meta_desc'];
$page_seo['product-detail']['keywords'] = $row['keywords'];
$page_seo['product-detail']['meta_tags'] = $row['meta_tags'];

}

$sql = db_query("select * from all_seo where cpage='parts-search' and language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from all_seo where cpage='parts-search' and language='en'");
$row = mysqli_fetch_array($sql);
$page_seo['parts-search']['meta_title'] = googleTranslatetext($row['meta_title'],$lan);
$page_seo['parts-search']['meta_desc'] = googleTranslatetext($row['meta_desc'],$lan);
$page_seo['parts-search']['keywords'] = googleTranslatetext($row['keywords'],$lan);
$page_seo['parts-search']['meta_tags'] = googleTranslatetext($row['meta_tags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['parts-search']['meta_title'] = $row['meta_title'];
$page_seo['parts-search']['meta_desc'] = $row['meta_desc'];
$page_seo['parts-search']['keywords'] = $row['keywords'];
$page_seo['parts-search']['meta_tags'] = $row['meta_tags'];

}

$sql = db_query("select * from all_seo where cpage='manufacturer' and language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from all_seo where cpage='manufacturer' and language='en'");
$row = mysqli_fetch_array($sql);
$page_seo['manufacturer']['meta_title'] = googleTranslatetext($row['meta_title'],$lan);
$page_seo['manufacturer']['meta_desc'] = googleTranslatetext($row['meta_desc'],$lan);
$page_seo['manufacturer']['keywords'] = googleTranslatetext($row['keywords'],$lan);
$page_seo['manufacturer']['meta_tags'] = googleTranslatetext($row['meta_tags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['manufacturer']['meta_title'] = $row['meta_title'];
$page_seo['manufacturer']['meta_desc'] = $row['meta_desc'];
$page_seo['manufacturer']['keywords'] = $row['keywords'];
$page_seo['manufacturer']['meta_tags'] = $row['meta_tags'];

}

$sql = db_query("select * from quote_landing where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from quote_landing where language='en'");
$row = mysqli_fetch_array($sql);
$page_seo['requestquote']['meta_title'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['requestquote']['meta_desc'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['requestquote']['keywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['requestquote']['meta_tags'] = googleTranslatetext($row['moretags'],$lan);
}
else{
$row = mysqli_fetch_array($sql);
$page_seo['requestquote']['meta_title'] = $row['metatitle'];
$page_seo['requestquote']['meta_desc'] = $row['metadescription'];
$page_seo['requestquote']['keywords'] = $row['metakeywords'];
$page_seo['requestquote']['meta_tags'] = $row['moretags'];
}

$sql = db_query("select * from all_seo where cpage='landing-page' and language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from all_seo where cpage='landing-page' and language='en'");
$row = mysqli_fetch_array($sql);
$page_seo['landing-page']['meta_title'] = googleTranslatetext($row['meta_title'],$lan);
$page_seo['landing-page']['meta_desc'] = googleTranslatetext($row['meta_desc'],$lan);
$page_seo['landing-page']['keywords'] = googleTranslatetext($row['keywords'],$lan);
$page_seo['landing-page']['meta_tags'] = googleTranslatetext($row['meta_tags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['landing-page']['meta_title'] = $row['meta_title'];
$page_seo['landing-page']['meta_desc'] = $row['meta_desc'];
$page_seo['landing-page']['keywords'] = $row['keywords'];
$page_seo['landing-page']['meta_tags'] = $row['meta_tags'];

}

$sql = db_query("select * from mng_aboutus where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_aboutus where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['about']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['about']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['about']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['about']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['about']['metatitle'] = $row['metatitle'];
$page_seo['about']['metadescription'] = $row['metadescription'];
$page_seo['about']['metakeywords'] = $row['metakeywords'];
$page_seo['about']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from mng_quality where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_quality where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['mng_quality']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['mng_quality']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['mng_quality']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['mng_quality']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['mng_quality']['metatitle'] = $row['metatitle'];
$page_seo['mng_quality']['metadescription'] = $row['metadescription'];
$page_seo['mng_quality']['metakeywords'] = $row['metakeywords'];
$page_seo['mng_quality']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from mng_line_card where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_line_card where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['line-card']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['line-card']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['line-card']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['line-card']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['line-card']['metatitle'] = $row['metatitle'];
$page_seo['line-card']['metadescription'] = $row['metadescription'];
$page_seo['line-card']['metakeywords'] = $row['metakeywords'];
$page_seo['line-card']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from mng_excess_inventory where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_excess_inventory where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['sell-excess-inventary']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['sell-excess-inventary']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['sell-excess-inventary']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['sell-excess-inventary']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['sell-excess-inventary']['metatitle'] = $row['metatitle'];
$page_seo['sell-excess-inventary']['metadescription'] = $row['metadescription'];
$page_seo['sell-excess-inventary']['metakeywords'] = $row['metakeywords'];
$page_seo['sell-excess-inventary']['moretags'] = $row['moretags'];
}


$sql = db_query("select * from privacy_policy where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from privacy_policy where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['privacy-policy']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['privacy-policy']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['privacy-policy']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['privacy-policy']['moretags'] = googleTranslatetext($row['moretags'],$lan);
$page_seo['privacy-policy']['description'] = googleTranslatetext(str_replace('../',SITEURL,$row['description']),$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['privacy-policy']['metatitle'] = $row['metatitle'];
$page_seo['privacy-policy']['metadescription'] = $row['metadescription'];
$page_seo['privacy-policy']['metakeywords'] = $row['metakeywords'];
$page_seo['privacy-policy']['moretags'] = $row['moretags'];
$page_seo['privacy-policy']['description'] = str_replace('../',SITEURL,$row['description']);
}

$sql = db_query("select * from terms_conditions where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from terms_conditions where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['terms-conditions']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['terms-conditions']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['terms-conditions']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['terms-conditions']['moretags'] = googleTranslatetext($row['moretags'],$lan);
$page_seo['terms-conditions']['description'] = googleTranslatetext(str_replace('../',SITEURL,$row['description']),$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['terms-conditions']['metatitle'] = $row['metatitle'];
$page_seo['terms-conditions']['metadescription'] = $row['metadescription'];
$page_seo['terms-conditions']['metakeywords'] = $row['metakeywords'];
$page_seo['terms-conditions']['moretags'] = $row['moretags'];
$page_seo['terms-conditions']['description'] = str_replace('../',SITEURL,$row['description']);
}

$sql = db_query("select * from industries_landing");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from industries_landing");
$row = mysqli_fetch_array($sql);
$page_seo['industries_landing']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['industries_landing']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['industries_landing']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['industries_landing']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['industries_landing']['metatitle'] = $row['metatitle'];
$page_seo['industries_landing']['metadescription'] = $row['metadescription'];
$page_seo['industries_landing']['metakeywords'] = $row['metakeywords'];
$page_seo['industries_landing']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from contact_us where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from contact_us where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['contact_us']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['contact_us']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['contact_us']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['contact_us']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['contact_us']['metatitle'] = $row['metatitle'];
$page_seo['contact_us']['metadescription'] = $row['metadescription'];
$page_seo['contact_us']['metakeywords'] = $row['metakeywords'];
$page_seo['contact_us']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from service_landing where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from service_landing where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['service_landing']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['service_landing']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['service_landing']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['service_landing']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['service_landing']['metatitle'] = $row['metatitle'];
$page_seo['service_landing']['metadescription'] = $row['metadescription'];
$page_seo['service_landing']['metakeywords'] = $row['metakeywords'];
$page_seo['service_landing']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from service_detail where language='$lan'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from service_detail where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['service_detail']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['service_detail']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['service_detail']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['service_detail']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['service_detail']['metatitle'] = $row['metatitle'];
$page_seo['service_detail']['metadescription'] = $row['metadescription'];
$page_seo['service_detail']['metakeywords'] = $row['metakeywords'];
$page_seo['service_detail']['moretags'] = $row['moretags'];
}

$sql = db_query("select * from mng_blog");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from service_detail where language='$lan'");
$row = mysqli_fetch_array($sql);
$page_seo['mng_blog']['metatitle'] = googleTranslatetext($row['metatitle'],$lan);
$page_seo['mng_blog']['metadescription'] = googleTranslatetext($row['metadescription'],$lan);
$page_seo['mng_blog']['metakeywords'] = googleTranslatetext($row['metakeywords'],$lan);
$page_seo['mng_blog']['moretags'] = googleTranslatetext($row['moretags'],$lan);

}
else{
$row = mysqli_fetch_array($sql);
$page_seo['mng_blog']['metatitle'] = $row['metatitle'];
$page_seo['mng_blog']['metadescription'] = $row['metadescription'];
$page_seo['mng_blog']['metakeywords'] = $row['metakeywords'];
$page_seo['mng_blog']['moretags'] = $row['moretags'];
}

return $page_seo;
}

function linkname(){

    if(!isset($_SESSION['lan'])){
    $lan=$_SESSION['lan'];
    }
    else{
    $lan=$_SESSION['lan'];
    }

    $sql = db_query("select link_name from all_seo where cpage='product-detail' and language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from all_seo where cpage='product-detail' and language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['product-detail'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['product-detail'] = $row['link_name'];
    }

    $sql = db_query("select link_name from all_seo where cpage='parts-search' and language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from all_seo where cpage='parts-search' and language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['parts-search'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['parts-search'] = $row['link_name'];
    }

      $sql = db_query("select link_name from quote_landing where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from quote_landing where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['request-quote'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['request-quote'] = $row['link_name'];

    }

      $sql = db_query("select link_name from all_seo where cpage='news' and language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from all_seo where cpage='news' and language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['news'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['news'] = $row['link_name'];
    }

         $sql = db_query("select link_name from mng_aboutus where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from mng_aboutus where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['About Us'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['About Us'] = $row['link_name'];
    }

            $sql = db_query("select link_name from mng_quality where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from mng_quality where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['Quality'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['Quality'] = $row['link_name'];
    }

    $sql = db_query("select link_name from mng_line_card where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from mng_line_card where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['Line Card'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['Line Card'] = $row['link_name'];
    }

      $sql = db_query("select link_name from mng_excess_inventory where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from mng_excess_inventory where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['Excess Inventary'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['Excess Inventary'] = $row['link_name'];
    }


      $sql = db_query("select link_name from privacy_policy where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from mng_excess_inventory where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['Privacy Policy'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['Privacy Policy'] = $row['link_name'];
    }


      $sql = db_query("select link_name from terms_conditions where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from terms_conditions where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['Terms&Conditions'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['Terms&Conditions'] = $row['link_name'];
    }
       $sql = db_query("select link_name from service_landing where language='$lan'");
    $numrow = mysqli_num_rows($sql);
    if($numrow==0){
    $sql = db_query("select link_name from service_landing where language='en'");
    $row = mysqli_fetch_array($sql);
    $linkname['service_landing'] = googleTranslatetext($row['link_name'],$lan);
    }
    else{
    $row = mysqli_fetch_array($sql);
    $linkname['service_landing'] = $row['link_name'];
    }

     $sql = db_query("select link_name from industries_landing");

    $row = mysqli_fetch_array($sql);
    $linkname['Industries'] = googleTranslatetext($row['link_name'],$_SESSION['lan']);

return $linkname;

}
function pageurl(){
    if(!isset($_SESSION['lan'])){
    $lan=$_SESSION['lan'];
    }
    else{
    $lan=$_SESSION['lan'];
    }
  $sql = db_query("select page_url from all_seo where cpage='product-detail' and language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['product-detail'] = $row['page_url'];

 $sql = db_query("select page_url from all_seo where cpage='manufacturer' and language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['manufacturer'] = $row['page_url'];

  $sql = db_query("select page_url from all_seo where cpage='parts-search' and language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['parts-search'] = $row['page_url'];

      $sql = db_query("select page_url from quote_landing where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['request-quote'] = $row['page_url'];

      $sql = db_query("select page_url from all_seo where cpage='landing-page' and language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['landing-page'] = $row['page_url'];

        $sql = db_query("select page_url from mng_aboutus where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['about'] = $row['page_url'];


       $sql = db_query("select page_url from mng_quality where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['quality'] = $row['page_url'];


       $sql = db_query("select page_url from mng_line_card where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['line-card'] = $row['page_url'];


       $sql = db_query("select page_url from mng_excess_inventory where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['sell-excess-inventary'] = $row['page_url'];


       $sql = db_query("select page_url from privacy_policy where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['privacy-policy'] = $row['page_url'];


       $sql = db_query("select page_url from terms_conditions where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['terms-conditions'] = $row['page_url'];

     $sql = db_query("select page_url from service_landing where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['services'] = $row['page_url'];

    $sql = db_query("select page_url from service_detail where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['service_detail'] = $row['page_url'];

      $sql = db_query("select page_url from industries_landing");
    $row = mysqli_fetch_array($sql);
    $page_url['industries'] = $row['page_url'];

    $sql = db_query("select page_url from contact_us where language='en'");
    $row = mysqli_fetch_array($sql);
    $page_url['contact-us'] = $row['page_url'];

     $sql = db_query("select page_url from all_seo where cpage = 'news'");
    $row = mysqli_fetch_array($sql);
    $page_url['news'] = $row['page_url'];


    return $page_url;
}
?>

<?php
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

function word_limiter($str, $limit = 20, $end_char = '&#8230;') {

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

function chageURL($str) {
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
    $str = rtrim(strtolower($str), '');
    return $str;
}




$secretKey   = "6Ldm79sZAAAAAOOj7t7RH3h5dwogeGVM09c31R2N";
$sitekey     = "6Ldm79sZAAAAANjsalOOfcXCSDuiha3-cs4CdlaA";


?>
