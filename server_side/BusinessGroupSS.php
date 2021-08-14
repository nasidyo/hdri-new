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



$table=" ( SELECT
business_group_id,
business_group_name,
sub_group_id,
status,
CASE
    WHEN status ='Y'
    THEN 'ใช้งาน'
    ELSE 'ระงับการใช้งาน'
END status_text
FROM
BusinessGroup
) BusinessGroup ";

// Table's primary key
$primaryKey = 'business_group_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'business_group_name','dt' => 0),
    array( 'db' => 'status_text','dt' => 1 ),
    array( 'db' => 'status','dt' => 2 ),
    array( 'db' => 'business_group_id','dt' => 3 )

);
$whereAll =' 1=1 ';



if (isset($_GET['sub_group_id'])) {
    $sub_group_id = (int)$_GET['sub_group_id'];
    if($sub_group_id !=null && $sub_group_id >0){
        $whereAll.=  " and sub_group_id =".$sub_group_id;
    }

}


 //echo ' SELECT * from '.$table.' where '.$whereAll;

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
