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
INCOME_OTHER_ID,
INCOME_DETAIL,
CASE WHEN STATUS ='' OR STATUS ='N' THEN 'ไม่ใช้งาน' ELSE 'ใช้งาน' END STATUS_TEXT,
COMMENT ,
STATUS,
INSTITUTE_ID
FROM
INCOME_OTHER_TD )INCOME_OTHER_TD ";

// Table's primary key
$primaryKey = 'INCOME_OTHER_ID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'INCOME_DETAIL','dt' => 0),
    array( 'db' => 'STATUS_TEXT','dt' => 1 ),
    array( 'db' => 'COMMENT','dt' => 2 ),
    array( 'db' => 'INCOME_OTHER_ID','dt' => 3 )
);
$whereAll =' 1=1 ';

if (isset($_GET['institute_id'])) {
    $institute_id = $_GET['institute_id'];

        $whereAll.=" and INSTITUTE_ID =".$institute_id;



}

if (isset($_GET['income_detail'])) {
        $income_detail = $_GET['income_detail'];
        if($income_detail!="0"){
            $whereAll.=" and INCOME_DETAIL like '%".$income_detail."%' " ;
        }


}
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if($status!=""){
        $whereAll.=" and STATUS = '".$status."'";
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
