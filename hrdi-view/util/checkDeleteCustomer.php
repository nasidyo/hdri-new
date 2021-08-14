<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sqlDeepCheck = "
    SELECT *
    FROM ( SELECT Customer_idCustomer as customer_id FROM PersonMarket_TD
            UNION ALL
           SELECT cmk.Customer_idCustomer as customer_id FROM TargetPlan_TD as tp
           INNER JOIN CustomerMarket_TD as cmk ON tp.market_id = cmk.idCustomerMarket ) Deep
      WHERE customer_id = '".$_POST["customer_id"]."'";

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