<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];
    $return_arr = array();
    if($basinId == '0'){
        $sql = "SELECT toa.idTypeOfArgi, toa.nameTypeOfArgi, SUM (pmt.TotalValue ) as totalValue 
                FROM TypeOfArgi_TD toa
                INNER JOIN  PersonMarket_TD pmt ON toa.idTypeOfArgi = pmt.TypeOfArgi_idTypeOfArgi
                WHERE  pmt.YearID ='".$yearsId."'
                GROUP BY toa.idTypeOfArgi, toa.nameTypeOfArgi";
        $stmt = sqlsrv_prepare($conn, $sql );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['id'] = $row['idTypeOfArgi'];
            $row_array['name'] = $row['nameTypeOfArgi'];
            $row_array['totalValue'] = $row['totalValue'];
            array_push($return_arr, $row_array);
        }
    }else{
        $sql = "SELECT toa.idTypeOfArgi, toa.nameTypeOfArgi, vlad.fbasin_name, SUM (pmt.TotalValue ) as totalValue 
                FROM TypeOfArgi_TD toa
                INNER JOIN  PersonMarket_TD pmt ON toa.idTypeOfArgi = pmt.TypeOfArgi_idTypeOfArgi
                INNER JOIN  vLinkAreaDetail vlad ON vlad.target_id = pmt.Area_idArea
                WHERE vlad.target_area_type_id in (3,5,10) AND vlad.fbasin_id NOT IN (1,22) and pmt.YearID ='".$yearsId."' and vlad.fbasin_id = '".$basinId."'
                GROUP BY toa.idTypeOfArgi, toa.nameTypeOfArgi, vlad.fbasin_name";
        $stmt = sqlsrv_prepare($conn, $sql );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['display'] = $row['fbasin_name'];
            $row_array['id'] = $row['idTypeOfArgi'];
            $row_array['name'] = $row['nameTypeOfArgi'];
            $row_array['totalValue'] = $row['totalValue'];
            array_push($return_arr, $row_array);
        }
        // $sql = "SELECT vlad.target_name , vlad.target_id , SUM (pmt.TotalValue ) as totalValue
        //         FROM vLinkAreaDetail vlad 
        //         INNER JOIN PersonMarket_TD pmt ON vlad.target_id = pmt.Area_idArea 
        //         WHERE vlad.target_area_type_id in (3,5,10) AND vlad.fbasin_id NOT IN (1,22) and pmt.YearID ='".$yearsId."' and vlad.fbasin_id = '".$basinId."'
        //         Group by vlad.target_name, vlad.target_id";

        // $stmt = sqlsrv_prepare($conn, $sql );
        // if( !$stmt ) {
        //     die( print_r( sqlsrv_errors(), true));
        // }
        // if( sqlsrv_execute( $stmt ) === false ) {
        //     die( print_r( sqlsrv_errors(), true));
        // }
        // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        //     $row_array['id'] = $row['target_id'];
        //     $row_array['name'] = $row['target_name'];
        //     $row_array['totalValue'] = $row['totalValue'];
        //     array_push($return_arr, $row_array);
        // }
    }
    echo json_encode($return_arr);
?>