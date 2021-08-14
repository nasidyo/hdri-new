<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT AMP_CODE ,AMP_T FROM V_CODE_AMPHUR where PROV_CODE =". $_POST["PROV_CODE"];
 $stmt = sqlsrv_query( $conn, $sql2 );
$data="<option value='0'>กรุณาเลือก</option>";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["AMP_CODE"];
   $name_pre=$row["AMP_T"];
   $data .="<option value='$id_pre'> $name_pre</option>";
   
 }
 echo  $data;

?>