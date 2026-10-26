<!--

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1846535141887168"

     crossorigin="anonymous"></script>

    -->

    

<footer>

	<div class="container py-sm-3">

		<div class="row footer-grids">

   <?php 

   $sql = db_query("select * from footer_area");

   $res = mysqli_fetch_array($sql);

   ?>

        	<div class="col-lg-5 col-md-5">

            	<div class="row footer_mar">

                	<div class="col-lg-7 col-md-7 col-sm-7">

                    <?php echo googleTranslatetext(str_replace("../","",$res['desc1']),$_SESSION['lan']);?>

					  <?php

					   $sql = db_query("select * from social_links");

					   $res = mysqli_fetch_array($sql);

					  ?>

                    <p class="social_footer">

                    <a href="<?php echo $res['facebook'];?>" target="_blank" class=""><i class="fa fa-facebook-square" aria-hidden="true"></i></a>

                    <a href="<?php echo $res['twitter'];?>" target="_blank" class=""><i class="fa fa-twitter" aria-hidden="true"></i></a>

                    <a href="<?php echo $res['linkedin'];?>" target="_blank" class=""><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></p>

                    </div>

<?php

   $sql = db_query("select * from footer_area");

   $res = mysqli_fetch_array($sql);

?>

<div class="col-lg-5 col-md-5 col-sm-5">

   <a href="/iso-certificate"> <img src="upload_page_images/<?php echo $res['image']?>" alt="<?php echo $res['alt_txt']?>" title="<?php echo $res['title_txt']?>"></a>

</div>

                </div>

            </div>	

            <div class="col-lg-7 col-md-7">

            	<div class="row footer_mar">

                	<div class="col-lg-3 col-md-3 col-sm-3">

                      <?php echo googleTranslatetext(str_replace("../","",$res['desc2']),$_SESSION['lan']);?>															

                    </div>

                	<div class="col-lg-4 col-md-4 col-sm-4">

                    <?php echo googleTranslatetext(str_replace("../","",$res['desc3']),$_SESSION['lan']);?>

                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5">

                     <?php echo googleTranslatetext(str_replace("../","",$res['desc4']),$_SESSION['lan']);?>

                    </div>

                </div>

            </div>

		</div>

	</div>

</footer>

<div class="copyright">

    <div class="container py-4">

        <div class=" text-center">
        
            <?php echo googleTranslatetext($res['copyright_txt'],$_SESSION['lan']);?>

        </div>

    </div>

</div>