<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $sql = "SELECT top 7 a2.idArea, a2.target_name , sum(pmt.TotalValue) as total
                FROM PersonMarket_TD pmt 
                INNER JOIN Area a2 ON a2.idArea = pmt.Area_idArea 
                WHERE pmt.YearID = '".$_POST["yearsId"]."'
                GROUP BY a2.target_name, a2.idArea
                ORDER BY total DESC";
    $stmt = sqlsrv_query( $conn, $sql);
    $data = '';
    $count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        // $data .= "<tr><td>".$row['target_name']."</td><td>".number_format($row['total'])."</td></tr>";
        $data .="<tr><td><a href='report-Target.php?area_Id=".$row["idArea"]."&yearsId=".$_POST["yearsId"]."'>".$row['target_name']."</td><td>".number_format($row['total'])."</td></tr>";
    }
    echo $data;
?>