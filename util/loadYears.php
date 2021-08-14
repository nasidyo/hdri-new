<?php 
function loadYears($conn){
    $sql2="
      SELECT tb.idYearTB,
      tb.nameYear +' ['+ FORMAT(tb.dateStart, 'dd/MMMM/yyyy','th') +' - '+ FORMAT(tb.dateStop, 'dd/MMMM/yyyy','th') +']' as displayYear
      FROM YearTB tb
      ORDER BY tb.idYearTB DESC
      ";
      $stmt = sqlsrv_query( $conn, $sql2);
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idYearTB"];
        $name_pre=$row["displayYear"];
        $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    echo $data;
}

?>