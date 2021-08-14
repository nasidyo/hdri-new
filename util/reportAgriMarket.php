<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $sql = "SELECT ta.idTypeOfArgi, ISNULL(SUM(pmt.TotalValue),0) as totalTypeArgi, ta.nameTypeOfArgi
            FROM TypeOfArgi_TD ta
            INNER JOIN PersonMarket_TD pmt ON pmt.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi
            WHERE ta.idTypeOfArgi != '0' AND pmt.YearID = '".$_POST['yearsId']."' 
            GROUP BY ta.idTypeOfArgi, ta.nameTypeOfArgi";

    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
    $labelSet = array();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $dataSet = array();
        $row_array1 = array();
        $row_array1['idTypeOfArgi'] = $row['nameTypeOfArgi'];
        $row_array1['totalTypeArgi'] = $row['totalTypeArgi'];
        $sql2 ="SELECT mt.nameMarket , ISNULL(SUM(TotalValue),0) as TotalValue , pmt.Market_idMarket 
                FROM PersonMarket_TD pmt 
                INNER JOIN Market_TD mt ON pmt.Market_idMarket = mt.idMarket 
                WHERE pmt.TypeOfArgi_idTypeOfArgi = '".$row['idTypeOfArgi']."' AND pmt.YearID = '".$_POST['yearsId']."' 
                GROUP BY pmt.Market_idMarket, mt.nameMarket 
                ORDER BY pmt.Market_idMarket";

        $stmt2 = sqlsrv_query( $conn, $sql2);
        while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
            $row_array2 = array();
            $totalVal = ((int)$row2['TotalValue']*100)/floatval($row['totalTypeArgi']);
            // $row_array2['idMarket'] = $row2['Market_idMarket'];
            $row_array1["data".$row2['Market_idMarket']] = number_format($totalVal,2);
            // array_push($dataSet, $row_array2);
        }
        $row_array1['dataSet'] = $dataSet;
        array_push($return_arr, $row_array1);
    }
    echo json_encode($return_arr);
?>