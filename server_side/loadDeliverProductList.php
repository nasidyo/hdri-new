<?php
    session_start();
    $area_Id = $_GET['area_Id'];
    $yearsId = $_GET['yearsId'];
    $monthId = $_GET['monthId'];
    $argi_Id = $_GET['argi_Id'];
    $market_Id = $_GET['market_Id'];
    $table = " (
        SELECT pmk.idPersonMarket, tyag.idTypeOfArgi, ag.idAgri, per.idPerson, cusmk.idCustomerMarket, FORMAT(pmk.dateDeliver, 'dd/MM/yyyy','th') as dateDeliver , per.firstName+' '+per.lastName as fullName, tyag.nameTypeOfArgi,
        CASE 
        WHEN sa.species_Id = '' THEN ag.nameArgi
        WHEN sa.species_Id IS NULL THEN ag.nameArgi  
        ELSE ag.nameArgi+'(พันธุ์:'+sa.species_name+')' END as nameOFArgi, tos.nameTypeOfStand, gd.codeGrade, COALESCE(pmk.Volumn,'0') as Volumns, COALESCE(pmk.Value,'0') as Value, COALESCE(pmk.TotalValue,'0') as TotalValues, mk.nameMarket, cus.c_name, pmk.Grade_codeGrade,
        ISNULL( pmk.onMB , 0 ) as isMB 
        FROM PersonMarket_TD pmk
        INNER JOIN Agri_TD ag ON pmk.Agri_idAgri = ag.idAgri
        LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and pmk.species_Id = sa.species_Id
        INNER JOIN TypeOfArgi_TD tyag ON pmk.TypeOfArgi_idTypeOfArgi = tyag.idTypeOfArgi
        INNER JOIN TypeOfStand tos ON pmk.TypeOfStand_idTypeOfStand = tos.idTypeOfStand
        INNER JOIN Grade gd ON pmk.Grade_codeGrade = gd.idGrade
        INNER JOIN Person_TD per ON pmk.Person_idPerson = per.idPerson
        LEFT JOIN Market_TD mk ON pmk.Market_idMarket = mk.idMarket
        LEFT JOIN Customer_TD cus ON pmk.Customer_idCustomer = cus.idCustomer
        LEFT JOIN CustomerMarket_TD cusmk ON cus.idCustomer = cusmk.Customer_idCustomer and mk.idMarket = cusmk.Market_idMarket and pmk.Area_idArea = cusmk.Area_idArea
        WHERE pmk.Area_idArea ='".$area_Id."' and pmk.MonthNo = '".$monthId."' and pmk.YearID ='".$yearsId."' and ag.idAgri = '".$argi_Id."' and mk.idMarket = '".$market_Id."'
    ) PersonMarket_TD";

    // Table's primary key
    $primaryKey = 'idPersonMarket';

    $columns = array(
        array( 'db' => 'idPersonMarket','dt' => 0 ),

        array( 'db' => 'idTypeOfArgi','dt' => 1 ),
        array( 'db' => 'idAgri','dt' => 2 ),
        array( 'db' => 'idPerson','dt' => 3 ),
        array( 'db' => 'idCustomerMarket','dt' => 4 ),
        array( 'db' => '','dt' => 5 ),
        array( 'db' => 'dateDeliver','dt' => 6),
        array( 'db' => 'fullName','dt' => 7),
        array( 'db' => 'nameTypeOfArgi','dt' => 8),
        array( 'db' => 'nameOFArgi','dt' => 9),
        array( 'db' => 'nameTypeOfStand','dt' => 10),
        array( 'db' => 'codeGrade','dt' => 11),
        array( 'db' => 'Volumns','dt' => 12),
        array( 'db' => 'Value','dt' => 13),
        array( 'db' => 'TotalValues','dt' => 14),
        array( 'db' => 'nameMarket','dt' => 15),
        array( 'db' => 'c_name','dt' => 16),
        array( 'db' => 'Grade_codeGrade','dt' => 17),
        array( 'db' => 'isMB','dt' => 18)
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