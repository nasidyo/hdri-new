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
ins.* ,
a.areaName,
rb.nameRiverBasin , rb.idRiverBasin
FROM
INSTITUTE ins ,
AREA a ,
RiverBasin rb
WHERE ins.AREA_ID = a.idArea and a.RiverBasin_idRiverBasin = rb.idRiverBasin ) INSTITUTE ";

// Table's primary key
$primaryKey = 'INSTITUTE_ID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'INSTITUTE_ID','dt' => 0 ),
    array( 'db' => 'nameRiverBasin','dt' => 1),
    array( 'db' => 'areaName','dt' => 2 ),
    array( 'db' => 'INSTITUTE_NAME','dt' => 3 ),
    array( 'db' => '','dt' => 4 )



);
$whereAll =' 1=1 ';

if (isset($_GET['idRiverBasin'])) {
        $idRiverBasin = (int)$_GET['idRiverBasin'];
        if($idRiverBasin>=0){
            $whereAll.=' and idRiverBasin ='.$idRiverBasin;
        }


}
if (isset($_GET['idArea'])) {
    $idArea = (int)$_GET['idArea'];
    if($idArea>0){
        $whereAll.=' and AREA_ID ='.$idArea;
    }


}
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    if($name !="" && $name!= 'undefined'){
        $whereAll.="and INSTITUTE_NAME like '%".$name."%' " ;
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
