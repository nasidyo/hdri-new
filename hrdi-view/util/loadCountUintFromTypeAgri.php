<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "
        SELECT gct.idCountUnit, cu.nameCountUnit
        FROM GroupCountUnitArgi as gct
        INNER JOIN CountUnit as cu ON gct.idCountUnit = cu.idCountUnit
        WHERE idTypeOfArgi = '".$_POST["typeOfAgri_Id"]."'";
      $stmt = sqlsrv_query( $conn, $sql );
      $data = "<option value='0'>กรุณาเลือก</option>";
      $rows = sqlsrv_has_rows($stmt);
      if ($rows === true){
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idCountUnit"];
            $name_pre=$row["nameCountUnit"];
            $data .= "<option value='$id_pre'> $name_pre</option>";
          }
      }else{
        $data .= "<option value='13'> กิโลกรัม</option>";
      }
    echo $data;
?>