<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];

    $table = "(SELECT cm.idCustomerMarket, a.areaName, m.nameMarket, c.c_name ";
    $table.= "FROM CustomerMarket_TD AS cm ";
    $table.= "INNER JOIN Customer_TD AS c ON (c.idCustomer = cm.Customer_idCustomer) ";
    $table.= "INNER JOIN Market_TD AS m ON (m.idMarket = cm.Market_idMarket) ";
    $table.= "INNER JOIN Area AS a ON (a.idArea = cm.Area_idArea) ";
    $table.= "WHERE 1=1 ";
 //   $table.= "WHERE cm.idCustomerMarket IS NOT NULL and cm.Area_idArea != '0'";

    if($idRiverBasin != 'null' and $idRiverBasin != 'undefined' and $idRiverBasin != '0'){
        $table.= "and a.RiverBasin_idRiverBasin = '".$idRiverBasin."'";
    }
    if($idArea != 'null' and $idArea != 'undefined' and $idArea != '0'){
        $table.= "and cm.Area_idArea = '".$idArea."'";
    }
    $table.= ") CustomerMarket_TD";
    // Table's primary key
    $primaryKey = 'idCustomerMarket';

    $columns = array(
        array( 'db' => 'idCustomerMarket','dt' => 0 ),
        array( 'db' => 'areaName','dt' => 1 ),
        array( 'db' => 'nameMarket','dt' => 2),
        array( 'db' => 'c_name','dt' => 3),
    );
 //   $whereAll =' 1=1 ';
 $whereAll = NULL;
    $serverName = "db01.hrdi.or.th";
    $userName = "farmer";
    $userPassword = "F95uRw";
    $dbName = "HRDI_Farmer";


 //echo ' SELECT * from '.$table.' where '.$whereAll;
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

?>
