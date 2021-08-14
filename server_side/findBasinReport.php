<?php
session_start();
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

//SELECT TABLE MainBasin AND MainTarget
$table=" ( SELECT
    m.idArea, m.areaName, m.idRiverBasin, r.nameRiverBasin 
    FROM
        MainTarget m
    INNER JOIN MainBasin r ON m.idRiverBasin = r.idRiverBasin
    WHERE m.target_area_type_id in (3,5,10)
    ) MainTarget";
    // LEFT JOIN ( SELECT TOP 1 idSendStatusPlan, idStatusPlan, Area_idArea
    //     FROM SendStatusPlan_TD) sstp ON m.idArea = sstp.Area_idArea
    // LEFT JOIN (
    //     SELECT TOP 1 LineItems.Quantity, LineItems.Description
    //     FROM SendStatusPlan_TD
    //     WHERE LineItems.OrderID = SendStatusPlan_TD) LineItems2
    //  ON 1=1
// Table's primary key
$primaryKey = 'idArea';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'idArea','dt' => 0 ),
    array( 'db' => 'nameRiverBasin','dt' => 1 ),
    array( 'db' => 'areaName','dt' => 2 ),
);
$whereAll =' 1=1 ';

if (isset($_GET['idRiverBasin'])) {
    $idRiverBasin = (int)$_GET['idRiverBasin'];
    if($idRiverBasin>0){
        $whereAll.=' and idRiverBasin ='.$idRiverBasin;
    }
}
// if (isset($_GET['idStatus'])) {
//     $idStatus = (int)$_GET['idStatus'];
//     if($idStatus>0){
//         $whereAll.=' and idStatusPlans ='.$idStatus;
//     }
// }
//permssion auto select
$permssion = $_SESSION['staffPermis'];
$idarea = $_SESSION['AreaAll'];
$idRiverBasin = $_SESSION['idRiverBasin'];
$AreaAll = $_SESSION['AreaAll'];
if($permssion != 'staff'){
    if($permssion =='manager'){
        $whereAll.=' and idArea IN ('.$AreaAll.')';
    }
}else{
    $whereAll.=' and idArea IN('.$idarea.')';
}
// if ($permssion != 'admin' and $permssion != 'powerUser') {
//     if($permssion == 'staff'){
//         $whereAll.=' and idArea ='.$idarea;
//     }else{
//         $whereAll.=' and idRiverBasin ='.$idRiverBasin;
//     }
// }
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
