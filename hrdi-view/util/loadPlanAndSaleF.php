<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];
    if($basinId == '0'){
        $sql = "SELECT DISTINCT rb.nameRiverBasin as nameDisplay, rb.idRiverBasin , SUM (pmt.TotalValue ) as salesTotal, sum(tpt.Total ) as planTotal
        FROM MainBasin rb 
        INNER JOIN Area a ON rb.idRiverBasin = a.RiverBasin_idRiverBasin
        INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
        INNER JOIN TargetPlan_TD tpt ON a.idArea = tpt.Area_idArea 
        WHERE a.target_area_type_id in (3,5,10) AND rb.idRiverBasin NOT IN (1,22) and pmt.YearID = '".$yearsId."' and tpt.YearTarget_YearID = '".$yearsId."'
        GROUP BY rb.nameRiverBasin, rb.idRiverBasin";
    }else{
        $sql = "SELECT DISTINCT rb.idRiverBasin, a.target_name as nameDisplay , SUM (pmt.TotalValue ) as salesTotal, sum(tpt.Total ) as planTotal
        FROM MainBasin rb 
        INNER JOIN Area a ON rb.idRiverBasin = a.RiverBasin_idRiverBasin
        INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
        INNER JOIN TargetPlan_TD tpt ON a.idArea = tpt.Area_idArea 
        WHERE a.target_area_type_id in (3,5,10) AND rb.idRiverBasin NOT IN (1,22) and pmt.YearID = '".$yearsId."' and tpt.YearTarget_YearID = '".$yearsId."' and rb.idRiverBasin = '".$basinId."' 
        GROUP BY a.target_name, rb.idRiverBasin";
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