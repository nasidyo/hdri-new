<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT top 5 COUNT(lt.log_idlogin) id , lt.username FROM LogAccess_TD lt GROUP BY lt.username ";
 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['id'] = $row['id'];
    $row_array['username'] = $row['username'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
