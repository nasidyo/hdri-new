<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();

 $sql2=" SELECT DISTINCT
        concat( a.nameArgi,' ', case when lt.grade =0 then ''  when lt.grade is null then ''  else  concat('(เกรด :',g.codeGrade,' )') end ) nameArgi
                FROM
                Agri_TD a
                LEFT JOIN
                list_taget_agri lt
                ON
                a.idAgri = lt.agri_id
                LEFT join Grade g on lt.grade = g.idGrade        order by nameArgi ";


 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
$data = array();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['nameArgi'] = $row['nameArgi'];
    array_push($data, $row['nameArgi']);

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


?>
