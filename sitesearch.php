<!-- about -->
<section class="banner-bottom">
	<div class="container">	
		<div class="row">
			<div class="col-lg-12">
            	<form class="form-inline" action="<?php  echo $url_arr['parts-search'];?>" method="post" style="justify-content: center;">
                  <!--
				  <div class="form-group mx-sm-6 m-2" style="position:relative;">
                    <input type="search" name="partnumber1" id="partnumber1" class="form-control"  placeholder="Search by Product Part # or Manufacturer" value="<?php if($_POST['partnumber1']){echo (trim($_POST['partnumber1']));}else{print (trim($_POST['partnumber']));}?>" required autocomplete="off"/>
                     <button type="submit" name="send" style="border:none;outline:none;position:absolute;right:10px;top:10px;cursor: pointer;background: transparent;"><i class="fa fa-search" aria-hidden="true" style="font-size:20px;color:#4c4c4c;"></i></button>
                  </div>
				  -->
                  <div class="form-group mx-sm-3 m-2">
                    <a href="<?php echo $url_arr['request-quote'];?>" class="btn btn1"><?php echo googleTranslatetext("Request a Quote",$_SESSION['lan']);?></a>
                  </div>
				  
				  <div class="form-group mx-sm-3 m-2">
                    <a href="<?php echo $url_arr['parts-search'];?>" class="btn btn1"><?php echo googleTranslatetext("Search for Parts",$_SESSION['lan']);?></a>
                  </div>
				  
                  <div class="form-group m-2">
                    <a href="<?php echo $url_arr['sell-excess-inventary'];?>" class="btn btn2"><?php echo googleTranslatetext("Sell Your Excess Inventory",$_SESSION['lan']);  ?></a>
                  </div>  
                </form>
            </div>
		</div>
	</div>
</section> 
<!-- //about -->
