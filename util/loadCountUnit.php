<?php 
function loadAllCountUnit ($conn){
    $sql2="
      SELECT cu.idCountUnit, nameCountUnit
      FROM CountUnit cu
      ORDER BY cu.idCountUnit DESC
      ";
      $stmt = sqlsrv_query( $conn, $sql2);
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idCountUnit"];
        $name_pre=$row["nameCountUnit"];
        $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    echo $data;
}

?>