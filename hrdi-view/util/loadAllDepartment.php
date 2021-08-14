<?php
  function loadDepartment($conn){
        $sql = "
            SELECT vld.org_lvl1_id, vld.department
              FROM vLoadDetailStaff vld
              GROUP BY org_lvl1_id, department
              ";
          $stmt = sqlsrv_query( $conn, $sql);
          $data = "<option value='0'> ไม่มีสังกัด</option>";
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["org_lvl1_id"];
            $name_pre=$row["department"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }    
          echo  $data;
  }
?>