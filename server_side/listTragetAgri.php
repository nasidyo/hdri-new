<?php
    session_start();
    $idRiverBasin = $_GET['idRiverBasin'];
    $idArea = $_GET['idArea'];
    $idTypeOfArgiSearch = $_GET['idTypeOfArgiSearch'];
    $idAgriSearch = $_GET['idAgriSearch'];
    $staffPermis = $_GET['staffPermis'];
    $areaAll = $_GET['areaAll'];

    $table = "(SELECT ltag.list_taget_agri_id, a.target_area_type_title+' '+a.target_name as fulltargetName , toa.nameTypeOfArgi, a.fbasin_name,
    CASE 
    WHEN agtd.speciesArgi = '' THEN agtd.nameArgi
    WHEN agtd.speciesArgi IS NULL THEN agtd.nameArgi  
    ELSE agtd.nameArgi+'(พันธุ์:'+agtd.speciesArgi+')' END as nameOFArgi, g.codeGrade ";
    $table .= 'FROM list_taget_agri as ltag ';
    $table.= 'INNER JOIN vLinkAreaDetail as a ON ltag.area_id = a.target_id ';
    $table.= 'INNER JOIN Agri_TD as agtd ON (agtd.idAgri = ltag.agri_id) ';
    $table.= 'INNER JOIN TypeOfArgi as toa ON (toa.idTypeOfArgi = ltag.TypeOfArgi_idTypeOfArgi) ';
    $table.= 'INNER JOIN Grade as g ON (g.idGrade = ltag.grade) ';
    $table.= "WHERE ltag.list_taget_agri_id IS NOT NULL ";
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
    if($idTypeOfArgiSearch != 'null' and $idTypeOfArgiSearch != 'undefined' and $idTypeOfArgiSearch != '0' and $idTypeOfArgiSearch != 'all'){
        $table.= "and ltag.TypeOfArgi_idTypeOfArgi = '".$idTypeOfArgiSearch."'";
    }
    if($idAgriSearch != 'null' and $idAgriSearch != 'undefined' and $idAgriSearch != '0'){
        $table.= "and ltag.area_id = '".$idAgriSearch."'";
    }
    $table.="GROUP BY list_taget_agri_id, target_name, fbasin_name, target_area_type_title, nameTypeOfArgi, speciesArgi, nameArgi, codeGrade";
    $table.= ") list_taget_agri";
    // Table's primary key
    $primaryKey = 'list_taget_agri_id';

    $columns = array(
        array( 'db' => 'list_taget_agri_id','dt' => 0 ),
        array( 'db' => 'fbasin_name','dt' => 1 ),
        array( 'db' => 'fulltargetName','dt' => 2 ),
        array( 'db' => 'nameTypeOfArgi','dt' => 3),
        array( 'db' => 'nameOFArgi','dt' => 4),
        array( 'db' => 'codeGrade','dt' => 5),
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