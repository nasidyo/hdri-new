<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT Month_name
        FROM MonthOfYear
        WHERE Month_id = '".$_POST["monthId"]."'";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $nameArgi=$row["Month_name"];
      }
    echo $nameArgi;
?>