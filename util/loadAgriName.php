<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT 
        CASE 
        WHEN speciesArgi = '' THEN nameArgi
        WHEN speciesArgi IS NULL THEN nameArgi  
        ELSE nameArgi+'(พันธุ์:'+speciesArgi+')' END as nameOFArgi
        FROM Agri_TD
        WHERE idAgri = '".$_POST["agri_Id"]."'";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $nameArgi=$row["nameOFArgi"];
      }
    echo $nameArgi;
?>