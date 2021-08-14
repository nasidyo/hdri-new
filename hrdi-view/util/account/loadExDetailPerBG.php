<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();
 $business_group_id=0;
if (isset($_GET['business_group_id'])) {
  $business_group_id = $_GET['business_group_id'];
}


 $sql2=" SELECT ";
 $sql2.=" DISTINCT";
 $sql2.="  SUM(ex.EXPENSE_AMOUNT ) exOther";
 $sql2.=" FROM";
 $sql2.="  EXPENSE_TD ex";
 $sql2.=" INNER JOIN";
 $sql2.="  EXPENSE_OTHER_TD eo";
 $sql2.=" ON";
 $sql2.="  ex.EXPENSE_OTHER_ID = eo.EXPENSE_OTHER_ID";
 $sql2.=" INNER JOIN";
 $sql2.="  AccountYear ay";
 $sql2.=" ON";
 $sql2.="  ex.SUB_GROUP_ID =ay.sub_group_id";
 $sql2.=" INNER JOIN";
 $sql2.="  BusinessGroup gb";
 $sql2.=" ON";
 $sql2.="  ex.BUSINESS_GROUP_ID = gb.business_group_id";
 $sql2.=" WHERE";
 $sql2.="  ex.EXPENSE_DATE >= ay.account_year_start";
 $sql2.=" AND ex.EXPENSE_DATE <=ay.account_year_end";
 $sql2.=" AND ex.EXPENSE_AMOUNT <>0";
 $sql2.=" AND ex.BUSINESS_GROUP_ID = " .$business_group_id;
 $sql2.=" and eo.TYPE is null and ex.CANCELED <> 'Y'  ";




 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['exOther'] = $row['exOther'];

    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
