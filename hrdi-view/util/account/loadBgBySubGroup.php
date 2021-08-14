<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $account_year_id=0;
 if (isset($_GET['account_year_id'])) {
    $account_year_id = $_GET['account_year_id'];
  }
 $sql2=" SELECT gb.business_group_id ,gb.business_group_name FROM BusinessGroup gb , AccountYear ay WHERE gb.sub_group_id = ay.sub_group_id ";
 if( $account_year_id!=0){
    $sql2 .=" and  ay.account_year_id  = ".$account_year_id;
 }


 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['business_group_id'] = $row['business_group_id'];
    $row_array['business_group_name'] = $row['business_group_name'];

    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
