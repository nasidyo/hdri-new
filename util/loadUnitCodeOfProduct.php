<?php
    require '../connection/database.php';
    // SELECT cun.nameCountUnit
    // FROM Agri_TD ag, CountUnit cun
    // WHERE ag.unit_id = cun.idCountUnit 
    // and ag.idAgri = '".$_POST["agri_Id"]."'
    $data = "";
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2 = "
        SELECT cun.nameCountUnit
        FROM Agri_TD ag
        INNER JOIN CountUnit cun ON ag.unit_id = cun.idCountUnit
        WHERE ag.idAgri = '".$_POST["agri_Id"]."'
    ";
    $stmt = sqlsrv_prepare( $conn, $sql2 );
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $rows = sqlsrv_has_rows($stmt);
    if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $data = $row["nameCountUnit"];
        }
    }else{
        $data = "กิโลกรัม";
    }
    echo $data;
?>