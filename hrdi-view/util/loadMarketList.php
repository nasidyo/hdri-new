<?php 
  function loadMarketList($conn, $area_Id){
      $sql2 = "
        SELECT cm.idCustomerMarket, cus.c_name, mk.idMarket, mk.nameMarket
        FROM CustomerMarket_TD cm
        INNER JOIN Customer_TD cus ON cm.Customer_idCustomer = cus.idCustomer
        INNER JOIN Market_TD mk ON cm.Market_idMarket = mk.idMarket
        WHERE cm.Area_idArea ='".$area_Id."'
        ORDER BY mk.idMarket";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $rows = sqlsrv_has_rows($stmt);
      if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $id_pre = $row["idCustomerMarket"];
          $name_pre = $row["c_name"];
          $type_name = $row["nameMarket"];
          if($name_pre != "ไม่ระบุ"){
              $data .= "<option value='$id_pre'>[$type_name] $name_pre</option>";
          }else{
              $data .= "<option value='$id_pre'>$type_name</option>";
          }
        }
      }else{
        $sql3 = "
        SELECT cm.idCustomerMarket, cus.c_name, mk.idMarket, mk.nameMarket
        FROM CustomerMarket_TD cm
        INNER JOIN Customer_TD cus ON cm.Customer_idCustomer = cus.idCustomer
        INNER JOIN Market_TD mk ON cm.Market_idMarket = mk.idMarket
        GROUP BY nameMarket, idMarket, idCustomerMarket, c_name
        ORDER BY mk.nameMarket, c_name";
        $stmt = sqlsrv_query( $conn, $sql3 );
        $temp = '';
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          if($temp != $row["c_name"] || $temp == ''){
            $temp = $row["c_name"];
            $id_pre = $row["idCustomerMarket"];
            $name_pre = $row["c_name"];
            $type_name = $row["nameMarket"];
            if($name_pre != "ไม่ระบุ"){
                $data .= "<option value='$id_pre'>[$type_name] $name_pre</option>";
            }else{
                $data .= "<option value='$id_pre'>$type_name</option>";
            }
          }
        }
      }
    echo $data;
  }
?>