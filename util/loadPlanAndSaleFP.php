<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];
    if($basinId == '0'){

        $sql = "SELECT t1.totalPlan as planTotal, t2.totalSale as salesTotal, t1.nameDisplay, t1.target_area_type_id
        FROM (SELECT SUM(tpt.Total) as totalPlan , a.areaType as nameDisplay , a.target_area_type_id
        FROM TargetPlan_TD tpt
        INNER JOIN Area a ON a.idArea = tpt.Area_idArea
        INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
        WHERE  tpt.YearTarget_YearID = '".$yearsId."'
        GROUP BY a.areaType, a.target_area_type_id
        ) t1,( SELECT SUM(pmt.TotalValue) as totalSale , a.areaType as nameDisplay , a.target_area_type_id
            FROM PersonMarket_TD pmt 
            INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
            INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
            WHERE  pmt.YearID = '".$yearsId."'
            GROUP BY a.areaType, a.target_area_type_id
        ) t2
        WHERE t1.target_area_type_id = t2.target_area_type_id AND t1.nameDisplay = t2.nameDisplay
        ORDER BY t1.nameDisplay";
    }else{

        $sql = "SELECT t1.totalPlan as planTotal, t2.totalSale as salesTotal, t1.nameDisplay, t1.target_area_type_id
        FROM (SELECT SUM(tpt.Total) as totalPlan , a.target_name as nameDisplay , a.target_area_type_id
        FROM TargetPlan_TD tpt
        INNER JOIN Area a ON a.idArea = tpt.Area_idArea
        INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
        WHERE  tpt.YearTarget_YearID = '".$yearsId."' AND a.target_area_type_id = '".$basinId."' 
        GROUP BY a.target_name, a.target_area_type_id
        ) t1,( SELECT SUM(pmt.TotalValue) as totalSale , a.target_name as nameDisplay , a.target_area_type_id
            FROM PersonMarket_TD pmt 
            INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
            INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
            WHERE  pmt.YearID = '".$yearsId."' AND a.target_area_type_id = '".$basinId."' 
            GROUP BY a.target_name, a.target_area_type_id
        ) t2
        WHERE t1.target_area_type_id = t2.target_area_type_id AND t1.nameDisplay = t2.nameDisplay
        ORDER BY t1.nameDisplay";
    }
    
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['totalPlan'] = $row['planTotal'];
        $row_array['totalSale'] = $row['salesTotal'];
        $row_array['name'] = $row['nameDisplay'];
        array_push($return_arr, $row_array);
    }
    
    echo json_encode($return_arr);
?>