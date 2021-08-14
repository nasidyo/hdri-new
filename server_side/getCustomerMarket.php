<?php
    session_start();
    $customerMatketId = $_GET['customerMatketId'];

    // $table = '(SELECT ltag.list_taget_agri_id, a.RiverBasin_idRiverBasin, ltag.area_id, ltag.TypeOfArgi_idTypeOfArgi, ltag.agri_id, ltag.grade, ltag.status';
    // $table.= ' FROM list_taget_agri AS ltag ';
    // $table.= 'LEFT JOIN Area AS a ON (a.idArea = ltag.area_id) ';
    // $table.= "WHERE list_taget_agri_id = '".$targetTypeId."'";
    // $table.= ') list_taget_agri';

    $table = "(SELECT cm.idCustomerMarket, cm.Area_idArea, a.RiverBasin_idRiverBasin, cm.Market_idMarket, cm.Customer_idCustomer ";
    $table.= "FROM CustomerMarket_TD AS cm ";
    $table.= "LEFT JOIN Customer AS c ON (c.idCustomer = cm.Customer_idCustomer) ";
    $table.= "LEFT JOIN Market_TD AS m ON (m.idMarket = cm.Market_idMarket) ";
    $table.= "LEFT JOIN Area AS a ON (a.idArea = cm.Area_idArea) ";
    $table.= "WHERE idCustomerMarket = '".$customerMatketId."'";
    $table.=") CustomerMarket_TD";

    // Table's primary key
    $primaryKey = 'idCustomerMarket';

    $columns = array(
        array( 'db' => 'idCustomerMarket','dt' => 0 ),
        array( 'db' => 'Area_idArea','dt' => 1 ),
        array( 'db' => 'RiverBasin_idRiverBasin','dt' => 2),
        array( 'db' => 'Market_idMarket','dt' => 3),
        array( 'db' => 'Customer_idCustomer','dt' => 4)
    );
    $whereAll =' 1=1 ';

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

?>