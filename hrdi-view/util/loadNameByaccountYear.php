<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $account_year_id =0;

    if (isset($_GET['account_year_id'])) {
     $account_year_id =$_GET['account_year_id'];
    }

    $sql2  ="   SELECT    ";
    $sql2  .="  a.areaName,    ";
    $sql2  .=" ins.INSTITUTE_NAME,    ";
    $sql2  .=" sp.sub_group_name ,    ";
    $sql2  .=" ay.year_text    ";
    $sql2  .=" FROM    ";
    $sql2  .=" SubPersonGroup sp ,    ";
    $sql2  .=" INSTITUTE ins,    ";
    $sql2  .=" Area a ,    ";
    $sql2  .=" AccountYear ay    ";
    $sql2  .=" WHERE    ";
    $sql2  .=" sp.institute_id = ins.INSTITUTE_ID    ";
    $sql2  .=" AND ins.AREA_ID =a.idArea    ";
    $sql2  .=" AND sp.sub_group_id =ay.sub_group_id    ";
    if($account_year_id!=0){
        $sql2.=" AND ay.account_year_id =".$institetu_id;
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
        $row_array['areaName'] = $row['areaName'];
        $row_array['INSTITUTE_NAME'] = $row['INSTITUTE_NAME'];
        $row_array['sub_group_name'] = $row['sub_group_name'];
        $row_array['year_text'] = $row['year_text'];

        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
