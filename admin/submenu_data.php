<?php
include("../includes/connection.php");
$val = $connect->real_escape_string(filter_inputs($_POST['val']));
$menu = $connect->real_escape_string(filter_inputs($_POST['menu']));
?>
<div id="<?php echo $menu;?>submenu_div<?php echo $val;?>" style="margin-bottom:10px;">
<br>
<div class="col-sm-4">
<select class="form-control" name="<?php echo $menu;?>submenu<?php echo $val;?>" required>
<option value="" selected diabled>Select Submenu</option>
<option>About Us</option>
<option>Services</option>
<option>Industries</option>
<option>Line Card</option>
<option>News</option>
<?php
$sql = db_query("select * from mng_pages");
while($res = mysqli_fetch_array($sql)){
?>
<option value="<?php echo $res['id'];?>"><?php echo $res['link_name'];?></option>
<?php
}
?>
</select>
<!-- <input type="hidden" id="submenu_cnt1" value="0"> -->
</div>
<div class="col-sm-4"><a href="javascript:void(0)" class="btn btn-danger" onclick="delete_submenu1('<?php echo $menu;?>','<?php echo $val;?>')">X</a></div>
<br>
</div>

