<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    if($_POST["years_Id"]){
      $_POST["years_Id"];
    }
    if($_POST["typeOfAgri_Id"]){
      $_POST["typeOfAgri_Id"];
    }
    if($_POST["agri_Id"]){
      $_POST["agri_Id"];
    }
    if($_POST["month_id"]){
      $_POST["month_id"];
    }
    if($_POST["market_id"]){
      $_POST["market_id"];
    }
    if($_POST["area_Id"]){
      $_POST["area_Id"];
    }
    $sql = " 
        SELECT toa.idTypeOfArgi ,toa.nameTypeOfArgi
        FROM OutputValue_TD opv
        INNER JOIN Agri_TD ag ON opv.Agri_idAgri = ag.idAgri
        LEFT JOIN TypeOfArgi_TD toa ON ag.TypeOfArgi_idTypeOfArgi = toa.idTypeOfArgi
        LEFT JOIN Market_TD mk ON opv.Market_idMarket = mk.idMarket
        WHERE
        opv.Area_id = '".$_POST["area_Id"]."' and opv.Year_id = '".$_POST["years_Id"]."' ";
      if($_POST["typeOfAgri_Id"]){
        $sql.="and toa.idTypeOfArgi = '".$_POST["typeOfAgri_Id"]."' ";
      }
      if($_POST["agri_Id"]){
          $sql.="and ag.idAgri = '".$_POST["agri_Id"]."' ";
      }
      if($_POST["month_id"]){
          $sql.="and opv.MonthNo = '".$_POST["month_id"]."' ";
      }
      if($_POST["market_id"]){
          $sql.="and mk.idMarket = '".$_POST["market_id"]."' ";
      }
    $sql.="GROUP BY idTypeOfArgi, nameTypeOfArgi";
    $stmt = sqlsrv_query( $conn, $sql);
    if( !$stmt ) {
      die( print_r( sqlsrv_errors(), true));
    }
    $rows = sqlsrv_has_rows($stmt);
    $data='';
    $totalPrice = 0;
    $totalWeight = 0;
    $totalPrice2 = 0;
    $totalWeight2 = 0;
    if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $data .= "<tr> <td colspan='6'>".$row["nameTypeOfArgi"]."</td> </tr>";
            $sql2 = "
                SELECT opv.Year_id, opv.Agri_idAgri, 
                CASE 
                WHEN ag.speciesArgi = '' THEN ag.nameArgi
                WHEN ag.speciesArgi IS NULL THEN ag.nameArgi  
                ELSE ag.nameArgi+'(พันธุ์:'+ag.speciesArgi+')' END as nameOFArgi, SUM(opv.Weight) weight,
                SUM(opv.Total) as total, mk.nameMarket , SUM(tpmk.weight2) as weight2, SUM(tpmk.total2) as total2
                FROM OutputValue_TD opv
                INNER JOIN Agri_TD ag ON opv.Agri_idAgri = ag.idAgri
                INNER JOIN Market_TD mk ON opv.Market_idMarket = mk.idMarket
                INNER JOIN (SELECT tp.idTargetPlan, SUM(tp.Weight) as weight2, SUM(tp.Total) as total2, cm.Market_idMarket ,tp.Agri_idAgri, tp.month_id, tp.YearTarget_YearID, tp.Area_idArea 
                FROM TargetPlan_TD tp
                LEFT JOIN CustomerMarket_TD cm ON tp.market_id = cm.idCustomerMarket
                GROUP BY tp.Price, tp.month_id, cm.Market_idMarket, tp.Agri_idAgri, tp.month_id, tp.YearTarget_YearID, tp.Area_idArea, idTargetPlan) tpmk ON 
                opv.MonthNo = tpmk.month_id and opv.Agri_idAgri = tpmk.Agri_idAgri and opv.Year_id = tpmk.YearTarget_YearID and opv.Area_id = tpmk.Area_idArea and opv.Market_idMarket = tpmk.Market_idMarket 
                WHERE
                opv.Area_id = '".$_POST["area_Id"]."' and opv.Year_id = '".$_POST["years_Id"]."' and ag.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."' and opv.TargetPlan_idTargetPlan = tpmk.idTargetPlan ";
            if($_POST["agri_Id"] != '0'){
                $sql2.="and ag.idAgri = '".$_POST["agri_Id"]."' ";
            }
            if($_POST["month_id"] != '0'){
                $sql2.="and opv.MonthNo = '".$_POST["month_id"]."' ";
            }
            if($_POST["market_id"] != '0'){
                $sql2.="and mk.idMarket = '".$_POST["market_id"]."' ";
            }
            $sql2.="GROUP BY nameArgi, speciesArgi, nameMarket, Year_id, opv.Agri_idAgri ";
            $sql2.="ORDER BY nameArgi";
            $stmt2 = sqlsrv_query( $conn, $sql2);
            if( !$stmt2 ) {
              die( print_r( sqlsrv_errors(), true));
            }
            $rows2 = sqlsrv_has_rows($stmt2);
            $temp ='';
            $tempName = '';
            $totalWeightTemp = 0;
            $totalPriceTemp = 0;
            $totalWeightTemp2 = 0;
            $totalPriceTemp2 = 0;
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
              if($row["idTypeOfArgi"] != $temp){
                  if($temp != ''){
                      $data .= "<tr tr style='background: beige;'> <td></td>";
                      $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td class='textorangen'>".number_format($totalWeightTemp2,2)."</td> <td class='textorangen'>".number_format($totalPriceTemp2,2)."</td> <td class='textblue'>".number_format($totalWeightTemp,2)."</td> <td class='textblue'>".number_format($totalPriceTemp,2)."</td> </tr>";
                      $data .= "<tr> <td></td>";
                      $totalWeightTemp = 0;
                      $totalPriceTemp = 0;
                      $totalWeightTemp2 = 0;
                      $totalPriceTemp2 = 0;
                  }else{
                    $data .= "<tr> <td></td>";
                  }
                      $temp = $row["idTypeOfArgi"];
                      $tempName = $row["nameTypeOfArgi"];
                      // $data .= "<tr> <td></td>";
                      $data .="<td>".$row2["nameOFArgi"]."</td>";
                      $data .="<td>".$row2["nameMarket"]."</td>";
                      $data .="<td class='textorangen'>".number_format($row2["weight2"],2)."</td>";
                      $data .="<td class='textorangen'>".number_format($row2["total2"],2)."</td>";
                      $data .="<td class='textblue'>".number_format($row2["weight"],2)."</td>";
                      $data .="<td class='textblue'>".number_format($row2["total"],2)."</td>";
                      $totalWeightTemp = $totalWeightTemp+$row2["weight"];
                      $totalPriceTemp = $totalPriceTemp+$row2["total"];
                      $totalWeightTemp2 = $totalWeightTemp2+$row2["weight2"];
                      $totalPriceTemp2 = $totalPriceTemp2+$row2["total2"];
                      $totalWeight = $totalWeight+$row2["weight"];
                      $totalPrice = $totalPrice+$row2["total"];
                      $totalWeight2 = $totalWeight2+$row2["weight2"];
                      $totalPrice2 = $totalPrice2+$row2["total2"];
                      $data .="</tr>";
              }else{
                  $data .= "<tr> <td></td>";
                  // $data .="<td></td>";
                  $data .="<td>".$row2["nameOFArgi"]."</td>";
                  $data .="<td>".$row2["nameMarket"]."</td>";
                  $data .="<td class='textorangen'>".number_format($row2["weight2"],2)."</td>";
                  $data .="<td class='textorangen'>".number_format($row2["total2"],2)."</td>";

                  $data .="<td class='textblue'>".number_format($row2["weight"],2)."</td>";
                  $data .="<td class='textblue'>".number_format($row2["total"],2)."</td>";

                  $data .="</tr>";
                  $totalWeightTemp = $totalWeightTemp+$row2["weight"];
                  $totalPriceTemp = $totalPriceTemp+$row2["total"];
                  $totalWeight = $totalWeight+$row2["weight"];
                  $totalPrice = $totalPrice+$row2["total"];
                  $totalWeightTemp2 = $totalWeightTemp2+$row2["weight2"];
                  $totalPriceTemp2 = $totalPriceTemp2+$row2["total2"];
                  $totalWeight2 = $totalWeight2+$row2["weight2"];
                  $totalPrice2 = $totalPrice2+$row2["total2"];
                  $data .="</tr>";
              }
          }
          $data .= "<tr tr style='background: beige;'> <td></td>";
          $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td class='textorangen'>".number_format($totalWeightTemp2,2)."</td> <td class='textorangen'>".number_format($totalPriceTemp2,2)."</td> <td class='textblue'>".number_format($totalWeightTemp,2)."</td> <td class='textblue'>".number_format($totalPriceTemp,2)."</td> </tr>";
          $totalWeightTemp = 0;
          $totalPriceTemp = 0;
          $totalWeightTemp2 = 0;
          $totalPriceTemp2 = 0;
      }
      if($totalWeight != 0 && $totalPrice != 0 ){
          $data.= "<tr style='background: bisque;'> <td colspan='3'> รวมทั้งหมด </td> <td class='textorangen'>".number_format($totalWeight2,2)."</td> <td class='textorangen'>".number_format($totalPrice2,2)." บาท</td> <td class='textblue'>".number_format($totalWeight,2)."</td> <td class='textblue'>".number_format($totalPrice,2)." บาท</td></tr>";
      }
      echo $data;
  }else{
      $data="<tr style='background: bisque;'><td colspan ='7'><center>ยังไม่มีรายการเป้าหมายผลผลิต</center></td></tr>";
      echo $data;
  }
?>