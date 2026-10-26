<?php
include("includes/connection.php");
$query  = $connect->real_escape_string($_POST['search']);
$sql = db_query("select id,partnumber,manufacturer from products where partnumber like '".$query."%' order by partnumber limit 10");
while($row = mysqli_fetch_array($sql)){
	$data[] = array( "value" => $row["id"] , "label" => $row["partnumber"], "manu"=>$row["manufacturer"]);
	//$data[] = $row["partnumber"];
}
echo json_encode($data);
exit;
?>