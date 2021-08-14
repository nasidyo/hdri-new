<?php
require_once '../service/EstimateProduct.php';
require_once '../model/EstimateM.php';
require_once '../service/SeqService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action = $_POST['action'];
        if($action=='update'){
            $EstimateM = new EstimateM();
            if(isset($_POST['idOutputValue'])){
                $EstimateM->setIdOutputValue($_POST['idOutputValue']);
            }
            if(isset($_POST['dataInputUpdate'])){
                $EstimateM->setWeight($_POST['dataInputUpdate']);
            }
            if(isset($_POST['week'])){
                $EstimateM->setWeekNo($_POST['week']);
            }
            if(isset($_POST['monthId'])){
                $EstimateM->setIdMonth($_POST['monthId']);
            }
            $estimateService = new estimeteProductService();
            $estimateService->updateEstimateProduct($EstimateM);
            $estimateService->updateOutputValue($EstimateM);
        }
        if($action=='updatelist'){
            if(isset($_POST['data'])){
                foreach($_POST['data'] as $data) {
                    $EstimateM = new EstimateM();
                    $EstimateM->setIdOutputValue($data['idOutputValue']);
                    $EstimateM->setWeight($data['totalQuality']);
                    $EstimateM->setPrice($data['pricePerProduct']);
                    $EstimateM->setWeekNo($data['id']);
                    $EstimateM->setIdMonth($data['monthId']);
                    $estimateService = new estimeteProductService();
                    $estimateService->updateEstimateProduct($EstimateM);
                    $estimateService->updateOutputValue($EstimateM);
                }
            }
        }
    }
}
?>