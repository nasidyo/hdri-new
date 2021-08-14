<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT idArea, areaName FROM Area WHERE target_area_type_id in (3,10 ,5) and RiverBasin_idRiverBasin =". $_POST["idRiverBasin"];
 $stmt = sqlsrv_query( $conn, $sql2 );
$data="<option value='0'>กรุณาเลือก</option>";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["idArea"];
   $name_pre=$row["areaName"];
   $data .="<option value='$id_pre'> $name_pre</option>";
   
 }
 echo  $data;

?>