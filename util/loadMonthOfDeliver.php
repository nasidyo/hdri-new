<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2 = "
     SELECT pmk.MonthNo, moy.Month_name as displayYear
       FROM PersonMarket_TD pmk
       INNER JOIN MonthOfYear moy ON pmk.MonthNo = moy.Month_id
       WHERE pmk.Area_idArea = '".$_POST["area_Id"]."' and pmk.YearID = '".$_POST["yearsOfDeliver"]."'
       GROUP BY pmk.MonthNo, moy.Month_name";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="<option value='0'>กรุณาเลือก</option>";
    $rows = sqlsrv_has_rows($stmt);
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["MonthNo"];
      $name_pre=$row["displayYear"];
      $data .="<option value='$id_pre'> $name_pre</option>";
    }
 echo  $data;


?>