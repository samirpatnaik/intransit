<?php
include("../includes/connection.php");

// DB table to use
$table = 'products';
// Table's primary key
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'partnumber', 	'dt' => 0 ),
    array( 'db' => 'manufacturer',  'dt' => 1 ),
    array( 'db' => 'quantity',   	'dt' => 2 ),
    array( 'db' => 'datasheet',     'dt' => 3 ),
	array( 'db' => 'id', 'dt' => 4,
			'formatter' => function( $d, $row ) {
            return '<a href="add_products.php?id='.$d.'"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;
			<a href="?delid='.$d.'"><i class="fa fa-trash-o" aria-hidden="true" onclick="return confirm(\'Are you sure to delete this product?\');"></i></a>';
        }
	)
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root', /*'thought3_intransit',*/
    'pass' => '', /*'intransit',*/
    'db'   => 'intransit', /*'thought3_intransit',*/
    'host' => 'localhost'
);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>
