<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];

    if($basinId != '0'){
        $sql = "SELECT DISTINCT vlad.fbasin_id , vlad.fbasin_name 
            FROM vLinkAreaDetail vlad 
            WHERE vlad.fbasin_id NOT IN (1,22) and vlad.fbasin_id = '".$basinId."'";
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
            $row_array['name'] = $row['fbasin_name'];
            if($basinId != '0'){
                $rowtable .= "<tr><td>".$row['fbasin_name']."</td>";
                $sql1 ="SELECT t1.Month_id,t1.Month_Etc, t1.Month_seq, COALESCE(t2.total,0) as totalPlan, COALESCE(t3.TotalValue,0) as totalSale
                FROM 
                    (SELECT moy.Month_id, moy.Month_Etc ,moy.Month_seq
                    FROM MonthOfYear moy ) t1
                        LEFT JOIN (SELECT SUM(tpt.Total ) as total, tpt.month_id 
                            FROM TargetPlan_TD tpt 
                            INNER JOIN vLinkAreaDetail vlad ON tpt.Area_idArea = vlad.target_id
                            WHERE tpt.YearTarget_YearID ='".$yearsId."' and vlad.fbasin_id = '".$row['fbasin_id']."'
                            GROUP BY tpt.month_id 
                        ) t2 ON t1.Month_id = t2.month_id
                        LEFT JOIN (SELECT SUM(pmt.TotalValue ) as TotalValue, pmt.MonthNo 
                            FROM PersonMarket_TD pmt 
                            INNER JOIN vLinkAreaDetail vlad ON pmt.Area_idArea = vlad.target_id
                            WHERE pmt.YearID ='".$yearsId."' and vlad.fbasin_id = '".$row['fbasin_id']."'
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
                while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
                    $yearDisply = (int)$_POST['yearsId'];
                    if($row1['Month_id'] >= 10){
                        $yearDisply = $yearDisply-1;
                    }
                    $row_array['Month_Etc'] = $row1['Month_Etc']." ".substr($yearDisply,-2);
                    $row_array['totalPlan'] = $row1['totalPlan'];
                    $row_array['totalSale'] = $row1['totalSale'];
                    array_push($return_arr, $row_array);
                }
            }
        }
    }else{
        $sql1 ="SELECT t1.Month_id,t1.Month_Etc, t1.Month_seq, COALESCE(t2.total,0) as totalPlan, COALESCE(t3.TotalValue,0) as totalSale
                FROM 
                    (SELECT moy.Month_id, moy.Month_Etc ,moy.Month_seq
                    FROM MonthOfYear moy ) t1
                        LEFT JOIN (SELECT SUM(tpt.Total ) as total, tpt.month_id 
                            FROM TargetPlan_TD tpt 
                            INNER JOIN vLinkAreaDetail vlad ON tpt.Area_idArea = vlad.target_id
                            WHERE tpt.YearTarget_YearID ='".$yearsId."'
                            GROUP BY tpt.month_id 
                        ) t2 ON t1.Month_id = t2.month_id
                        LEFT JOIN (SELECT SUM(pmt.TotalValue ) as TotalValue, pmt.MonthNo 
                            FROM PersonMarket_TD pmt 
                            INNER JOIN vLinkAreaDetail vlad ON pmt.Area_idArea = vlad.target_id
                            WHERE pmt.YearID ='".$yearsId."'
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
        $return_arr = array();
        while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            $yearDisply = (int)$_POST['yearsId'];
            if($row1['Month_id'] >= 10){
                $yearDisply = $yearDisply-1;
            }
            $row_array['Month_Etc'] = $row1['Month_Etc']." ".substr($yearDisply,-2);
            $row_array['totalPlan'] = $row1['totalPlan'];
            $row_array['totalSale'] = $row1['totalSale'];
            array_push($return_arr, $row_array);
        }
    }
    echo json_encode($return_arr);
?>