<?php
    require_once '../connection/database.php';
    require_once '../model/PlantHouseM.php';

    Class PlantHouseService{
        public function addPlantHouse($PlantHouseM){
            $sql  =" INSERT INTO PlantHouse_TD ( plantHouse_Id, Area_idArea, idLand, houseNumber ) ";
            $sql  .=" VALUES ( ?, ?, ?, ? ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $PlantHouseM->getPlantHouseId(),
               $PlantHouseM->getAreaId(),
               $PlantHouseM->getIdLand(),
               $PlantHouseM->getHouseNumber()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function editPlantHouse($PlantHouseM){
            $sql  =" UPDATE PlantHouse_TD SET idLand = ?, houseNumber = ?";
            $sql  .=" WHERE plantHouse_Id = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $PlantHouseM->getIdLand(),
                $PlantHouseM->getHouseNumber(),
                $PlantHouseM->getPlantHouseId()
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

         public function loadPlantHouse($Id){

            $sql = "SELECT ph.plantHouse_Id, ph.Area_idArea, ph.idLand, ph.houseNumber, a.idRiverBasin, l.person_id ";
            $sql.= "FROM PlantHouse_TD as ph ";
            $sql.= "INNER JOIN Land_Detail as l ON ph.idLand = l.land_detail_id ";
            $sql.= "INNER JOIN MainTarget as a ON ph.Area_idArea = a.idArea ";
            $sql.= "WHERE ph.plantHouse_Id =? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $PlantHouseM = new PlantHouseM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $PlantHouseM->setPlantHouseId($row['plantHouse_Id']);
                $PlantHouseM->setAreaId($row['Area_idArea']);
                $PlantHouseM->setIdLand($row['idLand']);
                $PlantHouseM->setHouseNumber($row['houseNumber']);
                $PlantHouseM->setIdPerson($row['person_id']);
                $PlantHouseM->setIdRiverBasin($row['idRiverBasin']);
            }
            echo json_encode($PlantHouseM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function delPlantHouse($id){

        $sql  =" DELETE FROM PlantHouse_TD WHERE plantHouse_Id = ? ";

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
