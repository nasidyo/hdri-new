<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    if($_POST["summaryMonth_id"]){
        echo $_POST["summaryMonth_id"];
    }
    if($_POST["summaryTypeOfAgri_Id"]){
      echo $_POST["summaryTypeOfAgri_Id"];
    }
    if($_POST["summaryAgri_Id"]){
      echo $_POST["summaryAgri_Id"];
    }
    $sql = "
        SELECT ta.idTypeOfArgi, ta.nameTypeOfArgi
        FROM TargetPlan_TD tgp
        INNER JOIN TypeOfArgi_TD ta ON tgp.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi
        WHERE tgp.YearTarget_YearID = '".$_POST["years_Id"]."' and tgp.Area_idArea = '".$_POST["area_Id"]."'";
    if($_POST["summaryMonth_id"]){
      $sql.=" and tgp.month_id = '".$_POST["summaryMonth_id"]."'";
    }
    if($_POST["summaryTypeOfAgri_Id"]){
        $sql.=" and tgp.TypeOfArgi_idTypeOfArgi = '".$_POST["summaryTypeOfAgri_Id"]."'";
    }
    $sql.="GROUP BY idTypeOfArgi, nameTypeOfArgi";
    $stmt = sqlsrv_query( $conn, $sql );
    if( !$stmt ) {
      die( print_r( sqlsrv_errors(), true));
    }
    $data='';
    $totalPrice = 0;
    $totalWeight = 0;
    $rows = sqlsrv_has_rows($stmt);
    if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $data .= "<tr> <td colspan='6'>".$row["nameTypeOfArgi"]."</td> </tr>";
          $sql2 = "
            SELECT tgp.Agri_idAgri, 
            CASE
            WHEN ag.speciesArgi = '' THEN ag.nameArgi
            WHEN ag.speciesArgi IS NULL THEN ag.nameArgi  
            ELSE ag.nameArgi+'(พันธุ์:'+ag.speciesArgi+')' END as nameOFArgi, mk.idMarket, mk.nameMarket, SUM(Weight) as totalWeight , SUM(Total) totalSummanry
            FROM TargetPlan_TD tgp
            INNER JOIN CustomerMarket_TD cmk ON tgp.market_id = cmk.idCustomerMarket
            INNER JOIN Market_TD mk ON cmk.Market_idMarket = mk.idMarket
            INNER JOIN Agri_TD ag ON tgp.Agri_idAgri = ag.idAgri
            WHERE tgp.YearTarget_YearID = '".$_POST["years_Id"]."' and tgp.Area_idArea = '".$_POST["area_Id"]."' and tgp.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."'";
            if($_POST["summaryMonth_id"]){
                $sql2.=" and tgp.month_id = '".$_POST["summaryMonth_id"]."'";
            }
            if($_POST["summaryAgri_Id"]){
                $sql2.=" and tgp.Agri_idAgri = '".$_POST["summaryAgri_Id"]."'";
            }
            $sql2.=" GROUP BY Agri_idAgri, nameArgi, idMarket, nameMarket, speciesArgi
            ORDER BY idMarket";
            $stmt2 = sqlsrv_query( $conn, $sql2 );
            if( !$stmt2 ) {
              die( print_r( sqlsrv_errors(), true));
            }
            $stmt2 = sqlsrv_query( $conn, $sql2 );

            $temp ='';
            $tempName = '';
            $totalWeightTemp = 0;
            $totalPriceTemp = 0;
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                if($row["idTypeOfArgi"] != $temp){
                    if($temp != ''){
                        $data .= "<tr tr style='background: beige;'> <td></td>";
                        $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td>".number_format($totalWeightTemp,2)." หน่วย</td> <td colspan='2'>".number_format($totalPriceTemp,2)." บาท</td> </tr>";
                        $totalWeightTemp = 0;
                        $totalPriceTemp = 0;
                    }
                    $temp = $row["idTypeOfArgi"];
                    $tempName = $row["nameTypeOfArgi"];
                    $data .= "<tr id='".$row2["Agri_idAgri"].", ".$row2["idMarket"]."'> <td></td>";
                    $data .="<td>".$row2["nameOFArgi"]."</td>";
                    $data .="<td>".$row2["nameMarket"]."</td>";
                    $data .="<td>".number_format($row2["totalWeight"],2)." หน่วย</td>";
                    $data .="<td>".number_format($row2["totalSummanry"],2)." บาท</td>";
                    $data .="<td><button type='button' class='btn btn-primary radiusBtn' onclick='return a1_onclick(".$row2["Agri_idAgri"].", ".$row2["idMarket"].")' id='showPopUpEdit' name='showPopUpEdit' ><i class='fa fa-search'></i></button></td>";
                    $totalWeightTemp = $totalWeightTemp+$row2["totalWeight"];
                    $totalPriceTemp = $totalPriceTemp+$row2["totalSummanry"];
                    $totalWeight = $totalWeight+$row2["totalWeight"];
                    $totalPrice = $totalPrice+$row2["totalSummanry"];
                    $data .="</tr>";
                }else{
                    $data .= "<tr id='".$row2["Agri_idAgri"].", ".$row2["idMarket"]."'> <td></td>";
                    // $data .="<td></td>";
                    $data .="<td>".$row2["nameOFArgi"]."</td>";
                    $data .="<td>".$row2["nameMarket"]."</td>";
                    $data .="<td>".number_format($row2["totalWeight"],2)." หน่วย</td>";
                    $data .="<td>".number_format($row2["totalSummanry"],2)." บาท</td>";
                    $data .="<td><button type='button' class='btn btn-primary radiusBtn' onclick='return a1_onclick(".$row2["Agri_idAgri"].", ".$row2["idMarket"].")' id='showPopUpEdit' name='showPopUpEdit' ><i class='fa fa-search'></i></button></td>";
                    $data .="</tr>";
                    $totalWeightTemp = $totalWeightTemp+$row2["totalWeight"];
                    $totalPriceTemp = $totalPriceTemp+$row2["totalSummanry"];
                    $totalWeight = $totalWeight+$row2["totalWeight"];
                    $totalPrice = $totalPrice+$row2["totalSummanry"];
                    $data .="</tr>";
                }
              }
              $data .= "<tr tr style='background: beige;'> <td></td>";  // if uncomment top this commnet
            $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td>".number_format($totalWeightTemp,2)." หน่วย</td> <td colspan='2'>".number_format($totalPriceTemp,2)." บาท</td> </tr>";
            $totalWeightTemp = 0;
            $totalPriceTemp = 0;
        }
        if($totalWeight != 0 && $totalPrice != 0){
            $data.= "<tr style='background: bisque;'> <td colspan='3'> รวมทั้งหมด </td> <td>".number_format($totalWeight,2)." หน่วย</td> <td colspan='2'>".number_format($totalPrice,2)." บาท </td> </tr>";
        }
        echo $data;
    }else{
        $data="<tr style='background: bisque;'><td colspan ='5'><center>ยังไม่มีรายการเป้าหมายผลผลิต</center></td></tr>";
        echo $data;
    }
?>