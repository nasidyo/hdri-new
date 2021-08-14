<?php
require_once '../service/deliverProduct.php';
require_once '../model/deliverProductM.php';
require_once '../service/SeqService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action = $_POST['action'];
        if($action=='create') {
            $deliverProductM = new deliverProductM();
            if(isset($_POST['person_Id'])){
                $deliverProductM -> setIdPerson($_POST['person_Id']);
            }
            if(isset($_POST['dataList'])){
                foreach($_POST['dataList'] as $data) {
                    $seqService = new SeqService();
                    $seqPersonMarket= $seqService->get('idPersonMarket_seq');
                    $deliverProductM->setIdPersonMarket($seqPersonMarket);
                    $deliverProductM -> setIdAgri($data['agri_Id']);
                    // $timestamp = date('Y-m-d', strtotime($data['dtp_input2']));
                    $date  = strtotime($data['dtp_input2']);
                    $day   = date('d',$date);
                    $month = date('m',$date);
                    $year  = date('Y',$date)-543;
                    $timestamp = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                    $deliverProductM -> setDateDeliver($timestamp);
                    // date Cultivate
                    if($data['dtp_input3']){
                        $date3  = strtotime($data['dtp_input3']);
                        $day3   = date('d',$date3);
                        $month3 = date('m',$date3);
                        $year3  = date('Y',$date3)-543;
                        $timestamp3 = date('Y-m-d',strtotime($year3.'-'.$month3.'-'.$day3));
                        $deliverProductM -> setDateCultivate($timestamp3);
                    }
                    // date Harvest
                    if($data['dtp_input4']){
                        $date4  = strtotime($data['dtp_input4']);
                        $day4   = date('d',$date4);
                        $month4 = date('m',$date4);
                        $year4  = date('Y',$date4)-543;
                        $timestamp4 = date('Y-m-d',strtotime($year4.'-'.$month4.'-'.$day4));
                        $deliverProductM -> setDateHarvest($timestamp4);
                    }
                    $deliverProductM -> setIdArea($data['area_Id']);
                    $deliverProductM -> setIdCustomerMarket($data['market_Id']);

                    $deliverProductM -> setIdGardProduct($data['gardProduct']);
                    $deliverProductM -> setIdStandrdProduct($data['standardProduct']);
                    $deliverProductM -> setPrice($data['price']);
                    $deliverProductM -> setQuality($data['quality']);
                    $deliverProductM -> setTotalPricre($data['totalPricre']);
                    $deliverProductM -> setIdTypeAgri($data['typeAgri_Id']);
                    $deliverProductM -> setIdYears($data['yearsId']);
                    $deliverProductM -> setIdMonth($data['monthId']);
                    $deliverProductM -> setlandDetail($data['landDetail']);
                    $deliverProductM -> setSpeciesId($data['speciesId']);
                    //Create personMarket
                    $deliverProductService = new deliverProductService();
                    $deliverProductService->createPersonDeliverProductMarket($deliverProductM);
                    $logisticId = $data['logistic_Id'];
                    $deliverProductService->updateLogisticDeliverProduct($logisticId, $seqPersonMarket, 'n');
                    echo "create";
                    foreach($data['listimage'] as $imageData) {
                        $logisticId = $data['logistic_Id'];
                        $imageId = $imageData['idimage'];
                        $deliverProductService->createImageLogisticDeliverProduct($logisticId, $imageId, $seqPersonMarket, 'n');
                    }
                    
                }
                //check status personMarket
                $deliverProductM -> setIdArea($data['area_Id']);
                $deliverProductM -> setIdYears($data['yearsId']);
                $deliverProductM -> setIdMonth($data['monthId']);
                $deliverProductM -> setIdStatus("1");
                $deliverProductService = new deliverProductService();
                $deliverProductService->updateStatusValue($deliverProductM);
            }
        }else if ($action=='updataStatus'){
            $deliverProductM = new deliverProductM();
            $deliverProductM -> setIdArea($_POST['area_Id']);
            $deliverProductM -> setIdYears($_POST['yearsId']);
            $deliverProductM -> setIdMonth($_POST['monthId']);
            $deliverProductM -> setIdStatus($_POST['statusId']);
            $deliverProductService = new deliverProductService();
            if($_POST['statusId'] == "2"){
                $deliverProductService->sendStatusValue($deliverProductM);
            }else if ($_POST['statusId'] == "3"){
                $deliverProductService->backtoEditStatus($deliverProductM);
            }else if ($_POST['statusId'] == "4"){
                $deliverProductService->confirmStatus($deliverProductM);
            }
        }else if ($action=='update') {
            if(isset($_POST['data'])){
                foreach($_POST['data'] as $data) {
                    $deliverProductM = new deliverProductM();
                    $deliverProductM->setIdPersonMarket($data['idPersonMarket']);
                    $deliverProductM -> setIdArea($data['area_Id']);
                    $deliverProductM->setIdTypeAgri($data['typeAgri_Id']);
                    $deliverProductM->setIdAgri($data['agri_Id']);
                    $deliverProductM->setIdCustomerMarket($data['market_Id']);
                    $deliverProductM->setQuality($data['quality']);
                    $deliverProductM->setPrice($data['price']);
                    $deliverProductM->setTotalPricre($data['totalPricre']);
                    $deliverProductM->setIdGardProduct($data['gardsProduct']);
                    $deliverProductM->setIdStandrdProduct($data['standardProduct']);
                    if($data['dtp_input3']){
                        $date3  = strtotime($data['dtp_input3']);
                        $day3  = date('d',$date3);
                        $month3 = date('m',$date3);
                        $year3  = date('Y',$date3)-543;
                        $timestamp3 = date('Y-m-d',strtotime($year3.'-'.$month3.'-'.$day3));
                        $deliverProductM -> setDateCultivate($timestamp3);
                    }
                    // date Harvest
                    if($data['dtp_input4']){
                        $date4  = strtotime($data['dtp_input4']);
                        $day4   = date('d',$date4);
                        $month4 = date('m',$date4);
                        $year4  = date('Y',$date4)-543;
                        $timestamp4 = date('Y-m-d',strtotime($year4.'-'.$month4.'-'.$day4));
                        $deliverProductM -> setDateHarvest($timestamp4);
                    }
                    $deliverProductService = new deliverProductService();
                    $deliverProductService->updateDeliverProduct($deliverProductM);
                    $logisticId = $data['logistic_Id'];
                    $deliverProductService->updateLogisticDeliverProduct($logisticId, $data['idPersonMarket'], 'n');
                    echo "update";
                    if($data['listimage'] != null){
                        foreach($data['listimage'] as $imageData) {
                            $logisticId = $data['logistic_Id'];
                            $imageId = $imageData['idimage'];
                            $deliverProductService->updateImageLogisticDeliverProduct($logisticId, $imageId, $data['idPersonMarket']);
                        }
                    }
                }
                //check status personMarket
                $deliverProductM -> setIdArea($data['area_Id']);
                $deliverProductM -> setIdYears($data['yearsId']);
                $deliverProductM -> setIdMonth($data['monthId']);
                $deliverProductM -> setIdStatus("1");
                $deliverProductService = new deliverProductService();
                $deliverProductService->updateStatusValue($deliverProductM);
            }
        }else if($action=='delete'){
            if (isset($_POST['idPersonMarket'])) {
                $idPersonMarket = $_POST['idPersonMarket'];
                $deliverProductService = new deliverProductService();
                $deliverProductService->delDeliverProduct($idPersonMarket);
              }
        }else if ($action == 'createPerson') {
            $seqService = new SeqService();
            $seqPerson= $seqService->get("person_id_seq");
            $deliverProductM = new deliverProductM();
            $deliverProductM -> setIdArea($_POST['area_Id']);
            $deliverProductM -> setIdPerson($seqPerson);
            foreach($_POST['data'] as $data) {
                // echo 111111;
                $deliverProductM -> setIdcard($data['argid']);
                $deliverProductM -> setPrefix_idPrefix($data['argpre']);
                $deliverProductM -> setFirstName(urldecode($data['argname']));
                $deliverProductM -> setLastName(urldecode($data['argsurname']));
                $deliverProductM -> setPhoneNumber($data['argTel']);
                $deliverProductM -> setStatusPerson("มีชีวิตอยู่");
                $deliverProductService = new deliverProductService();
                $results = $deliverProductService->createNewPerson($deliverProductM);
            }
            echo (int)$seqPerson;
        }else if ($action == 'createLogistic') {
            $logisticDetail = $_POST['Logistic'];
            $seqService = new SeqService();
            $logistic_seq= $seqService->get("logistic_TD_seq");
            $deliverProductM = new deliverProductM();
            $deliverProductM -> setlogisticId($logistic_seq);
            $deliverProductM -> setlogisticDetail($logisticDetail);
            $deliverProductService = new deliverProductService();
            $deliverProductService->createLogsitic($deliverProductM);
            echo $logistic_seq;
        }else if($action == 'uploadImage'){
            if(isset($_FILES["fileToUpload"]["type"])){
                $pathImage='../img/Activity';
                $allowTypes = array('jpg','png','jpeg','gif');
                $images_arr = array();
                $temp = $_FILES["fileToUpload"]["name"];
                $newfilename =  'Logistic_'.$temp;
                $targetFilePath = $pathImage."/".$newfilename;
                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath);
                $typeOfUpload = "Logistic";
                $seqService = new SeqService();
                $imgUpload_Id = $seqService->get("imgUpload_seq");
                $deliverProductService = new deliverProductService();
                $deliverProductService->createUploadImage($imgUpload_Id, $targetFilePath, $newfilename, $typeOfUpload);
                echo $imgUpload_Id.','.$targetFilePath;
            }
        }else if($action == 'cloneDeliver'){
            if(isset($_POST['deliverList'])){
                foreach($_POST['deliverList'] as $data) {
                    $seqService = new SeqService();
                    $seqPersonMarket= $seqService->get('idPersonMarket_seq');
                    $deliverProductM = new deliverProductM();
                    $deliverProductM->setIdPersonMarket($seqPersonMarket);
                    $timestamp = date('Y-m-d', time());
                    $deliverProductM -> setDateDeliver($timestamp);
                    $deliverProductM -> setIdYears($_POST['thisYearsId']);
                    $deliverProductM -> setIdMonth($_POST['thisMonthId']);
                    $deliverProductM -> setIdArea($_POST['area_Id']);
                    $deliverProductService = new deliverProductService();
                    $deliverProductService->saveCopyDeliverProduct($deliverProductM, $data);
                }
                //check status personMarket
                $deliverProductM -> setIdStatus("1");
                $deliverProductService = new deliverProductService();
                $deliverProductService->updateStatusValue($deliverProductM);
            }
        }else if ($action == 'checkPrinceIsmissing'){
            $deliverProductService = new deliverProductService();
            $deliverProductService->checkdeliverIncome($_POST['area_Id'], $_POST['yearsId'], $_POST['monthId']);
        }else if ($action == 'createMarket'){
            $seqService = new SeqService();
            $seqMarket = $seqService->get("marketId_seq");
            $deliverProductService = new deliverProductService();
            foreach($_POST['data'] as $data) {
                $deliverProductService->createNewMarket($seqMarket, $data['marketName']);
            }
            echo (int)$seqMarket;
        }else if ($action == 'createCustomer'){
            $deliverProductService = new deliverProductService();
            foreach($_POST['data'] as $data) {
                $deliverProductService->createNewCustomer($data['CustomerName']);
            }
        }else if ($action == 'deleteImage') {
            $deliverProductService = new deliverProductService();
            $deliverProductService->deletImage($_POST['idImgUpload']);
        }else if ($action == 'deliverProductMB') {
            //check status personMarket

            $deliverProductM = new deliverProductM();
            $deliverProductM -> setIdArea($_POST['areaId']);
            $deliverProductM -> setIdYears($_POST['yearsId']);
            $deliverProductM -> setIdMonth($_POST['monthId']);
            $deliverProductM -> setIdStatus("1");
            $deliverProductService = new deliverProductService();
            $deliverProductService->updateStatusValue($deliverProductM);
            
            $seqService = new SeqService();
            $seqPersonMarket= $seqService->get('idPersonMarket_seq');
            $deliverProductM->setIdPersonMarket($seqPersonMarket);
            $timestamp = date('Y-m-d h:i:s');
            $deliverProductM -> setDateDeliver($timestamp);
            // date Cultivate
            if($data['dtp_input3']){
                $date3  = strtotime($data['dtp_input3']);
                $day3  = date('d',$date3);
                $month3 = date('m',$date3);
                $year3  = date('Y',$date3)-543;
                $timestamp3 = date('Y-m-d',strtotime($year3.'-'.$month3.'-'.$day3));
                $deliverProductM -> setDateCultivate($timestamp3);
            }
            // date Harvest
            if($data['dtp_input4']){
                $date4  = strtotime($data['dtp_input4']);
                $day4   = date('d',$date4);
                $month4 = date('m',$date4);
                $year4  = date('Y',$date4)-543;
                $timestamp4 = date('Y-m-d',strtotime($year4.'-'.$month4.'-'.$day4));
                $deliverProductM -> setDateHarvest($timestamp4);
            }
            $deliverProductM -> setIdYears($_POST['yearsId']);
            $deliverProductM -> setIdMonth($_POST['monthId']);
            $deliverProductM -> setIdPerson($_POST['farmer_Id']);
            $deliverProductM->setIdArea($_POST['areaId']);
            $deliverProductM->setIdTypeAgri($_POST['typeAgri_Id']);
            $deliverProductM->setIdAgri($_POST['agri_Id']);
            $deliverProductM->setIdCustomerMarket($_POST['market_Id']);
            $deliverProductM->setQuality($_POST['totalQuality']);
            $deliverProductM->setPrice($_POST['price']);
            $deliverProductM->setTotalPricre($_POST['totalPricre']);
            $deliverProductM->setIdGardProduct($_POST['gardProduct']);
            $deliverProductM->setIdStandrdProduct($_POST['standardProduct']);
            $deliverProductM -> setlandDetail($_POST['landDetail']);
            $deliverProductM -> setSpeciesId($_POST['speciesId']);
            //Create personMarket
            $deliverProductService = new deliverProductService();
            $deliverProductService->createPersonDeliverProductMB($deliverProductM);
            if(isset($_POST['logistic_Id'])){
                $logisticId = $_POST['logistic_Id'];
                $deliverProductService->updateLogisticDeliverProduct($logisticId, $seqPersonMarket, 'n');
            }
            if(isset($_POST['logistic_Id'])){
                $typeOfUpload = "Logistic";
                $pathImage='../img/Activity/';
                $newfilename = null;
                echo "2222222".$_POST['image'];
                if (isset($_POST['image'])) {
                    $image_parts = explode(";base64,", $_POST['image']);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $targetFilePath = $pathImage . $seqPersonMarket . '.jpg';
                    file_put_contents($targetFilePath, $image_base64);
                    $newfilename = $seqPersonMarket . '.jpg';
                }
                if(isset($_FILES["fileToUpload"]["type"])){
                    $pathImage='../img/Activity';
                    $allowTypes = array('jpg','png','jpeg','gif');
                    $images_arr = array();
                    $temp = $_FILES["fileToUpload"]["name"];
                    $newfilename =  'Logistic_'.$temp;
                    $targetFilePath = $pathImage."/".$newfilename;
                    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath);
                }
                echo "2222222 newfilename :::::: ".$_POST['image'];
                if($newfilename != null && $newfilename != ''){
                    $seqService = new SeqService();
                    $imgUpload_Id = $seqService->get("imgUpload_seq");
                    $deliverProductService = new deliverProductService();
                    $deliverProductService->createUploadImage($imgUpload_Id, $targetFilePath, $newfilename, $typeOfUpload);
                    $logisticId = $_POST['logistic_Id'];
                    $deliverProductService->createImageLogisticDeliverProduct($logisticId, $imageId, $seqPersonMarket, 'n');
                }
            }
        } else if ($action == 'updatelist') {
            $deliverProductM = new deliverProductM();
            if(isset($_POST['data'])){
                foreach($_POST['data'] as $data) {
                    $deliverProductM->setIdPersonMarket($data['id']);
                    $deliverProductM->setQuality($data['totalQuality']);
                    $deliverProductM->setPrice($data['priceProduct']);
                    $deliverProductM->setTotalPricre((float)round($data['priceProduct'],2)*(float)round($data['totalQuality'],2));
                    $deliverProductService = new deliverProductService();
                    $deliverProductService->updateDeliverProductList($deliverProductM);
                    // $targetPlanService->updateTargetPlanNew($planM);
                }
            }
        } else if ($action == 'createTemp'){
           
            $deliverProductM = new deliverProductM();
            foreach($_POST['dataValue'] as $data) {
                $seqService = new SeqService();
                $seqPersonMarket= $seqService->get('personMarketCartseq');
                $deliverProductM->setIdPersonMarket($seqPersonMarket);
                $deliverProductM -> setIdAgri($data['agri_Id']);
                $deliverProductM -> setIdPerson($data['person_Id']);
                $date  = strtotime($data['dtp_input2']);
                $day   = date('d',$date);
                $month = date('m',$date);
                $year  = date('Y',$date)-543;
                $timestamp = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                $year  = date('Y',$date)-543;
                $deliverProductM -> setDateDeliver($timestamp);
                // date Cultivate
                if($data['dtp_input3']){
                    $date3  = strtotime($data['dtp_input3']);
                    $day3  = date('d',$date3);
                    $month3 = date('m',$date3);
                    $year3  = date('Y',$date3)-543;
                    $timestamp3 = date('Y-m-d',strtotime($year3.'-'.$month3.'-'.$day3));
                    $deliverProductM -> setDateCultivate($timestamp3);
                }
                // date Harvest
                if($data['dtp_input4']){
                    $date4  = strtotime($data['dtp_input4']);
                    $day4   = date('d',$date4);
                    $month4 = date('m',$date4);
                    $year4  = date('Y',$date4)-543;
                    $timestamp4 = date('Y-m-d',strtotime($year4.'-'.$month4.'-'.$day4));
                    $deliverProductM -> setDateHarvest($timestamp4);
                }
                $deliverProductM -> setIdArea($data['area_Id']);
                $deliverProductM -> setIdCustomerMarket($data['market_Id']);
                $deliverProductM -> setIdGardProduct($data['gardProduct']);
                $deliverProductM -> setIdStandrdProduct($data['standardProduct']);
                $deliverProductM -> setPrice($data['price']);
                $deliverProductM -> setQuality($data['quality']);
                $deliverProductM -> setTotalPricre($data['totalPricre']);
                $deliverProductM -> setIdTypeAgri($data['typeAgri_Id']);
                $deliverProductM -> setIdYears($data['yearsId']);
                $deliverProductM -> setIdMonth($data['monthId']);
                $deliverProductM -> setlandDetail($data['landDetail']);
                $deliverProductM -> setSpeciesId($data['speciesId']);
                // Create personMarket
                $deliverProductService = new deliverProductService();
                $deliverProductService->savePersonMarketToCart($deliverProductM, $data['idStaff']);
                $logisticId = $data['logistic_Id'];
                $deliverProductService->updateLogisticDeliverProduct($logisticId, $seqPersonMarket, 'y');
                if(isset($data['listimage'])){
                    foreach($data['listimage'] as $imageData) {
                        $logisticId = $data['logistic_Id'];
                        $imageId = $imageData['idimage'];
                        $deliverProductService->createImageLogisticDeliverProduct($logisticId, $imageId, $seqPersonMarket, 'y');
                    }
                }
            }
            echo (int)$seqPersonMarket;
        } else if ($action == 'DeleteItemInCartTemp') {
            $deliverProductService = new deliverProductService();
            $deliverProductService->deletItemInCart($_POST['dataCartId']);
        } else if ($action == 'loadInfoDeliverCart') {
            $deliverProductService = new deliverProductService();
            echo $deliverProductService->loadDeliverCart($_POST['yearsId'], $_POST['monthId'], $_POST['area_Id'], $_POST['idStaff']);
        } else if ($action == 'createItemInCart') {
            $deliverProductService = new deliverProductService();
            $deliverProductService->createAllInCart($_POST['yearsId'], $_POST['monthId'], $_POST['area_Id'], $_POST['idStaff']);
        } else if ($action == 'deleteAllItemInCart') {
            $deliverProductService = new deliverProductService();
            $deliverProductService->deleteAllItemsCart($_POST['yearsId'], $_POST['monthId'], $_POST['area_Id'], $_POST['idStaff']);
        }else if ($action == 'deleteList'){
            if(isset($_POST['idPersonMarkerList'])){
                foreach($_POST['idPersonMarkerList'] as $idPersonMarker) {
                    $deliverProductService = new deliverProductService();
                    $deliverProductService->delDeliverProduct($idPersonMarker);
                }
            }
        }
    }
}
?>