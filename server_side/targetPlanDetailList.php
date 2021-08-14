<?php
    session_start();
    $area_Id = $_GET['area_Id'];
    $yearsId = $_GET['yearsId'];
    $argi_Id = $_GET['argi_Id'];
    $market_Id = $_GET['market_Id'];
    $table=" ( SELECT
        tp.idTargetPlan, my.Month_name, toa.nameTypeOfArgi, toa.idTypeOfArgi, ag.idAgri, 
        CASE 
        WHEN sa.species_Id = '' THEN ag.nameArgi
        WHEN sa.species_Id IS NULL THEN ag.nameArgi  
        ELSE ag.nameArgi+'(พันธุ์:'+sa.species_name+')' END as nameOFArgi, ISNULL(NULLIF(cu.nameCountUnit,''),'กิโลกรัม') as nameUnit,
        tp.Weight, tp.Price, ROUND(tp.Total, 2, 1) AS Total, mk.nameMarket, cus.c_name, my.Month_id , mk.idMarket, my.Month_seq,
        tp.YearTarget_YearID, mb.nameRiverBasin, mt.areaName, mt.target_area_type_title, mt.target_name, COALESCE(pt1.amount,0) as amount1, 
        COALESCE(pt2.amount,0) as amount2,COALESCE( pt3.amount,0) as amount3 ,COALESCE(pt4.amount,0) as amount4 ,COALESCE(pt5.amount,0) as amount5 ,COALESCE(pt6.amount,0) as amount6 
        FROM TargetPlan_TD tp
        INNER JOIN MonthOfYear my ON tp.month_id = my.Month_id
        LEFT JOIN CustomerMarket_TD cmk ON tp.market_id = cmk.idCustomerMarket
        LEFT JOIN Customer_TD cus ON cmk.Customer_idCustomer = cus.idCustomer
        LEFT JOIN Market_TD mk ON cmk.Market_idMarket = mk.idMarket
        LEFT JOIN MainTarget mt ON tp.Area_idArea = mt.idArea
        LEFT JOIN MainBasin mb ON mt.idRiverBasin = mb.idRiverBasin
        INNER JOIN TypeOfArgi_TD toa ON tp.TypeOfArgi_idTypeOfArgi = toa.idTypeOfArgi
        INNER JOIN Agri_TD ag ON tp.Agri_idAgri = ag.idAgri
        LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and tp.species_Id = sa.species_Id
        LEFT JOIN CountUnit cu ON ag.unit_id = cu.idCountUnit

        LEFT JOIN plan_unit_attr_TD pt1 ON tp.idTargetPlan = pt1.idTagetPlan and pt1.TypeOfTargetId = '1'
        LEFT JOIN plan_unit_attr_TD pt2 ON tp.idTargetPlan = pt2.idTagetPlan and pt2.TypeOfTargetId = '2'
        LEFT JOIN plan_unit_attr_TD pt3 ON tp.idTargetPlan = pt3.idTagetPlan and pt3.TypeOfTargetId = '3'
        LEFT JOIN plan_unit_attr_TD pt4 ON tp.idTargetPlan = pt4.idTagetPlan and pt4.TypeOfTargetId = '5'
        LEFT JOIN plan_unit_attr_TD pt5 ON tp.idTargetPlan = pt5.idTagetPlan and pt5.TypeOfTargetId = '11'
        LEFT JOIN plan_unit_attr_TD pt6 ON tp.idTargetPlan = pt6.idTagetPlan and pt6.TypeOfTargetId = '12'

        WHERE tp.Area_idArea ='".$area_Id."' and tp.YearTarget_YearID ='".$yearsId."' and tp.Agri_idAgri = '".$argi_Id."' and mk.idMarket = '".$market_Id."'
        ) TargetPlan_TD";

    // Table's primary key
    $primaryKey = 'idTargetPlan';

    $columns = array(
        array( 'db' => 'idTargetPlan','dt' => 0 ),
        array( 'db' => 'idTypeOfArgi','dt' => 1 ),
        array( 'db' => 'idAgri','dt' => 2 ),
        array( 'db' => 'Month_id','dt' => 3),
        array( 'db' => '','dt' => 4),
        array( 'db' => 'Month_name','dt' => 5),
        array( 'db' => 'nameTypeOfArgi','dt' => 6),
        array( 'db' => 'nameOFArgi','dt' => 7),
        array( 'db' => 'nameMarket','dt' => 8),
        array( 'db' => 'c_name','dt' => 9),
        array( 'db' => 'nameUnit','dt' => 10),
        array( 'db' => 'Weight','dt' => 11),
        array( 'db' => 'Price','dt' => 12),
        array( 'db' => 'Total','dt' => 13),
        array( 'db' => 'idMarket','dt' => 14),
        array( 'db' => 'Month_seq','dt' => 15),
        array( 'db' => 'nameRiverBasin','dt' => 16),
        array( 'db' => 'areaName','dt' => 17),
        array( 'db' => 'YearTarget_YearID','dt' => 18),
        array( 'db' => 'target_area_type_title','dt' => 19),
        array( 'db' => 'target_name','dt' => 20),
        array( 'db' => 'amount1','dt' => 21),
        array( 'db' => 'amount2','dt' => 22),
        array( 'db' => 'amount3','dt' => 23),
        array( 'db' => 'amount4','dt' => 24),
        array( 'db' => 'amount5','dt' => 25),
        array( 'db' => 'amount6','dt' => 26),
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