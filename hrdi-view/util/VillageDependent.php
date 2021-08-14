<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2="  SELECT     CONVERT ( int ,VILL_CODE  )   VILL_CODE , VILL_T FROM V_CODE_VILLAGE WHERE PROV_CODE = ".$_POST["PROV_CODE"]." AND AMP_CODE=".$_POST["AMP_CODE"]." AND TAM_CODE = ".$_POST["TAM_CODE"]." order by VILL_CODE ";
 $stmt = sqlsrv_query( $conn, $sql2 );
$data="<option value='0'>กรุณาเลือก</option>";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["VILL_CODE"];
   $name_pre=$row["VILL_T"];
   $data .="<option value='$id_pre'> $name_pre</option>";
   
 }
 echo  $data;

?>