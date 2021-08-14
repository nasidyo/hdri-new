<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];
    $idTypeOfArgiSearch = $_GET['idTypeOfArgiSearch'];
    $idAgriSearch = $_GET['idAgriSearch'];

    $table = "(SELECT ratd.regisAgri_id, a.areaName, 
    CASE 
    WHEN agtd.speciesArgi = '' THEN agtd.nameArgi
    WHEN agtd.speciesArgi IS NULL THEN agtd.nameArgi  
    ELSE agtd.nameArgi+'(พันธุ์:'+agtd.speciesArgi+')' END as nameOFArgi, ratd.register_year, p.firstName +' '+ p.lastName as fullname ";
    $table.= "FROM RegisterAgri_TD AS ratd ";
    $table.= "LEFT JOIN Person AS p ON (p.idPerson = ratd.idPerson) ";
    $table.= "LEFT JOIN Area AS a ON (a.idArea = ratd.idArea) ";
    $table.= "LEFT JOIN Agri_TD AS agtd ON (agtd.idAgri = ratd.idAgri) ";
    $table.= "WHERE ratd.regisAgri_id IS NOT NULL ";
    if($idRiverBasin != 'null' and $idRiverBasin != 'undefined' and $idRiverBasin != '0'){
        $table.= "and a.RiverBasin_idRiverBasin = '".$idRiverBasin."'";
    }
    if($idArea != 'null' and $idArea != 'undefined' and $idArea != '0'){
        $table.= "and a.idArea = '".$idArea."'";
    }
    if($idTypeOfArgiSearch != 'null' and $idTypeOfArgiSearch != 'undefined' and $idTypeOfArgiSearch != '0'){
        $table.= "and agtd.TypeOfArgi_idTypeOfArgi = '".$idTypeOfArgiSearch."'";
    }
    if($idAgriSearch != 'null' and $idAgriSearch != 'undefined' and $idAgriSearch != '0'){
        $table.= "and ratd.idAgri = '".$idAgriSearch."'";
    }
    $table.= ") RegisterAgri_TD";
    // Table's primary key
    $primaryKey = 'regisAgri_id';

    $columns = array(
        array( 'db' => 'regisAgri_id','dt' => 0 ),
        array( 'db' => 'areaName','dt' => 1 ),
        array( 'db' => 'nameOFArgi','dt' => 2),
        array( 'db' => 'register_year','dt' => 3),
        array( 'db' => 'fullname','dt' => 4),
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