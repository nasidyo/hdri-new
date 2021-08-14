<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $month = $_POST['month'];
    $agriId = $_POST['agriId'];
    $yearsId = $_POST['yearsId'];
    $count = 5;
    $sumOfVolumn = 0;
    $return_arr = array();
    $return_arr2 = array();
    $data = array();
    for ($x = 0; $x < $count; $x++) {
        if($x == 0){
            $month = $month;
        }else{
            $month = ($month-1);
            if($month == 0){
                $month = 12;
            }
        }
        $sql = "SELECT moy.Month_name, moy.Month_id FROM MonthOfYear moy WHERE moy.Month_id = '".$month."'";
        $stmt = sqlsrv_query( $conn, $sql );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
          }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['Month_name'] = $row['Month_name'];
            $sql2 = "SELECT AVG(pmt.Volumn) as avgVolumn 
                    FROM PersonMarket_TD pmt 
                    WHERE pmt.Agri_idAgri = '".$agriId."' and pmt.MonthNo = '".$month."' and pmt.YearID ='".$yearsId."'";
            $stmt2 = sqlsrv_prepare($conn, $sql2 );
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt2 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $rows = sqlsrv_has_rows($stmt2);
            if ($rows === true){
                while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                    $sumOfVolumn = $sumOfVolumn+$row2['avgVolumn'];
                    $row_array['avgVolumn'] = $row2['avgVolumn'];
                }
            }else{
                $row_array['avgVolumn'] = '0';
            }
            array_push($return_arr, $row_array);
        }
    }
    // $row_array1['dataSet'] = $return_arr;
    // $row_array1['sumAvgVolumn'] = $sumOfVolumn;
    // array_push($return_arr2, $row_array1);
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>