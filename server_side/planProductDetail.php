<?php
    session_start();
    $area_Id = (int)$_GET['idArea'];
    $yearsId = (int)$_GET['yearsId'];
    $table=" ( SELECT
    tb.idYearTB,
    yt.YearTB_idYearTB,
    tb.nameYear +' ['+ FORMAT(tb.dateStart, 'dd/MMMM/yyyy', 'th') +' - '+ FORMAT(tb.dateStop, 'dd/MMMM/yyyy', 'th') +']' as displayYear,
    FORMAT(ssp.DateInsert, 'dd/MMMM/yyyy','th') as createDate,
    FORMAT(ssp.DateUpdate, 'dd/MMMM/yyyy','th') as updateDate,
    FORMAT(ssp.DateSend, 'dd/MMMM/yyyy','th') as sendDate,
    sst.nameSendStatus,
    COALESCE(ssp.idStatusPlan, '1') AS idStatusPlans
    FROM YearTarget yt
    INNER JOIN YearTB tb ON yt.YearTB_idYearTB = tb.idYearTB
    LEFT JOIN SendStatusPlan_TD ssp ON yt.YearTB_idYearTB = ssp.YearID and ssp.Area_idArea = '".$area_Id."'
    LEFT JOIN SendStatus_TD sst ON ssp.idStatusPlan = sst.idSendStatus
    WHERE
        yt.Area_idArea = '".$area_Id."' and tb.idYearTB = '".$yearsId."'
    ) YearTarget";


    // Table's primary key
    $primaryKey = 'idYearTB';

    $columns = array(
        array( 'db' => 'idYearTB','dt' => 0 ),
        array( 'db' => 'displayYear','dt' => 1 ),
        array( 'db' => 'createDate','dt' => 2 ),
        array( 'db' => 'updateDate','dt' => 3 ),
        array( 'db' => 'sendDate','dt' => 4 ),
        array( 'db' => 'nameSendStatus','dt' => 5 ),
        array( 'db' => 'idStatusPlans','dt' => 6 )
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