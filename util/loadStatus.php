<?php
    function loadStatuslist($conn){
      $sql2=" SELECT idSendStatus, nameSendStatus FROM SendStatus_TD WHERE idSendStatus NOT IN ('0')";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $data="<option value='0'>กรุณาเลือก</option>";
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idSendStatus"];
        $name_pre=$row["nameSendStatus"];
        $data.= "<option value='$id_pre'> $name_pre</option>";
      }
     echo  $data;
  }

?>