<?php
    require_once '../connection/database.php';
    require_once '../model/AgriM.php';
    require_once '../service/SeqService.php';

    Class AgriService {
        public function addNewAgri($AgriM){
            $sql  =" INSERT";
            $sql  .="  INTO Agri_TD ( idAgri, TypeOfStand_idTypeOfStand, TypeOfArgi_idTypeOfArgi, GrowLocate_idGrowLocate, nameArgi, unit_id, speciesArgi)
            values (  ?, ?, ?, ?, ?, ? ,? ) ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $AgriM->getIdAgri(),
               $AgriM->getTypeOfStandId(),
               $AgriM->getTypeOfArgi_idTypeOfArgi(),
               '0',
               $AgriM->getNameArgi(),
               $AgriM->getContUnitId(),
               $AgriM->getSpeciesArgi()

            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

        }

        public function updateAgri($AgriM){
            $sql  =" UPDATE";
            $sql  .="     Agri_TD ";
            $sql  .=" SET ";
            $sql  .="     nameArgi  = ?, ";
            $sql  .="     speciesArgi  = ? , ";
            $sql  .="     TypeOfStand_idTypeOfStand  = ? , ";
            $sql  .="     TypeOfArgi_idTypeOfArgi  = ?, ";
            $sql  .="     unit_id  = ?, ";
            $sql  .="     GrowLocate_idGrowLocate  = ? ";
            $sql  .=" WHERE";
            $sql  .="    idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $AgriM->getNameArgi(),
                $AgriM->getSpeciesArgi(),
                $AgriM->getTypeOfStandId(),
                $AgriM->getTypeOfArgi_idTypeOfArgi(),
                $AgriM->getContUnitId(),
                '0',
                $AgriM->getIdAgri()
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

        public function loadDetailAgri($Id){

            $sql  ="  SELECT      ";
            $sql  .="   idAgri, ";
            $sql  .="   nameArgi, ";
            $sql  .="   speciesArgi, ";
            $sql  .="   TypeOfStand_idTypeOfStand , ";
            $sql  .="   TypeOfArgi_idTypeOfArgi, ";
            $sql  .="   unit_id ";
            $sql  .=" FROM ";
            $sql  .="   Agri_TD ";
            $sql  .="  where idAgri = ?  ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $AgriM = new AgriM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $AgriM->setIdAgri($row['idAgri']);
                $AgriM->setNameArgi($row['nameArgi']);
                $AgriM->setSpeciesArgi($row['speciesArgi']);
                $AgriM->setTypeOfStandId($row['TypeOfStand_idTypeOfStand']);
                $AgriM->setTypeOfArgi_idTypeOfArgi($row['TypeOfArgi_idTypeOfArgi']);
                $AgriM->setContUnitId($row['unit_id']);
            }
            echo json_encode($AgriM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);
        }

        public function delAgri($id){
            //start delete form plan 
            $sql1  =" DELETE FROM TargetPlan_TD WHERE Agri_idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt1 = sqlsrv_prepare($conn, $sql1, array($id));
            if( !$stmt1 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt1 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            //end delete form plan 

            //start delete form deliver
            $sql2  =" DELETE FROM PersonMarket_TD WHERE Agri_idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt2 = sqlsrv_prepare($conn, $sql2, array($id));
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt2 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            //end delete form deliver

            //start delete form estimate
            $sql3  =" DELETE FROM OutputValueCast_TD WHERE Agri_idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt3 = sqlsrv_prepare($conn, $sql3, array($id));
            if( !$stmt3 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt3 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $sql4  =" DELETE FROM OutputValue_TD WHERE Agri_idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt4 = sqlsrv_prepare($conn, $sql4, array($id));
            if( !$stmt4 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt4 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            //end delete form estimate

            //start delete form list of garde
            $sql5  =" DELETE FROM listGradeOfAgri WHERE agri_id = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt5 = sqlsrv_prepare($conn, $sql5, array($id));
            if( !$stmt5 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt5 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            //end

            //start delete form species
            $sql6  =" DELETE FROM SpeciesArgi_TD WHERE Agri_idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt6 = sqlsrv_prepare($conn, $sql6, array($id));
            if( !$stmt6 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt6 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            //end

            $sql7  =" DELETE FROM Agri_TD WHERE idAgri = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt7 = sqlsrv_prepare($conn, $sql7, array($id));
            if( !$stmt7 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt7 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
    // public function delAgri($id){

    //     $sql  =" DELETE FROM Agri_TD WHERE idAgri = ? ";

    //     $db = new Database();
    //     $conn=  $db->getConnection();
    //     $stmt = sqlsrv_prepare($conn, $sql, array($id));

    //     if( !$stmt ) {
    //         die( print_r( sqlsrv_errors(), true));
    //     }
    //     if( sqlsrv_execute( $stmt ) === false ) {
    //         die( print_r( sqlsrv_errors(), true));
    //     }
    // }

    public function createTargetAgri($AgriM) {
        $sql  =" INSERT";
        $sql  .=" INTO list_taget_agri ( list_taget_agri_id, area_id, agri_id, grade, TypeOfArgi_idTypeOfArgi)
        values ( ?, ?, ?, ?, ? ) ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $AgriM->getListTagetId(),
            $AgriM->getAreaId(),
            $AgriM->getIdAgri(),
            $AgriM->getGradeId(),
            $AgriM->getTypeOfArgi_idTypeOfArgi()
        ));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function loadDetailTargetAgri($Id){
        $sql  ="  SELECT      ";
        $sql  .="   lta.list_taget_agri_id, ";
        $sql  .="   lta.area_id, ";
        $sql  .="   lta.agri_id, ";
        $sql  .="   lta.grade , ";
        $sql  .="   lta.TypeOfArgi_idTypeOfArgi, ";
        $sql  .="   lakd.fbasin_id ";
        $sql  .=" FROM ";
        $sql  .="   list_taget_agri as lta";
        $sql .=" INNER JOIN vLinkAreaDetail as lakd ON lta.area_id = lakd.target_id";
        $sql  .="  where lta.list_taget_agri_id = ?  ";
        $sql .="GROUP BY fbasin_id, list_taget_agri_id, area_id, agri_id, grade, TypeOfArgi_idTypeOfArgi";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $AgriM = new AgriM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $AgriM->setAreaId($row['area_id']);
            $AgriM->setIdAgri($row['agri_id']);
            $AgriM->setGradeId($row['grade']);
            $AgriM->setTypeOfArgi_idTypeOfArgi($row['TypeOfArgi_idTypeOfArgi']);
            $AgriM->setBasinId($row['fbasin_id']);
            $AgriM->setListTagetId($row['list_taget_agri_id']);
        }
        echo json_encode($AgriM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }

    public function updateTargetAgri ($AgriM){
        $sql  =" UPDATE";
        $sql  .="     list_taget_agri ";
        $sql  .=" SET ";
        $sql  .="     grade  = ? ";
        $sql  .=" WHERE";
        $sql  .="    list_taget_agri_id = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $params =array(
            $AgriM->getGradeId(),
            $AgriM->getListTagetId()
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
    public function delTargetAgri($id){
        $sql  =" DELETE FROM list_taget_agri WHERE list_taget_agri_id = ? ";

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

    public function createTargetAgriPlan($seqAgri, $dataAgri, $unitplan_Id){
        $sql  =" INSERT";
        $sql  .="  INTO list_taget_agri_unit_plan ( unit_plan_id, idAgri, taget_unit)
        values ( ?, ?, ?) ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $seqAgri,
            $dataAgri,
            $unitplan_Id
        ));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function loadTargetAgriPlan($id) {
        $sql  ="  SELECT      ";
        $sql  .="   lta.unit_plan_id, ";
        $sql  .="   lta.idAgri, ";
        $sql  .="   lta.taget_unit, ";
        $sql  .="   a.TypeOfArgi_idTypeOfArgi ";
        $sql  .=" FROM ";
        $sql  .="   list_taget_agri_unit_plan lta ";
        $sql  .=" INNER JOIN Agri_TD a ON lta.idAgri = a.idAgri";
        $sql  .="  where unit_plan_id = ?  ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $AgriM = new AgriM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $AgriM->setIdAgri($row['idAgri']);
            $AgriM->setTaget_unit($row['taget_unit']);
            $AgriM->setUnitplan_id($row['unit_plan_id']);
            $AgriM->setTypeOfArgi_idTypeOfArgi($row['TypeOfArgi_idTypeOfArgi']);
        }
        echo json_encode($AgriM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }

    public function updateTargetAgriPlan ($id, $value){
        $sql  =" UPDATE";
        $sql  .="     list_taget_agri_unit_plan ";
        $sql  .=" SET ";
        $sql  .="     taget_unit  = ? ";
        $sql  .=" WHERE";
        $sql  .="    unit_plan_id = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $params =array(
            $value,
            $id
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

    public function delTargetAgriPlan ($id){
        $sql  =" DELETE FROM list_taget_agri_unit_plan WHERE unit_plan_id = ? ";

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
    public function addNewSpeciesAgri ($idAgri, $speciesName, $id){
        echo $idAgri;
        echo "::::::".$speciesName."::::::";
        echo $id;
        $sql  =" INSERT";
        $sql  .="  INTO SpeciesArgi_TD ( species_Id, species_name, Agri_idAgri)
        values (  ?, ?, ?) ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $id,
            $speciesName,
            $idAgri
        ));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function delSpeciesItem ($id){
        $sql  =" DELETE FROM SpeciesArgi_TD WHERE species_Id = ? ";

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
    public function updateSpeciesAgri ($idAgri, $speciesName, $id){
        $sql  ="  SELECT      ";
        $sql  .="   sa.species_Id, ";
        $sql  .="   sa.species_name, ";
        $sql  .="   sa.Agri_idAgri";
        $sql  .=" FROM ";
        $sql  .=" SpeciesArgi_TD as sa WHERE sa.Agri_idAgri ='".$idAgri."' and sa.species_Id = '".$id."'";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows !== true){
            echo $speciesName;
            $seqService = new SeqService();
            $speciesId= $seqService->get("species_Id_seq");
            $speciesName = $speciesName;
            self:: addNewSpeciesAgri($idAgri, $speciesName, $speciesId);
        }
    }

    public function createGradeAgri ($AgriM){
        $sql  =" INSERT";
        $sql  .="  INTO listGradeOfAgri ( idGradeAgri, agri_id, grade_id)
        values (  ?, ?, ?) ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $AgriM->getListTagetId(),
            $AgriM->getIdAgri(),
            $AgriM->getGradeId()
        ));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function checklistGradeAgri($idAgri, $listGrade){
        $sql  =" DELETE FROM listGradeOfAgri  WHERE agri_id ='".$idAgri."' and grade_id NOT IN (".implode(",",$listGrade).")";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function updateGradeAgri ($idAgri, $id){
        $sql  ="  SELECT idGradeAgri ";
        $sql  .=" FROM ";
        $sql  .=" listGradeOfAgri WHERE agri_id ='".$idAgri."' and grade_id = '".$id."'";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows !== true){
            $seqService = new SeqService();
            $speciesId= $seqService->get("list_grade_agri_seq");
            self:: addNewGradeAgri($idAgri, $speciesId, $id);
        }
    }

    public function addNewGradeAgri ($idAgri, $id, $idGrade){
        $sql  =" INSERT";
        $sql  .="  INTO listGradeOfAgri ( idGradeAgri, agri_id, grade_id)
        values (  ?, ?, ?) ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $id, $idAgri, $idGrade
        ));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

}
?>