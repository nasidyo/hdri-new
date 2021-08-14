<?php
    session_start();
    $targetTypeId = $_GET['targetTypeId'];

    $table = '(SELECT ltag.list_taget_agri_id, a.RiverBasin_idRiverBasin, ltag.area_id, ltag.TypeOfArgi_idTypeOfArgi, ltag.agri_id, ltag.grade, ltag.status';
    $table.= ' FROM list_taget_agri AS ltag ';
    $table.= 'LEFT JOIN Area AS a ON (a.idArea = ltag.area_id) ';
    $table.= "WHERE list_taget_agri_id = '".$targetTypeId."'";
    $table.= ') list_taget_agri';

    // Table's primary key
    $primaryKey = 'list_taget_agri_id';

    $columns = array(
        array( 'db' => 'list_taget_agri_id','dt' => 0 ),
        array( 'db' => 'RiverBasin_idRiverBasin','dt' => 1 ),
        array( 'db' => 'area_id','dt' => 2),
        array( 'db' => 'TypeOfArgi_idTypeOfArgi','dt' => 3),
        array( 'db' => 'agri_id','dt' => 4),
        array( 'db' => 'grade','dt' => 5),
        array( 'db' => 'status','dt' => 6),
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