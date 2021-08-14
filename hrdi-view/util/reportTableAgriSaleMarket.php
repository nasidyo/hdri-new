<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $agriId = $_POST["agriId"];
    $sql = "SELECT idMarket , nameMarket 
	    FROM Market_TD mt";
    $return_arr = array();
    $return_arr1 = array();
    $stmt = sqlsrv_prepare($conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $data = '<tr>';
    $temp = '';
    $totalprice = 0;
    $totalVolumn = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        if($temp == ''){
            $data .= "<td>".$row['nameMarket']."</td>";
        }else{
            $data .= "</tr><tr><td>".$row['nameMarket']."</td>";
        }
        $temp = $row['nameMarket'];
        $sql1 = "SELECT COALESCE(SUM(pmt.TotalValue ),0) as totalprice ,COALESCE( SUM(pmt.Volumn ),0) as totalVolumn
                FROM PersonMarket_TD pmt 
                LEFT JOIN Market_TD mt ON mt.idMarket = pmt.Market_idMarket 
                WHERE pmt.Agri_idAgri = '".$agriId."' and pmt.YearID = '".$yearsId."' and pmt.Market_idMarket = '".$row['idMarket']."'";
        $stmt1 = sqlsrv_query( $conn, $sql1);
        while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            $totalprice = $totalprice+$row1['totalprice'];
            $totalVolumn = $totalVolumn+$row1['totalVolumn'];
            $data .= "<td>".number_format($row1['totalVolumn'])."</td><td>".number_format($row1['totalprice'])."</td>";
            $row_array['nameMarket'] = $row['nameMarket'];
            $row_array['totalVolumn'] = $row1['totalVolumn'];
            $row_array['totalprice'] = $row1['totalprice'];
            array_push($return_arr1, $row_array);
        }
    }
    $data .= "</tr><tr><td>รวม</td><td>".number_format($totalVolumn)."</td><td>".number_format($totalprice)."</td></tr>";
    $row_array1['dataTable'] = $data;
    $row_array1['dataset'] = $return_arr1;
    array_push($return_arr, $row_array1);
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>