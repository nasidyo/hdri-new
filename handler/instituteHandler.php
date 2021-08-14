<?php
require_once '../service/InstituteService.php';
require_once '../model/InstituteM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $instituteM = new InstituteM();
            $seqService = new SeqService();
            $seqinsitetu= $seqService->get("institute_id");

            $instituteM->setInstituteId( $seqinsitetu);

            if (isset($_POST['institute_name'])) {
                $instituteM->setInstituteName($_POST['institute_name']);
            }
            if (isset($_POST['area_id'])) {
                $instituteM->setAreaId($_POST['area_id']);
            }
            if (isset($_POST['status'])) {
                $instituteM->setStatus($_POST['status']);
            }
           $instituteService = new InstituteService();
           $instituteService->addInsitute($instituteM);

        }
        if($action=='update'){
            $instituteM = new InstituteM();

            if (isset($_POST['institute_id'])) {
                $instituteM->setInstituteId($_POST['institute_id']);
            }

            if (isset($_POST['institute_name'])) {
                $instituteM->setInstituteName($_POST['institute_name']);
            }
            if (isset($_POST['area_id'])) {
                $instituteM->setAreaId($_POST['area_id']);
            }
            if (isset($_POST['status'])) {
                $instituteM->setStatus($_POST['status']);
            }

            $instituteService = new InstituteService();
            $instituteService->updateInsitute($instituteM);
        }


        if($action=='delete'){
            if (isset($_POST['institute_id'])) {
                $institute_id = $_POST['institute_id'];
                $instituteService = new InstituteService();
                $instituteService->delInsitute($institute_id);
              }
        }

        if($action=='load'){
            if (isset($_POST['institute_id'])) {
                $institute_id = (int)$_POST['institute_id'];
                $instituteService = new InstituteService();
                $instituteService->loadInsitute($institute_id);
              }
        }

    }

}




?>
