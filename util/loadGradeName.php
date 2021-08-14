<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT codeGrade
        FROM Grade
        WHERE idGrade = '".$_POST["market_Id"]."'";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $nameArgi=$row["codeGrade"];
      }
    echo $nameArgi;

?>