
<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    if($_POST["summaryMonth_id"]){
        echo $_POST["summaryMonth_id"];
    }
    $sql2 = "
    SELECT ISNULL(NULLIF(ag.nameArgi+'(พันธุ์ :'+ ag.speciesArgi+')', ''), ag.nameArgi) as nameOFArgi, toag.idTypeOfArgi, toag.nameTypeOfArgi, SUM(psmk.Volumn) as totalWeight , SUM(psmk.TotalValue) totalSummanry
    FROM PersonMarket_TD psmk
    INNER JOIN Agri_TD ag ON psmk.Agri_idAgri = ag.idAgri
    INNER JOIN TypeOfArgi_TD toag ON psmk.TypeOfArgi_idTypeOfArgi = toag.idTypeOfArgi
    WHERE psmk.YearID = '".$_POST["years_Id"]."' and psmk.Area_idArea = '".$_POST["area_Id"]."' and psmk.Person_idPerson = '".$_POST["person_id"]."'";
    if($_POST["summaryMonth_id"]){
      $sql2.=" and psmk.MonthNo = '".$_POST["summaryMonth_id"]."'";
    }
    $sql2.=" GROUP BY nameTypeOfArgi, idTypeOfArgi, speciesArgi, nameArgi
    ORDER BY idTypeOfArgi";
    $stmt2 = sqlsrv_query( $conn, $sql2 );
    if( !$stmt2 ) {
      die( print_r( sqlsrv_errors(), true));
    }
    $data='';
    $totalPrice = 0;
    $totalWeight = 0;
    $temp ='';
    $tempName = '';
    $totalWeightTemp = 0;
    $totalPriceTemp = 0;
    $rows = sqlsrv_has_rows($stmt2);
    if ($rows === true){
      while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
          if($row2["idTypeOfArgi"] != $temp){
              if($temp != ''){
                  $data .= "<tr tr style='background: beige;'>";
                  $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td>".number_format($totalWeightTemp,2)." </td> <td>".number_format($totalPriceTemp,2)." บาท</td> </tr>";
                  $data .= "<tr>";
                  $totalWeightTemp = 0;
                  $totalPriceTemp = 0;
              }else{
                $data .= "<tr> ";
              }
              $data .="<td>".$row2["nameTypeOfArgi"]."</td>";
              $temp = $row2["idTypeOfArgi"];
              $tempName = $row2["nameTypeOfArgi"];
              $totalWeightTemp = $totalWeightTemp+$row2["totalWeight"];
              $totalPriceTemp = $totalPriceTemp+$row2["totalSummanry"];
              $totalWeight = $totalWeight+$row2["totalWeight"];
              $totalPrice = $totalPrice+$row2["totalSummanry"];
              $data .="<td>".$row2["nameOFArgi"]."</td>";
              $data .="<td>".number_format($row2["totalWeight"],2)."  </td>";
              $data .="<td>".number_format($row2["totalSummanry"],2)." บาท</td>";
              $data .="</tr>";
          }else{
              $data .= "<tr>";
              $data .="<td></td>";
              $data .="<td>".$row2["nameOFArgi"]."</td>";
              $data .="<td>".number_format($row2["totalWeight"],2)."</td>";
              $data .="<td>".number_format($row2["totalSummanry"],2)." บาท</td>";
              $data .="</tr>";
              $totalWeightTemp = $totalWeightTemp+$row2["totalWeight"];
              $totalPriceTemp = $totalWeightTemp+$row2["totalSummanry"];
              $totalWeight = $totalWeight+$row2["totalWeight"];
              $totalPrice = $totalPrice+$row2["totalSummanry"];
          }
      }
      $data .= "<tr tr style='background: beige;'>";
      $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td>".number_format($totalWeightTemp,2)."  </td> <td>".number_format($totalPriceTemp,2)." บาท</td> </tr>";
      $totalWeightTemp = 0;
      $totalPriceTemp = 0;

      if($totalWeight != 0 && $totalPrice != 0){
          $data.= "<tr style='background: bisque;'> <td colspan='2'> รวมทั้งหมด </td> <td>".number_format($totalWeight,2)."  </td> <td>".number_format($totalPrice,2)." บาท </td> </tr>";
      }
        echo $data;
    }else{
        $data="<tr style='background: bisque;'><td colspan ='4'><center>ยังไม่มีการส่งมอบผลผลิต</center></td></tr>";
        echo $data;
    }
?>