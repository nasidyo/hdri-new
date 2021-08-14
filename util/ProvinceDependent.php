<?php 
function loadProvinceDependent($conn){
    $sql2=" SELECT Code , Name FROM  V_CODE_PROVINCE  order by Code ";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="<option value='0'>กรุณาเลือก</option>";
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["Code"];
      $name_pre=$row["Name"];
      $data.= "<option value='$id_pre'> $name_pre</option>";
    }
   echo  $data;
}
?>

