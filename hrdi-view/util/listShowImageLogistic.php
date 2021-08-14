<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT lgd.idPersonMarket, img.ImgPath, img.TypeGroupName, img.idImgTD
          FROM LogisticDeliver_TD lgd
          LEFT JOIN ImgUpload_TD img on lgd.idImgUpload = img.idImgTD
          WHERE lgd.idPersonMarket = '".$_POST["idPersonMarket"]."' and img.TypeGroupName = 'Logistic'
        ";
      $stmt = sqlsrv_query( $conn, $sql2 );
      $data="";
      $countNumber = '0';
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $data.="<tr id='".$row['idImgTD']."'>";
          $data.="<td><img src='".$row['ImgPath']."' style=' height: 150px;float: left;'></td>";
        $data.="</tr>";
      }
    echo  $data;
?>