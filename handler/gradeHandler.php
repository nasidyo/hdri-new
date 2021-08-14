<?php
require_once '../service/GradeProductService.php';
require_once '../model/GradeM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        if($action=='createGrade'){
            if (isset($_POST['gradeName'])) {
                $gradeM = new GradeM();
                $seqService = new SeqService();
                $seqGradeId = $seqService->get("grade_seq_id");
                $gradeM->setIdGrade($seqGradeId);
                $gradeM->setCodeGrade(urldecode($_POST['gradeName']));
                $GradeProductService = new GradeProductService();
                $GradeProductService->createGradeProduct($gradeM);
            }
        }else if($action=='loadGrade'){
            if (isset($_POST['gradeId'])) {
                $GradeProductService = new GradeProductService();
                $GradeProductService->loadGradeProduct($_POST['gradeId']);
            }
        }else if($action == 'editGrade'){
            $gradeM = new GradeM();
            if (isset($_POST['gradeId'])) {
                $gradeM->setIdGrade($_POST['gradeId']);
            }
            if (isset($_POST['gradeName'])) {
                $gradeM->setCodeGrade(urldecode($_POST['gradeName']));
            }
            $GradeProductService = new GradeProductService();
            $GradeProductService->editGradeProduct($gradeM);
        }else if ($action == 'removeItem'){
            $GradeProductService = new GradeProductService();
            $GradeProductService->removeGradeItem($_POST['gradeId']);
        }

    }
}

?>
