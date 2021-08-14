<?php 
 function loadAllStatndProduct($conn){
    $sql2 = "
        SELECT tyst.idTypeOfStand, tyst.nameTypeOfStand
        FROM TypeOfStand tyst
      ";
    $data="<option value='0'>ไม่มีเกรด</option>";
    $stmt = sqlsrv_prepare( $conn, $sql2 );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idTypeOfStand"];
      $name_pre=$row["nameTypeOfStand"];
      if($id_pre != "0"){
          $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    }
    echo $data;
}
?>