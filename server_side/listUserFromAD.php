<?php
    session_start();
    $table = "(SELECT lds.frs_nam_tha, lds.lst_nam_tha, lds.emp_id, lds.usr ";
    $table.= 'FROM vLoadDetailStaff as lds ';
    $table.= 'WHERE lds.usr not in (SELECT staffUsername FROM Staff)';
    $table.= ") vLoadDetailStaff";
    // Table's primary key
    $primaryKey = 'emp_id';
    $columns = array(
        array( 'db' => 'emp_id','dt' => 0 ),
        array( 'db' => 'frs_nam_tha','dt' => 1),
        array( 'db' => 'lst_nam_tha','dt' => 2),
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