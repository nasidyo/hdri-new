<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT
        sub_group_id,
        sub_group_name
        FROM SubPersonGroup
          WHERE institute_id = ".$_POST["institute_id"]." and  status='Y' ";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $data="";
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["sub_group_id"];
        $name_pre=$row["sub_group_name"];
        $data .="<option value='$id_pre'>$name_pre</option>";
      }
    echo  $data;

?>
