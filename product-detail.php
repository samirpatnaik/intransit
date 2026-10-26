<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
$sessionid = session_id();

$id = $connect->real_escape_string(filter_inputs($_GET['id']));

/* GET PRODUCT DEATILS */
$psql = db_query("select id, partnumber,manufacturer,quantity,notes,datasheet from products where id='".$id."'");

$prow = mysqli_fetch_array($psql);
$partnumber 	= $prow['partnumber'];
$manufacturer 	= $prow['manufacturer'];
$quantity 		= $prow['quantity'];
$notes 			= $prow['notes'];
$datasheet 		= $prow['datasheet'];

/* GET MANUFACTURER's Detail*/
$msql 	= db_query("select detail from `manufacturers` where mname='".$manufacturer."'");
$mrow	= mysqli_fetch_array($msql);
$mdetail= $mrow['detail'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $partnumber ; ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['product-detail']['metakeywords']; ?> " />
<meta name="description" content="<?php echo $page_seo['product-detail']['metadescription']; ?>"  />

<?php if(trim($page_seo['product-detail']['moretags'])!=""){ echo $page_seo['product-detail']['moretags']; }?>
<?php include('css.php'); ?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
<style>
.ui-autocomplete-loading {
	background: white url("images/loading.gif") center center;
	background-repeat: no-repeat;
	background-size: 16px 16px;
}
</style>
</head>
<body>

<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
<?php 
$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='productdetailsbanner'");
$numrow = mysqli_num_rows($sql);
if($numrow==0){
$sql = db_query("select * from mng_inner_banner where language='en' and page='productdetailsbanner'");
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

<!-- Product details page Content -->

<section class="parts_search">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-12" style="padding-top:50px;padding-bottom:50px;">
		<div class="search_section">
		<div class="row">
		<div class="col-sm-6" style="display:none;">
		<form action="<?php echo $url_arr['parts-search'];?>" method="post" class="example1">
		<div class="form-group  mb-2 search-part" style="position:relative;">
		<input type="search" name="partnumber" id="partnumber" class="form-control partsearch" placeholder="Search by Part Name or Number" value="<?php print $_POST['partnumber1'];?>" autocomplete="off" required/>
		<button type="submit" name="send"><i class="fa fa-search" aria-hidden="true" style="font-size:18px;color:#4c4c4c;"></i></button>
		</div>
		</form>
		</div>
		
		<div class="col-sm-4">
		<form id="myForm"  method="post" action="<?php echo $url_arr['parts-search'];?>">  	
		<?php
		$vsql="SELECT * FROM products WHERE partnumber LIKE '%$partnumber%' LIMIT 20;";
		$sql_class = db_query($vsql);
		if(mysqli_num_rows($sql_class)>0){
		?>
		<select name='partnumber' id='partnumber' class="form-control dropbtn" onchange="myFunction()">
		<?php
			echo "<option value='0'>Variant List</option>";
			while($row_class=mysqli_fetch_array($sql_class)){
			echo "<option value='".$row_class['partnumber']."'>".$row_class['partnumber']."</option>";
			}
		?>
		</select>
		<?php } ?>
		</form>		
		</div>
		
		</div>
		</div>
		
		<h2 style="padding-top:30px;padding-bottom:0px;font-size: 26px;">
			 <?php echo googleTranslatetext('Manufacturer Found',$_SESSION['lan']); ?>
		</h2>

		<p style="color:black;font-size: 13px;letter-spacing: -0.5px;">
			 <?php echo googleTranslatetext($mdetail,$_SESSION['lan']); ?>
		</p>

 <!-- for dropdown select -->
	<div class="wrapper" style="margin-top:25px;">
		<div class="headline">
		<p style="color:grey;"><?php echo $partnumber; ?></p>
		<?php if($datasheet == 1){ ?>
		<div class="content2 text-left" style="margin-top:9px;width:140px;margin-left:90px;">
		<i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;
		<span style="font-size: 11px;color:#323232;font-weight:600;">Data Sheet Available Upon Request</span>
		</div>
		<?php } ?>
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
			<p style="color:black;font-size: 14px;">
			<a href="manufacturer-<?php print urlencode($manufacturer); ?>" >
			<?php echo $manufacturer; ?></a></p>
			</td>
			<td  width="10%">
			<p class="small_heading ">DC</p>
			<p style="color:black;font-size: 14px;">--</p> 
			</td>
			<td  width="25%"><p class="small_heading">STATUS</p>
			<p style="color:black;font-size: 14px;">Ships Today</p> </td>
			<td width="25%">  <p class="small_heading">AVAILABILITY</p>
			<p style="color:black;font-size: 14px;"><?php print $quantity; ?></p></td>
			<td width="25%">
			<p class="small_heading">QUANTITY</p>
				
			<div class="nice-number">
			<!-- <button   class="cssCircle minusSign">-</button> -->
			<input type="number" class="quantity_value" name="quantity" id="quantity" value="0">
			<!-- <button  class="cssCircle plusSign">+</button> -->
			</div>
			</td>
			<td width="40%" class="text-right">
			<button type="button" class="btn btn_custom text-right" onclick="addtoQuote('<?php echo $prow["id"]; ?>','<?php echo trim($prow["manufacturer"]); ?>','<?php echo $prow["partnumber"]; ?>')">Add to Quote </button>
			</td>
		</tr>
		</tbody>
	</table>
			</div>
		  </div>  
		</div>
		
	</div>
<!-- end wrapper -->

<!-- RELATED PRODUCTS -->
    <h2 style="padding-top:40px;padding-bottom: 20px;font-size: 26px;"> <?php echo googleTranslatetext('Related Products',$_SESSION['lan']); ?></h2>
    <div class="row">
  <?php
	$query = db_query("select id, partnumber, manufacturer, quantity, notes, datasheet from products where manufacturer='".$manufacturer."' limit 3");
	while($res = mysqli_fetch_array($query)){
  ?>
    <div class="col-md-4">
    <div class="side_wrapper1">
    <p style="color:grey;"><a href="<?php print $url_arr['product-detail'];?>_<?php print urlencode($res['partnumber']);?>_<?php echo $res['id']?>"><?php echo $res['partnumber']?></a></p><hr>
	  <div class="headline">
		<span style="color:#029cfc;font-size: 13px;font-weight:bolder;" class="side_wrapper_text">MANUFACTURER</span>&nbsp;
		<span style="color:black;font-size: 13px;" class="side_wrapper_text"><a href="<?php print $url_arr['manufacturer'];?>-<?php print urlencode($res['manufacturer']); ?>"><?php echo $res['manufacturer']?></a></span>
	  </div>
	  <div class="headline" style="padding-top: 10px;">
		<span style="color:#029cfc;font-size: 13px;font-weight:bolder;" class="side_wrapper_text">DC</span>
		<span style="color:black;font-size: 13px;" class="side_wrapper_text"> --</span>
	  </div>
	  <div class="headline"  style="padding-top: 10px;">
		<span style="color:#029cfc;font-size: 13px;font-weight:bolder;" class="side_wrapper_text">STATUS</span>
		<span style="color:black;font-size: 13px;" class="side_wrapper_text"> Ships Today</span>
	  </div>
	  <div class="headline"  style="padding-top: 10px;">
		<span style="color:#029cfc;font-size: 13px;font-weight:bolder;" class="side_wrapper_text">QUANTITY</span>
		<span style="color:black;font-size: 13px;" class="side_wrapper_text"> <?php echo $res['quantity']?></span>
	  </div> 
     </div>
     </div>   
     <?php } ?>
     </div>

     </div>
        <div class="col-md-3 col-12 mx-auto content">
		   <?php
		   $qsql = db_query("SELECT manufacturer, partnumber, quantity from addtoquote WHERE sessionid='".$sessionid."'");
		   $qnum = mysqli_num_rows($qsql);
		   //if($qnum > 0){
		   ?>
			
         <div class="side_wrapper" id="sticky">
         <p style="color:black; font-size: 13px;font-weight: bolder">Your Quote Details</p>
         <hr>
            <div class="headline">
            <span style="color:#029cfc;font-size: 13px;font-weight:bolder;" class="side_wrapper_text">MANUFACTURER</span>
            <span style="color:#029cfc;font-size: 13px;font-weight:bolder;" class="side_wrapper_text">QUANTITY</span>
          </div>
		  <?php while($qrow = mysqli_fetch_array($qsql)){ ?>
           <div class="headline" style="padding-top:10px;">
            <span style="color:black;font-size: 13px;"><?php print $qrow['manufacturer'];?></span>
            <span style="color:black;font-size: 13px;"><?php print $qrow['quantity'];?></span>
          </div>
		  <?php } ?>
           <a href="<?php echo $url_arr['request-quote'];?>" class="btn btn_custom text-right">Send RFQ </a>
	   
        </div>
		<?php //} ?>
    </div>
	
	
<!-- services section starts -->
<section class="services_section" style="padding-top:100px;" id="footer">
<div class="container">
<div class="row ">
<div class="col-md-10 col-12 mx-auto text-center">
<div class="row serv">
   <?php
        $sql = db_query("select * from service_detail where language='".$_SESSION['lan']."'");
        $numrow = mysqli_num_rows($sql);
        if($numrow==0){
        $sql = db_query("select * from service_detail where language='en'");
        }
        while($res = mysqli_fetch_array($sql)){
         $page_url = $res['page_url'];
        ?>
  <div class="col-md-4 col-12 mx-auto">
    <div class="services_box" style="padding:10px 10px;">
    <center><div class="circle_icon" style="margin-top:-60px;">
    <a href="<?php echo $page_url ?>"><img src="service_images/<?php echo $res['icon_image'] ;?>" alt="<?php echo $res['alt_txt'] ;?>" title="<?php echo $res['title_txt'] ;?>" class="img-fluid" width="60" height="60" style="margin-top:19px;"></a>
	</div></center>

    <p style="padding-top:20px;font-size: 16px;color:black;font-weight:600;text-align: center;" class="small_text"><a href="<?php echo $page_url ?>"><?php echo $res['heading'] ;?></a></p>

  <?php echo str_replace('../',SITEURL,$res['description']); ?>

<a href="<?php echo $page_url ?>"><button type="button" class="btn btn-service" style="margin-top:22px;"><?php echo $res['btn_txt'];?></button></a>
   </div>
  </div>
<?php
}
?>
</div>
</div> 
</div>
</section>
<!-- services section ends -->
<!-- Popular Manufacturers & Brands  -->	
<section class="papular" style="padding-top:10px !important;">
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
	
	
</div>    

</section>
<p>&nbsp;</p>
<p>&nbsp;</p>

<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/incrementing.js"></script>
<script>
function addtoQuote(id,m,pn){
	var quantity = $("#quantity").val();
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
			   //alert("Product Added Successfully!");
			   location.reload(); 
			},
		});
	}
}


$(document).ready(function(){
	
var selector = 'input.partsearch';	

$(document).on('keydown.autocomplete', selector, function(){
  // Initialize jQuery UI autocomplete
  $(this).autocomplete({
   source: function(request, response) {
    $.ajax({
     url: "partsearch.php",
     type: 'post',
     dataType: "json",
     data: {
      search: request.term, request:1
     },
     success: function(data) {
      response(data);
     }
    });
   },
   select: function (event, ui){
    var id 		= ui.item.value;
	var label 	= ui.item.label;
    document.getElementById('partnumber').value = label;
    return false;
   },
   minLength: 2,
   delay: 100,
   tokenLimit:10
  });
 });
 
});

</script>
</body>
</html>