<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();

 $sql2=" SELECT ";
 $sql2.=" idGroupVillage , nameGroupVillage  ";
 $sql2.=" FROM GroupVillage ";
 $sql2.=" WHERE  1=1 ";
 if (isset($_GET['idArea'])) {
    $sql2 .= "AND idArea  =".$_GET['idArea'];
  }
  if (isset($_GET['idRiverBasin'])) {
    $sql2 .= " AND idRiverBasin  =".$_GET['idRiverBasin'];
  }
 $sql2.=" Order by nameGroupVillage ";
 $stmt = sqlsrv_prepare($conn, $sql2);

 $data="<option value='0'>กรุณาเลือก</option>";

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

    $id =$row['idGroupVillage'];
    $name= $row['nameGroupVillage'];
    $data .="<option value='$id'> $name</option>";
 }
 echo  $data;


?>
