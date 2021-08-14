<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sqlCheck = "
        SELECT *
          FROM Person_TD 
          WHERE Area_idArea = '".$_POST["area_Id"]."' and firstName = '".urldecode($_POST["firstName"])."' and lastName ='".urldecode($_POST["lastName"])."'
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