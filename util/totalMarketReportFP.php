<?php
    require '../connection/database.php';
    $db = new Database();
    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];
    $conn=  $db->getConnection();
    $sql = "SELECT *
            FROM TypeOfArgi_TD 
            WHERE idTypeOfArgi != '0' ";
    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
    $rowtable = "";
    $theader = "<th rowspan='2'>รายสาขา</th>";
    $theaderRow = "";
    $checkFristRow = "N";
    $return_arr1 = array();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $totalRow1 = 0;
        $totalRow2 = 0;
        
        // $rowtable .= "<tr><td>".$row['nameTypeOfArgi']."</td>";
        $rowtable2 = '';
        if($basinId == '0'){
            $sql1= "SELECT t1.target_area_type_id, t1.areaType, COALESCE(t2.Volumn,0) as Volumn, COALESCE(t2.TotalValue,0) as TotalValue
                    FROM (SELECT a.target_area_type_id , a.areaType 
                    FROM Area a 
                    WHERE a.target_area_type_id in (3,10 ,5)
                    GROUP BY a.target_area_type_id, a.areaType) t1
                    LEFT JOIN (SELECT SUM(pmt.Volumn ) as Volumn , SUM (pmt.TotalValue ) as totalValue , a.target_area_type_id 
                    FROM Area a
                    INNER JOIN PersonMarket_TD pmt ON pmt.Area_idArea = a.idArea 
                    WHERE pmt.TypeOfArgi_idTypeOfArgi = '".$row['idTypeOfArgi']."' and pmt.YearID ='".$yearsId."'
                    GROUP BY a.target_area_type_id  ) t2 ON t1.target_area_type_id = t2.target_area_type_id
                    ORDER BY t1.target_area_type_id";
            $stmt1 = sqlsrv_query( $conn, $sql1);
            $row_array1['name'] = $row['nameTypeOfArgi'];
            $count = 0;
            while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
                $rowtable2 .= "<td style='text-align: right'>".number_format($row1['Volumn'])."</td><td style='text-align: right'>".number_format($row1['TotalValue'])."</td>";
                $totalRow1 = $totalRow1+$row1['Volumn'];
                $totalRow2 = $totalRow2+$row1['TotalValue'];

                $row_array1[$count."_V"] = $row1['Volumn'];
                $row_array1[$count."_T"] = $row1['TotalValue'];
                if($checkFristRow == 'N'){
                    $theader .= "<th colspan='2'>".$row1['areaType']."</th>";
                    $theaderRow.= "<th>ปริมาณ</th><th>มูลค่า</th>";
                }
                $count ++;
            }
            array_push($return_arr1, $row_array1);
        }else{
            $sql1= "SELECT t1.idArea, t1.target_name, COALESCE(t2.Volumn,0) as Volumn, COALESCE(t2.TotalValue,0) as TotalValue
                    FROM (SELECT a1.idArea , a1.target_name 
                    FROM Area a1
                    WHERE a1.target_area_type_id = '".$basinId."' AND a1.target_area_type_id in (3,5,10)) t1
                    LEFT JOIN (SELECT SUM(pmt.Volumn ) as Volumn , SUM (pmt.TotalValue ) as totalValue , a.idArea 
                    FROM Area a
                    INNER JOIN PersonMarket_TD pmt ON pmt.Area_idArea = a.idArea 
                    WHERE pmt.TypeOfArgi_idTypeOfArgi = '".$row['idTypeOfArgi']."' and pmt.YearID ='".$yearsId."' and a.target_area_type_id = '".$basinId."' AND a.target_area_type_id in (3,5,10)
                    GROUP BY a.idArea ) t2 ON t1.idArea = t2.idArea
                    ORDER BY t1.idArea";
            $stmt1 = sqlsrv_query( $conn, $sql1);
            $row_array1['name'] = $row['nameTypeOfArgi'];
            $count = 0;
            while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
                $rowtable2 .= "<td style='text-align: right'>".number_format($row1['Volumn'])."</td><td style='text-align: right'>".number_format($row1['TotalValue'])."</td>";
                $totalRow1 = $totalRow1+$row1['Volumn'];
                $totalRow2 = $totalRow2+$row1['TotalValue'];

                $row_array1[$count."_V"] = $row1['Volumn'];
                $row_array1[$count."_T"] = $row1['TotalValue'];
                if($checkFristRow == 'N'){
                    $theader .= "<th colspan='2'><a href='report-Target.php?area_Id=".$row1["idArea"]."&yearsId=".$yearsId."'>".$row1['target_name']."</th>";
                    $theaderRow.= "<th>ปริมาณ</th><th>มูลค่า</th>";
                }
                $count ++;
            }
            array_push($return_arr1, $row_array1);
        }
        if($checkFristRow == 'N'){
            $theader .= "<th colspan='2'>รวม</th>";
            $theaderRow.= "<th>ปริมาณ</th><th>มูลค่า</th>";
        }
        if($totalRow1 > 0 && $totalRow2 >0){
            $rowtable .= "<tr><td>".$row['nameTypeOfArgi']."</td>";
            $rowtable .= $rowtable2;
            $rowtable .= "<td style='text-align: right'>".number_format($totalRow1)."</td><td style='text-align: right'>".number_format($totalRow2)."</td>";
            $rowtable .= "</tr>";
        }
        $checkFristRow = "Y";
        
        
    }
    $row_array['thaedRow'] = "<tr>".$theader."</tr><tr>".$theaderRow."</tr>";
    $row_array['row'] = $rowtable;
    $row_array['test'] = $return_arr1;
    array_push($return_arr, $row_array);
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>