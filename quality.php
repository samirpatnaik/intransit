<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
$aboutactive = "class='active'";
?>
<html lang="en">
<head>
<title><?php echo $page_seo['mng_quality']['metatitle'] ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['mng_quality']['metakeywords']; ?>" />
<meta name="description" content="<?php echo $page_seo['mng_quality']['metadescription']; ?>"  />
<?php if(trim($page_seo['mng_quality']['moretags'])!=""){ echo $page_seo['mng_quality']['moretags']; }?>
<?php include('css.php'); ?>
</head>
<body>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
<?php 
	$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='qualitybanner'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from mng_inner_banner where language='en' and page='qualitybanner'");
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
<!-- quality section starts -->
<section class="quality" style="margin-top:30px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <figure style="border:1px solid black;">
                    <img src="upload_page_images/<?php echo $home['mng_quality']['image']; ?>" alt="<?php echo$home['mng_quality']['alt_txt'];?>" title="<?php echo $home['mng_quality']['title_txt'];?>" class="img-fluid">
                </figure>
            </div>
            <div style="margin-top:-10px;"class="col-lg-6 col-md-6 col-12 d-flex justify-content-center align-items-start flex-column">
                <h1 style="line-height: 60px;font-weight: 400;font-size: 30px;"><?php echo $home['mng_quality']['heading'];?></h1>
               <?php echo $home['mng_quality']['description']; ?>
            </div>
        </div>
    </div>
</section>
<!-- quality section ends -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
</body>
</html>