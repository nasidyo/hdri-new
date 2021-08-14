<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT mk.nameMarket
        FROM CustomerMarket_TD cmk
        INNER JOIN Market_TD mk ON cmk.Market_idMarket = mk.idMarket
        WHERE cmk.idCustomerMarket = '".$_POST["market_Id"]."'";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $nameArgi=$row["nameMarket"];
      }
    echo $nameArgi;

?>