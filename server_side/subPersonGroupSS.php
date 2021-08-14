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
spg.sub_group_id,
concat( a.areaName,' ',spg.sub_group_name) sub_group_name,
spg.institute_id,
spg.status ,
ins.AREA_ID,
ins.INSTITUTE_NAME,
rb.idRiverBasin,
CASE
    WHEN spg.status ='Y'
    THEN 'ใข้งาน'
    ELSE 'ระงับการใช้งาน'
END                 status_text ,
COUNT(pg.person_id) person
FROM
SubPersonGroup spg
LEFT JOIN
PersonGroup_TD pg
ON
spg.sub_group_id = pg.sub_group_id
LEFT JOIN
INSTITUTE ins
ON
spg.institute_id = ins.institute_id
LEFT JOIN
Area a
ON
ins.AREA_ID = a.idArea
LEFT JOIN
RiverBasin rb
ON
a.RiverBasin_idRiverBasin = rb.idRiverBasin
GROUP BY
spg.sub_group_id,
spg.sub_group_name,
spg.institute_id,
ins.AREA_ID,
a.areaName,
ins.INSTITUTE_NAME,
rb.idRiverBasin,
spg.status) SubPersonGroup ";

// Table's primary key
$primaryKey = 'sub_group_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'sub_group_name','dt' => 0),
    array( 'db' => 'person','dt' => 1 ),
    array( 'db' => 'status_text','dt' => 2 ),
    array( 'db' => 'sub_group_id','dt' => 3 ),
    array( 'db' => 'AREA_ID','dt' => 4),
    array( 'db' => 'institute_id','dt' => 5)




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
        $whereAll.=' and AREA_ID ='.$idArea;
    }
}

if (isset($_GET['id'])) {
    $INSTITUTE_ID = (int)$_GET['id'];
    if($INSTITUTE_ID>0){
        $whereAll.=' and INSTITUTE_ID ='.$INSTITUTE_ID;
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
