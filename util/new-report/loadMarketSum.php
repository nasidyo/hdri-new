<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
$sql = "SELECT pmk.Market_idMarket, mk.nameMarket, SUM(ISNULL(pmk.totalValue,0)) totalValue, SUM(ISNULL(pmk.Volumn,0)) as totalVolumn
   FROM PersonMarket_TD pmk
   INNER JOIN Market_TD mk ON pmk.Market_idMarket = mk.idMarket 
   WHERE pmk.YearID = '".$_POST['yearsId']."'
   GROUP BY pmk.Market_idMarket, mk.nameMarket ";
$stmt = sqlsrv_query( $conn, $sql);
$data = array();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $row_array['nameValue'] = $row['nameMarket'];
   $row_array['cost'] = $row['totalValue'];
   $row_array['quantity'] = $row['totalVolumn'];
   array_push($data, $row_array);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
sqlsrv_close($conn);

?>
