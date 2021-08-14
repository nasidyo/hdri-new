<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT firstName +' '+ lastName as fullname, idPerson
        FROM Person_TD
        WHERE Area_idArea = '".$_POST["agri_Id"]."'
    ";
    $data = "<option value='0'>กรุณาเลือก</option>";
    $stmt = sqlsrv_query( $conn, $sql2 );
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre = $row["idPerson"];
      $name_pre = $row["fullname"];
      $data .= "<option value='$id_pre'>$name_pre</option>";
    }
  echo $data;
?>