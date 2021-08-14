<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "
        SELECT species_Id, species_name
        FROM SpeciesArgi_TD
        WHERE Agri_idAgri = ".$_POST["argi_id"];
      $stmt = sqlsrv_query( $conn, $sql);
      $data="<option value='0'>ไม่มี</option>";
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["species_Id"];
        $name_pre=$row["species_name"];
        $data .="<option value='$id_pre'>$name_pre</option>";
      }
    echo  $data;
?>