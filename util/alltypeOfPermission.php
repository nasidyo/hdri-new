<?php
  function loadAllOfPermission($conn){
        $sql = "
            SELECT permissionId, permissionName
            FROM TypeOfPermission
            ORDER BY permission_seq
              ";
          $stmt = sqlsrv_query( $conn, $sql);
          $data = "<option value='0'> กรุณาเลือก</option>";
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["permissionId"];
            $name_pre=$row["permissionName"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }    
          echo  $data;
  }
?>