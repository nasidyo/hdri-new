<?php
    session_start();
    $listtargetId = $_GET['listtargetId'];

    $table = '(SELECT lta.unit_plan_id, lta.idAgri, lta.taget_unit, a.TypeOfArgi_idTypeOfArgi ';
    $table.= 'FROM list_taget_agri_unit_plan AS lta ';
    $table.= 'LEFT JOIN Agri_TD AS a ON (a.idAgri = lta.idAgri) ';
    $table.= 'LEFT JOIN CountUnit AS cu ON (cu.idCountUnit = lta.taget_unit) ';
    $table.= "WHERE unit_plan_id = '".$listtargetId."'";
    $table.= ') list_taget_agri_unit_plan';

    // Table's primary key
    $primaryKey = 'unit_plan_id';

    $columns = array(
        array( 'db' => 'unit_plan_id','dt' => 0 ),
        array( 'db' => 'idAgri','dt' => 1 ),
        array( 'db' => 'taget_unit','dt' => 2),
        array( 'db' => 'TypeOfArgi_idTypeOfArgi','dt' => 3)
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