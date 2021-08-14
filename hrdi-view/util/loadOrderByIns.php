<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = " SELECT o.ORDER_ID, CONCAT( o.ORDER_NAME ,' (', cu.nameCountUnit,')') ORDER_NAME FROM ORDER_TD o, CountUnit cu WHERE o.STATUS ='Y' and o.UNIT_ID = cu.idCountUnit AND o.INSTITUTE_ID  ='". $_POST["institute_id"]."'";
    $data = "<option value='0'>ทั้งหมด</option>";
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre = $row["ORDER_ID"];
    $name_pre = $row["ORDER_NAME"];
    $data .= "<option value='$id_pre'>$name_pre</option>";
    }
    echo $data;

?>
