<?php
 require '../model/OrderM.php';
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $id=0;
if (isset($_GET['order_id'])) {
  $id = $_GET['order_id'];
}
      $sql2 ="SELECT ORDER_ID, ORDER_NAME, STATUS, COMMENT, UNIT_ID, ISNULL(BALANCE, 0 ) BALANCE , INSTITUTE_ID FROM ORDER_TD where ORDER_ID = ".$id;
      $stmt = sqlsrv_query( $conn, $sql2 );
      $orderM = new OrderM();
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

          $orderM->setOrderId($row['ORDER_ID']);
          $orderM->setOrderName($row['ORDER_NAME']);
          $orderM->setStatus($row['STATUS']);
          $orderM->setComment($row['COMMENT']);
          $orderM->setBalance($row['BALANCE']);
          $orderM->setInstituteId($row['INSTITUTE_ID']);

      }
      sqlsrv_close($conn);
      echo json_encode($orderM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

?>
