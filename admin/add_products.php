<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "brand text";

if($language=="") {$language = "en"; }

$stage = $connect->real_escape_string(@$_POST['stage']);

if ($stage == 4) {
	$allowed_extensions = array('csv', 'CSV');
	if ($_FILES['mfile']['name'] != ""){
		$filenamenew = $_FILES['mfile']['name'];
        $path_info = pathinfo($filenamenew);
        $is_valid = in_array($path_info['extension'], $allowed_extensions);

        if (empty($is_valid)) {
            $msg = "Incorrect file extension, Please upload a CSV file";
            setcookie("msg", $msg, time() + 3);
            print "<script>";
            print "self.location = 'add_products.php';";
            print "</script>";
            exit;
        } else {
            $path2 = "manufacturers";
            $s1 = rand();
            $realname = removeSpchar($_FILES['mfile']['name']);
            $realname = $s1 . "_" . $realname;
            $dest = $path2 . "/" . $realname;
            move_uploaded_file($_FILES['mfile']['tmp_name'],$dest);
        }
	}
	
	$file = $dest;
 
	$action = $connect->real_escape_string($_POST['action']);
	
	if($action=='update'){
		
	/* READ THE CSV FILE AND DELETE RECORDS */
	$CSVfp = fopen($file, "r");
	if($CSVfp !== FALSE) {
	 while(! feof($CSVfp)) {
	  $data = fgetcsv($CSVfp, 1000, ",");
	  db_query("DELETE from `products` WHERE partnumber='".trim($data[0])."'");
	 }
	}
	fclose($CSVfp);
	
	/* ADD NEW RECORDS */
	db_query('LOAD DATA LOCAL INFILE "'.$file.'" INTO TABLE `products`
	FIELDS TERMINATED by \',\'
	LINES TERMINATED BY \'\n\' (@col1,@col2,@col3,@col4,@col5) set partnumber=@col1, manufacturer=@col2, quantity=@col3, datasheet=@col4, notes=@col5');
	
	db_query("update `products` set partnumber = REPLACE(REPLACE(partnumber, '\r', ''), '\n', '');");
	
	$msg = "Products Updated Successfully.";
	/*
	update `products` set partnumber = REPLACE(REPLACE(partnumber, '\r', ''), '\n', '');
	update `products` set partnumber = REPLACE(REPLACE(partnumber, '(', ''), ')', '');
	update `products` set partnumber = REPLACE(REPLACE(partnumber, '"', ''), ' ', '');
	update `products` set partnumber = REPLACE(partnumber, "'", "");
	update `products` set partnumber = REPLACE(partnumber, "/", "-");
	update `products` set partnumber = REPLACE(partnumber, "*", "");
	update `products` set partnumber = REPLACE(partnumber, "@", "");
	update `products` set partnumber = REPLACE(partnumber, "^", "");
	update `products` set partnumber = REPLACE(REPLACE(partnumber, '#', ''), '!', '');
	update `products` set partnumber = REPLACE(REPLACE(partnumber, '+', ''), '=', '');
	update `products` set partnumber = REPLACE(REPLACE(partnumber, '$', ''), '&', '');
	
	update `products` set manufacturer = REPLACE(REPLACE(manufacturer, '\r', ''), '\n', '');
	update `products` set manufacturer = REPLACE(REPLACE(manufacturer, '"', ''), '+', '');
	update `products` set manufacturer = REPLACE(REPLACE(manufacturer, '^', ''), '@', '');
	update `products` set manufacturer = REPLACE(REPLACE(manufacturer, '/', ''), '*', '');
	update `products` set manufacturer = REPLACE(REPLACE(manufacturer, '$', ''), '&', '');
	*/

	}
	
	if($action=='remove'){
	/* DELETE OLD RECORDS */
	db_query("TRUNCATE  TABLE `products` ");
	
	/* ADD NEW RECORDS */
	db_query('LOAD DATA LOCAL INFILE "'.$file.'" INTO TABLE `products`
	FIELDS TERMINATED by \',\'
	LINES TERMINATED BY \'\n\' (@col1,@col2,@col3,@col4,@col5) set partnumber=@col1, manufacturer=@col2, quantity=@col3, datasheet=@col4, notes=@col5');
	
	db_query("update `products` set partnumber = REPLACE(REPLACE(partnumber, '\r', ''), '\n', '');");
			
	$msg = "Products Updated Successfully.";
	}
	
	
	if($action=='addnew'){
	/* ADD NEW RECORDS */
	db_query('LOAD DATA LOCAL INFILE "'.$file.'" INTO TABLE `products`
	FIELDS TERMINATED by \',\'
	LINES TERMINATED BY \'\n\' (@col1,@col2,@col3,@col4,@col5) set partnumber=@col1, manufacturer=@col2, quantity=@col3, datasheet=@col4, notes=@col5');
	
	db_query("update `products` set partnumber = REPLACE(REPLACE(partnumber, '\r', ''), '\n', '');");
			
	$msg = "Products Added Successfully.";
	}
	
	setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_products.php';";
    print "</script>";
}



if ($stage == 2) {
    $partnumber 	= $connect->real_escape_string($_POST['partnumber']);
    $manufacturer 	= $connect->real_escape_string($_POST['manufacturer']);
    $quantity 		= $connect->real_escape_string($_POST['quantity']);
    $notes 			= $connect->real_escape_string($_POST['notes']);
    $datasheet 		= $connect->real_escape_string($_POST['datasheet']);
    $date 			= date("Y-m-d");
    $status 		= '1';
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
	if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_text.php;";
        print "</script>";
        exit;
    }
    // Build POST request
	
    if ($recaptcha->score = 0.5) {
	db_query("INSERT INTO `products` set partnumber='".$partnumber."', manufacturer='".$manufacturer."', date='".$date."', quantity='".$quantity."', notes='".$notes."', datasheet='".$datasheet."', status='".$status."'");
    $msg = "Product Added Successfully.";
	
    setcookie("msg", $msg, time() + 3);
	print "<script>";
    print "self.location = 'add_products.php';";
    print "</script>";
    exit;
	}else{
		$msg = "Please check the captcha.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'add_products.php';";
        print "</script>";
    }
}

if ($stage == 3) {
    $partnumber 	= $connect->real_escape_string($_POST['partnumber']);
    $manufacturer 	= $connect->real_escape_string($_POST['manufacturer']);
    $quantity 		= $connect->real_escape_string($_POST['quantity']);
    $notes 			= $connect->real_escape_string($_POST['notes']);
    $datasheet 		= $connect->real_escape_string($_POST['datasheet']);
    $date 			= date("Y-m-d");
    $status 		= '1';
    $id = $connect->real_escape_string($_POST['id']);
    
    $captcha = $connect->real_escape_string($_POST['recaptchaResponse']);
	if(!$captcha){
        $msg = "Please check the captcha form.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_brand_text.php;";
        print "</script>";
        exit;
    }
    // Build POST request
	
    if ($recaptcha->score = 0.5) {
	db_query("UPDATE `products` set partnumber='".$partnumber."', manufacturer='".$manufacturer."', date='".$date."', quantity='".$quantity."', notes='".$notes."', datasheet='".$datasheet."', status='".$status."' WHERE id='".$id."'");
	

	
    $msg = "Product Updated Successfully.";
	
    setcookie("msg", $msg, time() + 3);
	print "<script>";
    print "self.location = 'mng_products.php';";
    print "</script>";
    exit;
	}else{
		$msg = "Please check the captcha.";
        setcookie("msg", $msg, time() + 3);
        print "<script>";
        print "self.location = 'mng_products.php';";
        print "</script>";
    }
}

if($_GET['id']){
	$id = $connect->real_escape_string($_GET['id']);
	$sql= db_query("select partnumber, manufacturer, quantity, notes, datasheet from `products` where id='".$id."'");
	$row 		= mysqli_fetch_array($sql);
	$partnumber = $row['partnumber'];
	$manufacturer = $row['manufacturer'];
	$quantity 	= $row['quantity'];
	$notes 		= $row['notes'];
	$datasheet 	= $row['datasheet'];
}


?>
<!DOCTYPE HTML>
<!--[if lt IE 9]><html class="lt-ie9"><![endif]-->
<!--[if gt IE 9]><html><![endif]-->
<!--[if !IE]>--> <html> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<title>Intransit || Admin</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!--font-awesome Stylesheet-->
<?php 
include_once('css.php');
?>

<script src="tinymce/tinymce.min.js"></script>
<script src="tinymcejs.js"></script>

<script>
tinymce.init({
selector: '#description1,#img_text,#bannertext,#detail',
width: '100%', height:200 
})


function chnageLang(val){
  self.location = 'mng_brand_text.php?language='+val;
}
</script>
</head>
<body>
<!--left-side-->
<div id="left">
<!--logo-->

<!--end logo-->
<!--sidebar-menu-->
<?php include("sidebar.php");?>
<!--sidebar-menu-->
<!--copy-->

<!--end copy-->
</div>
<!--end left-side-->

<!--main-container-part-->
<div id="content">
<!--main area--> 
<div class="container clearfix">
  <div class="row clearfix">
        <div class="admin_top">
            <ul>
                <li><a href="#null">Hi Admin</a></li>
            </ul>
        </div>            
        <div class="admin_cont">
          <div class="col-md-12">
          <h2>Add Products</h2>
		  <a href="mng_products.php" class="btn btn-primary pull-right">Back</a>
            <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
	  <div class="clearfix"></div>
      <div class="row">
	  <div class="col-md-6">
		<div class="wbox1" style="padding-top:25px;"> 
		<form name="pwd" method="POST" action="" autocomplete="off">
           <?php if($id==""){ ?>
			  <input type="hidden" name="stage" value="2">
			  <?php }else{ ?>
			  <input type="hidden" name="stage" value="3">
			  <input type="hidden" name="id" value="<?php print $id; ?>">
			  <?php } ?>
			  <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">

            <div class="form-group row">
			<label class="col-sm-12 form-control-label">Part Number</label>
			<div class="col-sm-12">
			  <input type="text" value="<?php print $partnumber; ?>" class="form-control" name="partnumber" placeholder="Enter Part Number" required>
			</div>
            </div>
        
            <div class="form-group row">
			<label class="col-sm-12 form-control-label">Manufacturer</label>
			<div class="col-sm-12">
			  <input type="text" value="<?php print $manufacturer; ?>" class="form-control" name="manufacturer" placeholder="Enter Manufacturer" required>
			</div>
            </div>

            <div class="form-group row">
			<label class="col-sm-12 form-control-label">Quantity</label>
			<div class="col-sm-12">
			  <input type="text" value="<?php print $quantity; ?>" class="form-control" name="quantity" placeholder="Enter Quantity" required>
			</div>
            </div>

            <div class="form-group row">
			<label class="col-sm-4 form-control-label">Datasheet Available?</label>
			<div class="col-sm-8">
			  <input type="radio" name="datasheet" value="1" required> Yes &nbsp;&nbsp;
			  <input type="radio" name="datasheet" value="0" required> No 
			</div>
            </div>
			
            <div class="form-group row">
			<label class="col-sm-12 form-control-label">Notes</label>
			<div class="col-sm-12">
			   <textarea class="form-control" name="notes" id="notes" placeholder="Enter Notes"><?php print $notes; ?></textarea>
			</div>
            </div>			
            
            <div class="form-group row">
              <div class="col-sm-offset-4 col-sm-10">
              
                 <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            </form>
                      
             <div class="clearfix"></div>    
        
        </div>	  
	  
	  
	  </div> 
	  
	  
	  
	  
	  <div class="col-md-5 pull-right">
	  <div class="wbox1" style="padding-top:25px;"> 
	  <form name="pwd" method="POST" action="" autocomplete="off" enctype="multipart/form-data" >
		<input type="hidden" name="stage" value="4">

            <div class="form-group row">
			<label class="col-sm-12 form-control-label">Upload CSV File</label>
			<div class="col-sm-12">
			  <input type="file" value="" class="form-control" name="mfile" accept=".csv" required>
			</div>
            </div>
        
            <div class="form-group row">
			<label class="col-sm-3 form-control-label">Action</label>
			<div class="col-sm-9">
			<input type="radio" name="action" value="update" required> Update  &nbsp;&nbsp;&nbsp;
			<!-- <input type="radio" name="action" value="remove" required> Remove & Add New  &nbsp;&nbsp;&nbsp;
			-->
			<input type="radio" name="action" value="addnew" required> Add New
			</div>
			
			
            </div>
			<div class="form-group row">
			<div class="col-sm-12">
			** Update will update old data and add if found nay new data in CSV file. <br/>
			<!-- ** Remove & Add New will remove all old data and insert new data from CSV file. <br/> -->
			** Add New will insert new data from CSV file. <br/>
			** <a href="products.csv"><b>Click here</b></a> to download sample CSV file. <br/>
			</div>
			</div>
			
            
            <div class="form-group row">
              <div class="col-sm-offset-4 col-sm-10">
              
                 <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
			
			
            </form>
	   </div>
	  
	  </div>
	  
	  </div>
      

      
                      
            <div class="clearfix"></div>

            </div>            
            <div class="clearfix"></div>
        </div>
        
    </div>      
</div>
<!--End-main area-->
   
</div>
<!--end-main-container-part-->
<script src="https://www.google.com/recaptcha/api.js?render=<?php print $sitekey; ?>"></script>
<script>
grecaptcha.ready(function () {
    grecaptcha.execute('<?php print $sitekey; ?>',{action:'login'}).then(function(token){
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
    });
});
</script>

<script src="js/matrix.js"></script>
</body>
</html>
