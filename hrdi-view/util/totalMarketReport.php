<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "SELECT *
            FROM TypeOfArgi_TD 
            WHERE idTypeOfArgi != '0' ";
    $stmt = sqlsrv_query( $conn, $sql);
    $data = '';
    $rowchack = '';
    $totalVolum1 = 0;
    $totalVolum2 = 0;
    $totalVolum3 = 0;
    $totalVolum4 = 0;
    $totalVolum5 = 0;
    $totalVolum6 = 0;
    $totalVolum7 = 0;

    $totalValue1 = 0;
    $totalValue2 = 0;
    $totalValue3 = 0;
    $totalValue4 = 0;
    $totalValue5 = 0;
    $totalValue6 = 0;
    $totalValue7 = 0;
    $rowchack = '';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $total1 = 0;
        $total2 = 0;
        // if($rowchack = ''){
            $data .= "<tr> <td>".$row["nameTypeOfArgi"]."</td>";
        // }
        $sql2 = "SELECT ISNULL(t1.TotalValue,0) as tv1, ISNULL(t1.Volumn,0) as v1, ISNULL(t2.TotalValue,0) as tv2, ISNULL(t2.Volumn,0) as v2, ISNULL(t3.TotalValue,0) as tv3, ISNULL(t3.Volumn,0) as v3, 
        ISNULL(t4.TotalValue,0) as tv4, ISNULL(t4.Volumn,0) as v4, ISNULL(t5.TotalValue,0) as tv5, ISNULL(t5.Volumn,0) as v5, ISNULL(t6.TotalValue,0) as tv6, ISNULL(t6.Volumn,0) as v6
        from 
        (select sum(pmt.TotalValue)as TotalValue, sum(pmt.Volumn) as Volumn 
            from PersonMarket_TD pmt WHERE pmt.Market_idMarket = '2' and pmt.YearID = '".$_POST["yearsId"]."' and pmt.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."') t1,
        (select  sum(pmt.TotalValue)as TotalValue, sum(pmt.Volumn) as Volumn 
            from PersonMarket_TD pmt WHERE pmt.Market_idMarket = '3' and pmt.YearID ='".$_POST["yearsId"]."' and pmt.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."') t2,
            (select sum(pmt.TotalValue)as TotalValue, sum(pmt.Volumn) as Volumn 
            from PersonMarket_TD pmt WHERE pmt.Market_idMarket = '4' and pmt.YearID = '".$_POST["yearsId"]."' and pmt.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."') t3,
            (select  sum(pmt.TotalValue)as TotalValue, sum(pmt.Volumn) as Volumn 
            from PersonMarket_TD pmt WHERE pmt.Market_idMarket = '6' and pmt.YearID = '".$_POST["yearsId"]."' and pmt.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."') t4,
            (select  sum(pmt.TotalValue)as TotalValue, sum(pmt.Volumn) as Volumn 
            from PersonMarket_TD pmt WHERE pmt.Market_idMarket = '7' and pmt.YearID = '".$_POST["yearsId"]."' and pmt.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."') t5,
            (select sum(pmt.TotalValue)as TotalValue, sum(pmt.Volumn) as Volumn 
            from PersonMarket_TD pmt WHERE pmt.Market_idMarket = '5' and pmt.YearID = '".$_POST["yearsId"]."' and pmt.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."') t6
        ";
        $stmt2 = sqlsrv_query( $conn, $sql2);
        while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
            $totalVolum1 = $totalVolum1+$row2["v1"];
            $totalValue1 = $totalValue1+$row2["tv1"];

            $totalVolum2 = $totalVolum2+$row2["v2"];
            $totalValue2 = $totalValue2+$row2["tv2"];

            $totalVolum3 = $totalVolum3+$row2["v3"];
            $totalValue3 = $totalValue3+$row2["tv3"];

            $totalVolum4 = $totalVolum4+$row2["v4"];
            $totalValue4 = $totalValue4+$row2["tv4"];

            $totalVolum5 = $totalVolum5+$row2["v5"];
            $totalValue5 = $totalValue5+$row2["tv5"];

            $totalVolum6 = $totalVolum6+$row2["v6"];
            $totalValue6 = $totalValue6+$row2["tv6"];

            $total1 = $row2["v1"]+$row2["v2"]+$row2["v3"]+$row2["v4"]+$row2["v5"]+$row2["v6"];
            $total2 = $row2["tv1"]+$row2["tv2"]+$row2["tv3"]+$row2["tv4"]+$row2["tv5"]+$row2["tv6"];

            $totalVolum7 = $totalVolum7+$total1;
            $totalValue7 = $totalValue7+$total2;

            // echo $row2;
            $data .="<td style='text-align: right'>".number_format($row2["v1"],2)."</td><td style='text-align: right'>".number_format($row2["tv1"],2)."</td><td style='text-align: right'>".number_format($row2["v2"],2)."</td><td style='text-align: right'>".number_format($row2["tv2"],2)."</td>";
            $data .="<td style='text-align: right'>".number_format($row2["v3"],2)."</td><td style='text-align: right'>".number_format($row2["tv3"],2)."</td><td style='text-align: right'>".number_format($row2["v4"],2)."</td><td style='text-align: right'>".number_format($row2["tv4"],2)."</td>";
            $data .="<td style='text-align: right'>".number_format($row2["v5"],2)."</td><td style='text-align: right'>".number_format($row2["tv5"],2)."</td><td style='text-align: right'>".number_format($row2["v6"],2)."</td><td style='text-align: right'>".number_format($row2["tv6"],2)."</td>";
            $data .="<td style='text-align: right'>".number_format($total1,2)."</td><td style='text-align: right'>".number_format($total2,2)."</td>";
        }
        $data .="</tr>";
    }
    $data .="<tr style='background-color: moccasin;'><td>รวม</td><td style='text-align: right'>".number_format($totalVolum1,2)."</td><td style='text-align: right'>".number_format($totalValue1,2)."</td><td style='text-align: right'>".number_format($totalVolum2,2)."</td><td style='text-align: right'>".number_format($totalValue2,2)."</td><td style='text-align: right'>".number_format($totalVolum3,2)."</td><td style='text-align: right'>".number_format($totalValue3,2)."</td>
        <td style='text-align: right'>".number_format($totalVolum4,2)."</td><td style='text-align: right'>".number_format($totalValue4,2)."</td><td style='text-align: right'>".number_format($totalVolum5,2)."</td><td style='text-align: right'>".number_format($totalValue5,2)."</td><td style='text-align: right'>".number_format($totalVolum6,2)."</td><td style='text-align: right'>".number_format($totalValue6,2)."</td>
        <td style='text-align: right'>".number_format($totalVolum7,2)."</td><td style='text-align: right'>".number_format($totalValue7,2)."</td></tr>";
    echo $data;
?>