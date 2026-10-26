<?php 
include("includes/connection.php"); 
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
<?php if(trim($page_seo['service_detail']['moretags'])!=""){ echo $page_seo['mng_blog']['moretags']; }?>
<?php include('css.php'); ?>
<script type="text/javascript">
$(document).ready(function(){
 $("#load").click(function(){
  loadmore();
 });
});
function loadmore()
{
 var val = document.getElementById("result_no").value;
 $.ajax({
 type: 'post',
 url: 'fetch.php',
 data: {
  getresult:val
 },
 success: function (response) {
  var content = document.getElementById("result_para");
  content.innerHTML = content.innerHTML+response;

  // We increase the value by 2 because we limit the results by 2
  document.getElementById("result_no").value = Number(val)+2;
 }
 });
}
</script>
	
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

<!-- blog section starts -->
<section class="blog" id="content"  style="margin-top:30px;">
    <div class="container" id="result_para">
        
           
           <?php

           $sql = db_query("select * from mng_blog limit 0,2");
           while($res = mysqli_fetch_array($sql)){

            $page_url = $res['page_url'];

           ?>


<div class="row" >

            <div class="col-md-6 col-12 d-flex justify-content-center align-items-start flex-column float-left">
                <a style="color:black;"href="<?php echo $page_url; ?>"><h1 style="line-height: 35px;font-weight: 400;font-size: 27px;padding-bottom: 20px;" class="letter_sm"><?php echo googleTranslatetext($res['title'],$_SESSION['lan']); ?> </h1></a>
 
                 <p style="color:black;letter-spacing: -0.5px;font-size: 15px;font-weight: 600;"> <?php echo word_limiter(googleTranslatetext($res['description'],$_SESSION['lan'])); ?>

               <span style="color:#00549a;font-size: 15px;font-weight: 600;"><a href="<?php echo $page_url; ?>">Read more</a></span></p>

<span  style="letter-spacing: -0.5px;font-size: 12px;font-weight: 600;padding-top:37px;"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?php echo date("d M, Y", strtotime($res['publish_date']));?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo googleTranslatetext($res['author_name'],$_SESSION['lan']);?></span>
            
            
            </div>
            

                <div class="col-md-6 col-12">
                <div class="float-right">
                <figure>
                    <img src="upload_page_images/<?php echo $res['image']; ?>" width="450" height="130" alt="<?php echo $res['alt_txt']; ?>" title="<?php echo $res['title_txt']; ?>"  class="img-fluid">
                </figure>
                </div>
            </div>
         <hr class="w-100 mx-auto">
         <p>&nbsp;</p>
            </div>
           <?php } ?>

     
 </div>


        <div class="text-center">
            <input type="hidden" id="result_no" value="2">
            <input type="button" id="load" value="Load More" class="btn btn_blog">
        </div> <br><br>
   

    

</section>
<!-- blog section ends -->






<!-- footer -->

<?php include('footer.php'); ?>

<!-- //copyright -->
        
<?php include('js.php'); ?>
  
</body>
</html>