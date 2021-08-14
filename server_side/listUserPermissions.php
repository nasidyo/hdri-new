<?php
    session_start();
    $typeOfPermission = $_GET['typeOfPermission'];
    $table = "(SELECT sttd.idStaff, sttd.staffFirstname+' '+sttd.staffLastname as fullName, sttd.staffUsername, sttd.staffEmail, typer.permissionName ";
    $table.= 'FROM Staff sttd ';
    $table.= 'INNER JOIN TypeOfPermission typer ON sttd.staffPermis = typer.permissionId ';
    if($typeOfPermission != 'null' && $typeOfPermission != 'undefined' && $typeOfPermission != '0'){
        $table.= "and sttd.staffPermis = '".$typeOfPermission."'";
    }
    $table.= ') vLoadDetailStaff';
    // Table's primary key
    $primaryKey = 'idStaff';
    $columns = array(
        array( 'db' => 'idStaff','dt' => 0 ),
        array( 'db' => 'fullName','dt' => 1),
        array( 'db' => 'staffUsername','dt' => 2),
        array( 'db' => 'staffEmail','dt' => 3),
        array( 'db' => 'permissionName','dt' => 4),
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