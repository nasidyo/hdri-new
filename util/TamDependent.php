<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 
 $sql2=' SELECT TAM_CODE, TAM_T FROM V_CODE_TAMBON where AMP_CODE = '.$_POST["AMP_CODE"].'and  PROV_CODE ='.$_POST["PROV_CODE"];
 $stmt = sqlsrv_query( $conn, $sql2 );
$data="<option value='0'>กรุณาเลือก</option>";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["TAM_CODE"];
   $name_pre=$row["TAM_T"];
   $data .="<option value='$id_pre'> $name_pre</option>";
   
 }
 echo  $data;

?>