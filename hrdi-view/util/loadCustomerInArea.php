<?php
 require '../connection/database.php';


 $db = new Database();
 $conn=  $db->getConnection();

if (isset($_GET['idArea'])) {
    $idArea = $_GET['idArea'];
}
if (isset($_GET['idMarket'])) {
    $idMarket = $_GET['idMarket'];
}

 $sql2=" SELECT ";
 $sql2.="   cm.idCustomerMarket, ";
 $sql2.="      cm.Customer_idCustomer, ";
 $sql2.="      cm.Market_idMarket, ";
 $sql2.="      cm.Area_idArea, ";
 $sql2.="      c.idCustomer, ";
 $sql2.="      concat( m.nameMarket,' (',c.c_name,')') name ";
 $sql2.="   FROM ";
 $sql2.="       CustomerMarket_TD cm , ";
 $sql2.="       Customer_TD c , ";
 $sql2.="       Market_TD m ";
 $sql2.="   WHERE ";
 $sql2.="       cm.Customer_idCustomer = c.idCustomer ";
 $sql2.="   AND cm.Market_idMarket = m.idMarket ";
 $sql2.="   AND     cm.Area_idArea =".$idArea." ";


 $stmt = sqlsrv_prepare($conn, $sql2);

 $data="";
 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre=$row["idCustomer"];
    $name_pre=$row["name"];
    if($id_pre != "0"){
        $data .= "<option value='$id_pre'> $name_pre</option>";
    }
 }
 echo $data;


?>
