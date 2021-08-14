<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();
 $account_year_id=0;
if (isset($_GET['account_year_id'])) {
  $account_year_id = $_GET['account_year_id'];
}

 $sql2=" SELECT ";
 $sql2.="  DISTINCT";
 $sql2.="   dbo.toMoney (";
 $sql2.="   (";
 $sql2.="       SELECT";
 $sql2.="           SUM(ind.RECEIVE_AMOUNT)";
 $sql2.="      FROM";
 $sql2.="           INCOME_TD ind";
 $sql2.="      WHERE";
 $sql2.="           sp.sub_group_id = ind.SUB_GROUP_ID";
 $sql2.="      AND ind.RECEIVE_DATE >=ay.account_year_start";
 $sql2.="      AND ind.RECEIVE_DATE<=ay.account_year_end ";
 $sql2.="       AND ind.ORDER_ID <>0 and ind.CANCELED <> 'Y' )) income_all,";
 $sql2.="        dbo.toMoney (";
 $sql2.="   (";
 $sql2.="       SELECT";
 $sql2.="          SUM(ex.EXPENSE_AMOUNT)";
 $sql2.="       FROM";
 $sql2.="          EXPENSE_TD ex";
 $sql2.="      WHERE ex.CANCELED <> 'Y' ";
 $sql2.="       and   sp.sub_group_id = ex.SUB_GROUP_ID";
 $sql2.="      AND ex.EXPENSE_DATE >=ay.account_year_start";
 $sql2.="      AND ex.EXPENSE_DATE<=ay.account_year_end ";
 $sql2.="      AND ex.ORDER_ID <>0)) expense_all  , ";
 $sql2.=" dbo.toMoney ( ";
 $sql2.=" ( ";
 $sql2.=" SELECT ";
 $sql2.="     SUM(ex.EXPENSE_AMOUNT) ";
 $sql2.=" FROM ";
 $sql2.="     EXPENSE_TD ex, ";
 $sql2.="     EXPENSE_OTHER_TD eot ";
 $sql2.=" WHERE ";
 $sql2.="    sp.sub_group_id = ex.SUB_GROUP_ID ";
 $sql2.="    AND ex.EXPENSE_OTHER_ID = eot.EXPENSE_OTHER_ID ";
 $sql2.=" AND ex.EXPENSE_DATE >=ay.account_year_start ";
 $sql2.=" AND ex.EXPENSE_DATE<=ay.account_year_end  ";
 $sql2.=" AND  eot.TYPE  is null and ex.CANCELED <> 'Y'  )) expense_oth ,  ";
 $sql2.="   ay.year_text ";
 $sql2.="  FROM";
 $sql2.="   Area a";
 $sql2.="  INNER JOIN";
 $sql2.="   INSTITUTE ins";
 $sql2.="  ON";
 $sql2.="   ins.AREA_ID = a.idArea";
 $sql2.="  INNER JOIN";
 $sql2.="   SubPersonGroup sp";
 $sql2.="  ON";
 $sql2.="   ins.INSTITUTE_ID = sp.institute_id";
 $sql2.="  INNER JOIN";
 $sql2.="   AccountYear ay";
 $sql2.="  ON";
 $sql2.="   sp.sub_group_id = ay.sub_group_id";
 $sql2.="  INNER JOIN";
 $sql2.="   INCOME_TD inct";
 $sql2.="  ON";
 $sql2.="   sp.sub_group_id = inct.sub_group_id ";
 if( $account_year_id !=0 ){
    $sql2.=" where ay.account_year_id = ".$account_year_id;
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
    $row_array['income_all'] = $row['income_all'];
    $row_array['expense_all'] = $row['expense_all'];
    $row_array['expense_oth'] = $row['expense_oth'];


    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
