<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();

  $year='';
  if (isset($_GET['year'])) {
     $year = $_GET['year'];
   }
   $area='';
  if (isset($_GET['area'])) {
     $area = $_GET['area'];
   }

 $sql2="  SELECT 
 a.idArea,
 a.target_name ,
 ag.nameArgi ,
 SUM( pm.TotalValue ) TotalValue
FROM
 Area a
LEFT JOIN
 PersonMarket_TD pm
ON
 a.idArea = pm.Area_idArea
LEFT JOIN
 Agri_TD ag
ON
 pm.Agri_idAgri = ag.idAgri ";
if($year != '0' && $year != ''){
    $sql2.=" WHERE 
    pm.YearID ='".$year."' ";
}

$sql2.="GROUP BY
 a.idArea,
 a.target_name ,
 ag.nameArgi
ORDER BY
 TotalValue desc ";

// echo $sql2;
 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['target_name'] = $row['target_name'];
    $row_array['nameArgi'] = $row['nameArgi'];
    $row_array['TotalValue'] = $row['TotalValue'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
