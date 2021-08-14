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
//$table = 'Pers on_TD';
 $hasGroupVillage = false;
 $idGroupVillage=0;
 if (isset($_GET['idGroupVillage'])) {
     $idGroupVillage = $_GET['idGroupVillage'];
     if($idGroupVillage !="" && $idGroupVillage !='undefined'&& $idGroupVillage !=0 ){
        $hasGroupVillage =true;
     }
 }

$hasidRiverBasin =false;
$idRiverBasin='';
if (isset($_GET['idRiverBasin'])) {
    $idRiverBasin = $_GET['idRiverBasin'];
    if($idRiverBasin !="" && $idRiverBasin !="0"  ){
        $hasidRiverBasin =true;
    }
}

$hasidArea =false;
$idArea ='';
if (isset($_GET['idArea'])) {
    $idArea = $_GET['idArea'];
    if($idArea !="" && $idArea !="0" ){
        $hasidArea =true;
    }
}

$hasArgi_group_type=false;
$argi_group_type =0;
if (isset($_GET['argi_group_type'])) {
    $argi_group_type = $_GET['argi_group_type'];
    if($argi_group_type!=""){
        $hasArgi_group_type =true;
    }
}

$hasArgi_group=false;
$argi_group =0;
if (isset($_GET['argi_group'])) {
    $argi_group = $_GET['argi_group'];
    if($argi_group!=""){
        $hasArgi_group =true;
    }
}

$name="";
$hasName=false;
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    if($name !=""){
        $hasName=true;
    }


}

$idPerson="";
$hasidPerson=false;
if (isset($_GET['idPerson'])) {
    $idPerson = $_GET['idPerson'];
    if($idPerson !=""){
        $hasidPerson=true;
    }


}
$table="  ( SELECT
        '' as row_number ,
        a.target_area_type_id,
        a.areaType,
        a.areaName,
        a.target_name,
        p.idPerson,
        p.idcard,
        p.phoneNumber,
        p.updatedate,
        p.RiverBasin_idRiverBasin,
        a.idArea,
        CASE
        WHEN px.idPrefix = 10
                THEN p.firstName +' '+ p.lastName
        ELSE px.prefixNameTh + p.firstName +' '+ p.lastName
    END fullname ,
        rb.nameRiverBasin , gv.nameGroupVillage " ;


$table .="    FROM
        Person_TD p ";
     /*   if($hasGroupVillage){
            $table .=" inner join    GroupVillage gv on  p.idGroupVillage = gv.idGroupVillage  ";
        }*/

        $table .=" left join    GroupVillage gv on  p.idGroupVillage = gv.idGroupVillage  ";
        $table .="     left join  Area a  on  p.Area_idArea = a.idArea
       left join   Prefix_TD px  on p.Prefix_idPrefix =px.idPrefix
       left join   RiverBasin rb on rb.idRiverBasin = a.RiverBasin_idRiverBasin ";
    if($hasArgi_group_type || $hasArgi_group){
        $table .="  inner join  RegisterAgri_TD ra on p.idPerson = ra.idPerson   ";
        $table .="  inner join  Agri_TD  agt on ra.idAgri = agt.idAgri  ";
    }
    $table .=" where 1=1 ";

    if($hasGroupVillage){
        $table .=" AND gv.idGroupVillage  = '".$idGroupVillage."'" ;
    }
    if($hasidRiverBasin){
        $table .=" AND rb.idRiverBasin  in (".$idRiverBasin.")" ;
    }
    if($hasidArea){
        $table .=" AND a.idArea in (".$idArea." ) " ;
    }

    if($hasArgi_group_type){
        $table .=" and agt.TypeOfArgi_idTypeOfArgi in ( ".$argi_group_type." )" ;
    }
    if($hasArgi_group){
        $table .=" and agt.idAgri in ( ".$argi_group." )" ;
    }
    if($hasName){
        $table.=" and p.firstName+' '+p.lastName  like '%".$name."%' " ;
    }
    if($hasidPerson){
        $table.=" and p.idPerson =".$idPerson;
    }
$table .=" ) Person_TD  ";

// Table's primary key
$primaryKey = 'idPerson';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'row_number','dt' => 0 ),
    array( 'db' => 'idcard','dt' => 1 ),
    array( 'db' => 'fullname','dt' => 2 ),
    array( 'db' => 'nameRiverBasin','dt' => 3),
    array( 'db' => 'target_name','dt' => 4),
    array( 'db' => 'nameGroupVillage','dt' => 5),
    array( 'db' => 'updatedate','dt' => 6),
    array( 'db' => 'idPerson','dt' => 7) ,



);




$whereAll = NULL;
// echo ' SELECT * from '.$table;
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
