<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $sql = "SELECT t1.YearID, t1.totalsale, t2.totalpaln, t1.totalVSale,  t2.totalVplan
        FROM (
            SELECT SUM(pmt.TotalValue) as totalsale, pmt.YearID , (SUM(pmt.Volumn)/1000) as totalVSale
                FROM PersonMarket_TD pmt
                GROUP BY pmt.YearID ) t1,
            (SELECT tpt.YearTarget_YearID , SUM(tpt.Total) as totalpaln, (SUM(tpt.Weight)/1000) as totalVplan
                FROM TargetPlan_TD tpt 
                GROUP BY tpt.YearTarget_YearID )t2 
                WHERE t1.YearID = t2.YearTarget_YearID";
    $stmt = sqlsrv_query( $conn, $sql);
    $return_arr = array();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['YearID'] = $row['YearID'];
        $row_array['totalsale'] = $row['totalsale'];
        $row_array['totalVSale'] = $row['totalVSale'];
        $row_array['totalpaln'] = $row['totalpaln'];
        $row_array['totalVplan'] = $row['totalVplan'];
        array_push($return_arr, $row_array);
    }
    echo json_encode($return_arr);
?>