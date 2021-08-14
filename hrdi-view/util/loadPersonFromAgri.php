<?php
  function loadFarmerFromAgri($conn, $area_Id){
      // $sql2 = "
      //   SELECT cm.idCustomerMarket, cus.c_name, mk.idMarket, mk.nameMarket
      //   FROM CustomerMarket cm
      //   INNER JOIN Customer cus ON cm.Customer_idCustomer = cus.idCustomer
      //   INNER JOIN Market mk ON cm.Market_idMarket = mk.idMarket
      //   WHERE cm.Area_idArea ='".$area_Id."'
      //   ORDER BY mk.idMarket";
      $sql2 = "
          SELECT firstName +' '+ lastName as fullname, idPerson
          FROM Person_TD
          WHERE Area_idArea = '".$area_Id."' and statusPerson = 'มีชีวิตอยู่'
          GROUP BY idPerson, firstName, lastName
      ";
      $data = "";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre = $row["idPerson"];
        $name_pre = $row["fullname"];
        $data .= "<option value='$id_pre'>$name_pre</option>";
      }
    echo $data;
  }

?>
