<?php 
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql = "
      SELECT lgoa.grade_id
      FROM listGradeOfAgri lgoa
      INNER JOIN Grade gd ON lgoa.grade_id = gd.idGrade
      WHERE lgoa.agri_id = '".$_POST["agri_id"]."' 
      ";
    $stmt = sqlsrv_prepare( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $data = null;
    $rows = sqlsrv_has_rows($stmt);
    $return_arr = array();
    if ($rows === true){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($return_arr, $row["grade_id"]);
        }
    }else{
        array_push($return_arr, "0");
    }
    echo json_encode($return_arr);
?>