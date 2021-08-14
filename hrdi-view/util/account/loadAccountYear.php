<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sub_group_id=0;
 if (isset($_GET['sub_group_id'])) {
    $sub_group_id = $_GET['sub_group_id'];
  }
 $sql2="  SELECT DISTINCT a.year_text, a.account_year_id FROM AccountYear a ";
 if( $sub_group_id!=0){
    $sql2 .=" where a.sub_group_id  = ".$sub_group_id." ORDER BY a.year_text ";
 }


 $stmt = sqlsrv_query( $conn, $sql2 );
$data="<option value='0'>กรุณาเลือก</option>";
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $id_pre=$row["account_year_id"];
   $name_pre=$row["year_text"];
   $data .="<option value='$id_pre'> $name_pre</option>";

 }
 echo  $data;

?>
