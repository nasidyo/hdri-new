<?php
require_once '../service/plan.php';
require_once '../model/PlanM.php';
require_once '../service/SeqService.php';
require_once '../service/sendEmail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        if($action=='add'){
            if(isset($_POST['dataList'])){
                // $planM = new PlanM();
                // $seqService = new SeqService();
                // $planM->setIdArea($_POST['area_Id']);
                // $planM->setIdYears($_POST['years_Id']);
                // $planM->setIdTypeOfArgi($_POST['typeOfAgri_id']);
                // $planM->setStatusTypeId("1");
                // $planM->setIdAgri($_POST['agriId']);
                // $planM->setSpeciesId($_POST['speciesId']);
                // $targetPlanService = new TargetPlanService();
                // $seqSentTargetPlan = $seqService->get('idSendStatusPlan_seq');
                // $planM->setIdSendStatusPlan($seqSentTargetPlan);
                // $targetPlanService->checkStatusSendPlanOfyears($planM);
                foreach($_POST['dataList'] as $data) {
                    $planM = new PlanM();
                    $seqService = new SeqService();
                    $seqTargetPlan = $seqService->get('id_target_plan_seq');
                    $planM->setIdTargetPlan($seqTargetPlan);
                    $planM->setIdArea($data['area_Id']);
                    $planM->setIdYears($data['years_Id']);
                    $planM->setIdTypeOfArgi($data['typeOfAgri_id']);
                    $planM->setIdAgri($data['agriId']);
                    $planM->setSpeciesId($data['speciesId']);
                    $planM->setPrice(sprintf("%.2f",$data['pricePerProduct']));
                    $planM->setWeight(sprintf("%.2f",$data['quality']));
                    $planM->setTotal(sprintf("%.2f",$data['totalPrice']));
                    $planM->setMarketId($data['marketId']);
                    $planM->setMonthId($data['monthId']);
                    $targetPlanService = new TargetPlanService();
                    $targetPlanService->crateTargetPlan($planM);
                    /*  create support data  */
                    if(isset($_POST['supportdatalist'])){
                        foreach($_POST['supportdatalist'] as $supportdata) {
                            $substring = explode("=",$supportdata);
                            $seqService = new SeqService();
                            $attrplanunit = $seqService->get('plan_unit_attr_seq');
                            $targetPlanService = new TargetPlanService();
                            $targetPlanService->createPlanUnitAttribute($seqTargetPlan, $substring[0], $substring[1], $attrplanunit);
                        }
                    }
                }
            }
            // if(isset($_POST['dataList'])){
            //     $planM = new PlanM();
            //     $seqService = new SeqService();
            //     $seqTargetPlanHeader = $seqService->get('id_target_plan_seq');
            //     $planM->setIdTargetPlan($seqTargetPlanHeader);
            //     $planM->setIdArea($_POST['dataList'][0]['area_Id']);
            //     $planM->setIdYears($_POST['dataList'][0]['years_Id']);
            //     $planM->setIdTypeOfArgi($_POST['dataList'][0]['typeOfAgri_id']);
            //     $planM->setStatusTypeId("1");
            //     $targetPlanService = new TargetPlanService();
            //     // $targetPlanService->crateTargetPlanHeader($planM);
            //     // $idTargetPlanRef = $planM->getIdTargetPlanRef();
            //     $seqSentTargetPlan = $seqService->get('idSendStatusPlan_seq');
            //     $planM->setIdSendStatusPlan($seqSentTargetPlan);
            //     $targetPlanService->checkStatusSendPlanOfyears($planM);
            //     /*  CREATE VAULE FORM LIST */
            //     foreach($_POST['dataList'] as $data) {
            //         $planM = new PlanM();
            //         // $planM->setIdTargetPlanRef($idTargetPlanRef);
            //         $seqTargetPlan = $seqService->get('id_target_plan_seq');
            //         $planM->setIdTargetPlan($seqTargetPlan);
            //         $planM->setIdArea($data['area_Id']);
            //         $planM->setIdYears($data['years_Id']);
            //         $planM->setIdTypeOfArgi($data['typeOfAgri_id']);
            //         $planM->setIdAgri($data['agriId']);
            //         $planM->setSpeciesId($data['speciesId']);
            //         $planM->setPrice(sprintf("%.2f",$data['pricePerProduct']));
            //         $planM->setWeight(sprintf("%.2f",$data['quality']));
            //         $planM->setTotal(sprintf("%.2f",$data['totalPrice']));
            //         $planM->setMarketId($data['marketId']);
            //         $planM->setMonthId($data['monthId']);
            //         $targetPlanService = new TargetPlanService();
            //         $targetPlanService->crateTargetPlan($planM);
            //         /*  create support data  */
            //         if(isset($_POST['supportdatalist'])){
            //             foreach($_POST['supportdatalist'] as $supportdata) {
            //                 $substring = explode("=",$supportdata);
            //                 $seqService = new SeqService();
            //                 $attrplanunit = $seqService->get('plan_unit_attr_seq');
            //                 $targetPlanService = new TargetPlanService();
            //                 $targetPlanService->createPlanUnitAttribute($seqTargetPlan, $substring[0], $substring[1], $attrplanunit);
            //             }
            //         }
            //     }
            // }
        }
        // if($action=='add'){
        //     if(isset($_POST['listPricePlan'])){
        //         $planM = new PlanM();
        //         $seqService = new SeqService();
        //         $planM->setIdArea($_POST['area_Id']);
        //         $planM->setIdYears($_POST['years_Id']);
        //         $planM->setIdTypeOfArgi($_POST['typeOfAgri_id']);
        //         $planM->setStatusTypeId("1");
        //         $planM->setIdAgri($_POST['agriId']);
        //         $planM->setSpeciesId($_POST['speciesId']);
        //         $targetPlanService = new TargetPlanService();
        //         $seqSentTargetPlan = $seqService->get('idSendStatusPlan_seq');
        //         $planM->setIdSendStatusPlan($seqSentTargetPlan);
        //         // $targetPlanService->checkStatusSendPlanOfyears($planM);
        //         foreach($_POST['listPricePlan'] as $data) {
        //             if(isset($data['TotalPrice']) && $data['TotalPrice'] != ''){
        //                 foreach($_POST['marketList'] as $dataMarket) {
        //                     $seqTargetPlan = $seqService->get('id_target_plan_seq');
        //                     $planM->setIdTargetPlan($seqTargetPlan);
        //                     $planM->setMarketId($dataMarket);
        //                     $planM->setMonthId($data['id']);
        //                     $maketSize = $_POST['marketsize'];
        //                     echo $maketSize." : ";
        //                     $planM->setPrice(sprintf("%.2f",$data['pricePer']));
        //                     $quantityONMth = ((float) $data['quantity'] / (int) $maketSize);
        //                     $planM->setWeight(sprintf("%.2f",$quantityONMth));
        //                     $total = ((float)$quantityONMth * (int) $data['pricePer']);
        //                     $planM->setTotal(sprintf("%.2f",$total));
        //                     echo $total." : ";
        //                     echo $quantityONMth." : ";
        //                     $targetPlanService = new TargetPlanService();
        //                     $targetPlanService->crateTargetPlan($planM);
        //                     if(isset($_POST['supportdatalist'])){
        //                         foreach($_POST['supportdatalist'] as $supportdata) {
        //                             $substring = explode("=",$supportdata);
        //                             $seqService = new SeqService();
        //                             $attrplanunit = $seqService->get('plan_unit_attr_seq');
        //                             $targetPlanService = new TargetPlanService();
        //                             $targetPlanService->createPlanUnitAttribute($seqTargetPlan, $substring[0], $substring[1], $attrplanunit);
        //                         }
        //                     }
        //                 }
                        
        //             }
        //         }
        //     }
        // }
        else if ($action=='update'){
            $planM = new PlanM();
            if (isset($_POST['traget_Id'])) {
                $planM->setIdTargetPlan($_POST['traget_Id']);
            }
            if (isset($_POST['productPrice'])) {
                $planM->setPrice($_POST['productPrice']);
            }
            if (isset($_POST['totalQuality'])) {
                $planM->setWeight($_POST['totalQuality']);
                $totalPrice = (float)round($_POST['totalQuality'],2)*(float)round($_POST['productPrice'],2);
                $planM->setTotal($totalPrice);
            }
            $targetPlanService = new TargetPlanService();
            $targetPlanService->updateTargetPlan($planM);
        }else if ($action=='delete'){
            $planM = new PlanM();
            if (isset($_POST['traget_Id'])) {
                $traget_Id = $_POST['traget_Id'];
                $targetPlanService = new TargetPlanService();
                $targetPlanService->deleteTargetPlan($traget_Id);
            }
        } else if ($action=='sendPlanOfYears'){
            $planM = new PlanM();
            $seqService = new SeqService();
            $planM->setStatusTypeId("2"); //สถาณะส่งข้อมูล
            if (isset($_POST['area_Id'])) {
                $planM->setIdArea($_POST['area_Id']);
            }
            if(isset($_POST['years_Id'])){
                $planM->setIdYears($_POST['years_Id']);
            }
            $targetPlanService = new TargetPlanService();
            $targetPlanService->updatePlanOfyears($planM);
            //send email to manager
            // LIST TO DO
            $sendEmail = new SandEmail();
            $sendEmail->getinfo($planM,'toManager', $_POST['statusTypeId']);
        } else if ($action=='updateStatusPlanOfYears'){
            $planM = new PlanM();
            // $planM->setIdSendStatusPlan($seqSentTargetPlan);
            $planM->setStatusTypeId($_POST['statusTypeId']); //สถาณะส่งข้อมูล
            // $planM->setIdOutputValue($seqOutputValue);
            if (isset($_POST['area_Id'])) {
                $planM->setIdArea($_POST['area_Id']);
            }
            if(isset($_POST['years_Id'])){
                $planM->setIdYears($_POST['years_Id']);
            }
            $targetPlanService = new TargetPlanService();
            $targetPlanService->updatePlanOfyears($planM);
            if($_POST['statusTypeId'] == '3'){
                $sendEmail = new SandEmail();
                $sendEmail->getinfo($planM,'toStaff', $_POST['statusTypeId']);
            }
            if($_POST['statusTypeId'] == '4'){
                //create estimate list
                $seqService = new SeqService();
                $seqOutputValue = $seqService->get('idOutputValue_seq');
                $planM->setIdOutputValue($seqOutputValue);
                $TargetPlanService = new TargetPlanService();
                $TargetPlanService->sendOutputValueN($planM);
                //create monthOfyear list
                $TargetPlanService = new TargetPlanService();
                $TargetPlanService->createSendOutputValue($planM);
                //send email to staff
                // LIST TO DO
                $sendEmail = new SandEmail();
                $sendEmail->getinfo($planM,'toStaff', $_POST['statusTypeId']);
            }
        }else if ($action=='checkplan'){
            if (isset($_POST['area_Id'])) {
                $area_Id = $_POST['area_Id'];
                $TargetPlanService = new TargetPlanService();
                $TargetPlanService->checkYearsTarget($area_Id);
            }
        } else if ($action=='pastUpdateFunction'){
            $planM = new PlanM();
            if (isset($_POST['area_Id'])) {
                $area_Id = $_POST['area_Id'];
                $planM->setIdArea($_POST['area_Id']);
            }
            $TargetPlanService = new TargetPlanService();
            $TargetPlanService->checkYearsTarget($area_Id);
            //create monthOfyear list
            $TargetPlanService = new TargetPlanService();
            $TargetPlanService->pastCreateSendOutputValue($planM);
        }else if ($action=='updatelist'){
            $planM = new PlanM();
            if(isset($_POST['data'])){
                foreach($_POST['data'] as $data) {
                    $planM->setIdTargetPlan($data['id']);
                    $planM->setPrice($data['productPrice']);
                    $planM->setWeight($data['totalQuality']);
                    $planM->setTotal((float)round($data['productPrice'],2)*(float)round($data['totalQuality'],2));
                    $targetPlanService = new TargetPlanService();
                    $targetPlanService->updateTargetPlanNew($planM);
                }
            }
        }else if ($action == 'loadPlanUint'){
            if(isset($_POST['tragetPlan_Id'])){
                $traget_Id = $_POST['tragetPlan_Id'];
            }
            $TargetPlanService = new TargetPlanService();
            $TargetPlanService->loadTargetPlanUint($traget_Id);
        }else if ($action == 'updateTargetPromo'){
            if(isset($_POST['targetPlanId'])){
                $targetPlanId = $_POST['targetPlanId'];
            }
            if(isset($_POST['listdata'])){
                foreach($_POST['listdata'] as $supportdata) {
                    $substring = explode("=",$supportdata);
                    if($substring[1] != ''){
                        $targetPlanService = new TargetPlanService();
                        $targetPlanService->updatePlanUnitAttribute($targetPlanId, $substring[0], $substring[1]);
                    }
                }
            }
        }else if ($action == 'deleteCheckB'){
            if(isset($_POST['traget_Id'])){
                foreach($_POST['traget_Id'] as $data) {
                    $targetPlanService = new TargetPlanService();
                    $targetPlanService->deleteTargetPlan($data);
                }
            }
        }
    }
}
?>