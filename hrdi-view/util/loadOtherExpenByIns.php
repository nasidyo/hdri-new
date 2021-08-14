<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = " SELECT EXPENSE_OTHER_ID, EXPENSE_DETAIL, STATUS, COMMENT, INSTITUTE_ID FROM EXPENSE_OTHER_TD where INSTITUTE_ID  ='". $_GET["institute_id"]."'  and  STATUS ='Y'";
    $data = "";
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre = $row["EXPENSE_OTHER_ID"];
    $name_pre = $row["EXPENSE_DETAIL"];
    $data .= "<option value='$id_pre'>$name_pre</option>";
    }
    echo $data;

?>
