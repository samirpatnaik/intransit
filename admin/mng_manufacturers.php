<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "manufacturer";

$delid = $connect->real_escape_string(filter_inputs($_GET['delid']));
if($delid !=""){
	db_query("DELETE from `manufacturers` where id=".$delid);
    $msg = "Manufacturer Deleted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_manufacturers.php';";
    print "</script>";
    exit;
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
          <h2>Manage Manufacturers</h2>
		  
		<a href="add_manufacturers.php" class="btn btn-primary pull-right">Add New</a>
		  
      <?php if (@$_COOKIE['msg']) { ?>
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
        <?php print $_COOKIE['msg']; ?>
        </div>
      <?php } ?>
      
      <div class="wbox1" style="padding-top:25px;"> 
        
		<table id="spreadsheet_db" class="table table-bordered" style="width:100%">
		<thead>
			<tr class="bg-info">
				<th><span>Manufacturer</span></th>
				<th><span>Detail</span></th>
				<th style="width: 80px;"><span>&nbsp;</span></th>                                            
			</tr>
		</thead>
		<tbody>
		<?php 
			$query  = db_query("SELECT id, mname, detail FROM manufacturers order by mname"); 
			while($resuser = mysqli_fetch_array($query)){     
		?>
		<tr>
			<td><?php echo $resuser['mname'];?></td>
			<td><?php echo strip_tags($resuser['detail']);?></td>
			<td align="center" width="80">
			 <a href="add_manufacturers.php?id=<?php print $resuser['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;
			<a href="?delid=<?php print $resuser['id']; ?>" onclick="return confirm('Are you sure to delete manufacturer?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
			</td>  
		</tr>
		<?php
		   }
		?> 
					  
	</tbody>
	</table>
		
                      
      <div class="clearfix"></div>
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

<script>

$(document).ready(function() {
    var table = $('#spreadsheet_db').DataTable( {       
        paging:         true,
        "pageLength": 25,
        "dom": '<"toolbar">frtip',
        "columnDefs": [
            { "orderable": false, "targets": -1 }
          ],
        language: {
            search: "" ,
            searchPlaceholder: "Manufacturer Search"
        }
    } );
} );

</script>
<script src="js/datatables.js"></script>
<script src="js/matrix.js"></script>
</body>
</html>
