<?php 
include("includes/connection.php"); 
	$url_arr=pageurl();
	$page_seo=pageSEO();
	$home=Translatetext();
	$id = $connect->real_escape_string($_GET['id']);
	
	$sql = db_query("select * from mng_pages where id='".$id."'");
	$res = mysqli_fetch_array($sql);
	$bannerimage = $res['bannerimage'];	
	$bannertext = $res['bannertext'];	
	$content = str_replace('../',SITEURL,$res['content']);	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $res['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $res['metakeywords']; ?>" />
<meta name="description" content="<?php echo $res['metadescription']; ?>"  />
<?php if(trim($res['moretags'])!=""){ echo $res['moretags']; }?>
<?php include('css.php'); ?>
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->

<div class="inner-banner" style="background:url(banner/<?php echo $bannerimage; ?>) no-repeat;">
  <div class="about-banner_text">
        <div class="container clearfix text-center">
        <?php
           echo googleTranslatetext($bannertext,$_SESSION['lan']); 
		?>
        </div>
    </div>  
</div>

<!-- //banner -->
<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- global-sourcing section starts -->
<section class="global" style="margin-top:30px; margin-bottom:40px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 mx-auto">
            <?php print googleTranslatetext($content,$_SESSION['lan']); ?>
         </div>
		
        </div>
    </div>
</section>
<!--global-sourcing section ends -->
<!-- //about bottom -->
<?php include("footer_request_quote.php");?>

<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
</body>
</html>