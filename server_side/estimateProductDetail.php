<?php
    session_start();
    $area_Id = $_GET['area_Id'];
    $yearsId = $_GET['yearsId'];

    $typeOfAgri_Id = $_GET['typeOfAgri_Id'];
    $agri_Id = $_GET['agri_Id'];
    $month_id = $_GET['month_id'];
    $market_id = $_GET['market_id'];

    $table=" (
            SELECT opv.idOutputValue, opv.Year_id, mon.Month_id, mon.Month_name, toa.nameTypeOfArgi, 
            CASE 
            WHEN sa.species_Id = '' THEN ag.nameArgi
            WHEN sa.species_Id IS NULL THEN ag.nameArgi  
            ELSE ag.nameArgi+'(พันธุ์:'+sa.species_name+')' END as nameOFArgi, ISNULL(NULLIF(cu.nameCountUnit,''),'กิโลกรัม') as nameUnit, opv.Weight, opv.Price,
            opv.Total as total, mk.nameMarket, tpmk.weight2, tpmk.total2, cs.c_name 
            FROM OutputValue_TD opv
            INNER JOIN MonthOfYear mon ON opv.MonthNo = mon.Month_id
            INNER JOIN Agri_TD ag ON opv.Agri_idAgri = ag.idAgri
            LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and opv.species_Id = sa.species_Id
            LEFT JOIN TypeOfArgi_TD toa ON ag.TypeOfArgi_idTypeOfArgi = toa.idTypeOfArgi
            LEFT JOIN CountUnit cu ON ag.unit_id = cu.idCountUnit
            LEFT JOIN Market_TD mk ON opv.Market_idMarket = mk.idMarket
            LEFT JOIN CustomerMarket_TD cm ON opv.idCustomer = cm.idCustomerMarket
            LEFT JOIN Customer_TD cs ON cm.Customer_idCustomer = cs.idCustomer
            INNER JOIN (SELECT SUM(tp.Weight) as weight2, SUM(tp.Total) as total2, cm.Market_idMarket ,tp.Agri_idAgri, tp.month_id, tp.YearTarget_YearID, tp.Area_idArea ,tp.idTargetPlan
                FROM TargetPlan_TD tp
                LEFT JOIN CustomerMarket_TD cm ON tp.market_id = cm.idCustomerMarket
                GROUP BY tp.Price, tp.month_id, cm.Market_idMarket, tp.Agri_idAgri, tp.month_id, tp.YearTarget_YearID, tp.Area_idArea, idTargetPlan) tpmk ON 
                opv.MonthNo = tpmk.month_id and opv.Agri_idAgri = tpmk.Agri_idAgri and opv.Year_id = tpmk.YearTarget_YearID and opv.Area_id = tpmk.Area_idArea and opv.Market_idMarket = tpmk.Market_idMarket
                and tpmk.idTargetPlan = opv.TargetPlan_idTargetPlan
            WHERE
            opv.Area_id = '".$area_Id."' and opv.Year_id = '".$yearsId."' ";
        if($typeOfAgri_Id != '0'){
            $table.="and toa.idTypeOfArgi = '".$typeOfAgri_Id."' ";
        }
        if($agri_Id != '0'){
            $table.="and ag.idAgri = '".$agri_Id."' ";
        }
        if($month_id != '0'){
            $table.="and mon.Month_id = '".$month_id."' ";
        }
        if($market_id != '0'){
            $table.="and opv.Market_idMarket = '".$market_id."' ";
        }
    $table.=") OutputValue_TD";

    // Table's primary key
    $primaryKey = 'idOutputValue';

    $columns = array(
        array( 'db' => 'idOutputValue','dt' => 0 ),
        array( 'db' => 'Month_id','dt' => 1 ),
        array( 'db' => 'Year_id','dt' => 2),
        array( 'db' => 'Month_name','dt' => 3),
        array( 'db' => 'nameTypeOfArgi','dt' => 4),
        array( 'db' => 'nameOFArgi','dt' => 5),
        array( 'db' => 'nameMarket','dt' => 6),
        array( 'db' => 'c_name','dt' => 7),
        array( 'db' => 'Weight2','dt' => 8),
        array( 'db' => 'total2','dt' => 9),
        array( 'db' => 'Weight','dt' => 10),
        array( 'db' => 'total','dt' => 11),
        array( 'db' => '','dt' => 12),
        array( 'db' => '','dt' => 13),
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
        SSP::complex (  $_GET, $sql_details, $table, $primaryKey, $columns, null,$whereAll)
    );

?>