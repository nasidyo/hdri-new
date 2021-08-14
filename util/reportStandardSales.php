<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $sql = "SELECT tos.nameTypeOfStand ,tos.idTypeOfStand , (SUM(pmt.Volumn)/1000) as volumnt
          FROM PersonMarket_TD pmt 
          INNER JOIN TypeOfStand tos ON pmt.TypeOfStand_idTypeOfStand = idTypeOfStand 
          WHERE pmt.YearID = '".$yearsId."'
          GROUP BY tos.idTypeOfStand , nameTypeOfStand 
        ";
    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
  
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idTypeOfStand'] = $row['idTypeOfStand'];
        $row_array['nameTypeOfStand'] = $row['nameTypeOfStand'];
        $row_array['volumt'] = $row['volumnt'];
        array_push($return_arr, $row_array);
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>