<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];
    $staffPermis = $_GET['staffPermis'];
    $areaAll = $_GET['areaAll'];

    $table = "(SELECT lvl.list_vill_level_id, lad.fbasin_name,  lad.target_area_type_title+' '+lad.target_name as fulltargetName, gv.nameGroupVillage,lvl.level
        FROM list_vill_level_TD as lvl 
        INNER JOIN GroupVillage as gv ON lvl.idGroupVillage = gv.idGroupVillage 
        INNER JOIN vLinkAreaDetail as lad ON lvl.idArea = lad.target_id 
        WHERE lvl.list_vill_level_id IS NOT NULL ";
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

    $table.=" GROUP BY list_vill_level_id, fbasin_name, target_area_type_title, target_name, nameGroupVillage, level";
    $table.= ") list_vill_level_TD";
    // Table's primary key
    $primaryKey = 'list_vill_level_id';

    $columns = array(
        array( 'db' => 'list_vill_level_id','dt' => 0 ),
        array( 'db' => 'fbasin_name','dt' => 1 ),
        array( 'db' => 'fulltargetName','dt' => 2),
        array( 'db' => 'nameGroupVillage','dt' => 3 ),
        array( 'db' => 'level','dt' => 4 )
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