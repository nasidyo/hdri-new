<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT cus.c_name
        FROM CustomerMarket_TD cmk
        INNER JOIN Customer_TD cus ON cmk.Customer_idCustomer = cus.idCustomer
        WHERE cmk.idCustomerMarket = '".$_POST["market_Id"]."'";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $nameArgi=$row["c_name"];
      }
    echo $nameArgi;

?>