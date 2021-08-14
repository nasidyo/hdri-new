<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT COUNT(s.idStaff) staffNum , rb.nameRiverBasin FROM Staff_TD s , RiverBasin rb where s.RiverBasin_idRiverBasin =rb.idRiverBasin group by rb.nameRiverBasin ";
 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['staffNum'] = $row['staffNum'];
    $row_array['nameRiverBasin'] = $row['nameRiverBasin'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
