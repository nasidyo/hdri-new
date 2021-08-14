<?php
    session_start();
    $registerId = $_GET['registerId'];

    $table = "(SELECT ratd.regisAgri_id, ratd.register_year, ratd.idPerson, a.idArea, a.RiverBasin_idRiverBasin, agtd.TypeOfArgi_idTypeOfArgi, ratd.idAgri ";
    $table.= "FROM RegisterAgri_TD AS ratd ";
    $table.= "LEFT JOIN Person AS p ON (p.idPerson = ratd.idPerson) ";
    $table.= "LEFT JOIN Area AS a ON (a.idArea = ratd.idArea) ";
    $table.= "LEFT JOIN Agri_TD AS agtd ON (agtd.idAgri = ratd.idAgri) ";
    $table.= "WHERE regisAgri_id ='".$registerId."') RegisterAgri_TD";

    // Table's primary key
    $primaryKey = 'regisAgri_id';

    $columns = array(
        array( 'db' => 'regisAgri_id','dt' => 0 ),
        array( 'db' => 'idArea','dt' => 1 ),
        array( 'db' => 'RiverBasin_idRiverBasin','dt' => 2),
        array( 'db' => 'TypeOfArgi_idTypeOfArgi','dt' => 3),
        array( 'db' => 'register_year','dt' => 4),
        array( 'db' => 'idPerson','dt' => 5),
        array( 'db' => 'idAgri','dt' => 6)
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