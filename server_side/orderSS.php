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
$table="(SELECT
ort.ORDER_ID,
ort.ORDER_NAME,
case when ort.STATUS <> 'Y' then 'N' else ort.STATUS end STATUS,
case when ort.STATUS <> 'Y' then 'ระงับการขาย' else 'ขาย' end STATUS_TEXT,
ort.COMMENT,
ort.UNIT_ID,
ort.BALANCE,
ort.INSTITUTE_ID ,
a.idArea,
rb.idRiverBasin,
cu.nameCountUnit UNIT_NAME ,
ort.SUB_GROUP_ID
FROM
ORDER_TD ort ,
INSTITUTE ins ,
Area a ,
RiverBasin rb ,
CountUnit cu
WHERE ort.INSTITUTE_ID = ins.INSTITUTE_ID
and ins.AREA_ID = a.idArea
and a.RiverBasin_idRiverBasin =rb.idRiverBasin
and ort.UNIT_ID = cu.idCountUnit
)ORDER_TD ";

// Table's primary key
$primaryKey = 'ORDER_ID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(


    array( 'db' => 'ORDER_NAME','dt' => 0 ),
    array( 'db' => 'UNIT_NAME','dt' => 1 ),
    array( 'db' => 'BALANCE','dt' => 2 ),
    array( 'db' => 'STATUS_TEXT','dt' => 3 ),
    array( 'db' => 'COMMENT','dt' => 4 ),
    array( 'db' => 'ORDER_ID','dt' => 5)


);
$whereAll =' 1=1 ';

//if (isset($_GET['idRiverBasin'])) {
        $idRiverBasin = (int)$_GET['idRiverBasin'];
//        if($idRiverBasin>0){
            $whereAll.=' and idRiverBasin ='.$idRiverBasin;
//        }


//}
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



if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    if($order_id >0){
        $whereAll.="and ORDER_ID = ".$order_id ;
    }

}

if (isset($_GET['sub_group_id'])) {
    $sub_group_id = $_GET['sub_group_id'];
    if($sub_group_id >0){
        $whereAll.="and SUB_GROUP_ID = ".$sub_group_id ;
    }

}

if (isset($_GET['filter']) && isset($_GET['params'])) {
    $filter = $_GET['filter'];
    $params =  $_GET['params'];
    if($params > 0){

        if($filter =="max"){
            $whereAll.=" and BALANCE >= ".$params;
        }else if($filter =="min"){
            $whereAll.=" and BALANCE  <= ".$params;
        }else{
            $whereAll.=" and BALANCE = ".$params;
        }

    }


}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if($status !=""){
        $whereAll.="and STATUS = '".$status."'" ;
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
