
<?php 
    require_once '../connection/database.php';
    require_once '../model/LandM.php';
   require_once '../model/LandDetailM.php';

    Class LandDetailService {
        
        public function createLandDetail($LandM){
            $sql  =" INSERT INTO Land_Detail (land_detail_id, person_id, land_no, x, y, z, unit1, unit2, unit3, unit4) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $LandM->getIdLand(),
                $LandM->getPerson_id() ,
                $LandM->getLandnumber() ,
                $LandM->getAxisX(),
                $LandM->getAxisY(),
                $LandM->getAxisZ(),
                $LandM->getUnit1(),
                $LandM->getUnit2(),
                $LandM->getUnit3(),
                $LandM->getUnit4()
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }
        public function LoadLandDetail ($id){
            $sql  ="SELECT ld.land_detail_id, ld.person_id, ld.land_no, ld.x, ld.y, ld.z, ld.unit1, ld.unit2, ld.unit3, ld.unit4, p.Area_idArea, a.fbasin_id
            FROM Land_Detail as ld 
            INNER JOIN Person_TD as p ON ld.person_id = p.idPerson
            INNER JOIN vLinkAreaDetail as a ON p.Area_idArea = a.target_id
            WHERE ld.land_detail_id =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($id));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $LandM = new LandM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $LandM->setIdLand($row['land_detail_id']);
                $LandM->setPerson_id($row['person_id']);
                $LandM->setLandnumber($row['land_no']);
                $LandM->setAxisX($row['x']);
                $LandM->setAxisY($row['y']);
                $LandM->setAxisZ($row['z']);
                $LandM->setUnit1($row['unit1']);
                $LandM->setUnit2($row['unit2']);
                $LandM->setUnit3($row['unit3']);
                $LandM->setUnit4($row['unit4']);
                $LandM->setidArea($row['Area_idArea']);
                $LandM->setRiverBasin($row['fbasin_id']);
            }
            echo json_encode($LandM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);
        }

        public function updateLandDetail($LandM) {
            $sql  =" UPDATE Land_Detail SET ";
            $sql.="  land_no =? , x=?, y=?, z=?, unit1=?, unit2=?, unit3=?, unit4=?  where land_detail_id =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $LandM->getLandnumber(),
                $LandM->getAxisX(),
                $LandM->getAxisY(),
                $LandM->getAxisZ(),
                $LandM->getUnit1(),
                $LandM->getUnit2(),
                $LandM->getUnit3(),
                $LandM->getUnit4(),
                $LandM->getIdLand()
            );
     
            $stmt = sqlsrv_prepare( $conn, $sql, $params);
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }


          public function loadLandDetailM($idPerson){

            $sql  =" SELECT land_detail_id, person_id, land_no, x, y, z, basin_quality_class, forest_area_classified, forest_type, forest_name, CASE WHEN IsNumeric(CONVERT(VARCHAR(12), unit1)) = 1 THEN CONVERT(VARCHAR(12),unit1) ELSE 0 END unit1 , CASE WHEN IsNumeric(CONVERT(VARCHAR(12), unit2)) = 1 THEN CONVERT(VARCHAR(12),unit2) ELSE 0 END unit2 , CASE WHEN IsNumeric(CONVERT(VARCHAR(12), unit3)) = 1 THEN CONVERT(VARCHAR(12),unit3) ELSE 0 END unit3 , CASE WHEN IsNumeric(CONVERT(VARCHAR(12), unit4)) = 1 THEN CONVERT(VARCHAR(12),unit4) ELSE 0 END unit4 FROM Land_Detail where person_id=? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($idPerson));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $landDetailArr = [];
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $landDetail = new LandDetailM();
                $landDetail->setLandDetailId($row['land_detail_id']);
                $landDetail->setPersonId($row['person_id']);
                $landDetail->setLandNo($row['land_no']);
                $landDetail->setX($row['x']);
                $landDetail->setY($row['y']);
                $landDetail->setZ($row['z']);
                $landDetail->setBasinQualityClass($row['basin_quality_class']);
                $landDetail->setForestAreaClassified($row['forest_area_classified']);
                $landDetail->setForestType($row['forest_type']);
                $landDetail->setForestName($row['forest_name']);
                $landDetail->setPlots($row['unit1']);
                $landDetail->setRai($row['unit2']);
                $landDetail->setNgan($row['unit3']);
                $landDetail->setSqaureWa($row['unit4']);
                array_push($landDetailArr,$landDetail);
            }
            return  $landDetailArr;
            sqlsrv_close($conn);

     }

        public function delelandDetail($id){
            $sql  =" DELETE FROM Land_Detail WHERE land_detail_id = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($id));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
    }



?>