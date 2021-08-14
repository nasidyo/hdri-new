<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();
 $business_group_id=0;
if (isset($_GET['business_group_id'])) {
  $business_group_id = $_GET['business_group_id'];
}

$sql2 =" SELECT   ISNULL(SUM(  DEBT ),0 ) debt  from ";
 $sql2.=" ( SELECT  distinct ";
 $sql2.="   inct.DEBT ";
 $sql2.="  FROM ";
 $sql2.="   INCOME_TD inct ";
 $sql2.="  INNER JOIN ";
 $sql2.="   SubPersonGroup sp ";
 $sql2.="  ON ";
 $sql2.="   inct.sub_group_id = inct.sub_group_id ";
 $sql2.="  INNER JOIN ";
 $sql2.="   AccountYear ay ";
 $sql2.="  ON ";
 $sql2.="   ay.sub_group_id =inct.sub_group_id ";
 $sql2.="  INNER JOIN ";
 $sql2.="   INSTITUTE ins ";
 $sql2.="  ON ";
 $sql2.="   ins.INSTITUTE_ID = sp.institute_id ";
 $sql2.="  WHERE ";
 $sql2.="   inct.business_group_id =  ".$business_group_id ;
 $sql2.="  AND inct.RECEIVE_DATE >= ay.account_year_start ";
 $sql2.="  AND inct.RECEIVE_DATE <=ay.account_year_end ";
 $sql2.="  AND inct.DEBT IS NOT NULL ";
 $sql2.="  AND inct.DEBT<>0 ";
 $sql2.="  AND inct.CANCELED <>'Y' ";
 $sql2.="  ) tmp ";

 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['debt'] = $row['debt'];
    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
