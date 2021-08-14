<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $sql1 = " SELECT COUNT( DISTINCT pmk.Person_idPerson) as totalperson, ty.idTypeOfArgi, ty.nameTypeOfArgi
                FROM PersonMarket_TD pmk
                INNER JOIN TypeOfArgi_TD as ty ON pmk.TypeOfArgi_idTypeOfArgi = ty.idTypeOfArgi
                WHERE pmk.YearID = '".$_POST['yearsId']."' and pmk.Area_idArea = '".$_POST["area_Id"]."'
                GROUP BY idTypeOfArgi, nameTypeOfArgi
                ORDER BY totalperson DESC
    ";
    $stmt1 = sqlsrv_prepare($conn, $sql1 );
    if( !$stmt1 ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt1 ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $return_arr = array();
    while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idTypeOfArgi'] = $row1['idTypeOfArgi'];
        $row_array['nameTypeOfArgi'] = $row1['nameTypeOfArgi'];
        $row_array['TotalValue'] = $row1['totalperson'];
        array_push($return_arr, $row_array);
    }

    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
