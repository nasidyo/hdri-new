<?php
    session_start();
    $idPersonMarket = $_GET['idPersonMarket'];
    $table = " (
        SELECT psmk.idPersonMarket, FORMAT(psmk.dateDeliver, 'dd/MMMM/yyyy', 'th') as dateDeliver, psmk.Person_idPerson, psmk.Grade_codeGrade, psmk.Agri_idAgri, psmk.TypeOfArgi_idTypeOfArgi, psmk.Volumn,
        psmk.TotalValue, psmk.Value, pes.firstName+' '+pes.lastName as fullName ,cmk.idCustomerMarket, psmk.TypeOfStand_idTypeOfStand, psmk.land_detail_id, psmk.lossValue, lgd.logistic_id,
        FORMAT(psmk.dateCultivate, 'yyyy-MM-dd') as dateCultivate, FORMAT(psmk.dateHarvest, 'yyyy-MM-dd') as dateHarvest
        FROM PersonMarket_TD psmk
        INNER JOIN Person_TD pes ON psmk.Person_idPerson = pes.idPerson
        LEFT JOIN LogisticDeliver_TD lgd ON psmk.idPersonMarket = lgd.idPersonMarket
        LEFT JOIN CustomerMarket_TD cmk ON psmk.Customer_idCustomer = cmk.Customer_idCustomer and psmk.Market_idMarket = cmk.Market_idMarket and cmk.Area_idArea = psmk.Area_idArea
        WHERE psmk.idPersonMarket ='".$idPersonMarket."'
    ) PersonMarket_TD";

    // Table's primary key
    $primaryKey = 'idPersonMarket';

    $columns = array(
        array( 'db' => 'fullName','dt' => 0 ),
        array( 'db' => 'Person_idPerson','dt' => 1 ),
        array( 'db' => 'dateDeliver','dt' => 2 ),
        array( 'db' => 'Grade_codeGrade','dt' => 3),
        array( 'db' => 'Agri_idAgri','dt' => 4),
        array( 'db' => 'TypeOfArgi_idTypeOfArgi','dt' => 5),
        array( 'db' => 'Volumn','dt' => 6),
        array( 'db' => 'TotalValue','dt' => 7),
        array( 'db' => 'Value','dt' => 8),
        array( 'db' => 'idCustomerMarket','dt' => 9),
        array( 'db' => 'TypeOfStand_idTypeOfStand','dt' => 10),
        array( 'db' => 'land_detail_id','dt' => 11),
        array( 'db' => 'lossValue','dt' => 12),
        array( 'db' => 'logistic_id','dt' => 13),
        array( 'db' => 'idPersonMarket','dt' => 14 ),
        array( 'db' => 'dateCultivate','dt' => 15 ),
        array( 'db' => 'dateHarvest','dt' => 16 ),
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