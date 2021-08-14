<?php
  function loadAllTypeOfTragetPaln($conn){
        $sql = "
            SELECT idTypeOfTarget, nameTypeOfTarget
            FROM TypeOfTarget
            ORDER BY idTypeOfTarget
              ";
          $stmt = sqlsrv_query( $conn, $sql);
          $data = "";
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idTypeOfTarget"];
            $name_pre=$row["nameTypeOfTarget"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }    
          echo  $data;
  }
?>