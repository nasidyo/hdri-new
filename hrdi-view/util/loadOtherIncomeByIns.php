<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = " SELECT INCOME_OTHER_ID, INCOME_DETAIL, STATUS, COMMENT, INSTITUTE_ID FROM INCOME_OTHER_TD where INSTITUTE_ID  ='". $_GET["institute_id"]."'  and  STATUS ='Y'";
    $data = "";
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre = $row["INCOME_OTHER_ID"];
    $name_pre = $row["INCOME_DETAIL"];
    $data .= "<option value='$id_pre'>$name_pre</option>";
    }
    echo $data;

?>
