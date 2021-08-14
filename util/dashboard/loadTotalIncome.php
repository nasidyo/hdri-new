<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
   $area = '';
   if (isset($_GET['area'])) {
      $area =$_GET['area'];
   }
   $year = '';
   if (isset($_GET['year'])) {
      $year =$_GET['year'];
   }
   $sql = "SELECT sum( pmt.TotalValue ) as TotalValue 
   FROM PersonMarket_TD pmt 
   WHERE pmt.Person_idPerson IS NOT NULL ";
   if($area != ''){
      $sql.=" and pmt.Area_idArea = '".$area."'";
   }
   if($year != ''){
      $sql.=" and pmt.YearID = '".$year."'";
   }
   $stmt = sqlsrv_query( $conn, $sql );
   $data = array();
   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $row_array['TotalValue'] = $row['TotalValue'];
      array_push($data, $row_array);
   }
   echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
   sqlsrv_close($conn);
?>
