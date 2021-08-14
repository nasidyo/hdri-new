<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sqlDeepCheck = "
      SELECT *
      FROM PersonMarket_TD
      WHERE Grade_codeGrade = '".$_POST["gradeId"]."'";
    $stmt = sqlsrv_query( $conn, $sqlDeepCheck );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $result = "N";
    $rows = sqlsrv_has_rows($stmt);
    if ($rows === true){
      $result = 'Y';
    }
    echo $result;
?>