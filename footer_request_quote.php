<?php 
	$sql = db_query("select * from request_quote where language='".$_SESSION['lan']."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from request_quote where language='en'");
	}
	$res = mysqli_fetch_array($sql);
?>
<section class="request" style="background: url(uploadimages/<?php echo $res['image']; ?>) top center; background-size:cover; padding:100px 0;">

<div class="container">
    <h3 class="text-center" style="font-size:52px; color:#fff; margin-bottom:30px;">
            <?php
            if($numrow==0){
              echo googleTranslatetext($res['heading'],$_SESSION['lan']); 
         }else{
              echo $res['heading'];
         }
         ?>
     </h3>
     <div class="row">
		<div class="col-lg-12 text-center">
        <p style="width:100%; max-width:650px; margin:0 auto 40px; font-size:22px; line-height:28px; font-weight:normal; color:#fff;">
         <?php 
		 $desc = str_ireplace('<p>','',$res['description']);
		 $desc = str_ireplace('</p>','',$desc);
		 
         if($numrow==0){
              echo googleTranslatetext($desc,$_SESSION['lan']); 
         }else{
              echo $desc;
         }
         ?></p>
    <a href='<?php echo $res['btn_link'];?>' class="btn btn2"> 
        <?php
        if($numrow==0){
			echo googleTranslatetext($res['btn_text'],$_SESSION['lan']); 
        }else{
			echo $res['btn_text'];
           }
         ?>
     </a>
    </div>
</div>
</div>
</section>