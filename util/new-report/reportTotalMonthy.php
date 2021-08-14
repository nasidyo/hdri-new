<?php
    require '../../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();

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
        $sql1 = "SELECT SUM(pmt.TotalValue) as TotalValue, SUM(pmt.Volumn) as TotalVolumn
                    FROM PersonMarket_TD pmt 
                    WHERE pmt.MonthNo = '".$row['Month_id']."' and pmt.YearID ='".$_POST['yearsId']."'";
        $stmt1 = sqlsrv_prepare($conn, $sql1 );
        if( !$stmt1 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt1 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            $row_array['TotalValue'] = $row1['TotalValue'];
            $row_array['TotalVolumn'] = $row1['TotalVolumn'];
        }
        array_push($return_arr, $row_array);
    }
    echo json_encode($return_arr);
?>