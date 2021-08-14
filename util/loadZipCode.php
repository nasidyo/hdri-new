<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();

 $sql2=' select  z.zipcode  from Zipcode_TD z where  z.districtCode = '.$_GET["districtCode"];
 $stmt = sqlsrv_query( $conn, $sql2 );
$data="";
 if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $data =$row["zipcode"];
 }
 echo  $data;

?>
