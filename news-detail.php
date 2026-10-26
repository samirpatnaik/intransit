<?php 

include("includes/connection.php"); 

$id = $connect->real_escape_string(filter_inputs($_GET['id']));


$url_arr=pageurl();

$page_seo=pageSEO();

$home=Translatetext();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['mng_blog']['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['mng_blog']['metakeywords']?>" />
<meta name="description" content="<?php echo $page_seo['mng_blog']['metadescription']; ?>"  />

<?php if(trim($page_seo['mng_blog']['moretags'])!=""){ echo $page_seo['mng_blog']['moretags']; }?>
<?php include('css.php'); ?>
	
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
<?php 
 
  

        $sql = db_query("select * from  mng_inner_banner where language='".$_SESSION['lan']."' and page='newsbanner'");

        $numrow = mysqli_num_rows($sql);

        if($numrow==0){

        $sql = db_query("select * from  mng_inner_banner where language='en' and page='newsbanner'");

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

<!-- blog section starts -->
<section class="blog_post2" style="margin-top:30px;">
    <div class="container">
        <div class="row ">
                <?php

           $sql = db_query("select * from mng_blog where id = '$id'");
           while($res = mysqli_fetch_array($sql)){

           ?>
          <div class="col-md-10 col-11 mx-auto text-center">
          
          <?php echo googleTranslatetext($res['description'],$_SESSION['lan']); ?>  
           
    </div>
<?php } ?>
<div class="row" style="padding-bottom: 50px;">
    <div class="col-md-10 col-12 mx-auto">
        <h2 style="padding-top:40px;"><?php echo googleTranslatetext('Related Posts',$_SESSION['lan']); ?> </h2>
        <p style="font-size: 15px;">
            <?php echo googleTranslatetext("Lorem Ipsum is simply dummy text of the printing and typesetting industry.
Lorem Ipsum has been the industry's standard dummy text ever since the
1500s, when an unkno",$_SESSION['lan']); ?>
    
</p>
    <div class="row" style="padding-top: 40px;">
        <?php

           $sql = db_query("SELECT * FROM mng_blog  where id!='CURRENT ID' ORDER BY RAND() LIMIT 3;");
           while($res = mysqli_fetch_array($sql)){

           ?>
        <div class="col-md-4 col-12 mx-auto">
            <div class="card">
    <img class="img-fluid" src="upload_page_images/<?php echo $res['image']; ?>" alt="<?php echo $res['alt_txt']; ?>" title="<?php echo $res['title_txt']; ?>" style="width:330px;height:190px;">

    <div class="card-body">
      <span  style="letter-spacing: -0.5px;font-size: 12px;font-weight: 550;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?php echo date("d M, Y", strtotime($res['publish_date']));?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo googleTranslatetext($res['author_name'],$_SESSION['lan']);?></span>
      <p style="font-size:17px;padding:10px 19px 10px 1px;line-height: 1.5;font-weight: 400;"><?php echo word_limiter(googleTranslatetext($res['description'],$_SESSION['lan']),8); ?>
          
      </p>
      <a href="#" target="_blank" style="font-size: 13px;color:blue;">Read More</a>
    </div>
  </div> 
        </div>
 
<?php } ?>
    </div>
    </div>
</div>
    

</section>
<!-- blog section ends -->







<!-- footer -->

<?php include('footer.php'); ?>

<!-- //copyright -->
        
<?php include('js.php'); ?>
  
</body>
</html>