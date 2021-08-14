<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();

  $year='';
  if (isset($_GET['year'])) {
     $year = $_GET['year'];
   }

 $sql2=" SELECT
 mt.nameMarket ,
 ag.nameArgi ,
cast( sum( pm.TotalValue )  as DECIMAL(10,2) )  TotalValue
FROM
 Agri_TD ag
INNER JOIN
 PersonMarket_TD pm
ON
 ag.idAgri = pm.Agri_idAgri
RIGHT JOIN
 Market_TD mt
ON
 pm.Market_idMarket = mt.idMarket
 WHERE
 pm.YearID ='".$year."'
 group by  mt.nameMarket ,
 ag.nameArgi
 order by TotalValue desc  ";


 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['nameMarket'] = $row['nameMarket'];
    $row_array['nameArgi'] = $row['nameArgi'];
    $row_array['TotalValue'] = $row['TotalValue'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
