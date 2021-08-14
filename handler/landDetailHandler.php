<?php
require_once '../service/LandDetailService.php';
require_once '../model/LandM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        if($action=='addLandDetail'){
            $LandM = new LandM();
            $seqService = new SeqService();
            $land_seq = $seqService->get("land_id_seq");
            echo $land_seq;
            $LandM->setIdLand($land_seq);
            if(isset($_POST['person_id'])){
                $LandM->setPerson_id($_POST['person_id']);
            }
            if(isset($_POST['land_number'])){
                $LandM->setLandnumber($_POST['land_number']);
            }
            if(isset($_POST['axisx'])){
                $LandM->setAxisX($_POST['axisx']);
            }
            if(isset($_POST['axisy'])){
                $LandM->setAxisY($_POST['axisy']);
            }
            if(isset($_POST['axisz'])){
                $LandM->setAxisZ($_POST['axisz']);
            }
            if(isset($_POST['unit1'])){
                $LandM->setUnit1($_POST['unit1']);
            }
            if(isset($_POST['unit2'])){
                $LandM->setUnit2($_POST['unit2']);
            }
            if(isset($_POST['unit3'])){
                $LandM->setUnit3($_POST['unit3']);
            }
            if(isset($_POST['unit4'])){
                $LandM->setUnit4($_POST['unit4']);
            }
            $landDetailService = new LandDetailService();
            $landDetailService->createLandDetail($LandM);
        }
        if($action=='loadLandDetail'){
            $landDetailService = new LandDetailService();
            $landDetailService->LoadLandDetail($_POST['landDetail_id']);
        }
        if($action=='updateLandDetail'){
            $LandM = new LandM();
            if(isset($_POST['land_detail_id'])){
                $LandM->setIdLand($_POST['land_detail_id']);
            }
            if(isset($_POST['land_number'])){
                $LandM->setLandnumber($_POST['land_number']);
            }
            if(isset($_POST['axisx'])){
                $LandM->setAxisX($_POST['axisx']);
            }
            if(isset($_POST['axisy'])){
                $LandM->setAxisY($_POST['axisy']);
            }
            if(isset($_POST['axisz'])){
                $LandM->setAxisZ($_POST['axisz']);
            }
            if(isset($_POST['unit1'])){
                $LandM->setUnit1($_POST['unit1']);
            }
            if(isset($_POST['unit2'])){
                $LandM->setUnit2($_POST['unit2']);
            }
            if(isset($_POST['unit3'])){
                $LandM->setUnit3($_POST['unit3']);
            }
            if(isset($_POST['unit4'])){
                $LandM->setUnit4($_POST['unit4']);
            }
            $landDetailService = new LandDetailService();
            $landDetailService->updateLandDetail($LandM);
        }
        if($action=='deleteLandDetail'){
            $landDetailService = new LandDetailService();
            $landDetailService->delelandDetail($_POST['landDetail_id']);
        }
    }

}




?>
