<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT *
            FROM TypeOfArgi_TD ty
            WHERE ty.idTypeOfArgi != '0'";
    $return_arr = array();
    $stmt = sqlsrv_prepare($conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idTypeOfArgi'] = $row['idTypeOfArgi'];
        $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];

        $sql1 = " SELECT COUNT( DISTINCT pmk.Person_idPerson) as totalperson
                    FROM PersonMarket_TD pmk
                    WHERE pmk.YearID = '".$_POST['yearsId']."' and pmk.Area_idArea = '".$_POST["area_Id"]."' AND pmk.TypeOfArgi_idTypeOfArgi ='".$row['idTypeOfArgi']."'
        ";
        $stmt1 = sqlsrv_prepare($conn, $sql1 );
        if( !$stmt1 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt1 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            $row_array['TotalValue'] = $row1['totalperson'];
            array_push($return_arr, $row_array);
        }
    }

    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
