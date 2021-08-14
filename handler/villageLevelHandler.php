<?php
require_once '../service/VillageLevelService.php';
require_once '../model/villageLevelM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        $villageLevelM = new villageLevelM();
        if($action=='addVillageLevel'){
            if (isset($_POST['idArea'])) {
                $villageLevelM->setAreaId($_POST['idArea']);
            }
            if (isset($_POST['levelNew'])) {
                $villageLevelM->setlevel($_POST['levelNew']);
            }
            if (isset($_POST['villageIdlist'])) {
                foreach($_POST['villageIdlist'] as $data) {
                    $seqService = new SeqService();
                    $seqvillageHeader = $seqService->get('village_level_seq');
                    $villageLevelM->setVillageLevelId($seqvillageHeader);
                    $villageLevelM->setGroupVillageId($data);
                    $villageLevelService = new villageLevelService();
                    $villageLevelService->createVillageLevel($villageLevelM);
                }
            }
        }
        if($action=='loadvillageDetail'){
            $villageLevelService = new villageLevelService();
            $villageLevelService->LoadvillageLevel($_POST['list_vill_level_id']);
        }
        if($action=='updatevillageDetail'){
            $villageLevelM = new villageLevelM();
            if(isset($_POST['list_vill_level_id'])){
                $villageLevelM->setVillageLevelId($_POST['list_vill_level_id']);
            }
            if(isset($_POST['levelVillage'])){
                $villageLevelM->setlevel($_POST['levelVillage']);
            }
            $villageLevelService = new villageLevelService();
            $villageLevelService->updateVillage($villageLevelM);
        }
        if($action=='delevillageDetail'){
            $villageLevelService = new villageLevelService();
            $villageLevelService->delevillageDetail($_POST['list_vill_level_id']);
        }
    }

}




?>
