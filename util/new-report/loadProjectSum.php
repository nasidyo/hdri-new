<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
$sql = " SELECT a.target_area_type_id , a.areaType , SUM (pmt.TotalValue ) as totalValue, SUM (pmt.Volumn ) as totalVolumn
   FROM Area a 
   INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
   WHERE a.target_area_type_id in (3,5,10) and pmt.YearID ='".$_POST['yearsId']."' 
   GROUP BY a.target_area_type_id , a.areaType";
$stmt = sqlsrv_query( $conn, $sql);
$data = array();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $row_array['projectName'] = $row['areaType'];
   $row_array['cost'] = $row['totalValue'];
   $row_array['quantity'] = $row['totalVolumn'];
   array_push($data, $row_array);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
sqlsrv_close($conn);

?>
