<?php 
  function loadMonthOfTheYears($conn){
      $sql2 = "
        SELECT Month_id, Month_name
        FROM MonthOfYear";
      $stmt = sqlsrv_query( $conn, $sql2 );
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["Month_id"];
        $name_pre=$row["Month_name"];
        $data .= "<option value='$id_pre'>$name_pre</option>";
      }
    echo $data;
  }
?>