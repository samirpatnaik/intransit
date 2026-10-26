<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['privacy-policy']['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['privacy-policy']['metakeywords']; ?>" />

<meta name="description" content="<?php echo $page_seo['privacy-policy']['metadescription']; ?>"  />

<?php if(trim($page_seo['privacy-policy']['moretags'])!=""){ echo $page_seo['privacy-policy']['moretags']; }?>

<?php include('css.php'); ?>
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
 <?php 
     $sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='privacy'");
     $numrow = mysqli_num_rows($sql);
     if($numrow==0){
		$sql = db_query("select * from mng_inner_banner where language='en' and page='privacy'");
     }
	$res = mysqli_fetch_array($sql);
?>
<div class="inner-banner" style="background:url(banner/<?php echo $res['image']; ?>) no-repeat;">
	<div class="about-banner_text">
        <div class="container clearfix text-center">
          <?php
            if($numrow==0){
				echo googleTranslatetext(str_replace('../',SITEURL,$res['description']),$_SESSION['lan']); 
			 }else{
				echo str_replace('../',SITEURL,$res['description']);
			}
         ?>
        </div>
    </div>	
</div>

<!-- //banner -->

<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- about bottom -->
<section class="about_us">
	<div class="container">
			<div class="row">
        	<div class="col-md-12 col-12 mx-auto">
				<?php echo $page_seo['privacy-policy']['description']; ?>
			</div>
          </div>
	</div>
</section>
<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
</body>
</html>