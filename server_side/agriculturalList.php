<?php
    session_start();
    $typeOfAgri_id = $_GET['typeOfAgri_id'];
    $idTypeOfStand = $_GET['idTypeOfStand'];

    $table = "(SELECT agtd.idAgri, toa.nameTypeOfArgi, gltd.nameGrowLocate, tos.nameTypeOfStand, ISNULL(NULLIF(cu.nameCountUnit,''),'กิโลกรัม') as nameUnit, 
    CASE 
    WHEN agtd.speciesArgi = '' THEN agtd.nameArgi
    WHEN agtd.speciesArgi IS NULL THEN agtd.nameArgi  
    ELSE agtd.nameArgi+'(พันธุ์:'+agtd.speciesArgi+')' END as nameOFArgi ";
    $table.= "FROM Agri_TD AS agtd ";
    $table.= "LEFT JOIN TypeOfStand AS tos ON (tos.idTypeOfStand = agtd.TypeOfStand_idTypeOfStand) ";
    $table.= "LEFT JOIN TypeOfArgi_TD AS toa ON (toa.idTypeOfArgi = agtd.TypeOfArgi_idTypeOfArgi) ";
    $table.= "LEFT JOIN GrowLocate_TD AS gltd ON (gltd.idGrowLocate = agtd.GrowLocate_idGrowLocate) ";
    $table.= "LEFT JOIN CountUnit AS cu ON (cu.idCountUnit = agtd.unit_id) ";
    $table.= "WHERE agtd.idAgri IS NOT NULL ";
    if($typeOfAgri_id != 'all' && $typeOfAgri_id != '0'){
        $table.= "and agtd.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
    }
    if($idTypeOfStand != 'all' && $idTypeOfStand != '0'){
        $table.= "and agtd.TypeOfStand_idTypeOfStand = '".$idTypeOfStand."'";
    }
    $table.= ") Agri_TD";

    // Table's primary key
    $primaryKey = 'idAgri';

    $columns = array(
        array( 'db' => 'idAgri','dt' => 0 ),
        array( 'db' => 'nameOFArgi','dt' => 1 ),
        array( 'db' => 'nameTypeOfArgi','dt' => 2),
        array( 'db' => 'nameTypeOfStand','dt' => 3),
        array( 'db' => 'nameUnit','dt' => 4),
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