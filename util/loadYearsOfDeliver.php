<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2 = "
     SELECT pmk.YearID, ytb.nameYear +' ['+ FORMAT(ytb.dateStart, 'dd/MMMM/yyyy','th') +' - '+ FORMAT(ytb.dateStop, 'dd/MMMM/yyyy','th') +']' as displayYear
       FROM PersonMarket_TD pmk
       INNER JOIN YearTB ytb ON pmk.YearID = ytb.idYearTB
       WHERE pmk.Area_idArea = '".$_POST["area_Id"]."' and pmk.MonthNo != '".$_POST["thisMonth"]."'
       GROUP BY pmk.YearID, ytb.nameYear, ytb.dateStart, ytb.dateStop";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="<option value='0'>กรุณาเลือก</option>";
    $rows = sqlsrv_has_rows($stmt);
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["YearID"];
      $name_pre=$row["displayYear"];
      $data .="<option value='$id_pre'> $name_pre</option>";
    }
 echo  $data;


?>