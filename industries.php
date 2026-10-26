<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['industries_landing']['metatitle']?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['industries_landing']['metakeywords']?>" />
<meta name="description" content="<?php echo $page_seo['industries_landing']['metadescription']; ?>"  />
<?php if(trim($page_seo['industries_landing']['moretags'])!=""){ echo $page_seo['industries_landing']['moretags']; }?>
	<?php include('css.php'); ?>
	
</head>
<body>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
<?php 
	$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='industriesbanner'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from mng_inner_banner where language='en' and page='industriesbanner'");
	}
	$res = mysqli_fetch_array($sql);
?>
<div class="inner-banner" style="background:url(banner/<?php echo $res['image']; ?>) no-repeat;">
	<div class="about-banner_text">
        <div class="container clearfix text-center">
         <?php

            if($numrow==0){

              echo googleTranslatetext($res['description'],$_SESSION['lan']); 
         }else{

              echo $res['description'];
          
         }
         ?>
        </div>
    </div>	
</div>
<!-- //banner -->
<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- Industry section starts -->
<section class="industry" style="margin-top:30px;">
    <div class="container">
        <div class="row">
        <div class="col-md-11 col-12 mx-auto">
   <?php 
   $sql = db_query("select * from industries_landing");
   $res = mysqli_fetch_array($sql);
   ?>
   <div class="float-left"><h1 style="font-size: 33px;"> <?php echo googleTranslatetext($res['heading'],$_SESSION['lan']);?></h1></div>
   <div class="float-right">
	   <div class="form-group  mb-2 search-part" style="position:relative; display:none;">
		<input type="text" class="form-control" id="inputPassword2"  placeholder="Search by Industry or NAICS">
		<i class="fa fa-search" aria-hidden="true" style="position:absolute; right:10px; top:10px; font-size:18px;color:grey;"></i>
	  </div>
   </div>
      </div>
      </div>
      <div class="row">
      <div class="col-md-11 col-12 mx-auto">
      <?php echo googleTranslatetext($res['description'],$_SESSION['lan']);?>
      <br>
	  <span class="indus_text">
          <a href="#a" >A</a><a href="#b">B</a><a href="#c">C</a><a href="#d">D</a><a href="#e">E</a><a href="#f">F</a><a href="#g">G</a><a href="#h">H</a><a href="#i">I</a><a href="#j">J</a><a href="#k">K</a><a href="#l">L</a><a href="#m">M</a><a href="#n">N</a><a href="#0">O</a><a href="#p">P</a><a href="#q">Q</a><a href="#r">R</a><a href="#s">S</a><a href="#t">T</a><a href="#u">U</a><a href="#v">V</a><a href="#w">W</a><a href="#x">X</a><a href="#y">Y</a><a href="#z">Z</a></span>
          <br><br>
          
<?php 
$sql = db_query("select * from mng_industries ORDER BY alphabet");
while($res = mysqli_fetch_array($sql)){
?>
<h1 style="padding:20px 0;" id="<?php print strtolower($res['alphabet']);?>">
<?php echo googleTranslatetext($res['alphabet'],$_SESSION['lan']);?>
</h1>
<?php echo googleTranslatetext($res['industries_desc'],$_SESSION['lan']);
   }
?>
</div>
</div>
</div>
    
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p> 

</section>
<!-- Industry section ends -->

<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
</body>
</html>