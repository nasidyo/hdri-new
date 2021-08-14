<?php 
require '../connection/database.php';
        $sql2 = "
            SELECT *
            FROM TypeOfArgi_TD 
            WHERE idTypeOfArgi != '0' ";
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_query( $conn, $sql2 );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $return_arr = array();
        $count = 1;
        $Btn = "<div class='form-group row'><div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary agris active' onclick='return reportNewT.a1_onclick(0)' id='argi_0'>ทุกสาขา</button></center></div>";
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            if($count%4 == 0){
                if($count != 0){
                    $Btn .= "</div> <div class='form-group row'>";
                }
            }
            $Btn .="<div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary agris' onclick='return reportNewT.a1_onclick(".$row['idTypeOfArgi'].")' id='argi_".$row['idTypeOfArgi']."'>".$row['nameTypeOfArgi']."</button></center></div>";
            $count ++;
        }
        echo $Btn;
?>