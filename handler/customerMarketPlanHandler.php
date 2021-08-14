<?php
require_once '../service/CustomerMarketPlanService.php';
require_once '../model/CustomerMarketPlanM.php';
require_once '../service/SeqService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $CustomerMarketPlanM = new CustomerMarketPlanM();


            $seqService = new SeqService();
            $seq= $seqService->get("customerMarketPlanId");

                $CustomerMarketPlanM->setIdCustomerMaketplan( $seq);


            if (isset($_POST['customer_id'])) {
                $CustomerMarketPlanM->setIdCustomer($_POST['customer_id']);
            }
            if (isset($_POST['idArea'])) {
                $CustomerMarketPlanM->setIdArea($_POST['idArea']);
            }
            if (isset($_POST['plan_Year'])) {
                $CustomerMarketPlanM->setPlanYear($_POST['plan_Year']);
            }
            if (isset($_POST['idAgri'])) {
                $CustomerMarketPlanM->setIdAgri($_POST['idAgri']);
            }
            if (isset($_POST['agri_weekplan_amount'])) {
                $CustomerMarketPlanM->setAgriWeekplanAmount($_POST['agri_weekplan_amount']);
            }
            if (isset($_POST['unit_id'])) {
                $CustomerMarketPlanM->setUnitId($_POST['unit_id']);
            }
            if (isset($_POST['agri_spect'])) {
                $CustomerMarketPlanM->setAgriSpect($_POST['agri_spect']);
            }
            if (isset($_POST['idTypeOfStand'])) {
                $CustomerMarketPlanM->setIdTypeOfStand($_POST['idTypeOfStand']);
            }
            if (isset($_POST['idLogistic'])) {
                $CustomerMarketPlanM->setIdLogistic($_POST['idLogistic']);
            }
            if (isset($_POST['Refund_period'])) {
                $CustomerMarketPlanM->setRefundPeriod($_POST['Refund_period']);
            }
            if (isset($_POST['conn_status_id'])) {
                $CustomerMarketPlanM->setConnStatusId($_POST['conn_status_id']);
            }



echo 'test';

            $CustomerMarketPlanService = new CustomerMarketPlanService();
            $CustomerMarketPlanService->addCustomerMarketPlan($CustomerMarketPlanM);

        }
        if($action=='update'){
            $CustomerMarketPlanM = new CustomerMarketPlanM();
            if (isset($_POST['customer_marketplan_id'])) {
                $CustomerMarketPlanM->setIdCustomerMaketplan($_POST['customer_marketplan_id']);
            }
            if (isset($_POST['customer_id'])) {
                $CustomerMarketPlanM->setIdCustomer($_POST['customer_id']);
            }
            if (isset($_POST['idArea'])) {
                $CustomerMarketPlanM->setIdArea($_POST['idArea']);
            }
            if (isset($_POST['plan_Year'])) {
                $CustomerMarketPlanM->setPlanYear($_POST['plan_Year']);
            }
            if (isset($_POST['idAgri'])) {
                $CustomerMarketPlanM->setIdAgri($_POST['idAgri']);
            }
            if (isset($_POST['agri_weekplan_amount'])) {
                $CustomerMarketPlanM->setAgriWeekplanAmount($_POST['agri_weekplan_amount']);
            }
            if (isset($_POST['unit_id'])) {
                $CustomerMarketPlanM->setUnitId($_POST['unit_id']);
            }
            if (isset($_POST['agri_spect'])) {
                $CustomerMarketPlanM->setAgriSpect($_POST['agri_spect']);
            }
            if (isset($_POST['idTypeOfStand'])) {
                $CustomerMarketPlanM->setIdTypeOfStand($_POST['idTypeOfStand']);
            }
            if (isset($_POST['idLogistic'])) {
                $CustomerMarketPlanM->setIdLogistic($_POST['idLogistic']);
            }
            if (isset($_POST['Refund_period'])) {
                $CustomerMarketPlanM->setRefundPeriod($_POST['Refund_period']);
            }
            if (isset($_POST['conn_status_id'])) {
                $CustomerMarketPlanM->setConnStatusId($_POST['conn_status_id']);
            }
            $CustomerMarketPlanService = new CustomerMarketPlanService();
            $CustomerMarketPlanService->updateCustomerMarketPlan($CustomerMarketPlanM);
        }


        if($action=='delete'){
            if (isset($_POST['customer_marketplan_id'])) {
                $CustomerMaketplan = (int)$_POST['customer_marketplan_id'];
                $CustomerMarketPlanService = new CustomerMarketPlanService();
                $CustomerMarketPlanService->delCustomerMarketPlan($CustomerMaketplan);
              }
        }

        if($action=='load'){
            if (isset($_POST['CustomerMaketplan'])) {
                $CustomerMaketplan = (int)$_POST['CustomerMaketplan'];
                $CustomerMarketPlanService = new CustomerMarketPlanService();
                $CustomerMarketPlanService->loadCustomerMarketPlan($CustomerMaketplan);
              }
        }

    }

}




?>
