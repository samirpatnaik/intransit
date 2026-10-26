<?php 
include("includes/connection.php"); 
$url_arr=pageurl();
$page_seo=pageSEO();
$home=Translatetext();
$pageurl = $url_arr['parts-search'];

// Look for a GET variable page if not found default is 1.
if (isset($_GET["page"])) {
	$pn = $_GET["page"];
} else {
	$pn = 1;
}
$start = ($pn - 1) * $limit;
$limit = 20;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page_seo['parts-search']['meta_title'] ?></title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $page_seo['parts-search']['keywords']?>" />
<meta name="description" content="<?php echo $page_seo['parts-search']['meta_desc']; ?>"  />
<?php if(trim($page_seo['parts-search']['meta_tags'])!=""){ echo $page_seo['parts-search']['meta_tags']; }?>
<?php include('css.php'); ?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
<style>
.ui-autocomplete-loading {
	background: white url("images/loading.gif") center center;
	background-repeat: no-repeat;
	background-size: 16px 16px;
}

.centered {
  position: fixed;
  top: 55%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
  z-index: 999;
  max-width:650px;
  width:98%;
  text-align:center;
  color: #000;
  display:block;
  padding: 40px 30px;
  background:rgba(255,255,255,.5);
  
}
</style>
</head>
<body>
<div class="centered" id="loading">
<h3>Loading Search Results, Please wait..</h3>
<img src="images/loadingprogress.gif" alt="loading" title="loading" style="margin-top:20px;">
</div>
<!-- //header -->
<?php include('header.php'); ?>
<!-- //header -->

<!-- banner -->
<?php 
	$sql = db_query("select * from mng_inner_banner where language='".$_SESSION['lan']."' and page='partsearchbanner'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from mng_inner_banner where language='en' and page='partsearchbanner'");
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


<section class="parts_search" style="margin:30px 0;">
<div class="container">
    <div class="row">
		<div class="col-md-12 col-12">
		<iframe id="iFrame" frameborder="0" marginwidth="0" marginheight="0" scrolling="auto" width="100%" height="600"></iframe>
		</div>
	</div>
</div>
</section>
<!-- Parts Search Content -->

<section class="parts_search">
<div class="container">
    <div class="row">
        <div class="col-md-12 col-12 mx-auto" style="padding-bottom:50px;">
            

<?php  
/* SEARCH BOTH Product Part AND  Manufacturer*/
$searchdata = $connect->real_escape_string(trim($_REQUEST['partnumber1']));

if($searchdata){
	$psql = "select id, partnumber, manufacturer, quantity, datasheet from `products` where (partnumber LIKE '%$searchdata%' OR manufacturer LIKE '%$searchdata%') order by partnumber LIMIT $start, $limit ";

	/* Variant List */
	$vsql="SELECT partnumber FROM products WHERE partnumber LIKE '%$searchdata%' OR manufacturer LIKE '$searchdata%' LIMIT 20;";

	/*GET TOTAL RECORDS */
	$tsql = db_query("select count(1) from products where (partnumber LIKE '%$searchdata%' OR manufacturer LIKE '%$searchdata%') ");
	$trow = mysqli_fetch_array($tsql);
	$totalrecords = $trow[0];
	$totalPages = ceil($totalrecords / $limit);

	/* SEARCH STRING */
	$string = "partnumber1=".$searchdata;
	
	/* SAVE SEARCH DATA */
	$ssql = db_query("SELECT id, partnumber, manufacturer from `products` where (partnumber Like '%$searchdata%' OR manufacturer Like '%$searchdata%')");
	$srow = mysqli_fetch_array($ssql);
	$m = $srow['manufacturer'];
	$p = $srow['partnumber'];
	$id = $srow['id'];
	if($m!="" or $p!=""){
		db_query("INSERT INTO `search_query` set manufacturer='".$m."', partnumber='".$p."',partid='".$id."' ");
	}

}
/* SEARCH ONLY PART # */
else if($_REQUEST['partnumber']){
	$searchdata = $connect->real_escape_string(trim($_REQUEST['partnumber']));
	$psql = "select id, partnumber, manufacturer, quantity, datasheet from `products` where partnumber LIKE '%$searchdata%' order by partnumber  LIMIT $start, $limit ";	

	/* Variant List */
	$vsql="SELECT partnumber FROM products WHERE partnumber LIKE '%$searchdata%' LIMIT 20;";

	/*GET TOTAL RECORDS */
	$tsql = db_query("select count(1) from products where partnumber LIKE '%$searchdata%' ");
	$trow = mysqli_fetch_array($tsql);
	$totalrecords = $trow[0];
	$totalPages = ceil($totalrecords / $limit);

	$string = "partnumber=".$searchdata;
	
	/* SAVE SEARCH DATA */
	$ssql = db_query("SELECT id, partnumber, manufacturer from `products` where (partnumber LIKE '%$searchdata%')");
	$srow = mysqli_fetch_array($ssql);
	$p = $srow['partnumber'];
	$m = $srow['manufacturer'];
	$id = $srow['id'];
	if($p){
		db_query("INSERT INTO `search_query` set manufacturer='".$m."', partnumber='".$p."',partid='".$id."' ");
	}
	
	
}else{
	$searchdata = "";
	$psql = "select id, partnumber, manufacturer, quantity, datasheet from `products` order by partnumber  LIMIT $start, $limit ";	

	/* Variant List */
	//$vsql="SELECT partnumber FROM products WHERE partnumber LIKE '%$searchdata%' LIMIT 20;";

	/*GET TOTAL RECORDS */
	$tsql = db_query("select count(1) from products");
	$trow = mysqli_fetch_array($tsql);
	$totalrecords = $trow[0];
	$totalPages = ceil($totalrecords / $limit);

	$string = "";
	
}
if($psql){
$result_set = db_query($psql);
while($row = mysqli_fetch_array($result_set)) {
?>
<div class="wrapper">
		<div class="headline">
		<p><?php echo $row["partnumber"]; ?></p>
	<!--
		<a href="<?php /* print $url_arr['product-detail'];?>?id=<?php print $row['id']; */?>" style="color:#029cfc;">Details&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></a>
	-->
		<a href="<?php print $url_arr['product-detail'];?>_<?php print urlencode($row['partnumber']);?>_<?php print $row['id']; ?>" style="color:#029cfc;">Details&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></a>
		
		 </div>
		<hr>
		<div class="content">
		  <div class="row">
			<div class="table-responsive">
				<table class="table borderless">
					<tbody>
						<tr class="d-flex">
							<td  width="40%">
							<p class="small_heading">MANUFACTURER</p>
				  <p style="color:black;font-size: 14px;"><?php echo $row["manufacturer"]; ?></p>
							</td>
							<td  width="10%">
							<p class="small_heading ">DC</p>
				  <p style="color:black;font-size: 14px;">--</p> 
							</td>
							<td  width="20%"><p class="small_heading">STATUS</p>
				  <p style="color:black;font-size: 14px;">Ships Today</p> </td>

							<td width="20%">  <p class="small_heading">QUANTITY</p>
				  <p style="color:black;font-size: 14px;">--</p></td>

				  <td width="25%" class="float-left">
				  <p class="small_heading">QUANTITY</p>
				  <div class="nice-number">
				  <!-- <button   class="cssCircle minusSign">-</button> -->
				  <input type="number" class="quantity_value" name="quantity<?php echo $row["id"]; ?>" id="quantity<?php echo $row["id"]; ?>" value="0">
				  <!-- <button  class="cssCircle plusSign">+</button> -->
				   </div>
				  </td>
				  <td width="30%" class="text-right" >
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
		<a class="page-link" href="<?php print $pageurl;?>?page=<?php echo (($pn-1)).'&'.$string;?>">Previous</a></li>
		<?php }
		if (($pn - 1) > 1){
		?>
		<li class="page-item"><a class="page-link" href="<?php print $pageurl;?>?page=1&<?php print $string; ?>">1</a></li>
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
	<li class="page-item"><a class="page-link <?php echo $class; ?>" href="<?php print $pageurl;?>?page=<?php echo $i.'&'.$string;?>"><?php echo $i; ?></a></li>
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
	<li class="page-item"><a class="page-link <?php echo $class; ?>" href="<?php print $pageurl;?>?page=<?php echo $totalPages.'&'.$string;?>">
	<?php echo $totalPages; ?></a></li> 
	<?php
	}
	?>
    <?php
    if (($pn < $totalPages)) {
    ?>
	<li class="page-item"><a class="page-link" href="<?php print $pageurl;?>?page=<?php echo (($pn+1)).'&'.$string;?>">Next</a></li>
    <?php
    }
    ?>
	</ul>
</nav>    
</div>
</div>
</div>
</section>

<section class="about">
<div class="container">
<div class="row">
<div class="col-md-12">
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
</div>
</section>





<!-- //about bottom -->
<?php include("footer_request_quote.php");?>
<!-- footer -->
<?php include('footer.php'); ?>
<!-- //copyright -->
<?php include('js.php'); ?>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/incrementing.js"></script>
<script type="text/javascript">
function myFunction(val) {
  //document.getElementById("myForm").submit();
  window.location="<?php echo $url_arr['parts-search'];?>?partnumber="+val;
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
   select: function (event, ui) {
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

<!-- <script type="text/javascript">
	
$(document).ready(function(){
	$("#partnumber").on('change',function(){
		var value = $(this).val();
		$.ajax({
			url:'dropdown_part_search.php',
			type:'POST',
			data:'partnumber='+value,
			beforeSend:function(){
                 $("#result").html('working on....');
			},
			success:function(data){
                 $("#result").html(data);
			},
		});
	});
});



</script> -->
<!-- <script type="text/javascript">
	let result = document.getElementById("result");


	function imu(x){
		if(x.length == 0){
			result.innerHTML = 'No Data Found'
		}
		else{
			var XML = new XMLHttpRequest();
			XML.onreadystatechange = function(){
                 if(XML.readyState == 4 && XML.status == 200){
                 	result.innerHTML = XML.responseText;
                 }
			};

			XML.open('GET','fetch-parts-search.php?query='+x, true);
			XML.send();
		}
	}
</script> -->
<!-- <script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"fetch-parts-search.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});
</script> -->

<script type="text/javascript">
function QueryStringPart(){
	var query = window.location.search.substring(1);
	query = unescape(query);
	var pairs = query.split("&");
	for (var i=0;i<pairs.length;i++){
		var pos = pairs[i].indexOf('=');
		if (pos >= 0){
			var argname = pairs[i].substring(0,pos);
				if (argname == 'part') {
					var value = pairs[i].substring(pos+1);
					return value;
				}
			}
		}
		return "";
	}
function GetWebLink() {     
//document.getElementById("iFrame").src="https://icsource.com/icsourcewdl/icswdl2.aspx?user=intrans&part="+ QueryStringPart();
document.getElementById("iFrame").src="https://icsource.com/icsourcewdl/icswdl2.aspx?user=intrans&part=<?php print $searchdata; ?>";

}
$(window).load(function () {
	$("#loading").hide();
});

</script>
<script type="text/javascript">
    GetWebLink();
</script>

</body>
</html>
