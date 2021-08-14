<?php
    session_start();
    $idTypeOfArgiSearch = $_GET['idTypeOfArgiSearch'];
    $idAgriSearch = $_GET['idAgriSearch'];

    $table = "(SELECT lta.unit_plan_id, 
    CASE 
    WHEN a.speciesArgi = '' THEN a.nameArgi
    WHEN a.speciesArgi IS NULL THEN a.nameArgi  
    ELSE a.nameArgi+'(พันธุ์:'+a.speciesArgi+')' END as nameOFArgi, cu.nameTypeOfTarget, b.nameTypeOfArgi ";
    $table.= 'FROM list_taget_agri_unit_plan AS lta ';
    $table.= 'LEFT JOIN Agri_TD AS a ON (a.idAgri = lta.idAgri) ';
    $table.= 'LEFT JOIN TypeOfArgi_TD AS b ON (a.TypeOfArgi_idTypeOfArgi = b.idTypeOfArgi) ';
    $table.= 'LEFT JOIN TypeOfTarget AS cu ON (cu.idTypeOfTarget = lta.taget_unit) ';
    $table.= "WHERE lta.unit_plan_id IS NOT NULL ";

    if($idTypeOfArgiSearch != 'null' and $idTypeOfArgiSearch != 'undefined' and $idTypeOfArgiSearch != '0'){
        $table.= "and a.TypeOfArgi_idTypeOfArgi = '".$idTypeOfArgiSearch."'";
    }
    if($idAgriSearch != 'null' and $idAgriSearch != 'undefined' and $idAgriSearch != '0'){
        $table.= "and lta.idAgri = '".$idAgriSearch."'";
    }
    $table.= ") list_taget_agri_unit_plan";
    // Table's primary key
    $primaryKey = 'unit_plan_id';

    $columns = array(
        array( 'db' => 'unit_plan_id','dt' => 0 ),
        array( 'db' => 'nameTypeOfArgi','dt' => 1 ),
        array( 'db' => 'nameOFArgi','dt' => 2 ),
        array( 'db' => 'nameTypeOfTarget','dt' => 3)
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