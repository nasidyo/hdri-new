<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT nameTypeOfStand
        FROM TypeOfStand
        WHERE idTypeOfStand = '".$_POST["market_Id"]."'";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $nameArgi=$row["nameTypeOfStand"];
      }
    echo $nameArgi;

?>