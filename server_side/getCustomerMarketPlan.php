<?php
    session_start();
    $customerMatketPlanId = $_GET['customerMatketPlanId'];
    $table = '(SELECT a.idCustomerMaketplan, c.RiverBasin_idRiverBasin, a.Area_idArea, a.Customer_idCustomer, a.plan_Year, a.Agri_idAgri, d.TypeOfArgi_idTypeOfArgi, ';
    $table.= 'a.agri_weekplan_amount as amount, a.unit_id as countUnit, a.agri_spect as spect, a.TypeOfStand_idTypeOfStand as idTypeOfStand, a.Logistic_idLogistic as idLogistic, ';
    $table.= 'a.conn_status_id as status_id, a.Refund_period as refund, a.update_date as date ';
    $table.= 'FROM CustomerMaketPlan_TD AS a ';
    $table.= 'LEFT JOIN Area c ON c.idArea = a.Area_idArea ';
    $table.= 'LEFT JOIN Agri_TD d ON d.idAgri = a.Agri_idAgri ';
    $table.= "WHERE a.idCustomerMaketplan = '".$customerMatketPlanId."'";
    $table.= ') CustomerMaketPlan_TD';
    // Table's primary key
    $primaryKey = 'idCustomerMaketplan';
    $columns = array(
        array( 'db' => 'idCustomerMaketplan','dt' => 0 ),
        array( 'db' => 'RiverBasin_idRiverBasin','dt' => 1),
        array( 'db' => 'Area_idArea','dt' => 2),
        array( 'db' => 'Customer_idCustomer','dt' => 3),
        array( 'db' => 'plan_Year','dt' => 4),
        array( 'db' => 'Agri_idAgri','dt' => 5),
        array( 'db' => 'TypeOfArgi_idTypeOfArgi','dt' => 6),
        array( 'db' => 'amount','dt' => 7),
        array( 'db' => 'countUnit','dt' => 8),
        array( 'db' => 'spect','dt' => 9),
        array( 'db' => 'idTypeOfStand','dt' => 10),
        array( 'db' => 'idLogistic','dt' => 11),
        array( 'db' => 'refund','dt' => 12),
        array( 'db' => 'status_id','dt' => 13),
        array( 'db' => 'date','dt' => 14)
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