<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $sql = "SELECT mt.idMarket, mt.nameMarket , SUM(pmt.TotalValue) as TotalValue , SUM (pmt.Volumn) as totalVolumn
        FROM PersonMarket_TD pmt 
        INNER JOIN Market_TD mt ON mt.idMarket = pmt.Market_idMarket
        WHERE pmt.YearID = '".$yearsId."'
        GROUP BY mt.nameMarket, mt.idMarket
        ";
    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
    $return_arr1 = array();
    $data = '';
    $header = '';
    $row1 ='';
    $row2 = '';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $header .="<th>".$row['nameMarket']."</th>";
        $row1 .='<td>'.number_format($row['totalVolumn']).'</td>';
        $row2 .='<td>'.number_format($row['TotalValue']).'</td>';
        $row_array['nameMarket'] = $row['nameMarket'];
        $row_array['TotalValue'] = $row['TotalValue'];
        array_push($return_arr1, $row_array);
    }
    $row_array1['header'] = $header;
    $row_array1['row1'] = $row1;
    $row_array1['row2'] = $row2;
    $row_array1['data'] = $return_arr1;
    array_push($return_arr, $row_array1);
    echo json_encode($return_arr);
?>