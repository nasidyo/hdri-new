
<?php 
    require_once '../connection/database.php';
    require_once '../model/villageLevelM.php';

    Class villageLevelService {
        
        public function createVillageLevel($villageLevelM){
            $sql  =" INSERT INTO list_vill_level_TD (list_vill_level_id, idArea, idGroupVillage, level) VALUES ( ?, ?, ?, ?)";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $villageLevelM->getVillageLevelId(),
                $villageLevelM->getAreaId() ,
                $villageLevelM->getGroupVillageId() ,
                $villageLevelM->getlevel()
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }
        public function LoadvillageLevel ($id){
            $sql = "SELECT lvl.list_vill_level_id, lvl.idArea, lvl.idGroupVillage, lvl.level, a.fbasin_id
                FROM list_vill_level_TD as lvl 
                INNER JOIN vLinkAreaDetail as a ON lvl.idArea = a.target_id
                WHERE lvl.list_vill_level_id =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($id));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $villageLevelM = new villageLevelM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $villageLevelM->setVillageLevelId($row['list_vill_level_id']);
                $villageLevelM->setAreaId($row['idArea']);
                $villageLevelM->setGroupVillageId($row['idGroupVillage']);
                $villageLevelM->setlevel($row['level']);
                $villageLevelM->setIdRiverBasin($row['fbasin_id']);
            }
            echo json_encode($villageLevelM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);
        }

        public function updateVillage($villageLevelM) {
            $sql  =" UPDATE list_vill_level_TD SET ";
            $sql.="  level =? where list_vill_level_id =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $villageLevelM->getlevel(),
                $villageLevelM->getVillageLevelId(),
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
        public function delevillageDetail($id){
            $sql  =" DELETE FROM list_vill_level_TD WHERE list_vill_level_id = ? ";
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