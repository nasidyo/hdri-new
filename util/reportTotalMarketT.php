<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $typeAgri = $_POST["typeAgri"];
    if($typeAgri != '0'){
        $sql = "SELECT pmk.Market_idMarket, mk.nameMarket, tya.nameTypeOfArgi as nameDisplay, SUM(ISNULL(pmk.TotalValue,0)) TotalValue
            FROM PersonMarket_TD pmk
            INNER JOIN Market_TD mk ON pmk.Market_idMarket = mk.idMarket
            INNER JOIN TypeOfArgi_TD tya ON pmk.TypeOfArgi_idTypeOfArgi = tya.idTypeOfArgi 
            WHERE pmk.YearID = '".$_POST['yearsId']."' and pmk.TypeOfArgi_idTypeOfArgi = '".$typeAgri."'
            GROUP BY pmk.Market_idMarket, mk.nameMarket, tya.nameTypeOfArgi
            ORDER BY TotalValue DESC";
    }else{
        $sql = "SELECT pmk.Market_idMarket, mk.nameMarket, SUM(ISNULL(pmk.TotalValue,0)) TotalValue
            FROM PersonMarket_TD pmk
            INNER JOIN Market_TD mk ON pmk.Market_idMarket = mk.idMarket 
            WHERE pmk.YearID = '".$_POST['yearsId']."'
            GROUP BY pmk.Market_idMarket, mk.nameMarket
            ORDER BY TotalValue DESC";
    }
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        if($typeAgri != '0'){
            $row_array['nameDisplay'] = $row['nameDisplay'];
        }
        $row_array['idMarket'] = $row['Market_idMarket'];
        $row_array['nameMarket'] = $row['nameMarket'];
        $row_array['TotalValue'] = $row['TotalValue'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>