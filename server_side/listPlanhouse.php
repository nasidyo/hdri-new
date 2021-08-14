<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];
    $staffPermis = $_GET['staffPermis'];
    $areaAll = $_GET['areaAll'];

    $table = "(SELECT ph.plantHouse_Id, ph.idLand, ph.houseNumber, a.target_area_type_title+' '+a.target_name as fulltargetName, a.fbasin_name,
        'จำนวน:'+ COALESCE(lan.unit1,'0')+' แปลง พื้นที่:'+COALESCE(lan.unit2,'0')+'-'+COALESCE(lan.unit3,'0')+'-'+COALESCE(lan.unit4,'0')+'ไร่' as coordinat, p.firstName+' '+p.lastName as personName 
        FROM PlantHouse_TD as ph
        INNER JOIN vLinkAreaDetail as a ON ph.Area_idArea = a.target_id 
        INNER JOIN Land_Detail as lan ON ph.idLand = lan.land_detail_id
        INNER JOIN Person_TD as p ON lan.person_id = p.idPerson
        WHERE ph.plantHouse_Id IS NOT NULL ";
    if($idRiverBasin != 'null' && $idRiverBasin != 'undefined' && $idRiverBasin != '0'){
        $table.= "and a.fbasin_id = '".$idRiverBasin."'";
    }
    if($idArea != 'null' and $idArea != 'undefined' and $idArea != '0'){
        $table.= "and a.target_id = '".$idArea."'";
    }else{
        if($staffPermis == 'staff'){
            $table.= "and a.target_id IN (".$areaAll.")";
        }
    }
    $table.="GROUP BY plantHouse_Id, idLand, fbasin_name, target_area_type_title, target_name, houseNumber, unit1, unit2, unit3, unit4, firstName ,lastName  ";
    $table.= ") PlantHouse_TD";
    // Table's primary key
    $primaryKey = 'plantHouse_Id';

    $columns = array(
        array( 'db' => 'plantHouse_Id','dt' => 0 ),
        array( 'db' => 'fbasin_name','dt' => 1 ),
        array( 'db' => 'fulltargetName','dt' => 2),
        array( 'db' => 'personName','dt' => 3),
        array( 'db' => 'coordinat','dt' => 4),
        array( 'db' => 'houseNumber','dt' => 5),
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