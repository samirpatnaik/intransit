<?php 

include("includes/connection.php"); 


$url_arr=pageurl();

$page_seo=pageSEO();

$home=Translatetext();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['about']['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['about']['metakeywords']; ?>" />

<meta name="description" content="<?php echo $page_seo['about']['metadescription']; ?>"  />

<?php if(trim($page_seo['about']['moretags'])!=""){ echo $page_seo['about']['moretags']; }?>

<?php include('css.php'); ?>
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
  <?php 
 
        $sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='aboutbanner'");

        $numrow = mysqli_num_rows($sql);

        if($numrow==0){

        $sql = db_query("select * from mng_inner_banner where language='en' and page='aboutbanner'");

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
        	<div class="col-md-12">
            	<h2><?php echo $home['about']['heading_1']; ?></h2>
            </div>
        	<?php echo $home['about']['description_1']; ?>
            
          </div>

          <div class="row ">        	
        	<div class="col-md-6">
            	<img src="upload_page_images/<?php echo $home['about']['image_1']?>" alt="<?php echo $home['about']['alt_txt_1']?>" title="<?php echo $home['about']['title_txt_1']?>">
            </div>
            <div class="col-md-6">
            	<h2><?php echo $home['about']['heading_2']; ?> </h2>

            	<?php echo $home['about']['description_2']; ?>

             
                <a href="<?php echo $home['about']['btn_link_1']; ?>" target="_blank"><button type="button" class="btn btn2"><?php echo $home['about']['btn_txt_1']; ?> </button></a>
            </div>            
          </div>
          <div class="row"> 
            <div class="col-md-6 mtb-60">
            	<h2><?php echo $home['about']['heading_3']; ?> </h2>
            	<?php echo $home['about']['description_3']; ?>

                  <a href="<?php echo $home['about']['btn_link_2']; ?>" target="_blank"><button type="button" class="btn btn2"><?php echo $home['about']['btn_txt_2']; ?> </button></a>
            </div> 
            <div class="col-md-6 text-right mtb-60">
            	<img src="upload_page_images/<?php echo $home['about']['image_2']?>" alt="<?php echo $home['about']['alt_txt_2']?>" title="<?php echo $home['about']['title_txt_2']?>">
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