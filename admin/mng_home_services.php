<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "home";

$delid = $connect->real_escape_string(filter_inputs($_GET['delid']));
if($delid !=""){
    $sql = db_query("select * from home_services where id=".$delid);
    $row = mysqli_fetch_array($sql);
    $icon_image= $row['icon_image'];
    $delpath ="../service_images/".$blog_image;
    @unlink($delpath);
    
    db_query("delete from home_services where id=".$delid);
    
    $msg = "Data Deleted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_home_services.php';";
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
            <h2 style="display:inline-block; margin-bottom:30px">Manage Home Page Services</h2>
            <a href="add_home_services.php" class="btn btn-success greenbtn pull-right">Add New</a>
            <?php if (@$_COOKIE['msg']) { ?>
                <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" onClick="$('.alert').hide('slow');">&times;</a>
                 <?php print $_COOKIE['msg']; ?>
                </div>
            <?php } ?>
            </div> 
      
     <div class="admin_table">
                        <div class="col-md-12">
                            <div class="member_list">
                                <table class="table d-flex flex-direction-row">
                                  <thead>
                                    <tr>
                                    <th width="18%">Heading</th>
                                    <th width="40%">Description</th>
                                      <th width="20%">Icon Image</th> 
                                      <th width="18%">Button Text</th>
                                      <th width="18%">Language</th>
                                      <th>&nbsp;</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php 
                                        $query  = db_query("SELECT * FROM home_services order by id desc "); 
                                        while($resuser = mysqli_fetch_array($query)){
                                        
                                            
                                    ?>
                                    <tr>
                                      <td style="width: 10% !important;">
                                        <?php echo $resuser['heading']?>
                                      </td>
                                      <td><?php echo $resuser['description'];?></td>
                                      <td><img src="../service_images/<?php echo $resuser['icon_image']?>" width="100px" height="100px"></td>
                                      <td><?php echo $resuser['btn_txt']?></td>
                                        <td><?php echo $resuser['language']?></td> 
                                      <td>

                                      <a href="add_home_services.php?id=<?php print $resuser['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                      <a href="?delid=<?php print $resuser['id']; ?>" onclick="return confirm('Are you sure to delete this service?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                      
                                      </td>
                                    </tr>
                                   <?php
                                    }
                                   ?>
                                  </tbody>
                                </table> 
                            </div>             
                        </div>
                    </div>
       
        
    </div>      
</div>
<!--End-main area-->
   
</div>
<!--end-main-container-part-->

<script src="js/matrix.js"></script>
</body>
</html>
