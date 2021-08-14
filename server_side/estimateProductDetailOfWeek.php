<?php
    session_start();
    $monthId = $_GET['monthId'];
    $idOutputValue = $_GET['idOutputValue'];
    $table=" (
            SELECT tag.nameTypeOfArgi, ag.nameArgi, opvc.Week, opvc.Weight, opvc.Price, opvc.Total as total, opvc.Agri_idAgri
            FROM OutputValueCast_TD opvc
            INNER JOIN Agri_TD ag ON opvc.Agri_idAgri = ag.idAgri
            INNER JOIN TypeOfArgi_TD tag ON ag.TypeOfArgi_idTypeOfArgi = tag.idTypeOfArgi
            WHERE
                opvc.MonthNo = '".$monthId."' and opvc.idOutputValue = '".$idOutputValue."'
        ) OutputValueCast_TD";

    // Table's primary key
    $primaryKey = 'Week';

    $columns = array(
        array( 'db' => 'nameTypeOfArgi','dt' => 0 ),
        array( 'db' => 'nameArgi','dt' => 1 ),
        array( 'db' => 'Week','dt' => 2),
        array( 'db' => 'Weight','dt' => 3),
        array( 'db' => 'Price','dt' => 4),
        array( 'db' => 'total','dt' => 5),
        array( 'db' => 'Agri_idAgri','dt' => 6),
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