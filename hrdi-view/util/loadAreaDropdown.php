<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "
      SELECT mtag.target_id, mtag.target_area_type_title+' '+mtag.target_name as fullTargetName
      FROM vLinkAreaDetail mtag
      WHERE mtag.fbasin_id = '".$_POST["idRiverBasin"]."' and mtag.target_area_type_id in (3,10,5)
      ";
    if($_POST["idArea"] != "" || $_POST["idArea"] != 0){
        $sql.=" and mtag.target_id IN (".$_POST["idArea"].")";
    }
    $sql.="GROUP BY target_id, target_area_type_title, target_name";
    $stmt = sqlsrv_prepare( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $data = "<option value='0'>กรุณาเลือก</option>";
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["target_id"];
      $name_pre=$row["fullTargetName"];
      if($id_pre != "0"){
          $data .= "<option value='$id_pre'> $name_pre</option>";
      }
    }
    echo $data;
?>