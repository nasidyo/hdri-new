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
ay.account_year_id,
ay.account_year_start,
ay.account_year_end,
ay.status,
ay.current_bugget,
ay.sub_group_id,
ay.bank_bugget,
ay.stocks_amount,
ay.stocks_price,
ay.stocks_amount * ay.stocks_price stocks_value,
ay.year_text ,
CASE
    WHEN ay.status ='Y'
    THEN 'ใช้งาน'
    ELSE 'ปิดบัญชี'
END                                         status_text,
concat(a.areaName,' ' , sp.sub_group_name ) sub_group_name ,
rb.idRiverBasin,
a.idArea,
ins.INSTITUTE_ID
FROM
AccountYear ay ,
SubPersonGroup sp ,
INSTITUTE ins,
Area a ,
RiverBasin rb
WHERE
ay.sub_group_id = sp.sub_group_id
AND sp.institute_id = ins.INSTITUTE_ID
AND ins.AREA_ID =a.idArea
and a.RiverBasin_idRiverBasin = rb.idRiverBasin ) AccountYear ";

// Table's primary key
$primaryKey = 'account_year_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'year_text','dt' => 0),
    array( 'db' => 'sub_group_name','dt' => 1),
    array( 'db' => 'current_bugget','dt' => 2 ),
    array( 'db' => 'bank_bugget','dt' => 3 ),
    array( 'db' => 'stocks_amount','dt' => 4 ),
    array( 'db' => 'stocks_value','dt' => 5 ),
    array( 'db' => 'status_text','dt' => 6 ),
    array( 'db' => 'account_year_id','dt' => 7),
    array( 'db' => 'sub_group_id','dt' => 8)

);
$whereAll =' 1=1 ';
if (isset($_GET['idRiverBasin'])) {
    $idRiverBasin = (int)$_GET['idRiverBasin'];
    if($idRiverBasin>0){
        $whereAll.=' and idRiverBasin ='.$idRiverBasin;
    }


}
if (isset($_GET['idArea'])) {
$idArea = (int)$_GET['idArea'];
if($idArea>0){
    $whereAll.=' and idArea ='.$idArea;
}
}
if (isset($_GET['institute_id'])) {
$institute_id = $_GET['institute_id'];
if($institute_id !=0 ){
    $whereAll.="and INSTITUTE_ID =".$institute_id ;
}
}

if (isset($_GET['sub_group_id'])) {
    $sub_group_id = $_GET['sub_group_id'];
    if($sub_group_id !=0 ){
        $whereAll.="and sub_group_id =".$sub_group_id ;
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
