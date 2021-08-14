<?php
 require '../../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();


 $sql2=" SELECT ";
 $sql2.="   concat(firstName , lastName) name ,idPerson   from Person_TD";





 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();
 $dataTmp = array();
 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['name'] = $row['name'];
    $row_array['idPerson'] = $row['idPerson'];
    array_push($data, $row_array);
 }
 $dataTmp = $data;
for($i=0;$i<count($data);$i++){

    for($j=0;$j<count($dataTmp);$j++){
        similar_text($data[$i]['name'], $dataTmp[$j]['name'], $percent);
        if($percent <100 && $percent>=95){
            echo $data[$i]['name']."|".$dataTmp[$j]['name'].":".$data[$i]['idPerson']."=".$dataTmp[$j]['idPerson']."|".round($percent, 2)."%\n";
        }

    }

}

 sqlsrv_close($conn);


?>
