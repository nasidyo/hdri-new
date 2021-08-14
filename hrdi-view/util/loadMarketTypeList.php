<?php 
  function loadMarketTypeList($conn, $area_Id){
      $sql2 = "
        SELECT mk.idMarket mk.nameMarket
        FROM CustomerMarket_TD cm
        INNER JOIN Customer_TD cus ON cm.Customer_idCustomer = cus.idCustomer
        INNER JOIN Market_TD mk ON cm.Market_idMarket = mk.idMarket
        WHERE cm.Area_idArea ='".$area_Id."'
        GROUP BY mk.nameMarket, mk.idMarket";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $rows = sqlsrv_has_rows($stmt);
      $data = "<option value='0'>กรุณาเลือก</option>";
      if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $id_pre = $row["idMarket"];
          $type_name = $row["nameMarket"];
          if($type_name != "ไม่ระบุ"){
              $data .= "<option value='$id_pre'>$type_name</option>";
          }else{
              $data .= "<option value='$id_pre'>$type_name</option>";
          }
        }
      }else{
        $sql3 = "
        SELECT mk.idMarket, mk.nameMarket
        FROM CustomerMarket_TD cm
        INNER JOIN Customer_TD cus ON cm.Customer_idCustomer = cus.idCustomer
        INNER JOIN Market_TD mk ON cm.Market_idMarket = mk.idMarket
        GROUP BY mk.nameMarket, mk.idMarket";

        $stmt = sqlsrv_query( $conn, $sql3 );
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $id_pre = $row["idMarket"];
          $type_name = $row["nameMarket"];
          if($type_name != "ไม่ระบุ"){
              $data .= "<option value='$id_pre'>$type_name</option>";
          }else{
              $data .= "<option value='$id_pre'>$type_name</option>";
          }
        }
      }
    echo $data;
  }
?>