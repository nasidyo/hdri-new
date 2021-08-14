<?php
    function loadLogisticList($conn){
      $sql2 = "
        SELECT logistic_id, logistic_name
        FROM Logistic_TD";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["logistic_id"];
        $name_pre=$row["logistic_name"];
        $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    echo $data;
  }
?>