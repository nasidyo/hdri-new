<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();
 $account_year_id=0;
if (isset($_GET['account_year_id'])) {
  $account_year_id = $_GET['account_year_id'];
}

$year="";
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}

 $sql2=" SELECT ";
 $sql2.="  DISTINCT  ";
 $sql2.="   a.idArea, ";
 $sql2.="   a.areaName, ";
 $sql2.="   dbo.toMoney( ay.bank_bugget+ay.current_bugget ) MONEY , ";
 $sql2.="    dbo.toMoney(( ";
 $sql2.="       SELECT ";
 $sql2.="           SUM(ind.DEBT) ";
 $sql2.="      FROM ";
 $sql2.="           INCOME_TD ind ";
 $sql2.="       WHERE  ind.CANCELED <> 'Y' and ";
 $sql2.="           sp.sub_group_id = ind.SUB_GROUP_ID ";
 $sql2.="      AND ind.RECEIVE_DATE >=ay.account_year_start ";
 $sql2.="       AND ind.RECEIVE_DATE<=ay.account_year_end )) inc_debt, ";
 $sql2.="    dbo.toMoney(( ";
 $sql2.="       SELECT ";
 $sql2.="           SUM(ex.DEBT) ";
 $sql2.="       FROM ";
 $sql2.="           EXPENSE_TD ex ";
 $sql2.="      WHERE ex.CANCELED <> 'Y' and ";
 $sql2.="          sp.sub_group_id = ex.SUB_GROUP_ID ";
 $sql2.="      AND ex.EXPENSE_DATE >=ay.account_year_start ";
 $sql2.="       AND ex.EXPENSE_DATE<=ay.account_year_end )) ex_debt, ";
 $sql2.="     dbo.toMoney((   ay.stocks_price * stocks_amount  )) stocksValue , ";

 $sql2.=" dbo.toMoney( ";
 $sql2.="    (";
 $sql2.="        SELECT";
 $sql2.="           SUM(sv.amount)";
 $sql2.="       FROM";
 $sql2.="           Saving sv";
 $sql2.="       WHERE";
 $sql2.="         sp.sub_group_id = sv.sub_group_id";
 $sql2.="       AND sv.create_date >=ay.account_year_start";
 $sql2.="       AND sv.create_date <=ay.account_year_end )) saving";

 $sql2.="  FROM ";
 $sql2.="   Area a ";
 $sql2.="  INNER JOIN ";
 $sql2.="   INSTITUTE ins ";
 $sql2.="  ON ";
 $sql2.="   ins.AREA_ID = a.idArea ";
 $sql2.="  INNER JOIN ";
 $sql2.="   SubPersonGroup sp ";
 $sql2.="  ON ";
 $sql2.="   ins.INSTITUTE_ID = sp.institute_id ";
 $sql2.="  INNER JOIN ";
 $sql2.="   AccountYear ay ";
 $sql2.="  ON ";
 $sql2.="   sp.sub_group_id = ay.sub_group_id ";
 $sql2.="  INNER JOIN ";
 $sql2.="   INCOME_TD inct ";
 $sql2.="  ON ";
 $sql2.="  sp.sub_group_id = inct.sub_group_id   ";
 $sql2."  where 1=1 and inct.CANCELED <> 'Y' ";
 if( $account_year_id !=0 ){
    $sql2.=" and ay.account_year_id = ".$account_year_id;
 }
 if( $year !=""){
    $sql2.=" and ay.year_text = '".$year."'";
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
    $row_array['idArea'] = $row['idArea'];
    $row_array['areaName'] = $row['areaName'];
    $row_array['MONEY'] = $row['MONEY'];
    $row_array['inc_debt'] = $row['inc_debt'];
    $row_array['ex_debt'] = $row['ex_debt'];
    $row_array['stocksValue'] = $row['stocksValue'];
    $row_array['saving'] = $row['saving'];
    array_push($data, $row_array);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);


?>
