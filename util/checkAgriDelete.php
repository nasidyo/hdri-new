<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sqlDeepCheck = "
      SELECT *
      FROM ( SELECT Agri_idAgri as agri_id FROM TargetPlan_TD
              UNION ALL
             SELECT Agri_idAgri as agri_id FROM PersonMarket_TD
              UNION ALL
             SELECT Agri_idAgri as agri_id FROM OutputValue_TD ) Deep 
      WHERE agri_id = '".$_POST["idAgri"]."'";
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