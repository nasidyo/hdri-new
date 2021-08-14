<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT lgsd.logisticImg_Id, lgsd.logistic_id, im.ImgPath, lgsd.idImgUpload
        FROM LogisticDeliver_TD lgsd
        INNER JOIN ImgUpload_TD im ON lgsd.idImgUpload = im.idImgTD
        WHERE lgsd.idPersonMarket = '".$_POST["dataId"]."' and lgsd.temp = 'y'
    ";
    $return_arr = array();
    $stmt = sqlsrv_query( $conn, $sql2 );
    if( !$stmt ) {
      die( print_r( sqlsrv_errors(), true));
    }  
    $rows = sqlsrv_has_rows($stmt);
    if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['logisticImg_Id'] = $row['logisticImg_Id'];
            $row_array['logistic_id'] = $row['logistic_id'];
            $row_array['ImgPath'] = $row['ImgPath'];
            $row_array['idImgUpload'] = $row['idImgUpload'];
            array_push($return_arr, $row_array);
        }
    }else{
        return true;
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>