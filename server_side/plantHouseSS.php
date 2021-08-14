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
ph.plantHouse_Id ,
a.areaName,
l.idLand,
ph.houseNumber,
rb.nameRiverBasin,
concat( p.firstName,'  ',p.lastName ) fullname,
rb.idRiverBasin,
a.idArea,
p.idPerson
FROM
PlantHouse_TD ph ,
Area a ,
Land_TD l ,
RiverBasin rb ,
Person_TD p
WHERE
ph.Area_idArea = a.idArea
AND ph.idLand = l.idLand
and a.RiverBasin_idRiverBasin = rb.idRiverBasin
and l.Person_idPerson = p.idPerson ) PlantHouse_TD ";

// Table's primary key
$primaryKey = 'plantHouse_Id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'plantHouse_Id','dt' => 0),
    array( 'db' => 'areaName','dt' => 1 ),
    array( 'db' => 'fullname','dt' => 2 ),
    array( 'db' => 'idLand','dt' => 3 ),
    array( 'db' => 'houseNumber','dt' => 4 )



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

if (isset($_GET['person_id'])) {
    $person_id = (int)$_GET['person_id'];
    if($person_id>0){
        $whereAll.=' and idPerson ='.$person_id;
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
