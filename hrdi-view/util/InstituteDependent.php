<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT INSTITUTE_ID, INSTITUTE_NAME, AREA_ID, STATUS FROM INSTITUTE where AREA_ID =". $_GET["idArea"];
 $stmt = sqlsrv_query( $conn, $sql2 );
 $data ="";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["INSTITUTE_ID"];
   $name_pre=$row["INSTITUTE_NAME"];
   $data .="<option value='$id_pre'> $name_pre</option>";

 }
 echo  $data;

?>
