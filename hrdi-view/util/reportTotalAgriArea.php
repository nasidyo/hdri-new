<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT pmk.TypeOfArgi_idTypeOfArgi, tya.nameTypeOfArgi, SUM(ISNULL(pmk.TotalValue,0)) TotalValue
            FROM PersonMarket_TD pmk
            INNER JOIN TypeOfArgi_TD tya ON pmk.TypeOfArgi_idTypeOfArgi = tya.idTypeOfArgi 
            WHERE pmk.YearID = '".$_POST['yearsId']."' and pmk.Area_idArea = '".$_POST["area_Id"]."'
            GROUP BY pmk.TypeOfArgi_idTypeOfArgi, tya.nameTypeOfArgi";
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idTypeOfArgi'] = $row['TypeOfArgi_idTypeOfArgi'];
        $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
        $row_array['TotalValue'] = $row['TotalValue'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
