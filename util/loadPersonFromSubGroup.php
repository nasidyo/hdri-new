<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "   SELECT pg.person_id , concat(p.firstName ,' ', p.lastName ) fullname FROM PersonGroup_TD pg , Person_TD p, SubPersonGroup sp WHERE pg.person_id = p.idPerson AND pg.sub_group_id = sp.sub_group_id and sp.sub_group_id = ". $_POST["sub_group_id"];
    $data = " <option value='0'>กรุณาเลือก</option>";
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre = $row["person_id"];
    $name_pre = $row["fullname"];
    $data .= "<option value='$id_pre'>$name_pre</option>";
    }
    echo $data;

?>
