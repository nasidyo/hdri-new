<?php 


  function loadAllTypeOfAgri($conn){
        $sql = "
            SELECT idTypeOfArgi, nameTypeOfArgi
              FROM TypeOfArgi_TD
              ";
          $stmt = sqlsrv_query( $conn, $sql);
          $data = "<option value='0'> กรุณาเลือก</option>";
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idTypeOfArgi"];
            $name_pre=$row["nameTypeOfArgi"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }    
          echo  $data;
  }
?>