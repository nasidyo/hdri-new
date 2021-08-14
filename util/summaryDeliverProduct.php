<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "
        SELECT ta.idTypeOfArgi, ta.nameTypeOfArgi
        FROM PersonMarket_TD permk
        INNER JOIN TypeOfArgi_TD ta ON permk.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi
        INNER JOIN Market_TD mk ON permk.Market_idMarket = mk.idMarket
        LEFT JOIN Customer_TD cus ON permk.Customer_idCustomer = cus.idCustomer
        LEFT JOIN CustomerMarket_TD cusmk ON cus.idCustomer = cusmk.Customer_idCustomer and mk.idMarket = cusmk.Market_idMarket and permk.Area_idArea = cusmk.Area_idArea
        WHERE permk.YearID = '".$_POST["years_Id"]."' and permk.Area_idArea = '".$_POST["area_Id"]."'
        and permk.MonthNo = '".$_POST["monthId"]."'";
    if($_POST["typeOfAgri_id"] != 0 and $_POST["typeOfAgri_id"] !=''){
      $sql.="and permk.TypeOfArgi_idTypeOfArgi = '".$_POST["typeOfAgri_id"]."'";
    }
    if($_POST["agri"] != 0 and $_POST["agri"] !=''){
      $sql.="and permk.Agri_idAgri = '".$_POST["agri"]."'";
    }
    if($_POST["farmer_Id"] != 0 and $_POST["farmer_Id"] !=''){
      $sql.="and permk.Person_idPerson = '".$_POST["farmer_Id"]."'";
    }
    if($_POST["market_id"] != 0 and $_POST["market_id"] !=''){
      $sql.="and cusmk.idCustomerMarket  = '".$_POST["market_id"]."'";
    }
    if($_POST["gardProduct"] != 0 and $_POST["gardProduct"] !=''){
      $sql.="and permk.Grade_codeGrade = '".$_POST["gardProduct"]."'";
    }
    $sql.="GROUP BY ta.idTypeOfArgi, ta.nameTypeOfArgi";
    echo $sql;
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
            SELECT permk.Agri_idAgri, 
            CASE 
            WHEN ag.speciesArgi = '' THEN ag.nameArgi
            WHEN ag.speciesArgi IS NULL THEN ag.nameArgi  
            ELSE ag.nameArgi+'(พันธุ์:'+ag.speciesArgi+')' END as nameOFArgi, mk.nameMarket, toag.nameTypeOfArgi, SUM(Volumn) as totalWeight , SUM(TotalValue) totalSummanry, mk.idMarket
            FROM PersonMarket_TD permk
            INNER JOIN Market_TD mk ON permk.Market_idMarket = mk.idMarket
            LEFT JOIN Customer_TD cus ON permk.Customer_idCustomer = cus.idCustomer
            LEFT JOIN CustomerMarket_TD cusmk ON cus.idCustomer = cusmk.Customer_idCustomer and mk.idMarket = cusmk.Market_idMarket and permk.Area_idArea = cusmk.Area_idArea
            INNER JOIN Agri_TD ag ON permk.Agri_idAgri = ag.idAgri
            INNER JOIN TypeOfArgi_TD toag ON permk.TypeOfArgi_idTypeOfArgi = toag.idTypeOfArgi
            WHERE permk.YearID = '".$_POST["years_Id"]."' and permk.Area_idArea = '".$_POST["area_Id"]."' and permk.TypeOfArgi_idTypeOfArgi = '".$row["idTypeOfArgi"]."'
            and permk.MonthNo = '".$_POST["monthId"]."'";
            if($_POST["typeOfAgri_id"] != 0 and $_POST["typeOfAgri_id"] !=''){
              $sql2.="and permk.TypeOfArgi_idTypeOfArgi = '".$_POST["typeOfAgri_id"]."'";
            }
            if($_POST["agri"] != 0 and $_POST["agri"] !=''){
              $sql2.="and permk.Agri_idAgri = '".$_POST["agri"]."'";
            }
            if($_POST["farmer_Id"] != 0 and $_POST["farmer_Id"] !=''){
              $sql2.="and permk.Person_idPerson = '".$_POST["farmer_Id"]."'";
            }
            if($_POST["market_id"] != 0 and $_POST["market_id"] !=''){
              $sql2.="and cusmk.idCustomerMarket = '".$_POST["market_id"]."'";
            }
            if($_POST["gardProduct"] != 0 and $_POST["gardProduct"] !=''){
              $sql2.="and permk.Grade_codeGrade = '".$_POST["gardProduct"]."'";
            }
            $sql2.=" GROUP BY Agri_idAgri, nameTypeOfArgi, idTypeOfArgi,nameMarket, speciesArgi, nameArgi, idMarket
            ORDER BY idTypeOfArgi";
            echo $sql2;
            $stmt2 = sqlsrv_query( $conn, $sql2 );
            if( !$stmt2 ) {
              die( print_r( sqlsrv_errors(), true));
            }
            $temp ='';
            $tempName = '';
            $totalWeightTemp = 0;
            $totalPriceTemp = 0;
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                if($row["idTypeOfArgi"] != $temp){
                    if($temp != ''){
                        $data .= "<tr tr style='background: beige;'> <td></td>";
                        $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td>".number_format($totalWeightTemp,2)."</td> <td>".number_format($totalPriceTemp,2)."</td> </tr>";
                        $data .= "<tr> <td></td>";
                        $totalWeightTemp = 0;
                        $totalPriceTemp = 0;
                    // }else{
                    //   $data .= "<tr> <td></td>";
                    }
                    $data .= "<tr> <td></td>";  // if uncomment top this commnet
                    $data .="<td>".$row2["nameOFArgi"]."</td>";
                    $temp = $row["idTypeOfArgi"];
                    $tempName = $row["nameTypeOfArgi"];
                    $totalWeightTemp = $totalWeightTemp+$row2["totalWeight"];
                    $totalPriceTemp = $totalPriceTemp+$row2["totalSummanry"];
                    $totalWeight = $totalWeight+$row2["totalWeight"];
                    $totalPrice = $totalPrice+$row2["totalSummanry"];
                    $data .="<td>".$row2["nameMarket"]."</td>";
                    $data .="<td>".number_format($row2["totalWeight"],2)."</td>";
                    $data .="<td>".number_format($row2["totalSummanry"],2)."</td>";
                    $data .="<td><button type='button' class='btn btn-primary radiusBtn' onclick='return a1_onclick(".$row2["Agri_idAgri"].", ".$row2["idMarket"].")' id='showPopUpEdit' name='showPopUpEdit' ><i class='fa fa-search'></i></button></td>";
                    $data .="</tr>";
                }else{
                    $data .= "<tr> <td></td>";
                    // $data .="<td></td>";
                    $data .="<td>".$row2["nameOFArgi"]."</td>";
                    $data .="<td>".$row2["nameMarket"]."</td>";
                    $data .="<td>".number_format($row2["totalWeight"],2)."</td>";
                    $data .="<td>".number_format($row2["totalSummanry"],2)."</td>";
                    $data .="<td><button type='button' class='btn btn-primary radiusBtn' onclick='return a1_onclick(".$row2["Agri_idAgri"].", ".$row2["idMarket"].")' id='showPopUpEdit' name='showPopUpEdit' ><i class='fa fa-search'></i></button></td>";
                    $data .="</tr>";
                    $totalWeightTemp = $totalWeightTemp+$row2["totalWeight"];
                    $totalPriceTemp = $totalPriceTemp+$row2["totalSummanry"];
                    $totalWeight = $totalWeight+$row2["totalWeight"];
                    $totalPrice = $totalPrice+$row2["totalSummanry"];
                }
            }
            $data .= "<tr tr style='background: beige;'> <td></td>";  // if uncomment top
            $data.= "<td colspan='2'> รวม [".$tempName."]</td> <td>".number_format($totalWeightTemp,1)."</td> <td colspan='2'>".number_format($totalPriceTemp,2)."</td> </tr>";
            $totalWeightTemp = 0;
            $totalPriceTemp = 0;
      }
      if($totalWeight != 0 && $totalPrice != 0){
          $data.= "<tr style='background: bisque;'> <td colspan='3'> รวมทั้งหมด </td> <td>".number_format($totalWeight,2)."</td> <td colspan='2'>".number_format($totalPrice,2)."</td> </tr>";
      }
      echo $data;
    }else{
      $data="<tr style='background: bisque;'><td colspan ='6'><center>ยังไม่มีการส่งมอบผลผลิต</center></td></tr>";
          echo $data;
    }
?>