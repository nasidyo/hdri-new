<?php 
    require '../connection/database.php';
    require '../classes/coordinates.class.php';
    $db = new Database();
    if(isset($_POST['idRiverBasin'])){
        $idBasin = $_POST['idRiverBasin'];
    }
    if(isset($_POST['idArea'])){
        $idArea = $_POST['idArea'];
    }
    if(isset($_POST['person_id'])){
        $person_id = $_POST['person_id'];
    }
    if(isset($_POST['staffPermis'])){
      $staffPermis = $_POST['staffPermis'];
    }
    if(isset($_POST['areaAll'])){
        $areaAll = $_POST['areaAll'];
    }
    $table = "SELECT p.firstName +' '+ p.lastName as fullname, lad.target_area_type_title+' '+lad.target_name as fulltargetName, lad.fbasin_name,
        COALESCE(lan.unit1,'0')+'ไร่-'+COALESCE(lan.unit2,'0')+'งาน -'+COALESCE(lan.unit3,'0')+'ตารางวา' as coordinat ,
        lan.x, lan.y 
        FROM Land_Detail as lan 
        INNER JOIN Person_TD as p ON lan.person_id = p.idPerson 
        INNER JOIN vLinkAreaDetail as lad ON p.Area_idArea = lad.target_id 
        WHERE lan.land_detail_id IS NOT NULL ";
    if($idBasin != 'null' && $idBasin != 'undefined' && $idBasin != '0'){
        $table.= "and lad.fbasin_id = '".$idBasin."'";
    }
    if($idArea != 'null' and $idArea != 'undefined' and $idArea != '0'){
        $table.= "and lad.target_id = '".$idArea."'";
    }else{
        if($staffPermis == 'staff'){
            $table.= "and lad.target_id IN (".$areaAll.")";
        }
    }
    if($person_id != '0'){
        $table.= "and lan.person_id = '".$person_id."'";
    }
    $table.="GROUP BY land_detail_id, fbasin_name, target_area_type_title, target_name, land_no, firstName, lastName, unit1, unit2, unit3, lan.x, lan.y";
    $return_arr = array();
    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $table );

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        if($row['y'] != null and $row['x'] != null ){
          $llvalue = utm2ll($row['x'],$row['y'],47,true);
          $json = json_decode($llvalue,true);
          $subjson = json_decode(json_encode($json['attr']),true);
          $row_array['displayName'] = $row['fullname']."<br>".$row['fulltargetName']."<br>".$row['coordinat'];
          $row_array['latloung'] = json_encode($subjson['lat']);
          $row_array['loung'] = json_encode($subjson['lon']);
          array_push($return_arr, $row_array);
        }
    }
    sqlsrv_close($conn);
    echo json_encode($return_arr)

?>