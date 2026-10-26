<?php
include("../includes/connection.php");
if (!isset($_SESSION['nm'])):
    header("location:index.php");
endif;
$page = "blog";

$delid = $connect->real_escape_string(filter_inputs($_GET['delid']));
if($delid !=""){
    $sql = db_query("select * from mng_blog where id=".$delid);
    $row = mysqli_fetch_array($sql);
    $blog_image = $row['image'];
    $delpath ="../upload_page_images/".$blog_image;
    @unlink($delpath);
    
    db_query("delete from mng_blog where id=".$delid);
    
    $msg = "Data Deleted Successfully.";
    setcookie("msg", $msg, time() + 3);
    print "<script>";
    print "self.location = 'mng_list_blog.php';";
    print "</script>";
    exit;
}
$sql = db_query("select * from mng_blog");
$row = mysqli_fetch_array($sql);
$image = $row['image'];
$title = $row['title'];
$publish_date = date("M d, Y", strtotime($row['publish_date']));
$author_name = $row['author_name'];
$details = $row['description'];
$language = $row['language'];
$metatitle = $row['metatitle'];
$metadescription = $row['metadescription'];
$metakeywords = $row['metakeywords'];
$moretags = $row['moretags'];
$alt_txt = $row['alt_txt'];
$title_txt = $row['title_txt'];
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
            <h2 style="display:inline-block; margin-bottom:30px">Blog Management</h2>
            <a href="mng_blog.php" class="btn btn-success greenbtn pull-right">Add New</a>
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
                                    <th width="18%">Blog Title</th>
                                    <th width="18%">Blog Image</th>
                                      <th width="10%">Publish Date</th> 
                                      <th width="15%">Author Name</th>
                                      <th width="50%">Blog Content</th>
                                      <th width="18%">Language</th>
                                      <th>&nbsp;</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php 
                                        $query  = db_query("SELECT * FROM mng_blog order by id desc "); 
                                        while($resuser = mysqli_fetch_array($query)){
                                        
                                            
                                    ?>
                                    <tr>
                                      <td style="width: 10% !important;">
                                        <?php echo $resuser['title']?>
                                      </td>
                                      <td><img src="../upload_page_images/<?php echo $resuser['image']?>" width="100px" height="100px"></td>
                                       <td><?php echo date("M d, Y", strtotime($resuser['publish_date']));?></td>
                                       <td><?php echo $resuser['author_name']?></td>
                                       <td><?php echo word_limiter($details, 50);?></td>
                                        <td><?php echo $resuser['language']?></td> 
                                      <td>

                                      <a href="mng_blog.php?id=<?php print $resuser['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                      <a href="?delid=<?php print $resuser['id']; ?>" onclick="return confirm('Are you sure to delete this blog?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                      
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
