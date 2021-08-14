<?php 
function loadAllargiDropdown($conn){
    $sql = "SELECT ta.idTypeOfArgi, ta.nameTypeOfArgi
            FROM TypeOfArgi_TD ta 
            WHERE ta.idTypeOfArgi NOT IN ('0')
            ORDER BY ta.idTypeOfArgi";
    $stmt = sqlsrv_prepare( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $data = '';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $data .= '<optgroup label="'.$row['nameTypeOfArgi'].'">';
            $sql2 = "SELECT ag.idAgri, ag.nameArgi
                    FROM Agri_TD ag
                    WHERE ag.TypeOfArgi_idTypeOfArgi = '".$row['idTypeOfArgi']."'";
                    $stmt2 = sqlsrv_prepare( $conn, $sql2);
                    if( !$stmt2 ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt2 ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                        $id_pre=$row2["idAgri"];
                        $name_pre=$row2["nameArgi"];
                        if($id_pre != "0"){
                            $data .= "<option value='$id_pre'> $name_pre</option>";
                        }
                    }
        $data .='</optgroup>';
    }
    // $sql = "
    //   SELECT mtag.target_id, mtag.target_area_type_title+' '+mtag.target_name as fullTargetName
    //   FROM vLinkAreaDetail mtag
    //   WHERE mtag.fbasin_id = '".$_POST["idRiverBasin"]."' and mtag.target_area_type_id in (3,10,5)
    //   ";
    // if($_POST["idArea"] != "" || $_POST["idArea"] != 0){
    //     $sql.=" and mtag.target_id IN (".$_POST["idArea"].")";
    // }
    // $sql.="GROUP BY target_id, target_area_type_title, target_name";
    // $stmt = sqlsrv_prepare( $conn, $sql);
    // if( !$stmt ) {
    //     die( print_r( sqlsrv_errors(), true));
    // }
    // if( sqlsrv_execute( $stmt ) === false ) {
    //     die( print_r( sqlsrv_errors(), true));
    // }
    // $data = "<option value='0'>กรุณาเลือก</option>";
    // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    //   $id_pre=$row["target_id"];
    //   $name_pre=$row["fullTargetName"];
    //   if($id_pre != "0"){
    //       $data .= "<option value='$id_pre'> $name_pre</option>";
    //   }
    // }
    echo $data;
};
?>