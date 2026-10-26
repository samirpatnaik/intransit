<?php
include("includes/connection.php");
$sessionid = session_id();
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	
$del = $_POST['del'];
	foreach($del as $d){
		db_query("DELETE from addtoquote WHERE id='".$d."'");
	}
}
?>
<table class="table">
<thead>
  <tr style="font-size: 13px;color:#029cfc;font-weight:bolder;">
	 <th></th>
	<th>PART NUMBR</th>
	<th>MANUFACTURER</th>
	<th>QUANTITY</th>
	<th>TARGET PRICE</th>
	<th>NEED BY</th>
  </tr>
</thead>
<tbody>

<tr>
<?php
   $qsql = db_query("SELECT id,manufacturer, partnumber, quantity from addtoquote WHERE sessionid='".$sessionid."'");
   $qnum = mysqli_num_rows($qsql);
   if($qnum > 0){
	while($qrow = mysqli_fetch_array($qsql)){	
?>
	<td><input type="checkbox" id="del" name="del[]" value='<?php print $qrow['id'];?>'></td>
	<td><?php print $qrow['partnumber'];?></td>
	<td><?php print $qrow['manufacturer'];?></td>
	<td><input type="text" name="qty[]" value="<?php print $qrow['quantity'];?>" style="width: 80px;border-radius: 10px;padding: 7px 15px;"></td>
	<td>$ <input type="text" name="price[]" value="" style="width:80px; border-radius:10px; padding: 7px 15px;"></td>
	<td>
	 <select name="needby[]" class="form-control">
	 <?php 
		$nsql = db_query("select text from `needby` order by id");
		while($nrow= mysqli_fetch_array($nsql)){
	 ?>
	  <option value="<?php print $nrow['text'];?>"><?php print $nrow['text'];?></option>
	<?php } ?>
	</select>
	</td>
  </tr>
   <?php } } ?>    
</tbody>
</table>