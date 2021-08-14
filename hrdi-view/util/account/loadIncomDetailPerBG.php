<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();
 $business_group_id=0;
if (isset($_GET['business_group_id'])) {
  $business_group_id = $_GET['business_group_id'];
}


 $sql2=" SELECT ";
 $sql2.=" SUM(inc.RECEIVE_AMOUNT ) income, ";
 $sql2.="  ort.ORDER_NAME , ";
 $sql2.="  inc.BUSINESS_GROUP_ID , ";
 $sql2.="  gb.business_group_name , ";
 $sql2.="  'inc' type ";
 $sql2.=" FROM ";
 $sql2.="  INCOME_TD inc ";
 $sql2.=" INNER JOIN ";
 $sql2.="  ORDER_TD ort ";
 $sql2.=" ON ";
 $sql2.="  inc.ORDER_ID = ort.ORDER_ID ";
 $sql2.=" INNER JOIN ";
 $sql2.="  AccountYear ay ";
 $sql2.=" ON ";
 $sql2.="  inc.SUB_GROUP_ID =ay.sub_group_id ";
 $sql2.=" INNER JOIN ";
 $sql2.="  BusinessGroup gb ";
 $sql2.=" ON ";
 $sql2.="  inc.BUSINESS_GROUP_ID = gb.business_group_id ";
 $sql2.=" WHERE ";
 $sql2.="  inc.RECEIVE_DATE >= ay.account_year_start ";
 $sql2.=" AND inc.RECEIVE_DATE <=ay.account_year_end ";
 $sql2.=" AND inc.RECEIVE_AMOUNT <>0 and inc.CANCELED <> 'Y'  ";
 $sql2.=" and inc.BUSINESS_GROUP_ID = ".$business_group_id;
 $sql2.=" GROUP BY ";
 $sql2.="  ort.ORDER_NAME , ";
 $sql2.="  inc.BUSINESS_GROUP_ID, ";
 $sql2.="  gb.business_group_name ";
 $sql2.=" UNION ";
 $sql2.=" SELECT ";
 $sql2.="  SUM(ex.EXPENSE_AMOUNT ) income, ";
 $sql2.="  ort.ORDER_NAME , ";
 $sql2.="  ex.BUSINESS_GROUP_ID , ";
 $sql2.="  gb.business_group_name , ";
 $sql2.="  'ex' type ";
 $sql2.=" FROM ";
 $sql2.="  EXPENSE_TD ex ";
 $sql2.=" INNER JOIN ";
 $sql2.="  ORDER_TD ort ";
 $sql2.=" ON ";
 $sql2.="  ex.ORDER_ID = ort.ORDER_ID ";
 $sql2.=" INNER JOIN ";
 $sql2.="  AccountYear ay ";
 $sql2.=" ON ";
 $sql2.="  ex.SUB_GROUP_ID =ay.sub_group_id ";
 $sql2.=" INNER JOIN ";
 $sql2.="  BusinessGroup gb ";
 $sql2.=" ON ";
 $sql2.="  ex.BUSINESS_GROUP_ID = gb.business_group_id ";
 $sql2.=" WHERE ";
 $sql2.="  ex.EXPENSE_DATE >= ay.account_year_start ";
 $sql2.=" AND ex.EXPENSE_DATE <=ay.account_year_end ";
 $sql2.=" AND ex.EXPENSE_AMOUNT <>0 and ex.CANCELED <> 'Y'  ";
 $sql2.=" and ex.BUSINESS_GROUP_ID = ".$business_group_id;
 $sql2.=" GROUP BY ";
 $sql2.="  ort.ORDER_NAME , ";
 $sql2.="  ex.BUSINESS_GROUP_ID, ";
 $sql2.="  gb.business_group_name  ";



 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['income'] = $row['income'];
    $row_array['ORDER_NAME'] = $row['ORDER_NAME'];
    $row_array['business_group_name'] = $row['business_group_name'];
    $row_array['type'] = $row['type'];

    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
