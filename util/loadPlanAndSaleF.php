<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];
    if($basinId == '0'){
        $sql = "SELECT t1.totalPlan as planTotal, t2.totalSale as salesTotal, t1.nameDisplay, t1.idRiverBasin
        FROM (SELECT SUM(tpt.Total) as totalPlan , mb.nameRiverBasin as nameDisplay , mb.idRiverBasin 
        FROM TargetPlan_TD tpt
        INNER JOIN Area a ON a.idArea = tpt.Area_idArea
        INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
        WHERE  tpt.YearTarget_YearID = '".$yearsId."'
        GROUP BY mb.nameRiverBasin, mb.idRiverBasin
        ) t1,( SELECT SUM(pmt.TotalValue) as totalSale , mb.nameRiverBasin as nameDisplay , mb.idRiverBasin 
            FROM PersonMarket_TD pmt 
            INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
            INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
            WHERE  pmt.YearID = '".$yearsId."'
            GROUP BY mb.nameRiverBasin, mb.idRiverBasin
        ) t2
        WHERE t1.idRiverBasin = t2.idRiverBasin AND t1.nameDisplay = t2.nameDisplay
        ORDER BY t1.nameDisplay";
    }else{
        $sql = "SELECT t1.totalPlan as planTotal, t2.totalSale as salesTotal, t1.nameDisplay, t1.idRiverBasin
        FROM (SELECT SUM(tpt.Total) as totalPlan , a.target_name as nameDisplay , mb.idRiverBasin 
        FROM TargetPlan_TD tpt
        INNER JOIN Area a ON a.idArea = tpt.Area_idArea
        INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
        WHERE  tpt.YearTarget_YearID = '".$yearsId."' and mb.idRiverBasin = '".$basinId."'
        GROUP BY a.target_name, mb.idRiverBasin , a.idArea 
        ) t1,( SELECT SUM(pmt.TotalValue) as totalSale , a.target_name as nameDisplay , mb.idRiverBasin 
            FROM PersonMarket_TD pmt 
            INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
            INNER JOIN MainBasin mb on mb.idRiverBasin = a.RiverBasin_idRiverBasin
            WHERE  pmt.YearID = '".$yearsId."' and mb.idRiverBasin = '".$basinId."'
            GROUP BY a.target_name, mb.idRiverBasin , a.idArea 
        ) t2
        WHERE t1.idRiverBasin = t2.idRiverBasin AND t1.nameDisplay = t2.nameDisplay
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