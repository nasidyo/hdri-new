<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $month = $_POST["month"];
    $sql ="SELECT toat.nameTypeOfArgi , toat.idTypeOfArgi , sum(Volumn) as volumt
            FROM PersonMarket_TD pmt 
            INNER JOIN TypeOfArgi_TD toat ON pmt.TypeOfArgi_idTypeOfArgi = toat.idTypeOfArgi 
            WHERE pmt.YearID = '".$yearsId."' and pmt.MonthNo ='".$month."' 
            GROUP BY toat.idTypeOfArgi , toat.nameTypeOfArgi
            ORDER BY toat.idTypeOfArgi";
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idTypeOfArgi'] = $row['idTypeOfArgi'];
        $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
        $row_array['volumt'] = $row['volumt'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);

    // $sql = "SELECT pmk.TypeOfArgi_idTypeOfArgi, tya.nameTypeOfArgi, SUM(ISNULL(pmk.TotalValue,0)) TotalValue
    //         FROM PersonMarket_TD pmk
    //         INNER JOIN TypeOfArgi_TD tya ON pmk.TypeOfArgi_idTypeOfArgi = tya.idTypeOfArgi 
    //         WHERE pmk.YearID = '".$_POST['yearsId']."'
    //         GROUP BY pmk.TypeOfArgi_idTypeOfArgi, tya.nameTypeOfArgi";
    // $return_arr = array();
    // $stmt = sqlsrv_prepare($conn, $sql );
    // if( !$stmt ) {
    //     die( print_r( sqlsrv_errors(), true));
    // }
    // if( sqlsrv_execute( $stmt ) === false ) {
    //     die( print_r( sqlsrv_errors(), true));
    // }
    // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    //     $row_array['idTypeOfArgi'] = $row['TypeOfArgi_idTypeOfArgi'];
    //     $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
    //     $row_array['TotalValue'] = $row['TotalValue'];
    //     array_push($return_arr, $row_array);
    // }
    // sqlsrv_close($conn);
    // echo json_encode($return_arr);
?>
