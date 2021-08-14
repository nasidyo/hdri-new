<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $sub_group_id =0;

    if (isset($_GET['sub_group_id'])) {
     $sub_group_id = intval($_GET['sub_group_id']);
    }


    $sql2  ="     SELECT  TOP 1  ";
    $sql2  .="  ay.account_year_id,  ";
    $sql2  .="  ay.account_year_start,  ";
    $sql2  .="  ay.account_year_end,  ";
    $sql2  .="  ay.status,  ";
    $sql2  .="  ay.current_bugget,  ";
    $sql2  .="  ay.sub_group_id,  ";
    $sql2  .="  ay.bank_bugget,  ";
    $sql2  .="  ay.stocks_amount,  ";
    $sql2  .="  ay.stocks_price,  ";
    $sql2  .="  ay.year_text  ";
    $sql2  .=" FROM  ";
    $sql2  .="    AccountYear ay ,  ";
    $sql2  .="   SubPersonGroup sp  ";
    $sql2  .=" WHERE  ";
    $sql2  .="   ay.sub_group_id = sp.sub_group_id  ";
    $sql2  .="   and ay.status <>'Y'    ";

        $sql2.=" and  ay.sub_group_id  = ".$sub_group_id;

    $sql2  .="    order by ay.year_text desc    ";



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
        $row_array['year_text'] = $row['year_text'];
        $row_array['current_bugget'] = $row['current_bugget'];
        $row_array['bank_bugget'] = $row['bank_bugget'];
        $row_array['stocks_amount'] = $row['stocks_amount'];
        $row_array['stocks_price'] = $row['stocks_price'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
