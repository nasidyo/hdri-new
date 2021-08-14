<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $typeAgri = $_POST["typeAgri"];
    $sql = "SELECT Month_id, Month_Etc
    FROM MonthOfYear
    ORDER BY Month_seq";
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $yearDisply = (int)$_POST['yearsId'];
        if($row['Month_id'] >= 10){
            $yearDisply = $yearDisply-1;
        }
        $row_array['Month_Etc'] = $row['Month_Etc']." ".substr($yearDisply,-2);
        if($typeAgri != '0'){
            $sql1 = "SELECT t1.totalPlan, t2.totalSale, t1.nameTypeOfArgi
                FROM (SELECT SUM(tpt.Total) as totalPlan, tya.nameTypeOfArgi
                    FROM TargetPlan_TD tpt 
                    INNER JOIN TypeOfArgi_TD tya ON tpt.TypeOfArgi_idTypeOfArgi = tya.idTypeOfArgi 
                    WHERE tpt.month_id = '".$row['Month_id']."' and tpt.YearTarget_YearID ='".$_POST['yearsId']."' and tpt.TypeOfArgi_idTypeOfArgi = $typeAgri 
                    GROUP BY tya.nameTypeOfArgi) t1,
                (SELECT SUM(pmt.TotalValue) as totalSale
                    FROM PersonMarket_TD pmt 
                    WHERE pmt.MonthNo = '".$row['Month_id']."' and pmt.YearID ='".$_POST['yearsId']."' and pmt.TypeOfArgi_idTypeOfArgi = $typeAgri) t2";
        }else{
            $sql1 = "SELECT t1.totalPlan, t2.totalSale
                    FROM (SELECT SUM(tpt.Total) as totalPlan
                            FROM TargetPlan_TD tpt 
                            WHERE tpt.month_id = '".$row['Month_id']."' and tpt.YearTarget_YearID ='".$_POST['yearsId']."' ) t1,
                        (SELECT SUM(pmt.TotalValue) as totalSale
                            FROM PersonMarket_TD pmt 
                            WHERE pmt.MonthNo = '".$row['Month_id']."' and pmt.YearID ='".$_POST['yearsId']."' ) t2";
        }
        $stmt1 = sqlsrv_prepare($conn, $sql1 );
        if( !$stmt1 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt1 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            if($typeAgri != '0'){
                $row_array['nameTypeOfArgi'] = $row1['nameTypeOfArgi'];
            }
            $row_array['totalPlan'] = $row1['totalPlan'];
            $row_array['totalSale'] = $row1['totalSale'];
        }
        array_push($return_arr, $row_array);
    }
    echo json_encode($return_arr);
?>