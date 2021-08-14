<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    // $sql2 = "
    //     SELECT ag.idAgri, 
    //     CASE 
    //     WHEN ag.speciesArgi = '' THEN ag.nameArgi
    //     WHEN ag.speciesArgi IS NULL THEN ag.nameArgi  
    //     ELSE ag.nameArgi+'(พันธุ์:'+ag.speciesArgi+')' END as nameOFArgi
    //     FROM RegisterAgri_TD rega
    //     INNER JOIN Agri_TD ag ON rega.idAgri = ag.idAgri
    //     INNER JOIN TypeOfArgi_TD tyoa ON ag.TypeOfArgi_idTypeOfArgi = tyoa.idTypeOfArgi
    //     WHERE rega.idArea='".$_POST["area_Id"]."' and tyoa.idTypeOfArgi='".$_POST["tpyeOfAgri_Id"]."'
    //     GROUP BY idAgri, nameArgi" ;
        
    //   $stmt = sqlsrv_query( $conn, $sql2 );
      $data="<option value='0'>กรุณาเลือก</option>";
    //   $rows = sqlsrv_has_rows($stmt);
    //   if ($rows === true){
    //     while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    //       $id_pre=$row["idAgri"];
    //       $name_pre=$row["nameOFArgi"];
    //       $data .="<option value='$id_pre'> $name_pre</option>";
    //     }
    //   }else{
        $sql = "
            SELECT idAgri, 
            CASE 
            WHEN speciesArgi = '' THEN nameArgi
            WHEN speciesArgi IS NULL THEN nameArgi  
            ELSE nameArgi+'(พันธุ์:'+speciesArgi+')' END as nameOFArgi
              FROM Agri_TD
              WHERE TypeOfArgi_idTypeOfArgi = '".$_POST["tpyeOfAgri_Id"]."'
            ";
          $stmt = sqlsrv_query( $conn, $sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idAgri"];
            $name_pre=$row["nameOFArgi"];
            $data.= "<option value='$id_pre'> $name_pre</option>";
          }
      // }
    echo $data;

?>