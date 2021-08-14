<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
//$table = 'Person_TD';
$table="( SELECT
c.idCustomer,
c.c_name,
c.c_sname,
c.c_status,
c.Area_idArea,
c.c_address,
c.c_phone,
c.c_comment,
c.sessionID,
CASE
    WHEN cs.conn_status_name <> ''
    THEN cs.conn_status_name
    ELSE
          (
          SELECT
              conn_status_name
          FROM
              connection_status_TD
          WHERE
              conn_status_id =2)
END conn_status_name
FROM
Customer_TD c
LEFT JOIN
connection_status_TD cs
ON
c.c_status = cs.conn_status_id

)Customer_TD ";

// Table's primary key
$primaryKey = 'idCustomer';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(


    array( 'db' => 'sessionID','dt' => 0 ),
    array( 'db' => 'c_name','dt' =>1 ),
    array( 'db' => 'c_address','dt' => 2 ),
    array( 'db' => 'c_phone','dt' => 3 ),
    array( 'db' => 'conn_status_name','dt' => 4),
    array( 'db' => 'idCustomer','dt' => 5 )


);
$whereAll =' 1=1 ';

if (isset($_GET['customer_name'])) {
        $customer_name = $_GET['customer_name'];
        if($customer_name != ""){
            $whereAll.=" and c_name like '%".$customer_name."%' " ;
        }


}
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if($status !="0"){
        $whereAll.=" and c_status = '".$status."'";
    }
}

// echo ' SELECT * from '.$table.' where '.$whereAll;
// SQL server connection information

$serverName = "db01.hrdi.or.th";
$userName = "farmer";
$userPassword = "F95uRw";
$dbName = "HRDI_Farmer";



$sql_details = array(
    'user' => $userName,
    'pass' => $userPassword,
    'db'   => $dbName,
    'host' => $serverName
);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
   // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
       SSP::complex (  $_GET, $sql_details, $table, $primaryKey, $columns, null,$whereAll)
);
