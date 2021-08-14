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
 $sql2.="  dbo.toMoney(SUM(expenseOther)) expenseOther , ";
 $sql2.="   dbo.toMoney( SUM(expense) )    expense ";
 $sql2.="  FROM ";
 $sql2.="   ( ";
 $sql2.="       SELECT DISTINCT ";
 $sql2.="          ex.business_group_id , ";
 $sql2.="          ex.EXPENSE_AMOUNT expenseOther, ";
 $sql2.="          0                 expense, ";
 $sql2.="          ex.EXPENSE_ID ";
 $sql2.="      FROM ";
 $sql2.="          BusinessGroup bg ";
 $sql2.="      INNER JOIN ";
 $sql2.="          SubPersonGroup sp ";
 $sql2.="      ON ";
 $sql2.="           bg.sub_group_id = sp.sub_group_id ";
 $sql2.="       INNER JOIN ";
 $sql2.="          AccountYear ay ";
 $sql2.="      ON ";
 $sql2.="          sp.sub_group_id = ay.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          INSTITUTE ins ";
 $sql2.="      ON ";
 $sql2.="          sp.institute_id = ins.INSTITUTE_ID ";
 $sql2.="     INNER JOIN ";
 $sql2.="          Area a ";
 $sql2.="      ON ";
 $sql2.="          ins.AREA_ID = a.idArea ";
 $sql2.="      INNER JOIN ";
 $sql2.="          EXPENSE_TD ex ";
 $sql2.="      ON ";
 $sql2.="          sp.sub_group_id = ex.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          EXPENSE_OTHER_TD eot ";
 $sql2.="      ON ";
 $sql2.="          ex.EXPENSE_OTHER_ID = eot.EXPENSE_OTHER_ID ";

    $sql2.="      WHERE ";
    $sql2.="          ex.business_group_id = ".$business_group_id." ";

 $sql2.="      AND ex.ORDER_ID =0 ";
 $sql2.="      AND eot.TYPE IS NULL ";
 $sql2.="      AND ex.EXPENSE_DATE >= ay.account_year_start ";
 $sql2.="      AND ex.EXPENSE_DATE <=ay.account_year_end  and ex.CANCELED <> 'Y'  ";
 $sql2.="       UNION ";
 $sql2.="      SELECT DISTINCT ";
 $sql2.="          ex.business_group_id , ";
 $sql2.="          0                 expenseOther, ";
 $sql2.="          ex.EXPENSE_AMOUNT expense, ";
 $sql2.="          ex.EXPENSE_ID ";
 $sql2.="      FROM ";
 $sql2.="          BusinessGroup bg ";
 $sql2.="      INNER JOIN ";
 $sql2.="          SubPersonGroup sp ";
 $sql2.="       ON ";
 $sql2.="          bg.sub_group_id = sp.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          AccountYear ay ";
 $sql2.="      ON ";
 $sql2.="          sp.sub_group_id = ay.sub_group_id ";
 $sql2.="      INNER JOIN ";
 $sql2.="          INSTITUTE ins ";
 $sql2.="      ON ";
 $sql2.="          sp.institute_id = ins.INSTITUTE_ID ";
 $sql2.="      INNER JOIN ";
 $sql2.="          Area a ";
 $sql2.="      ON ";
 $sql2.="          ins.AREA_ID = a.idArea ";
 $sql2.="      INNER JOIN ";
 $sql2.="          EXPENSE_TD ex ";
 $sql2.="      ON ";
 $sql2.="          sp.sub_group_id = ex.sub_group_id ";
 $sql2.="      WHERE ";
 $sql2.="         ex.business_group_id = ".$business_group_id." ";
 $sql2.="      AND ex.ORDER_ID <> 0 ";
 $sql2.="      AND ex.EXPENSE_AMOUNT <> 0 ";
 $sql2.="      AND ex.EXPENSE_DATE >= ay.account_year_start ";
 $sql2.="      AND ex.EXPENSE_DATE <=ay.account_year_end and ex.CANCELED <> 'Y' ) tmp ";
 $sql2.="  GROUP BY ";
 $sql2.="   business_group_id  ";


 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['expenseOther'] = $row['expenseOther'];
    $row_array['expense'] = $row['expense'];
    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
