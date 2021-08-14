<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    // $sql2 = "
    //     SELECT tyoa.idTypeOfArgi, tyoa.nameTypeOfArgi
    //     FROM RegisterAgri_TD rega
    //     INNER JOIN Agri_TD ag ON rega.idAgri = ag.idAgri
    //     INNER JOIN TypeOfArgi_TD tyoa ON ag.TypeOfArgi_idTypeOfArgi = tyoa.idTypeOfArgi
    //     WHERE rega.idPerson = '".$_POST["person_Id"]."' and rega.idArea='".$_POST["area_Id"]."'
    //     GROUP BY nameTypeOfArgi, idTypeOfArgi";
    //   $stmt = sqlsrv_query( $conn, $sql2 );
    //   $data="<option value='0'>กรุณาเลือก</option>";
    //   $rows = sqlsrv_has_rows($stmt);
    //   if ($rows === true){
    //     while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    //         $id_pre=$row["idTypeOfArgi"];
    //         $name_pre=$row["nameTypeOfArgi"];
    //         $data.= "<option value='$id_pre'> $name_pre</option>";
    //       }
    //   }else{
          // $sql = " SELECT tag.idTypeOfArgi, tag.nameTypeOfArgi
          // FROM list_taget_agri lta
          // INNER JOIN Agri_TD ag ON lta.agri_id = ag.idAgri
          // INNER JOIN TypeOfArgi_TD tag ON ag.TypeOfArgi_idTypeOfArgi = tag.idTypeOfArgi
          // WHERE lta.area_id = '".$_POST["area_Id"]."'
          // GROUP BY nameTypeOfArgi, idTypeOfArgi
          // ";
          $data="<option value='0'>กรุณาเลือก</option>"; //comment when uncommnet topline
          // $stmt2 = sqlsrv_query( $conn, $sql);
          // $rows2 = sqlsrv_has_rows($stmt2);
          // if($rows2 === true){
          //     while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
          //       $id_pre=$row2["idTypeOfArgi"];
          //       $name_pre=$row2["nameTypeOfArgi"];
          //       $data.= "<option value='$id_pre'> $name_pre</option>";
          //     }
          // }else{
            $sql3 = "
              SELECT idTypeOfArgi, nameTypeOfArgi
              FROM TypeOfArgi_TD
              ";
              $stmt3 = sqlsrv_query( $conn, $sql3);
              while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
                $id_pre=$row3["idTypeOfArgi"];
                $name_pre=$row3["nameTypeOfArgi"];
                $data.= "<option value='$id_pre'> $name_pre</option>";
              }
          // }
      // }
    echo $data;
?>