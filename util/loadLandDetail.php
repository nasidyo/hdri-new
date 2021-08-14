<?php
  require '../connection/database.php';
  $db = new Database();
  $conn=  $db->getConnection();
    $sql2 = "
      SELECT lan.land_detail_id, 'แปลง พื้นที่:'+ COALESCE(lan.unit1,'0')+'ไร่-'+COALESCE(lan.unit2,'0')+'งาน -'+COALESCE(lan.unit3,'0')+'ตารางวา' as coordinat
      FROM Land_Detail lan
      WHERE lan.person_id = '".$_POST["person_Id"]."'";
      $data="<option value='0'>ไม่เลือกพื้นที่</option>";
    $stmt = sqlsrv_query( $conn, $sql2 );
    if( !$stmt ) {
      die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $id_pre=$row["land_detail_id"];
      $name_pre=$row["coordinat"];
      $data .= "<option value='$id_pre'> $name_pre</option>";
      echo $id_pre."<br/>";
    }
  echo $data;
?>