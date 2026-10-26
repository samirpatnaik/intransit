<?php
include("includes/connection.php"); 

 $no = $_POST['getresult'];

$sql = db_query("select * from mng_blog limit $no,2");

 while($res = mysqli_fetch_array($sql))
 {
  $page_url = $res['page_url'];
 
?>
<div class="row">

            <div class="col-md-6 col-12 d-flex justify-content-center align-items-start flex-column float-left">
                <a style="color:black;"href="<?php echo $page_url; ?>"><h1 style="line-height: 35px;font-weight: 400;font-size: 27px;padding-bottom: 20px;" class="letter_sm"><?php echo googleTranslatetext($res['title'],$_SESSION['lan']); ?> </h1></a>
 
                 <p style="color:black;letter-spacing: -0.5px;font-size: 15px;font-weight: 550;"> <?php echo word_limiter(googleTranslatetext($res['description'],$_SESSION['lan'])); ?>

               <span style="color:#00549a;font-size: 15px;font-weight: 600;"><a href="<?php echo $page_url; ?>">Read more</a></span></p><br>

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