<?php 
function loadAllMarketDropdown($conn){
    $sql = "SELECT mk.idMarket, mk.nameMarket
            FROM Market_TD mk 
            ORDER BY mk.idMarket";
    $stmt = sqlsrv_prepare( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $data = '';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idMarket"];
        $name_pre=$row["nameMarket"];
        if($id_pre != "0"){
            $data .= "<option value='$id_pre'> $name_pre</option>";
        }
    }
    echo $data;
};
?>