<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
$sql = "SELECT COUNT (DISTINCT pmt.Person_idPerson) as contOfPerson
   FROM PersonMarket_TD pmt 
   WHERE  pmt.YearID = '".$_POST['yearsId']."'
";
$stmt = sqlsrv_query( $conn, $sql);
$data = array();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $row_array['contOfPerson'] = $row['contOfPerson'];
   array_push($data, $row_array);
}
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
sqlsrv_close($conn);

?>
