<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sqlCheck = "
        SELECT *
          FROM Grade 
          WHERE codeGrade = '".urldecode($_POST["gradeName"])."'
        ";
      $stmt = sqlsrv_query( $conn, $sqlCheck );
      if( !$stmt ) {
          die( print_r( sqlsrv_errors(), true));
      }
      $result = '0';
      $rows = sqlsrv_has_rows($stmt);
      if ($rows === true){
        $result = '1';
      }
      echo $result
?>