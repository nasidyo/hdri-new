<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT
            business_group_id,
            business_group_name
        FROM BusinessGroup
          WHERE sub_group_id = ".$_POST["sub_group_id"]." and  status='Y' ";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $data="";
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["business_group_id"];
        $name_pre=$row["business_group_name"];
        $data .="<option value='$id_pre'> $name_pre</option>";
      }
    echo  $data;

?>
