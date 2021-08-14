<?php 
function loadAllareaDropdown($conn){
    $sql = "SELECT mb.idRiverBasin, mb.nameRiverBasin
            FROM MainBasin mb 
            WHERE mb.idRiverBasin NOT IN ('1','22')
            ORDER BY mb.nameRiverBasin";
    $stmt = sqlsrv_prepare( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $data = '';
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $data .= '<optgroup label="'.$row['nameRiverBasin'].'">';
            $sql2 = "SELECT mt.idArea, mt.target_name
                    FROM MainTarget mt
                    WHERE mt.idRiverBasin ='".$row['idRiverBasin']."' AND mt.target_area_type_id IN (3,10,5)
                    ORDER BY mt.target_name";
                    $stmt2 = sqlsrv_prepare( $conn, $sql2);
                    if( !$stmt2 ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt2 ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                        $id_pre=$row2["idArea"];
                        $name_pre=$row2["target_name"];
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