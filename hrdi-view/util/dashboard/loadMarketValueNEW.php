<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
$idMarket=0;
if (isset($_GET['idMarket'])) {
   $idMarket = $_GET['idMarket'];
}
$year='';
if (isset($_GET['year'])) {
   $year = $_GET['year'];
}

$sql1 = "
   SELECT toat.idTypeOfArgi, toat.nameTypeOfArgi
   FROM TypeOfArgi_TD toat
";
$stmt1 = sqlsrv_query( $conn, $sql1 );
$data = array();
while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
   $row_array['nameTypeArgi'] = $row1['nameTypeOfArgi'];
   //  $row_array['monthName'] = $row['monthName'];
   //  $row_array['TotalAmount'] = $row['TotalAmount'];
   //  array_push($data, $row_array);
   $sql2 = "
      SELECT moy.Month_id, COALESCE(SUM(psmk.Weight),'0') AS totalIncome , moy.Month_Etc, moy.Month_seq
      FROM MonthOfYear moy
      LEFT JOIN ( SELECT tp.Weight, tp.month_id, tp.market_id, tp.TypeOfArgi_idTypeOfArgi, tp.YearTarget_YearID
      FROM TargetPlan_TD as tp
      INNER JOIN CustomerMarket_TD cm ON tp.market_id = cm.idCustomerMarket
      INNER JOIN Market_TD mt ON cm.Market_idMarket = mt.idMarket ";

if( $idMarket==0){
    $sql2 .= "  WHERE TypeOfArgi_idTypeOfArgi=".$row1['idTypeOfArgi']." and YearTarget_YearID =".$year." ) psmk ON moy.Month_id = psmk.month_id  ";
}else{
    $sql2 .= "  WHERE TypeOfArgi_idTypeOfArgi=".$row1['idTypeOfArgi']." and YearTarget_YearID =".$year." and mt.idMarket = ".$idMarket.") psmk ON moy.Month_id = psmk.month_id  ";

}

      $sql2 .=" GROUP BY moy.Month_id, Month_Etc, Month_seq
      ORDER BY Month_seq ";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $dataset = [];
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
         array_push($dataset, $row['totalIncome']);
      }
      $row_array['dataset'] = $dataset;
      array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
