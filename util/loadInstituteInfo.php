<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $institetu_id =0;

    if (isset($_GET['institetu_id'])) {
     $institetu_id =$_GET['institetu_id'];
    }

    $sql2  ="     SELECT    ";
    $sql2  .="       a.idArea,  ";
    $sql2  .="       a.areaName,   ";
    $sql2  .="       a.RiverBasin_idRiverBasin,  ";
    $sql2  .="       rb.nameRiverBasin,  ";
    $sql2  .="       ins.INSTITUTE_ID,  ";
    $sql2  .="       ins.INSTITUTE_NAME  ";
    $sql2  .="   FROM  ";
    $sql2  .="       INSTITUTE ins ,  ";
    $sql2  .="       Area a ,  ";
    $sql2  .="       RiverBasin rb  ";
    $sql2  .="   WHERE  ";
    $sql2  .="       ins.AREA_ID =a.idArea  ";
    $sql2  .="   AND a.RiverBasin_idRiverBasin = rb.idRiverBasin  ";
    $sql2  .="   and ins.STATUS = 'Y'  ";
    if($institetu_id!=0){
        $sql2.=" and ins.INSTITUTE_ID  = ".$institetu_id;
    }


    $return_arr = array();
    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql2 );

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idArea'] = $row['idArea'];
        $row_array['areaName'] = $row['areaName'];
        $row_array['RiverBasin_idRiverBasin'] = $row['RiverBasin_idRiverBasin'];
        $row_array['nameRiverBasin'] = $row['nameRiverBasin'];
        $row_array['INSTITUTE_ID'] = $row['INSTITUTE_ID'];
        $row_array['INSTITUTE_NAME'] = $row['INSTITUTE_NAME'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
