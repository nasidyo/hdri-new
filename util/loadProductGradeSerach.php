<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
      SELECT gd.idGrade, gd.codeGrade
      FROM list_taget_agri ltg
      INNER JOIN Grade gd ON ltg.grade = gd.idGrade
      WHERE ltg.agri_id = '".$_POST["agri_Id"]."' and ltg.area_id = '".$_POST["area_Id"]."'
      ";
    $data="<option value='all'>เลือกทั้งหมด</option>";
    $stmt = sqlsrv_prepare( $conn, $sql2 );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["idGrade"];
      $name_pre=$row["codeGrade"];
      if($id_pre != "0"){
          $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    }
    echo $data;
?>