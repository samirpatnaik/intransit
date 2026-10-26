<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
$aboutactive = "class='active'";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['line-card']['metatitle']; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="keywords" content="<?php echo $page_seo['line-card']['metakeywords']; ?>" />
<meta name="description" content="<?php echo $page_seo['line-card']['metadescription']; ?>"  />

<?php if(trim($page_seo['line-card']['moretags'])!=""){ echo $page_seo['line-card']['moretags']; }?>

<?php include('css.php'); ?>

	
	
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->



<!-- banner -->
<?php
	$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='linecardbanner'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from mng_inner_banner where language='en' and page='linecardbanner'");
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
                    <img src="upload_page_images/<?php echo $home['mng_line_card']['image'] ?>" alt="<?php echo $home['mng_line_card']['alt_txt'] ?>" title="<?php echo $home['mng_line_card']['title_txt'] ?>" class="img-fluid">
                </figure>
            </div>
            <div style="margin-top:-10px;"class="col-lg-6 col-md-6 col-12 d-flex justify-content-center align-items-start flex-column">
                <h1 style="line-height: 60px;font-weight: 400;font-size: 30px;"><?php echo $home['mng_line_card']['heading']; ?></h1>
             <?php echo $home['mng_line_card']['description']; ?>
            
            </div>
        </div>
        <div class="row">
         <div class="col-md-12 col-lg-12 col-12 mx-auto" style="padding:20px 0px">
            <h1 style="color:black;line-height: 60px;font-weight: 400;font-size: 30px;" class="text-center"> <?php echo googleTranslatetext("Product Lines Offered",$_SESSION['lan']);?></h1>
         </div>
		 <?php 
				$psql = db_query("select `productlines` from mng_line_card");
				$prow = mysqli_fetch_array($psql);
				echo $prow['productlines'];
		 ?>
		 
         <div class="col-md-12 col-lg-12 col-12 mx-auto" style="padding:20px 0px">
            <h1 style="color:black;line-height: 60px;font-weight: 400;font-size: 30px;" class="text-center"><?php echo googleTranslatetext("Manufactures Offered",$_SESSION['lan']); ?></h1>
         </div>
		<?php
		function get_states(){
			$q1 = "SELECT id, mname FROM `manufacturers` order by mname";
			$incart_r = db_query($q1);
			$contents = array();
			while($incart = mysqli_fetch_array($incart_r)){
		//build array of info
			$item = array(
				$incart['id'],
				$incart['mname']);
			array_push($contents,$item);
			}
			return $contents;
		}
$c = get_states();
$cols = 4;  // decide how many cells you want, wide
$rows = ceil( count($c) / $cols ); // works out how many rows
$cnt = 1; // set a counter for upcoming loop
echo '<div class="col-md-3 col-6 product_border_right"><ul>' . PHP_EOL;
for($i=0; $i < count($c); $i++){
if( $cnt >= $rows ) {  // start a new TD when you get to the number of rows
 echo "<li>" . $c[$i][1] . "</li></ul></div><div class='col-md-3 col-6 product_border_right'><ul>" .PHP_EOL ;
  $cnt = 0;  // reset the counter, and start a new column
 }else{ // other wise just echo the country name
  echo "<li>" . $c[$i][1] . "</li>" . PHP_EOL;
 }
$cnt++;
}
echo '</ul></div>' . PHP_EOL;
?>
<p>&nbsp;</p>
<p>&nbsp;</p> 
<p>&nbsp;</p>       
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