<?php
    session_start();
    $area_Id = $_GET['area_Id'];
    $yearsId = $_GET['yearsId'];
    $table = " (
        SELECT sstv.idSendStatusValue ,sstv.MonthID ,moy.Month_name+' '+sstv.yearSet as monthValue, FORMAT(sstv.DateInsert, 'dd/MMMM/yyyy', 'th') as DateInsert, FORMAT(sstv.DateUpdate, 'dd/MMMM/yyyy', 'th') as DateUpdate, 
        FORMAT(sstv.DateSend, 'dd/MMMM/yyyy', 'th') as DateSend, sts.nameSendStatus, sstv.idSendStatus
        FROM SendStatusValue_TD sstv 
        INNER JOIN MonthOfYear moy ON sstv.MonthID = moy.Month_id
        LEFT JOIN SendStatus_TD sts ON sstv.idSendStatus = sts.idSendStatus
        WHERE sstv.Area_idArea ='".$area_Id."' and sstv.YearID = '".$yearsId."'
    ) SendStatusValue_TD";

    // Table's primary key
    $primaryKey = 'idSendStatusValue';

    $columns = array(
        array( 'db' => 'idSendStatusValue','dt' => 0 ),
        array( 'db' => 'MonthID','dt' => 1),
        array( 'db' => 'monthValue','dt' => 2 ),
        array( 'db' => 'DateInsert','dt' => 3),
        array( 'db' => 'DateUpdate','dt' => 4),
        array( 'db' => 'DateSend','dt' => 5),
        array( 'db' => 'nameSendStatus','dt' => 6),
        array( 'db' => 'idSendStatus','dt' => 7)
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