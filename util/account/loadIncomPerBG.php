<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();
 $business_group_id=0;
if (isset($_GET['business_group_id'])) {
  $business_group_id = $_GET['business_group_id'];
}


 $sql2=" SELECT ";
 $sql2.="  business_group_id , ";
 $sql2.="  dbo.toMoney(SUM(incomeOther)) incomeOther , ";
 $sql2.="  dbo.toMoney( SUM(income) )     income ";
 $sql2.="  FROM ";
 $sql2.="   ( ";
 $sql2.="      SELECT DISTINCT ";
 $sql2.="          inct.business_group_id , ";
 $sql2.="          inct.RECEIVE_AMOUNT incomeOther, ";
 $sql2.="          0                   income, ";
 $sql2.="          inct.INCOME_ID ";
 $sql2.="      FROM ";
 $sql2.="           BusinessGroup bg ";
 $sql2.="       INNER JOIN ";
 $sql2.="           SubPersonGroup sp ";
 $sql2.="       ON ";
 $sql2.="           bg.sub_group_id = sp.sub_group_id ";
 $sql2.="       INNER JOIN ";
 $sql2.="           AccountYear ay ";
 $sql2.="       ON ";
 $sql2.="           sp.sub_group_id = ay.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          INSTITUTE ins ";
 $sql2.="       ON ";
 $sql2.="           sp.institute_id = ins.INSTITUTE_ID ";
 $sql2.="       INNER JOIN ";
 $sql2.="          Area a ";
 $sql2.="      ON ";
 $sql2.="          ins.AREA_ID = a.idArea ";
 $sql2.="      INNER JOIN ";
 $sql2.="          INCOME_TD inct ";
 $sql2.="       ON ";
 $sql2.="           sp.sub_group_id = inct.sub_group_id  ";

 $sql2.="INNER JOIN ";
 $sql2.="    INCOME_OTHER_TD iot ";
 $sql2.=" ON ";
 $sql2.="   inct.INCOME_OTHER_ID = iot.INCOME_OTHER_ID ";
 $sql2.="       WHERE ";
 $sql2.="          inct.business_group_id = ".$business_group_id." ";
 $sql2.="      AND inct.ORDER_ID =0  and iot.TYPE is null ";
 $sql2.="      AND inct.RECEIVE_DATE >= ay.account_year_start ";
 $sql2.="      AND inct.RECEIVE_DATE <=ay.account_year_end  and inct.CANCELED <> 'Y'  ";
 $sql2.="      UNION ";
 $sql2.="      SELECT DISTINCT ";
 $sql2.="          inct.business_group_id , ";
 $sql2.="          0                   incomeOther , ";
 $sql2.="          inct.RECEIVE_AMOUNT income, ";
 $sql2.="           inct.INCOME_ID ";
 $sql2.="       FROM ";
 $sql2.="           BusinessGroup bg ";
 $sql2.="       INNER JOIN ";
 $sql2.="           SubPersonGroup sp ";
 $sql2.="      ON ";
 $sql2.="          bg.sub_group_id = sp.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          AccountYear ay ";
 $sql2.="      ON ";
 $sql2.="          sp.sub_group_id = ay.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          INSTITUTE ins ";
 $sql2.="      ON ";
 $sql2.="          sp.institute_id = ins.INSTITUTE_ID ";
 $sql2.="       INNER JOIN ";
 $sql2.="           Area a ";
 $sql2.="      ON ";
 $sql2.="          ins.AREA_ID = a.idArea ";
 $sql2.="       INNER JOIN ";
 $sql2.="          INCOME_TD inct ";
 $sql2.="      ON ";
 $sql2.="          sp.sub_group_id = inct.sub_group_id ";
 $sql2.="      WHERE ";
 $sql2.="          inct.business_group_id = ".$business_group_id." ";
 $sql2.="      AND inct.ORDER_ID <> 0 ";
 $sql2.="      AND inct.RECEIVE_DATE >= ay.account_year_start ";
 $sql2.="      AND inct.RECEIVE_DATE <=ay.account_year_end and inct.CANCELED <> 'Y'  ) tmp ";
 $sql2.="  GROUP BY ";
 $sql2.="  business_group_id   ";

 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['incomeOther'] = $row['incomeOther'];
    $row_array['income'] = $row['income'];
    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
