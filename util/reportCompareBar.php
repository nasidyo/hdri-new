<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $yearsPassId = $yearsId-1;
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
        // $row1 .='<td>'.number_format($row['totalVolumn'],2).'</td>';
        // $row2 .='<td>'.number_format($row['TotalValue'],2).'</td>';
        $row1 .='<td>'.number_format($row['totalVolumn']).'</td>';
        $row2 .='<td>'.number_format($row['TotalValue']).'</td>';
        $row_array['nameMarket'] = $row['nameMarket'];
        $row_array['TotalValue'] = $row['TotalValue'];
        $row_array['totalVolumn'] = $row['totalVolumn'];
        $sql2 = "SELECT pmt.Market_idMarket , SUM(pmt.TotalValue) as TotalValuePass
            FROM PersonMarket_TD pmt 
            WHERE pmt.YearID = '".$yearsPassId."' AND pmt.Market_idMarket = '".$row['idMarket']."'
            GROUP BY pmt.Market_idMarket
        ";
        $stmt1 = sqlsrv_query( $conn, $sql2);
        while( $rowPass = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            $row_array['TotalValuePass'] = $rowPass['TotalValuePass'];
        }
        array_push($return_arr1, $row_array);
    }
    $row_array1['header'] = $header;
    $row_array1['row1'] = $row1;
    $row_array1['row2'] = $row2;
    $row_array1['data'] = $return_arr1;
    array_push($return_arr, $row_array1);
    echo json_encode($return_arr);
?>