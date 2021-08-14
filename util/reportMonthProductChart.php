<?php
    require '../connection/database.php';
    $db = new Database();
    $yearsId = $_POST["yearsId"];
    $conn=  $db->getConnection();
    $sql = "SELECT psmk.TypeOfArgi_idTypeOfArgi, toa.nameTypeOfArgi
            FROM PersonMarket_TD psmk
            INNER JOIN TypeOfArgi_TD toa ON psmk.TypeOfArgi_idTypeOfArgi=toa.idTypeOfArgi
            WHERE psmk.YearID = '".$yearsId."'
            GROUP BY TypeOfArgi_idTypeOfArgi, nameTypeOfArgi";
    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
    $rowtable = "";
    $theader = "<th rowspan='2'>รายสาขา</th>";
    $theaderRow = "";
    $checkFristRow = "N";
    $return_arr1 = array();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
          $sql2 = "
              SELECT moy.Month_id, COALESCE(SUM(psmk.TotalValue),'0') AS totalIncome , moy.Month_Etc, moy.Month_seq
              FROM MonthOfYear moy
              LEFT JOIN ( SELECT TotalValue, MonthNo, Area_idArea
              FROM PersonMarket_TD pmk";
                $sql2 .=" WHERE TypeOfArgi_idTypeOfArgi='".$row['TypeOfArgi_idTypeOfArgi']."' and YearID = '".$yearsId."') psmk ON moy.Month_id = psmk.MonthNo ";
                $sql2.= "GROUP BY Month_id, Month_Etc, Month_seq
                    ORDER BY Month_seq
          ";
          $stmt2 = sqlsrv_query( $conn, $sql2);
          $dataset = [];
          while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
              array_push($dataset, $row2['totalIncome']);
          }
          $row_array['dataset'] = $dataset;
          array_push($return_arr, $row_array);
    }
    // array_push($return_arr, $row_array);
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>