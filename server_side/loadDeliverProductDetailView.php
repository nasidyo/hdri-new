<?php
    session_start();
    $idPersonMarket = $_GET['idPersonMarket'];
    $table = " (
        SELECT psmk.idPersonMarket, FORMAT(psmk.dateDeliver, 'dd/MMMM/yyyy', 'th') as dateDeliver, psmk.Person_idPerson, ISNULL(NULLIF(cu.nameCountUnit,''),'กิโลกรัม') as nameUnit, 
        CASE 
        WHEN ag.speciesArgi = '' THEN ag.nameArgi
        WHEN ag.speciesArgi IS NULL THEN ag.nameArgi  
        ELSE ag.nameArgi+'(พันธุ์:'+ag.speciesArgi+')' END as nameOFArgi, ta.nameTypeOfArgi, psmk.Volumn,
        psmk.TotalValue, psmk.Value, pes.firstName+' '+pes.lastName as fullName ,'['+mk.nameMarket+'] '+cut.c_name as marketName,
        ts.nameTypeOfStand, psmk.lossValue, 'จำนวน:'+ COALESCE(lan.unit1,'0')+' แปลง พื้นที่:'+COALESCE(lan.unit2,'0')+'-'+COALESCE(lan.unit3,'0')+'-'+COALESCE(lan.unit4,'0')+'ไร่' as coordinat,
        lg.logistic_name, grd.codeGrade, FORMAT(psmk.dateCultivate, 'dd/MMMM/yyyy', 'th') as dateCultivate, FORMAT(psmk.dateHarvest, 'dd/MMMM/yyyy', 'th') as dateHarvest
        FROM PersonMarket_TD psmk
        INNER JOIN Person_TD pes ON psmk.Person_idPerson = pes.idPerson
        INNER JOIN Agri_TD ag ON psmk.Agri_idAgri = ag.idAgri
        LEFT JOIN CountUnit cu ON ag.unit_id = cu.idCountUnit
        INNER JOIN Market_TD mk ON psmk.Market_idMarket = mk.idMarket
        INNER JOIN TypeOfArgi ta ON psmk.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi
        INNER JOIN Customer_TD cut ON psmk.Customer_idCustomer = cut.idCustomer
        LEFT JOIN TypeOfStand ts ON psmk.TypeOfStand_idTypeOfStand = ts.idTypeOfStand
        LEFT JOIN Land_Detail lan ON psmk.land_detail_id = lan.land_detail_id
        LEFT JOIN Grade grd ON psmk.Grade_codeGrade = grd.idGrade
        INNER JOIN CustomerMarket_TD cmk ON psmk.Customer_idCustomer = cmk.Customer_idCustomer and psmk.Market_idMarket = cmk.Market_idMarket and cmk.Area_idArea = psmk.Area_idArea
        LEFT JOIN LogisticDeliver_TD ld ON psmk.idPersonMarket = ld.idPersonMarket
        LEFT JOIN Logistic_TD lg ON ld.logistic_id = lg.logistic_id
        WHERE psmk.idPersonMarket ='".$idPersonMarket."'
    ) PersonMarket_TD";

    // Table's primary key
    $primaryKey = 'idPersonMarket';

    $columns = array(
        array( 'db' => 'fullName','dt' => 0 ),
        array( 'db' => 'Person_idPerson','dt' => 1 ),
        array( 'db' => 'dateDeliver','dt' => 2 ),
        array( 'db' => 'nameUnit','dt' => 3),
        array( 'db' => 'nameOFArgi','dt' => 4),
        array( 'db' => 'nameTypeOfArgi','dt' => 5),
        array( 'db' => 'Volumn','dt' => 6),
        array( 'db' => 'TotalValue','dt' => 7),
        array( 'db' => 'Value','dt' => 8),
        array( 'db' => 'marketName','dt' => 9),
        array( 'db' => 'nameTypeOfStand','dt' => 10),
        array( 'db' => 'lossValue','dt' => 11),
        array( 'db' => 'coordinat','dt' => 12),
        array( 'db' => 'logistic_name','dt' => 13),
        array( 'db' => 'codeGrade','dt' => 14),
        array( 'db' => 'idPersonMarket','dt' => 15),
        array( 'db' => 'dateCultivate','dt' => 16),
        array( 'db' => 'dateHarvest','dt' => 17),
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