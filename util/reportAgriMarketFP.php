<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];

    if($basinId == 0){
        $sql = "SELECT a.target_area_type_id, a.areaType , SUM (pmt.TotalValue ) as totalValue
                FROM Area a 
                INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
                WHERE a.target_area_type_id in (3,5,10) AND a.RiverBasin_idRiverBasin NOT IN (1,22) and pmt.YearID ='".$yearsId."' 
                GROUP BY a.target_area_type_id, a.areaType";
        $stmt = sqlsrv_query( $conn, $sql);
        $return_arr = array();
        $labelSet = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $dataSet = array();
            $row_array1 = array();
            $row_array1['name'] = $row['areaType'];
            $row_array1['totalValue'] = $row['totalValue'];
            $sql2 = "SELECT mt.nameMarket , ISNULL(SUM(TotalValue),0) as TotalValueM , pmt.Market_idMarket
                    FROM PersonMarket_TD pmt
                    INNER JOIN Area a ON a.idArea = pmt.Area_idArea
                    INNER JOIN Market_TD mt ON pmt.Market_idMarket = mt.idMarket 
                    WHERE a.target_area_type_id in (3,5,10) AND a.RiverBasin_idRiverBasin NOT IN (1,22) and pmt.YearID ='".$yearsId."' and a.target_area_type_id = '".$row['target_area_type_id']."'
                    GROUP BY pmt.Market_idMarket, mt.nameMarket
                    ORDER BY pmt.Market_idMarket";
            $stmt2 = sqlsrv_query( $conn, $sql2);
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                $row_array2 = array();
                $row_array1['value'.$row2['Market_idMarket']] = $row2['TotalValueM'];
                $totalVal = ((int)$row2['TotalValueM']*100)/floatval($row['totalValue']);
                $row_array1["data".$row2['Market_idMarket']] = number_format($totalVal,2);
            }
            $row_array1['dataSet'] = $dataSet;
            array_push($return_arr, $row_array1);
        }
    }else{
        $sql = "SELECT a.target_area_type_id, a.areaType, SUM (pmt.TotalValue ) as totalValue
                FROM Area a
                INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
                WHERE a.target_area_type_id in (3,5,10) AND a.RiverBasin_idRiverBasin NOT IN (1,22) and pmt.YearID ='".$yearsId."' and a.target_area_type_id = '".$basinId."'
                GROUP BY a.target_area_type_id, a.areaType";
        $stmt = sqlsrv_query( $conn, $sql);
        $return_arr = array();
        $labelSet = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $dataSet = array();
            $row_array1 = array();
            $row_array1['name'] = $row['areaType'];
            $row_array1['totalValue'] = $row['totalValue'];
            $sql2 = "SELECT mt.nameMarket , ISNULL(SUM(TotalValue),0) as TotalValueM , pmt.Market_idMarket
                    FROM PersonMarket_TD pmt
                    INNER JOIN Area a ON a.idArea = pmt.Area_idArea
                    INNER JOIN Market_TD mt ON pmt.Market_idMarket = mt.idMarket 
                    WHERE a.target_area_type_id in (3,5,10) AND a.RiverBasin_idRiverBasin NOT IN (1,22) and pmt.YearID ='".$yearsId."' and  a.target_area_type_id = '".$row['target_area_type_id']."'
                    GROUP BY pmt.Market_idMarket, mt.nameMarket
                    ORDER BY pmt.Market_idMarket";
            $stmt2 = sqlsrv_query( $conn, $sql2);
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                $row_array2 = array();
                $row_array1['value'.$row2['Market_idMarket']] = $row2['TotalValueM'];
                $totalVal = ((int)$row2['TotalValueM']*100)/floatval($row['totalValue']);
                $row_array1["data".$row2['Market_idMarket']] = number_format($totalVal,2);
            }
            $row_array1['dataSet'] = $dataSet;
            array_push($return_arr, $row_array1);
        }
    }
    echo json_encode($return_arr);
?>