<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "SELECT toa.idTypeOfArgi, toa.nameTypeOfArgi
            FROM list_taget_agri ltg
            INNER JOIN TypeOfArgi_TD toa ON ltg.TypeOfArgi_idTypeOfArgi = toa.idTypeOfArgi
            WHERE ltg.area_id = '".$_POST["idArea"]."'
            GROUP BY idTypeOfArgi, nameTypeOfArgi";
    $stmt = sqlsrv_prepare( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $rows = sqlsrv_has_rows($stmt);
    $data = "<option value='all'>ทั้งหมด</option>";
    if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $id_pre=$row["idTypeOfArgi"];
            $name_pre=$row["nameTypeOfArgi"];
            $data .= "<option value='$id_pre'> $name_pre</option>";
        }
    }else{
        $sql2 = "
            SELECT idTypeOfArgi, nameTypeOfArgi
              FROM TypeOfArgi_TD
              ";
        $stmt2 = sqlsrv_query( $conn, $sql2);
        while( $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idTypeOfArgi"];
        $name_pre=$row["nameTypeOfArgi"];
        $data.= "<option value='$id_pre'> $name_pre</option>";
        }
    }
    echo $data;
?>