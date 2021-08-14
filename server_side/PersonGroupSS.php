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



$table=" ( SELECT distinct
        p.idPerson,
        p.idcard,
      --  CONCAT( pr.prefixNameTh,' ' ,p.firstName,' ' ,p.lastName ) FullName,
        CASE
WHEN pr.idPrefix = 10
        THEN p.firstName +' '+ p.lastName
ELSE pr.prefixNameTh + p.firstName +' '+ p.lastName
END FullName ,
        p.phoneNumber,
        p.firstName,
        p.lastName,
        p.Area_idArea,
        pg.institute_id,
        pg.sub_group_id,
        CASE
            WHEN pg.sub_group_id IS NULL
            THEN 'N' ";
            if (isset($_GET['sub_group_id'])) {
                $sub_group_id = $_GET['sub_group_id'];
                if($sub_group_id !="" ){
                    $table .=  "when pg.sub_group_id <> ".$sub_group_id."  then  'N'";
                }

            }


$table .="    ELSE 'Y'
        END isGroup,
        ISNULL ( ( SELECT SUM( s.amount) FROM Stocks s WHERE p.idPerson =s.person_id ) ,0 ) Stocks ,
        ISNULL ( ( SELECT  s.amount FROM Saving s WHERE p.idPerson =s.person_id ) ,0 ) Saving
        FROM
        Person_TD p
        LEFT JOIN
        PersonGroup_TD pg
        ON
        p.idPerson = pg.person_id
        INNER JOIN
        Prefix_TD pr
        ON
        p.Prefix_idPrefix = pr.idPrefix
        LEFT JOIN
        INSTITUTE ins
        ON
        pg.institute_id = ins.INSTITUTE_ID
        left join area a on  a.idArea = ins.AREA_ID  ) PersonGroup_TD ";

// Table's primary key
$primaryKey = 'idPerson';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array( 'db' => 'idcard','dt' => 0),
    array( 'db' => 'FullName','dt' => 1 ),
    array( 'db' => 'Stocks','dt' => 2 ),
    array( 'db' => 'Saving','dt' => 3 ),
    array( 'db' => 'isGroup','dt' => 4 ),
    array( 'db' => 'idPerson','dt' => 5 ),
    array( 'db' => 'idPerson','dt' => 6 )

);
$whereAll =' 1=1 ';

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    if($name !="" && $name!=null && $name!="undefined"){
        $whereAll.=  " and ( firstName like '%".$name."%'"." or lastName like '%".$name."%')";
    }

}
if (isset($_GET['isGroup'])) {
    $isGroup = $_GET['isGroup'];
    if($isGroup !="" && $isGroup =="Y"){
        $whereAll.=" and  isGroup = 'Y'" ;
    }

}
if (isset($_GET['idArea'])) {
    $idArea = (int)$_GET['idArea'];
    if($idArea !=null && $idArea >0){
        $whereAll.=  " and Area_idArea =".$idArea;
    }

}

if (isset($_GET['sub_group_id'])) {
    $sub_group_id = $_GET['sub_group_id'];
    if($sub_group_id !="" ){
        $whereAll.=   "and  (sub_group_id is null  or sub_group_id = ".$sub_group_id." )  ";
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
