<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT idArea, areaName FROM Area WHERE target_area_type_id in (3,10 ,5) and RiverBasin_idRiverBasin in (". $_POST["idRiverBasin"].")"." and idArea in ( ".$_POST["idArea"].")";
 $stmt = sqlsrv_query( $conn, $sql2 );
 $data="";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["idArea"];
   $name_pre=$row["areaName"];
   $data .="<option value='$id_pre'> $name_pre</option>";

 }
 echo  $data;

?>
