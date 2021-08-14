<?php
      require '../connection/database.php';
      $db = new Database();
      $conn=  $db->getConnection();
      $sql2 = "
        SELECT idGrade ,codeGrade 
        FROM Grade ";
        $stmt = sqlsrv_query( $conn, $sql2 );
        $data = "<option value='ALL'>ทั้งหมด</option>";
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $id_pre=$row["idGrade"];
          $name_pre=$row["codeGrade"];
          $data .= "<option value='$id_pre'> $name_pre</option>";
        }
      echo $data;
?>