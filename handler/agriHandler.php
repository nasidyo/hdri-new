<?php
require_once '../service/AgriService.php';
require_once '../model/AgriM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        if($action=='addAgri'){
            $AgriM = new AgriM();
            $seqService = new SeqService();
            $seqAgri= $seqService->get("agri_TD_seq");
            $AgriM->setIdAgri((int)$seqAgri);
            if (isset($_POST['typeOfAgri_Id'])) {
                $AgriM->setTypeOfArgi_idTypeOfArgi($_POST['typeOfAgri_Id']);
            }
            if (isset($_POST['agriName'])) {
                $AgriM->setNameArgi(urldecode($_POST['agriName']));
            }
            // if (isset($_POST['speciesArgi'])) {
            //     $AgriM->setSpeciesArgi(urldecode($_POST['speciesArgi']));
            // }
            if (isset($_POST['idTypeOfStand'])) {
                $AgriM->setTypeOfStandId($_POST['idTypeOfStand']);
            }
            if (isset($_POST['contUnitId'])) {
                $AgriM->setContUnitId($_POST['contUnitId']);
            }
            $AgriService = new AgriService();
            $AgriService->addNewAgri($AgriM);
            echo $_POST['listSpecies'];
            if (isset($_POST['listSpecies'])){
                foreach($_POST['listSpecies'] as $speciesValue) {
                    $speciesId= $seqService->get("species_Id_seq");
                    echo $speciesId;
                    echo $speciesValue['speciesName'];
                    $AgriService->addNewSpeciesAgri($seqAgri, $speciesValue['speciesName'], $speciesId);
                }
            }
            if (isset($_POST['speciesArgi']) && $_POST['speciesArgi'] != null && $_POST['speciesArgi'] != ''){
                $speciesId= $seqService->get("species_Id_seq");
                $AgriService->addNewSpeciesAgri($seqAgri, $_POST['speciesArgi'], $speciesId);
            }
            if(isset($_POST['gradeList'])){
                foreach($_POST['gradeList'] as $dataGrade) {
                    $seqService = new SeqService();
                    $seqlistGrade = $seqService->get("list_grade_agri_seq");
                    $AgriM->setListTagetId((int)$seqlistGrade);
                    $AgriM->setIdAgri($seqAgri);
                    $AgriM->setGradeId($dataGrade);
                    $AgriService = new AgriService();
                    $AgriService->createGradeAgri($AgriM);
                }
            }

        }
        if($action=='update'){
            $AgriM = new AgriM();
            if (isset($_POST['agri_id'])) {
                $AgriM->setIdAgri($_POST['agri_id']);
            }
            if (isset($_POST['agriName'])) {
                $AgriM->setNameArgi($_POST['agriName']);
            }
            // if (isset($_POST['speciesArgi'])) {
            //     $AgriM->setSpeciesArgi($_POST['speciesArgi']);
            // }
            if (isset($_POST['typeOfAgri_Id'])) {
                $AgriM->setTypeOfArgi_idTypeOfArgi($_POST['typeOfAgri_Id']);
            }
            if (isset($_POST['idTypeOfStand'])) {
                $AgriM->setTypeOfStandId($_POST['idTypeOfStand']);
            }
            if (isset($_POST['contUnitId'])) {
                $AgriM->setContUnitId($_POST['contUnitId']);
            }
            $AgriService = new AgriService();
            $AgriService->updateAgri($AgriM);

            if (isset($_POST['listSpecies'])){
                foreach($_POST['listSpecies'] as $speciesValue) {
                    $AgriService->updateSpeciesAgri($_POST['agri_id'], $speciesValue['speciesName'], $speciesValue['datanumber']);
                }
            }

            if (isset($_POST['gradeList'])){
                $AgriService->checklistGradeAgri($_POST['agri_id'], $_POST['gradeList']);
                foreach($_POST['gradeList'] as $dataGrade) {
                    $AgriService->updateGradeAgri ($_POST['agri_id'], $dataGrade);
                }
            }
            // if (isset($_POST['speciesArgi'])){
            //     $seqService = new SeqService();
            //     $speciesId= $seqService->get("species_Id_seq");
            //     $AgriService->addNewSpeciesAgri($_POST['agri_id'], $_POST['speciesArgi'], $speciesId);
            // }
        }
        if($action=='delete'){
            if (isset($_POST['agri_id'])) {
                $agri_id = (int)$_POST['agri_id'];
                $AgriService = new AgriService();
                $AgriService->delAgri($agri_id);
            }
        }
        if($action=='load'){
            if (isset($_POST['agri_id'])) {
                $agri_id = (int)$_POST['agri_id'];
                $AgriService = new AgriService();
                $AgriService->loadDetailAgri($agri_id);
            }
        }
        if ($action == 'addTargetAgri') {
            $AgriM = new AgriM();
            if(isset($_POST['idArea'])) {
                $AgriM->setAreaId($_POST['idArea']);
            }
            if(isset($_POST['typeOfAgri'])) {
                $AgriM->setTypeOfArgi_idTypeOfArgi($_POST['typeOfAgri']);
            }
            if(isset($_POST['agriList'])){
                foreach($_POST['agriList'] as $dataAgri) {
                    if(isset($_POST['gradeList'])){
                        foreach($_POST['gradeList'] as $dataGrade) {
                            $seqService = new SeqService();
                            $seqAgri= $seqService->get("list_taget_agri_TD_seq");
                            $AgriM->setListTagetId((int)$seqAgri);
                            $AgriM->setIdAgri($dataAgri);
                            $AgriM->setGradeId($dataGrade);
                            $AgriService = new AgriService();
                            $AgriService->createTargetAgri($AgriM);
                        }
                    }
                }
            }
        }
        if ($action == 'loadTarget') {
            if (isset($_POST['list_target_agri_id'])) {
                $list_target_agri_id = (int)$_POST['list_target_agri_id'];
                $AgriService = new AgriService();
                $AgriService->loadDetailTargetAgri($list_target_agri_id);
            }
        }
        if($action == 'updateTargetAgri'){
            $AgriM = new AgriM();
            if (isset($_POST['list_taget_agri_Id'])) {
                $AgriM->setListTagetId($_POST['list_taget_agri_Id']);
            }
            if (isset($_POST['gradeId'])) {
                $AgriM->setGradeId($_POST['gradeId']);
            }
            $AgriService = new AgriService();
            $AgriService->updateTargetAgri($AgriM);
        }
        if($action == 'deleteTargetAgri'){
            if (isset($_POST['list_target_agri_id'])) {
                $list_target_agri_id = (int)$_POST['list_target_agri_id'];
                $AgriService = new AgriService();
                $AgriService->delTargetAgri($list_target_agri_id);
            }
        }
        if($action == 'addAgriPlan') {
            if(isset($_POST['agriList'])){
                foreach($_POST['agriList'] as $dataAgri) {
                    if(isset($_POST['unit_plan_List'])){
                        foreach($_POST['unit_plan_List'] as $unitplan_Id) {
                            $seqService = new SeqService();
                            $seqAgri = $seqService->get("unit_plan_id_seq");
                            $AgriService = new AgriService();
                            $AgriService->createTargetAgriPlan($seqAgri, $dataAgri, $unitplan_Id);
                        }
                    }
                }
            }
        }
        if ($action == 'loadTargetPlan') {
            if (isset($_POST['unit_plan_id'])) {
                $unit_plan_id = (int)$_POST['unit_plan_id'];
                $AgriService = new AgriService();
                $AgriService->loadTargetAgriPlan($unit_plan_id);
            }
        }
        if ($action == 'updateTargetAgriPlan') {
            if (isset($_POST['unit_plan_id'])) {
                $unit_plan_id = (int)$_POST['unit_plan_id'];
                $AgriService = new AgriService();
                $AgriService->updateTargetAgriPlan($unit_plan_id, $_POST['taget_unit_id']);
            }
        }
        if ($action == 'deleteTargetAgri') {
            if (isset($_POST['unit_plan_id'])) {
                $unit_plan_id = (int)$_POST['unit_plan_id'];
                $AgriService = new AgriService();
                $AgriService->delTargetAgriPlan($unit_plan_id);
            }
        }
        if ($action == 'deleteSpecies') {
            if (isset($_POST['species_Id'])) {
                $species_Id = (int)$_POST['species_Id'];
                $AgriService = new AgriService();
                $AgriService->delSpeciesItem($species_Id);
            }
        }
    }

}




?>
