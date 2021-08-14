<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT COUNT( lt.ipAddress) id , lt.platform FROM LogAccess_TD lt GROUP BY lt.platform ";
 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['id'] = $row['id'];
    $row_array['platform'] = $row['platform'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
