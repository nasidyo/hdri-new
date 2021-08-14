<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];


    $table = "(SELECT a.idCustomerMaketplan, b.c_name, c.areaName, 
    CASE 
    WHEN d.speciesArgi = '' THEN d.nameArgi
    WHEN d.speciesArgi IS NULL THEN d.nameArgi  
    ELSE d.nameArgi+'(พันธุ์:'+d.speciesArgi+')' END as nameOFArgi, ISNULL(NULLIF(e.nameCountUnit,''),'กิโลกรัม') as nameUnit, f.nameTypeOfStand, g.logistic_name, ";
    $table.= 'h.conn_status_name ';
    $table.= 'FROM CustomerMaketPlan_TD AS a ';
    $table.= 'LEFT JOIN Customer_TD AS b ON (b.idCustomer = a.Customer_idCustomer) ';
    $table.= 'LEFT JOIN Area c ON (c.idArea = a.Area_idArea) ';
    $table.= 'LEFT JOIN Agri_TD d ON (d.idAgri = a.Agri_idAgri) ';
    $table.= 'LEFT JOIN CountUnit e ON (e.idCountUnit = a.unit_id) ';
    $table.= 'LEFT JOIN TypeOfStand f ON (f.idTypeOfStand = a.TypeOfStand_idTypeOfStand) ';
    $table.= 'LEFT JOIN Logistic_TD g ON (g.logistic_id = a.Logistic_idLogistic) ';
    $table.= 'LEFT JOIN connection_status_TD h ON (h.conn_status_id = a.conn_status_id) ';
    $table.= "WHERE a.idCustomerMaketplan IS NOT NULL ";

    if($idRiverBasin != 'null' and $idRiverBasin != 'undefined' and $idRiverBasin != '0'){
        $table.= "and c.RiverBasin_idRiverBasin = '".$idRiverBasin."'";
    }
    if($idArea != 'null' and $idArea != 'undefined' and $idArea != '0'){
        $table.= "and a.Area_idArea = '".$idArea."'";
    }
    $table.= ") CustomerMaketPlan_TD";
    // Table's primary key
    $primaryKey = 'idCustomerMaketplan';

    $columns = array(
        array( 'db' => 'idCustomerMaketplan','dt' => 0 ),
        array( 'db' => 'c_name','dt' => 1 ),
        array( 'db' => 'areaName','dt' => 2),
        array( 'db' => 'nameOFArgi','dt' => 3),
        array( 'db' => 'nameUnit','dt' => 4),
        array( 'db' => 'nameTypeOfStand','dt' => 5),
        array( 'db' => 'logistic_name','dt' => 6),
        array( 'db' => 'conn_status_name','dt' => 7),
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