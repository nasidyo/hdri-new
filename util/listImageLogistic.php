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
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $data.="<tr id='".$row['idImgTD']."'>";
          $data.="<td><img src='".$row['ImgPath']."' style=' height: 150px;float: left;'></td>";
          $data.="<td><button type='button' class='btn btn-danger' id='deleteImageBtn' name='deleteImageBtn' style='margin-top: 50px'><i class='fa fa-minus-square-o' data-toggle='tooltip' title='ลบรูปนี้'></i></button></td>";
        $data.="</tr>";
      }
    echo  $data;
?>