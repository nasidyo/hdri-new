
<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $sub_group_id =0;

    if (isset($_GET['sub_group_id'])) {
     $sub_group_id =$_GET['sub_group_id'];
    }

    $sql2  ="     SELECT    ";
    $sql2  .="     a.idArea, ";
    $sql2  .="       a.areaName, ";
    $sql2  .="       a.RiverBasin_idRiverBasin, ";
    $sql2  .="       rb.nameRiverBasin, ";
    $sql2  .="       ins.INSTITUTE_ID, ";
    $sql2  .="       ins.INSTITUTE_NAME, ";
    $sql2  .="       sp.sub_group_id, ";
    $sql2  .="      sp.sub_group_name ";
    $sql2  .="   FROM ";
    $sql2  .="       INSTITUTE ins , ";
    $sql2  .="       SubPersonGroup sp , ";
    $sql2  .="      Area a , ";
    $sql2  .="      RiverBasin rb ";
    $sql2  .="   WHERE ";
    $sql2  .="       ins.INSTITUTE_ID = sp.institute_id ";
    $sql2  .="   AND ins.AREA_ID =a.idArea ";
    $sql2  .="   AND a.RiverBasin_idRiverBasin = rb.idRiverBasin ";
    $sql2  .="   AND ins.STATUS = 'Y' ";
    if( $sub_group_id !=0){
        $sql2.=" and sp.sub_group_id  = ".$sub_group_id ;
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
        $row_array['sub_group_id'] = $row['sub_group_id'];
        $row_array['sub_group_name'] = $row['sub_group_name'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
