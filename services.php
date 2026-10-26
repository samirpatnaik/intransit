<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['service_landing']['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['service_landing']['metakeywords']; ?> " />
<meta name="description" content="<?php echo $page_seo['service_landing']['metadescription']; ?>"  />
<?php if(trim($page_seo['service_landing']['moretags'])!=""){ echo $page_seo['service_landing']['moretags']; }?>
<?php include('css.php'); ?>
</head>
<body>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
<?php 
        $sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='servicesbanner'");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
        $sql = db_query("select * from mng_inner_banner where language='en' and page='servicesbanner'");
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
<!-- services section starts -->
<section class="services_section" style="margin-top:30px;">
    <div class="container">
        <div class="row ">
          <div class="col-md-10 col-12 mx-auto text-center">
              <h2><?php echo $home['service_landing']['heading'];?></h2>
  <?php echo $home['service_landing']['description'];?>
<br><br><br>
<div class="row serv">
   <?php
        $sql = db_query("select * from service_detail where language='".$_SESSION['lan']."'");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
        $sql = db_query("select * from service_detail where language='en'");
        }
        while($res = mysqli_fetch_array($sql)){
         $page_url = $res['page_url'];
        ?>
  <div class="col-md-4 col-12 mx-auto">
    <div class="services_box" style="padding:10px 10px;">
    <center><div class="circle_icon" style="margin-top:-60px;">
    <a href="<?php echo $page_url ?>"><img src="service_images/<?php echo $res['icon_image'] ;?>" alt="<?php echo $res['alt_txt'] ;?>" title="<?php echo $res['title_txt'] ;?>" class="img-fluid" width="60" height="60" style="margin-top:19px;"></a>
	</div></center>

    <p style="padding-top:20px;font-size: 16px;color:black;font-weight:600;text-align: center;" class="small_text"><a href="<?php echo $page_url ?>"><?php echo $res['heading'] ;?></a></p>

  <?php echo str_replace('../',SITEURL,$res['description']); ?>

<a href="<?php echo $page_url ?>"><button type="button" class="btn btn-service" style="margin-top:22px;"><?php echo $res['btn_txt'];?></button></a>
   </div>
  </div>
<?php
}
?>
</div>
</div> 
</div>
   <p>&nbsp;</p> 
   <p>&nbsp;</p> 
</section>
<!-- services section ends -->

<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
</body>
</html>