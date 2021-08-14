<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT lgd.idPersonMarket, img.idImgTD, img.ImgPath, img.TypeGroupName, img.ImgName
          FROM LogisticDeliver_TD lgd
          LEFT JOIN ImgUpload_TD img on lgd.idImgUpload = img.idImgTD
          WHERE lgd.idPersonMarket = '".$_POST["idPersonMarket"]."' and img.TypeGroupName = 'Logistic'
        ";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $data = array();
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        array_push($data, $row);
      }
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    //echo  $data;
?>