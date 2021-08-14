<?php
    require '../connection/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $yearsId = $_POST["yearsId"];
    $basinId = $_POST["basinId"];
    $areaId = $_POST["areaId"];
    $return_arr = array();
    if($basinId == '0'){
        $sql = "SELECT a.target_area_type_id , a.areaType , SUM (pmt.TotalValue ) as totalValue
                FROM Area a 
                INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
                WHERE a.target_area_type_id in (3,5,10) and pmt.YearID ='".$yearsId."' 
                GROUP BY a.target_area_type_id , a.areaType";
        $stmt = sqlsrv_prepare($conn, $sql );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['id'] = $row['target_area_type_id'];
            $row_array['name'] = $row['areaType'];
            $row_array['totalValue'] = $row['totalValue'];
            array_push($return_arr, $row_array);
        }
    }else{
        $sql = "SELECT a.target_name , a.idArea , SUM (pmt.TotalValue ) as totalValue
                FROM Area a
                INNER JOIN PersonMarket_TD pmt ON a.idArea = pmt.Area_idArea 
                WHERE a.target_area_type_id in (3,5,10) and pmt.YearID ='".$yearsId."' and a.target_area_type_id = '".$basinId."'
                Group by a.target_name, a.idArea
                ORDER BY totalValue DESC";

        $stmt = sqlsrv_prepare($conn, $sql );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['id'] = $row['idArea'];
            $row_array['name'] = $row['target_name'];
            $row_array['totalValue'] = $row['totalValue'];
            array_push($return_arr, $row_array);
        }
    }
    echo json_encode($return_arr);
?>