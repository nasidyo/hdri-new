<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];
    $idpersonSearch = $_GET['idpersonSearch'];
    $staffPermis = $_GET['staffPermis'];
    $areaAll = $_GET['areaAll'];

    $table = "(SELECT lan.land_detail_id, lan.land_no, p.firstName +' '+ p.lastName as fullname, lad.target_area_type_title+' '+lad.target_name as fulltargetName, lad.fbasin_name,
    COALESCE(lan.unit1,'0')+'ไร่-'+COALESCE(lan.unit2,'0')+'งาน -'+COALESCE(lan.unit3,'0')+'ตารางวา' as coordinat 
        FROM Land_Detail as lan 
        INNER JOIN Person_TD as p ON lan.person_id = p.idPerson 
        INNER JOIN vLinkAreaDetail as lad ON p.Area_idArea = lad.target_id 
        WHERE lan.land_detail_id IS NOT NULL ";
    if($idRiverBasin != 'null' && $idRiverBasin != 'undefined' && $idRiverBasin != '0'){
        $table.= "and lad.fbasin_id = '".$idRiverBasin."'";
    }
    if($idArea != 'null' and $idArea != 'undefined' and $idArea != '0'){
        $table.= "and lad.target_id = '".$idArea."'";
    }else{
        if($staffPermis == 'staff'){
            $table.= "and lad.target_id IN (".$areaAll.")";
        }
    }
    if($idpersonSearch != '0'){
        $table.= "and lan.person_id = '".$idpersonSearch."'";
    }
    $table.="GROUP BY land_detail_id, fbasin_name, target_area_type_title, target_name, land_no, firstName, lastName, unit1, unit2, unit3, unit4  ";
    $table.= ") Land_Detail";
    // Table's primary key
    $primaryKey = 'land_detail_id';

    $columns = array(
        array( 'db' => 'land_detail_id','dt' => 0 ),
        array( 'db' => 'fbasin_name','dt' => 1 ),
        array( 'db' => 'fulltargetName','dt' => 2),
        array( 'db' => 'fullname','dt' => 3 ),
        array( 'db' => 'land_no','dt' => 4),
        array( 'db' => 'coordinat','dt' => 5),
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