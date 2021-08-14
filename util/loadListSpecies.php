<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT species_Id as datanumber, species_name as speciesName
          FROM SpeciesArgi_TD
          WHERE Agri_idAgri = '".$_POST["agri_id"]."'
        ";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $data = array();
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        array_push($data, $row);
      }
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>