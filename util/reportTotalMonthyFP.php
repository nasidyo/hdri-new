<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];

    if($basinId == '0'){
        $sql = "SELECT DISTINCT a.target_area_type_id , a.areaType 
                FROM Area a 
                WHERE a.target_area_type_id in (3,5,10)";
    }else{
        $sql = "SELECT DISTINCT a.idArea , a.target_name 
                FROM Area a 
                WHERE a.RiverBasin_idRiverBasin NOT IN (1,22) and a.target_area_type_id in (3,5,10) and a.target_area_type_id = '".$basinId."'";
    }
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $rowtable = "";
    if($basinId == '0'){
        $theader = "<th rowspan='2'>ลุ่มน้ำ</th>";
    }else{
        $theader = "<th rowspan='2'>พื้นที่</th>";
    }
    $theaderRow = "";
    $checkFristRow = "N";
    $count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $return_arr1 = array();
        if($basinId == '0'){
            // $rowtable .= "<tr><td>".$row['areaType']."</td>";
            $sql1 ="SELECT t1.Month_id,t1.Month_Etc, t1.Month_seq, COALESCE(t2.total,0) as totalPlan, COALESCE(t3.TotalValue,0) as totalSale
            FROM 
                (SELECT moy.Month_id, moy.Month_Etc ,moy.Month_seq
                FROM MonthOfYear moy ) t1
                    LEFT JOIN (SELECT SUM(tpt.Total ) as total, tpt.month_id 
                        FROM TargetPlan_TD tpt 
                        INNER JOIN Area a ON a.idArea = tpt.Area_idArea
                        WHERE tpt.YearTarget_YearID ='".$yearsId."' and a.target_area_type_id = '".$row['target_area_type_id']."'
                        GROUP BY tpt.month_id 
                    ) t2 ON t1.Month_id = t2.month_id
                    LEFT JOIN (SELECT SUM(pmt.TotalValue ) as TotalValue, pmt.MonthNo 
                        FROM PersonMarket_TD pmt 
                        INNER JOIN Area a ON a.idArea = pmt.Area_idArea
                        WHERE pmt.YearID ='".$yearsId."' and a.target_area_type_id = '".$row['target_area_type_id']."'
                        GROUP BY pmt.MonthNo 
                    ) t3 ON t1.Month_id = t3.MonthNo
                ORDER BY t1.Month_seq";
            $stmt1 = sqlsrv_prepare($conn, $sql1 );
            if( !$stmt1 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt1 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $rowtable2 = '';
            $sumrow1 = 0;
            $sumrow2 = 0;
            while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
                $sumrow1 = $sumrow1+$row1['totalPlan'];
                $sumrow2 = $sumrow2+$row1['totalSale'];
                $rowtable2 .= "<td style='text-align: right'>".number_format($row1['totalPlan'])."</td><td style='text-align: right'>".number_format($row1['totalSale'])."</td>";
                if($checkFristRow == 'N'){
                    $yearDisply = (int)$_POST['yearsId'];
                    if($row1['Month_id'] >= 10){
                        $yearDisply = $yearDisply-1;
                    }
                    $theader .= "<th colspan='2'>".$row1['Month_Etc']." ".substr($yearDisply,-2)."</th>";
                    $theaderRow.= "<th>เป้าหมาย</th><th>ส่งมอบ</th>";
                }
                $count ++;
            }
            if($sumrow1 > 0 && $sumrow2 > 0){
                $rowtable .= "<tr><td>".$row['areaType']."</td>";
                $rowtable .= $rowtable2;
                $rowtable .= "</tr>";
            }
            $checkFristRow = "Y";
        }else{
            // $rowtable .= "<tr><td>".$row['target_name']."</td>";
            $sql1 ="SELECT t1.Month_id,t1.Month_Etc, t1.Month_seq, COALESCE(t2.total,0) as totalPlan, COALESCE(t3.TotalValue,0) as totalSale
                    FROM 
                        (SELECT moy.Month_id, moy.Month_Etc ,moy.Month_seq
                        FROM MonthOfYear moy ) t1
                            LEFT JOIN (SELECT SUM(tpt.Total ) as total, tpt.month_id 
                                FROM TargetPlan_TD tpt 
                                INNER JOIN Area a ON a.idArea = tpt.Area_idArea
                                WHERE tpt.YearTarget_YearID ='".$yearsId."' and a.idArea = '".$row['idArea']."'
                                GROUP BY tpt.month_id 
                            ) t2 ON t1.Month_id = t2.month_id
                            LEFT JOIN (SELECT SUM(pmt.TotalValue ) as TotalValue, pmt.MonthNo 
                                FROM PersonMarket_TD pmt 
                                INNER JOIN Area a ON a.idArea = pmt.Area_idArea
                                WHERE pmt.YearID ='".$yearsId."' and a.idArea = '".$row['idArea']."'
                                GROUP BY pmt.MonthNo 
                            ) t3 ON t1.Month_id = t3.MonthNo
                ORDER BY t1.Month_seq";
            $stmt1 = sqlsrv_prepare($conn, $sql1 );
            if( !$stmt1 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt1 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $rows = sqlsrv_has_rows($stmt1);
            if ($rows === true){
                $sumrow1 = 0;
                $sumrow2 = 0;
                $rowtable2 = '';
                while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
                    $sumrow1 = $sumrow1+$row1['totalPlan'];
                    $sumrow2 = $sumrow2+$row1['totalSale'];
                    $rowtable2 .= "<td style='text-align: right'>".number_format($row1['totalPlan'])."</td><td style='text-align: right'>".number_format($row1['totalSale'])."</td>";
                    if($checkFristRow == 'N'){
                        $yearDisply = (int)$_POST['yearsId'];
                        if($row1['Month_id'] >= 10){
                            $yearDisply = $yearDisply-1;
                        }
                        $theader .= "<th colspan='2'>".$row1['Month_Etc']." ".substr($yearDisply,-2)."</th>";
                        $theaderRow.= "<th>เป้าหมาย</th><th>ส่งมอบ</th>";
                    }
                    $count ++;
                }
                
            }else{
                $rowtable2 .= "<td>0.00</td><td>0.00</td>";
            }
            if($sumrow1 > 0 && $sumrow2 > 0){
                $rowtable .= "<tr><td>".$row['target_name']."</td>";
                $rowtable .= $rowtable2;
                $rowtable .= "</tr>";
            }
            $checkFristRow = "Y";
        }
    }
    
    // $rowtable .= "</tr>";
    $row_array['row'] = $rowtable;
    $row_array['thaedRow'] = "<tr>".$theader."</tr><tr>".$theaderRow."</tr>";
    array_push($return_arr, $row_array);
    echo json_encode($return_arr);
?>