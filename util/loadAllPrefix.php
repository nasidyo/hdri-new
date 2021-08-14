<?php
  function loadPrefix($conn){
        $sql = "
            SELECT idPrefix, prefixNameTh
              FROM Prefix_TD
              ";
          $stmt = sqlsrv_query( $conn, $sql);
          $data = "<option value='0'> กรุณาเลือก</option>";
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idPrefix"];
            $name_pre=$row["prefixNameTh"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }    
          echo  $data;
  }
?>