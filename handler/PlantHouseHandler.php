<?php
require_once '../service/PlantHouseService.php';
require_once '../model/PlantHouseM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        if($action=='loadPlanHouse'){
            if (isset($_POST['planHouseId'])) {
                $planHouseId = (int)$_POST['planHouseId'];
                $PlantHouseService = new PlantHouseService();
                $PlantHouseService->loadPlantHouse($planHouseId);
            }
        }
        if($action=='addPlantHouse'){
            $plantHouseM = new PlantHouseM();
            $seqService = new SeqService();
            $seqPlantHouse = $seqService->get("plant_house_id");
            $plantHouseM->setPlantHouseId((int)$seqPlantHouse);
            if (isset($_POST['idRiverBasin'])){
                $plantHouseM->setIdRiverBasin($_POST['idRiverBasin']);
            }
            if (isset($_POST['idArea'])){
                $plantHouseM->setAreaId($_POST['idArea']);
            }
            if (isset($_POST['landDetail'])){
                $plantHouseM->setIdLand($_POST['landDetail']);
            }
            if (isset($_POST['house_number'])){
                $plantHouseM->setHouseNumber($_POST['house_number']);
            }
            if (isset($_POST['person_id'])){
                $plantHouseM->setIdPerson($_POST['person_id']);
            }
            $PlantHouseService = new PlantHouseService();
            $PlantHouseService->addPlantHouse($plantHouseM);
        }
        if($action=='editPlantHouse'){
            // echo $_POST['user_targetAreaList'];
            $plantHouseM = new PlantHouseM();
            if (isset($_POST['plant_house_id'])) {
                $plantHouseM->setPlantHouseId($_POST['plant_house_id']);
            }
            if (isset($_POST['house_number_edit'])) {
                $plantHouseM->setHouseNumber($_POST['house_number_edit']);
            }
            if (isset($_POST['land_id_edit'])) {
                $plantHouseM->setIdLand($_POST['land_id_edit']);
            }
            $PlantHouseService = new PlantHouseService();
            $PlantHouseService->editPlantHouse($plantHouseM);
        }
        if($action=='deletePlantHouse'){
            $PlantHouseService = new PlantHouseService();
            $PlantHouseService->delPlantHouse($_POST['plant_house_id']);
        }
    }

}




?>
