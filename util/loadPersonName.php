<?php 
    require '../connection/database.php';
    
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT pex.prefixNameTh+' '+per.firstName +' '+ per.lastName as fullname
        FROM Person_TD per
        INNER JOIN Prefix_TD pex ON per.Prefix_idPrefix = pex.idPrefix
        LEFT JOIN ( SELECT YearTB_idYearTB, YearID, Area_idArea
            FROM YearTarget
            WHERE YearTB_idYearTB = (SELECT TOP 1 idYearTB
            FROM YearTB
            ORDER BY dateStart DESC)) yt ON per.Area_idArea = yt.Area_idArea
        WHERE per.idPerson = '".$_POST["personId"]."'
    ";
    $stmt = sqlsrv_query( $conn, $sql2 );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $return_arr = array();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $fullname= $row['fullname'];
    }
    echo $fullname;
?>