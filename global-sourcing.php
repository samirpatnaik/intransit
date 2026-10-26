<?php 

include("includes/connection.php"); 




$url_arr=pageurl();

$page_seo=pageSEO();

$home=Translatetext();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php 
 
  

        $sql = db_query("select * from service_detail where language='".$_SESSION['lan']."' and btn_link='global-sourcing'");

        $numrow = mysqli_num_rows($sql);

        if($numrow==0){

        $sql = db_query("select * from service_detail where language='en' and btn_link='global-sourcing'");

        }

        $res = mysqli_fetch_array($sql);

        ?>
<title><?php echo $res['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $res['metakeywords']; ?>" />

<meta name="description" content="<?php echo $res['metadescription']; ?>"  />

<?php if(trim($res['moretags'])!=""){ echo $page_seo['service_detail']['moretags']; }?>
<?php include('css.php'); ?>
	
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
<?php 
 
  

        $sql = db_query("select * from service_detail where language='".$_SESSION['lan']."' and btn_link='global-sourcing'");

        $numrow = mysqli_num_rows($sql);

        if($numrow==0){

        $sql = db_query("select * from service_detail where language='en' and btn_link='global-sourcing'");

        }

        $res = mysqli_fetch_array($sql);

        ?>
<div class="inner-banner" style="background:url(service_images/<?php echo $res['banner_image']; ?>) no-repeat;">
	<div class="about-banner_text">
        <div class="container clearfix text-center">
            <?php

            if($numrow==0){

              echo googleTranslatetext($res['banner_desc'],$_SESSION['lan']); 
         }else{

              echo $res['banner_desc'];
          
         }
         ?>
        </div>
    </div>	
</div>

<!-- //banner -->
<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- global-sourcing section starts -->
<section class="global" style="margin-top:30px;">
    <div class="container">
               <?php

         $sql = db_query("select * from service_detail where language='".$_SESSION['lan']."' and btn_link='global-sourcing'");

        $numrow = mysqli_num_rows($sql);

        if($numrow==0){

        $sql = db_query("select * from service_detail where language='en' and btn_link='global-sourcing'");

        }

        $res = mysqli_fetch_array($sql);

        ?>
        <div class="row">
            <div class="col-md-11 col-12 mx-auto">
                <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <figure style="border:1px solid black;">
                    <img src="service_images/<?php echo $res['image_1']; ?>" alt="<?php echo $res['alt_txt_2'] ; ?>" title="<?php echo $res['title_txt_2']; ?>" class="img-fluid">
                </figure>
            </div>
            <div style="margin-top:-10px;"class="col-lg-6 col-md-6 col-12 d-flex justify-content-center align-items-center flex-column">
                <h1 style="line-height: 40px;font-weight: 400;font-size: 25px;">


                         <?php

            if($numrow==0){

              echo googleTranslatetext($res['heading_1'],$_SESSION['lan']); 
         }else{

              echo $res['heading_1'];
          
         }
         ?>
                    
                  </h1>

                   <?php

            if($numrow==0){

              echo googleTranslatetext(str_replace('../',SITEURL,$res['detail_desc']),$_SESSION['lan']); 
         }else{

              echo str_replace('../',SITEURL,$res['detail_desc']);
          
         }
         ?>
            </div>
            </div>
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