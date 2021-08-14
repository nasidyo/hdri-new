<?php 


  function loadTypeOfAgri($conn, $areaId){
      // $sql2 = "
      //   SELECT tag.idTypeOfArgi, tag.nameTypeOfArgi
      //     FROM list_taget_agri lta
      //     INNER JOIN Agri_TD ag ON lta.agri_id = ag.idAgri
      //     INNER JOIN TypeOfArgi_TD tag ON ag.TypeOfArgi_idTypeOfArgi = tag.idTypeOfArgi
      //     WHERE lta.area_id = '".$areaId."'
      //     GROUP BY nameTypeOfArgi, idTypeOfArgi
      //     ";
      // $stmt = sqlsrv_query( $conn, $sql2 );
      // $data="<option value='0'>กรุณาเลือก</option>";
      // $rows = sqlsrv_has_rows($stmt);
      // if ($rows === true){
      //   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      //     $id_pre=$row["idTypeOfArgi"];
      //     $name_pre=$row["nameTypeOfArgi"];
      //     $data.= "<option value='$id_pre'> $name_pre</option>";
      //   }
      // }else{
        $sql = "
            SELECT idTypeOfArgi, nameTypeOfArgi
              FROM TypeOfArgi_TD
              ";
          $stmt = sqlsrv_query( $conn, $sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idTypeOfArgi"];
            $name_pre=$row["nameTypeOfArgi"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }
      // }
    echo  $data;
  }


?>