<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
$sql = "SELECT rb.nameRiverBasin, rb.idRiverBasin , SUM (pmt.TotalValue ) as totalValue, SUM (pmt.Volumn ) as totalVolumn
               FROM MainBasin rb 
               INNER JOIN Area a ON rb.idRiverBasin = a.RiverBasin_idRiverBasin
               INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
               WHERE a.target_area_type_id in (3,5,10) AND rb.idRiverBasin NOT IN (1,22) and pmt.YearID ='".$_POST['yearsId']."' 
               GROUP BY rb.nameRiverBasin, rb.idRiverBasin
               ORDER BY rb.nameRiverBasin";
$stmt = sqlsrv_query( $conn, $sql);
$data = array();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $row_array['projectName'] = $row['nameRiverBasin'];
   $row_array['cost'] = $row['totalValue'];
   $row_array['quantity'] = $row['totalVolumn'];
   array_push($data, $row_array);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
sqlsrv_close($conn);

?>
