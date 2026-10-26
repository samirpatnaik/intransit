<?php
//fetch.php
include("includes/connection.php"); 
include("css.php");
$search = '';

if(isset($_GET["query"]))
{
 /*$search = $connect->real_escape_string($_POST['query']);*/
   
   $search = $_GET["query"];


 $tbl_name="products";    //your table name
 $adjacents = 5;        
 $limit =10; 

 $query = "
 SELECT * FROM $tbl_name
  WHERE partnumber LIKE '%$search%';
 ";
}
else
{
 $query = "
  SELECT * FROM products ORDER BY id
 ";
}
$result = db_query($query);

if($result){


include('../pagination.php');
              $result =db_query($query);
              if(isset($_GET['page']))
              $n=($_GET['page']*$limit)-$limit+1;
              else
              $n=1;
            


 
 while($row = mysqli_fetch_array($result))
 {

  ?>
              <div class="wrapper" style="margin-top:35px;">
                <div class="headline">
                <p><?php echo $row["partnumber"]; ?></p>
                <a href="#" style="color:#029cfc;">Details&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></a>
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
                           <p style="color:black;font-size: 14px;">--</p>
                                    </td>

                                    <td width="40%" class="text-right" >
                                        
                              <button type="button" class="btn btn_custom text-right">Add to Quote
                                          </button>

                                          <?php 
                                          if($row['datasheet'] == 1){
                                            ?>
                          
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
  <?php

}

}
include('js.php');

?>

