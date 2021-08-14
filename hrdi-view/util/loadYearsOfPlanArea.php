<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2="
      SELECT tb.idYearTB, yt.YearTB_idYearTB,
      tb.nameYear +' ['+ FORMAT(tb.dateStart, 'dd/MMMM/yyyy','th') +' - '+ FORMAT(tb.dateStop, 'dd/MMMM/yyyy','th') +']' as displayYear
      FROM YearTarget yt
      INNER JOIN YearTB tb ON yt.YearTB_idYearTB = tb.idYearTB
      WHERE yt.Area_idArea = '".$_POST["area_Id"]."'
      ORDER BY tb.idYearTB DESC
      ";
      $stmt = sqlsrv_query( $conn, $sql2);
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idYearTB"];
        $name_pre=$row["displayYear"];
        $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    echo $data;

?>