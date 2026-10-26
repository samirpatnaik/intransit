<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();


// Look for a GET variable page if not found default is 1.
if (isset($_GET["page"])) {
	$pn = $_GET["page"];
} else {
	$pn = 1;
}
$start = ($pn - 1) * $limit;
$limit = 20;

/* SEARCH BOTH Product Part AND  Manufacturer*/
$searchdata = $connect->real_escape_string(trim(rawurldecode($_REQUEST['m'])));
$pageurl = "manufacturer-".$searchdata;
if($searchdata){
	$psql = "select id, partnumber, manufacturer, quantity, datasheet from `products` where manufacturer = '$searchdata' order by manufacturer LIMIT $start, $limit ";

	/*GET TOTAL RECORDS */
	$tsql = db_query("select count(1) from products where manufacturer = '$searchdata' ");
	$trow = mysqli_fetch_array($tsql);
	$totalrecords = $trow[0];
	$totalPages = ceil($totalrecords / $limit);

	/* SEARCH STRING */
	//$string = "m=".$searchdata;
	$string ="";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $searchdata; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['manufacturer']['keywords']?>" />
<meta name="description" content="<?php echo $page_seo['manufacturer']['meta_desc']; ?>"  />
<?php if(trim($page_seo['manufacturer']['meta_tags'])!=""){ echo $page_seo['manufacturer']['meta_tags']; }?>
<?php include('css.php'); ?>
</head>
<body>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->
<!-- banner -->
<?php 
	$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='manufacturer'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from mng_inner_banner where language='en' and page='manufacturer'");
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

<!-- Parts Search Content -->

<section class="parts_search">
<div class="container">
<div class="row">
<div class="col-md-9 col-12 mx-auto" style="padding-top:50px;padding-bottom:50px;">
<div class="search_section">
<div class="row">
</div>
</div>

<?php  
if($psql){
$result_set = db_query($psql);
while($row = mysqli_fetch_array($result_set)) {
?>
<div class="wrapper" style="margin-top:35px;">
		<div class="headline">
		<p><?php echo $row["partnumber"]; ?></p>
	
		<a href="<?php print $url_arr['product-detail'];?>_<?php print urlencode($row['partnumber']);?>_<?php echo $row['id']?>" style="color:#029cfc;">Details&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  
		 </div>
		<hr>
		<div class="content">
		  <div class="row">
			<div class="table-responsive">
				<table class="table borderless">
					<tbody>
						<tr class="d-flex">
							<td  width="20%">
							<p class="small_heading">MANUFACTURER</p>
				  <p style="color:black;font-size: 14px;"><?php echo $row["manufacturer"]; ?></p>
							</td>
							<td  width="10%">
							<p class="small_heading ">DC</p>
				  <p style="color:black;font-size: 14px;">--</p> 
							</td>
							<td  width="25%"><p class="small_heading">STATUS</p>
				  <p style="color:black;font-size: 14px;">Ships Today</p> </td>

							<td width="25%">  <p class="small_heading">QUANTITY</p>
				  <p style="color:black;font-size: 14px;">--</p></td>

				  <td width="25%" class="float-left">
				  <p class="small_heading">QUANTITY</p>
				  <div class="nice-number">
				  <!-- <button   class="cssCircle minusSign">-</button> -->
				  <input type="number" class="quantity_value" name="quantity<?php echo $row["id"]; ?>" id="quantity<?php echo $row["id"]; ?>" value="0">
				  <!-- <button  class="cssCircle plusSign">+</button> -->
				   </div>
				  </td>
				  <td width="40%" class="text-right" >
				  <button type="button" class="btn btn_custom text-right" onclick="addtoQuote('<?php echo $row["id"]; ?>','<?php echo trim($row["manufacturer"]); ?>','<?php echo $row["partnumber"]; ?>')">Add to Quote</button>
				  <?php  if($row['datasheet'] == 1){ ?>
				  <div class="content1 text-left" style="margin-top:9px;margin-left: 50px;">
				  <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;
				  <span style="font-size: 11px;color:#323232;font-weight:400;">Data Sheet Available Upon Request</span>
				  </div>
				  <?php } ?>
				  </td>
				  </tr>
					</tbody>
				</table>
			</div>
		  </div>  
		</div>
		
	</div>
<!-- end wrapper -->
<?php
	}
}
?>
</div>
</div>
</div>
</div>
</div>
</section>

<section class="pagination_footer" style="padding-bottom:40px;">
<div class="container">
  <div class="row">
    <div class="col-md-6 col-12 mx-auto">
   
	<nav aria-label="Page navigation example">
	  <ul class="pagination">
		<li class="page-item">
		<?php if ($pn > 1){ ?>
		<a class="page-link" href="<?php print $pageurl;?>?page=<?php echo (($pn-1));?>">Previous</a></li>
		<?php }
		if (($pn - 1) > 1){
		?>
		<li class="page-item"><a class="page-link" href="<?php print $pageurl;?>?page=1">1</a></li>
		<li class='page-item'>...</li>
		<?php } 
		
		for ($i = ($pn - 1); $i <= ($pn + 10); $i ++) {
		if ($i < 1)
			continue;
		if ($i > $totalPages)
			break;
		if ($i == $pn) {
			$class = "active";
		} else {
			$class = "page-a-link";
		}
    ?>
	<li class="page-item"><a class="page-link <?php echo $class; ?>" href="<?php print $pageurl;?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
    <?php
		}
	if (($totalPages - ($pn + 1)) >= 10) {
    ?>
    <li class='page-item'>...</li>
	<?php
	}
	if (($totalPages - ($pn + 1)) >= 9) {
		if ($pn == $totalPages) {
			$class = "active";
		} else {
			$class = "page-a-link";
		}
		?>
	<li class="page-item"><a class="page-link <?php echo $class; ?>" href="<?php print $pageurl;?>?page=<?php echo $totalPages;?>">
	<?php echo $totalPages; ?></a></li> 
	<?php
	}
	?>
    <?php
    if (($pn < $totalPages)) {
    ?>
	<li class="page-item"><a class="page-link" href="<?php print $pageurl;?>?page=<?php echo (($pn+1));?>">Next</a></li>
    <?php
    }
    ?>
	</ul>
</nav>    
</div>
</div>
</div>
</section>
<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
<script type="text/javascript" src="js/incrementing.js"></script>
<script type="text/javascript">
function myFunction(val) {
  //document.getElementById("myForm").submit();
  //window.location="<?php echo $url_arr['parts-search'];?>?partnumber="+val;
}
function addtoQuote(id,m,pn){
	var quantity = $("#quantity"+id).val();
	if(quantity==0){
		alert("Please Enter Quantity!");
		return false;
	}else{
		$.ajax({
			url:'addtoquote.php',
			type:'POST',
			data:'id='+id+'&qty='+quantity+'&m='+m+'&pn='+pn,
			success:function(data){
               //window.location="<?php print $url_arr['product-detail'];?>?id="+id;  
			   alert("Product Added Successfully!");
			},
		});
	}
}
</script>
</body>
</html>
