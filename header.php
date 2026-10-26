<?php 
session_start();
$linkname=linkname();
if(isset($_GET['lan'])){
$_SESSION['lan']=$_GET['lan'];
}
if(!isset($_SESSION['lan'])){
 $_SESSION['lan']='en';
}
?>
<!-- TOP HEADER -->
<div class="header-top">
	<div id="myModal" class="modal fade contact" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <!--  <h4 class="modal-title">Modal Header</h4> -->
      </div>
      <div class="modal-body">
        <h1 style="color:black;font-size:23px;font-weight: bolder;padding-bottom: 15px;" class="text-center">
        	<?php echo $home['tech_support']['heading']; ?></h1>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 col-12 mx-auto">
             <figure style="border:1px solid black;" class="tech_img">
                    <img src="upload_page_images/<?php echo $home['tech_support']['image'] ?>"  alt="<?php echo $home['tech_support']['alt_txt']?>" title="<?php echo $home['tech_support']['title_txt']?>" class="img-fluid">
                </figure>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-center align-items-start flex-column">
             <?php echo $home['tech_support']['description']; ?>
<br>
  <a href="<?php echo $home['tech_support']['btn_link']; ?>" target="_blank"><button type="submit" class="btn btn_contact"><?php echo $home['tech_support']['btn_txt']; ?></button></a>

            </div>
          </div>
        </div>
      </div>
     
    </div>

  </div>
</div>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<ul class="d-lg-flex header-w3_pvt">
					<li>
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						<a href="" data-toggle="modal" data-target="#myModal" class=""><?php echo googleTranslatetext("Technical Support",$_SESSION['lan']);?></a>
					</li>
                    <li>
						<i class="fa fa-phone" aria-hidden="true"></i>
					
						<a href="tel:<?php echo $home['footer_area']['phone']; ?>">
						<?php echo $home['footer_area']['phone']; ?></a>
				
					
					</li>
					<li>
						<i class="fa fa-commenting-o" aria-hidden="true"></i>

                   <?php
						$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

						$actual_link = str_replace('&lan='.$_SESSION['lan'], '', $actual_link);

						$actual_link = str_replace('?lan='.$_SESSION['lan'], '', $actual_link);

						$query = parse_url($actual_link, PHP_URL_QUERY);

						if($_SESSION['lan']=='en')	{
							$newlng = "es";
							$lngtext = "Se Habla Espanol";
						}else{
							$newlng = "en";
							$lngtext = "English speaking";
						}
							
						if ($query) {
						  $new_link = $actual_link."&lan=".$newlng;
						} else {
						  $new_link = $actual_link."?lan=".$newlng;
						}
                     ?>
					<a href="<?php echo $new_link;?>" class=""><?php print $lngtext; ?></a>
					</li>
				</ul>
			</div>
			<div class="col-md-4 header-right-w3_pvt">
				<ul class="d-lg-flex header-w3_pvt justify-content-lg-end">
					<?php
                       $sql = db_query("select * from social_links");
                       $res = mysqli_fetch_array($sql);
					 ?>
                	<li class=""><a href="<?php echo $res['facebook']; ?>" target="_blank" class=""><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                    <li class=""><a href="<?php echo $res['twitter']; ?>" target="_blank" class=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li class=""><a href="<?php echo $res['linkedin']; ?>" target="_blank" class=""><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                    <li class="">
                 
                    <a href="mailto:<?php echo $home['footer_area']['email']?>" class="">

                    <i class="fa fa-envelope-o" aria-hidden="true"></i>

                    </a>
              
                </li>
					<li class=""><a href="<?php echo $url_arr['contact-us'];?>" class=""><?php echo googleTranslatetext("Contact",$_SESSION['lan']);?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- TOP HEADER -->
<!-- HEADER -->
<header class="py-sm-3 pt-3 pb-2">
	<div class="container">
			<div id="logo">
				<h1> <a href="<?php echo SITEURL;?>"><img src="images/Logo.png" alt="Intransit Technologies"  title="Intransit Technologies"></a></h1>
			</div>
		<!-- nav 
		<nav id='cssmenu'>
			<div id="head-mobile"></div>
            <div class="button"></div>
			<ul>
				<li <?php /* print $aboutactive;?>><a href="<?php echo $url_arr['about'];?>"><?php echo $linkname['About Us'];?></a></li>
				<li class=""><a href="<?php echo $url_arr['services'];?>"><?php echo $linkname['service_landing']; ?></a></li>
				<li class=""><a href="<?php echo $url_arr['industries'];?>"><?php echo $linkname['Industries']; ?></a></li>
				<li class=""><a href="<?php echo $url_arr['line-card'];?>"><?php echo $linkname['Line Card'];?></a></li>
				<li class=""><a href="<?php echo $url_arr['news'];?>"><?php echo $linkname['news']; */ ?></a></li>
			</ul>
		</nav>
		-->
		<nav id='cssmenu'>        
			<div id="head-mobile"></div>
			<div class="button"></div>
			<ul>                    
			<?php
              $sql = db_query("select * from mng_menu where type='parent' order by position");
              while($res = mysqli_fetch_array($sql)){
               $item1=$res['name'];
               if($item1=='About Us'){
               $menu_link_url=$url_arr['about'];
               $menu_link_name=$linkname['About Us'];
               }
               elseif($item1=='Services'){
               $menu_link_url=$url_arr['services'];
               $menu_link_name=$linkname['service_landing'];
               }
               elseif($item1=='Industries'){
               $menu_link_url=$url_arr['industries'];
               $menu_link_name=$linkname['Industries'];
               }

               elseif($item1=='Line Card'){
               $menu_link_url=$url_arr['line-card'];
               $menu_link_name=$linkname['Line Card'];
               }

               elseif($item1=='News'){
               $menu_link_url=$url_arr['news'];
               $menu_link_name=$linkname['news'];
               }
			   elseif($item1=='Products'){
               $menu_link_url	= $url_arr['parts-search'];
               $menu_link_name	= googleTranslatetext('Products',$_SESSION['lan']);
               }

               else{
               $sql1 = db_query("select page_url,link_name,language from mng_pages where id='".$res['page_id']."'");
               while($res1 = mysqli_fetch_array($sql1)){
                 if($res1['language']==$_SESSION['lan']){
                   $menu_link_url=$res1['page_url'];
                   $menu_link_name=$res1['link_name'];
                 }else{
					 $menu_link_name= googleTranslatetext($res1['link_name'],$_SESSION['lan']);
				 }
               }
               }
			   $sql1 = db_query("select * from mng_menu where type='child' and position='".$res['position']."' order by position");
               $numrow = mysqli_num_rows($sql1);
			   if($item1=='Services'){ 
					$subclass = ' class="has-sub"';
			   }
			   if($numrow >0){ $subclass = ' class="has-sub"'; }else{$subclass = '';}
               echo "<li ".$subclass.">";

               echo "<a href='".$menu_link_url."'>".$menu_link_name."</a>";
               if($item1=='Services'){ 
					echo "<ul>";
					$sql3 = db_query("select * from service_detail where language='en'");
					while($res3 = mysqli_fetch_array($sql3)){
					$page_url = $res3['page_url'];
					echo "<li>";
					echo "<a href='".$page_url."'>".$res3['heading']."</a>";
					echo "</li>";
					}
					echo "</ul>";
			   }
               if($numrow>0){
               echo "<ul>";
               while($res1 = mysqli_fetch_array($sql1)){
                 $subitem=$res1['name'];
                 if($subitem=='About Us'){
                 $submenu_link_url=$url_arr['about'];
                 $submenu_link_name=$linkname['About Us'];
                 }
                 elseif($subitem=='Services'){
                 $submenu_link_url=$url_arr['services'];
                 $submenu_link_name=$linkname['service_landing'];
                 }
                 elseif($subitem=='Industries'){
                 $submenu_link_url=$url_arr['industries'];
                 $submenu_link_name=$linkname['Industries'];
                 }
                 elseif($subitem=='Line Card'){
                 $submenu_link_url=$url_arr['line-card'];
                 $submenu_link_name=$linkname['Line Card'];
                 }
                 elseif($subitem=='News'){
                 $submenu_link_url=$url_arr['news'];
                 $submenu_link_name=$linkname['news'];
                 }
				 elseif($item1=='Products'){
				 $menu_link_url =  $url_arr['parts-search'];
				 $menu_link_name=  $linkname['parts-search'];
				 }
                 else{
                 $sql2 = db_query("select page_url,link_name,language from mng_pages where id='".$res1['page_id']."'");
                 while($res2 = mysqli_fetch_array($sql2)){
                 if($res2['language']==$_SESSION['lan']){
                   $submenu_link_url=$res2['page_url'];
                   $submenu_link_name=$res2['link_name'];
                 }else{
					 $submenu_link_name= googleTranslatetext($res2['link_name'],$_SESSION['lan']);
				 }
                 }
                }
                echo "<li>";
                echo "<a href='".$submenu_link_url."'>".$submenu_link_name."</a>";
                echo "</li>";
               }
               echo "</ul>";
               }
               echo "</li>";
              }
            ?>                
			</ul>                
		</nav>
		
		<div class="clear"></div>
		<!-- //nav -->
	</div>
</header>
<!-- HEADER 
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1846535141887168"
     crossorigin="anonymous"></script>-->

<?php
$sql = db_query("select * from action_bar where language='".$_SESSION['lan']."' and status='Active'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
 //  $sql = db_query("select * from action_bar where language='en' and status='Active'");
}
$res = mysqli_fetch_array($sql);
if($numrow>0){
?>
<div class="heder_option clearfix" style="background:<?php print $res['barcolor'];?> !important;">
<div class="container">
<?php 
echo $res['content'];
?>
</div>
</div>
<?php } ?>
