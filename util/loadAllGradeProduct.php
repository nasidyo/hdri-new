<?php
    function loadAllGradeProduct($conn){
      $sql2 = "
        SELECT idGrade ,codeGrade 
        FROM Grade ";
        $stmt = sqlsrv_query( $conn, $sql2 );
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          $id_pre=$row["idGrade"];
          $name_pre=$row["codeGrade"];
          $data .= "<option value='$id_pre'> $name_pre</option>";
        }
      echo $data;
    }
?>