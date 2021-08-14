<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $month = $_POST['month'];
    $area_Id = $_POST['area_Id'];
    $yearsId = $_POST['yearsId'];
    $count = 5;
    $sumOfVolumn1 = 0;
    $sumOfVolumn2 = 0;
    $sumOfVolumn3 = 0;
    $sumOfVolumn4 = 0;
    $sumOfVolumn5 = 0;
    $return_arr = array();
    $return_arr2 = array();
    $idAgriList = array();
    $nameAgriList = array();
    $data = array();


    $sqlAgri = "SELECT TOP (5) pmt.Agri_idAgri, ag.nameArgi , SUM(pmt.TotalValue) as totalValue
            FROM PersonMarket_TD pmt 
            INNER JOIN Agri_TD ag on ag.idAgri = pmt.Agri_idAgri 
            WHERE pmt.Area_idArea = '".$area_Id."' and pmt.YearID ='".$yearsId."'
            GROUP BY pmt.Agri_idAgri, ag.nameArgi
            ORDER BY totalValue";
    $stmtAgri = sqlsrv_query( $conn, $sqlAgri );
    if( !$stmtAgri ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $rowAgri = sqlsrv_fetch_array( $stmtAgri, SQLSRV_FETCH_ASSOC) ) {
        array_push($return_arr, $rowAgri['nameArgi']);
        $result[] = $rowAgri['Agri_idAgri'];
    }

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
            $sql2 = "SELECT AVG(pmt.Volumn) as avgVolumn , pmt.Agri_idAgri, ag.nameArgi
                    FROM PersonMarket_TD pmt 
                    INNER JOIN Agri_TD ag on ag.idAgri = pmt.Agri_idAgri
                    WHERE pmt.Area_idArea = '".$area_Id."' and pmt.MonthNo = '".$month."' and pmt.YearID ='".$yearsId."' AND pmt.Agri_idAgri IN (".implode(",",$result).") 
                    GROUP BY pmt.Agri_idAgri, ag.nameArgi";

            $stmt2 = sqlsrv_prepare($conn, $sql2 );
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt2 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $rows = sqlsrv_has_rows($stmt2);
            $counts = 1;
            if ($rows === true){
                while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                    $sumOfVolumn.$counts = ($sumOfVolumn.$counts+$row2['avgVolumn']);
                    // $row_array['avgVolumn'] = $row2['avgVolumn'];
                    $counts ++;
                }
            }else{
                $row_array['avgVolumn'] = '0';
            }
            array_push($return_arr, $row_array);
        }
    }
    echo  $sumOfVolumn1." || ";
    echo  $sumOfVolumn2." || ";
    echo  $sumOfVolumn3." || ";
    echo  $sumOfVolumn4." || ";
    echo  $sumOfVolumn5." || ";
    echo  $sumOfVolumn6." || ";

    $row_array1['dataSet'] = $return_arr;
    // $row_array1['sumAvgVolumn'] = $sumOfVolumn;
    array_push($return_arr2, $row_array1);
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>