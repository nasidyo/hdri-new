<?php
require_once '../service/OtherIncomeService.php';
require_once '../model/OtherIncomeM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $OtherIncomeM = new OtherIncomeM();
            $seqService = new SeqService();
            $seq= $seqService->get("other_income_id");

            $OtherIncomeM->setIncomeOtherId( $seq);


            if (isset($_POST['income_detail'])) {

                $OtherIncomeM->setIncomeDetail($_POST['income_detail']);
            }
            if (isset($_POST['status'])) {
                $OtherIncomeM->setStatus($_POST['status']);
            }
            if (isset($_POST['comment'])) {
                $OtherIncomeM->setComment($_POST['comment']);
            }
            if (isset($_POST['institute_id'])) {
                $OtherIncomeM->setInstituteId($_POST['institute_id']);
            }




            $OtherIncomeService = new OtherIncomeService();
            $OtherIncomeService->addOtherIncome($OtherIncomeM);


        }
        if($action=='update'){
            $OtherIncomeM = new OtherIncomeM();
            if (isset($_POST['income_detail'])) {
                $OtherIncomeM->setIncomeDetail($_POST['income_detail']);
            }
            if (isset($_POST['status'])) {
                $OtherIncomeM->setStatus($_POST['status']);
            }
            if (isset($_POST['comment'])) {
                $OtherIncomeM->setComment($_POST['comment']);
            }
            if (isset($_POST['income_other_id'])) {
                $OtherIncomeM->setIncomeOtherId($_POST['income_other_id']);
            }
            if (isset($_POST['institute_id'])) {
                $OtherIncomeM->setInstituteId($_POST['institute_id']);
            }
            $OtherIncomeService = new OtherIncomeService();
            $OtherIncomeService->updateOtherIncome($OtherIncomeM);

        }
        if($action=='load'){
            if (isset($_POST['income_other_id'])) {
                $income_other_id = (int)$_POST['income_other_id'];
                $OtherIncomeService = new OtherIncomeService();
                $OtherIncomeService->loadOtherIncome($income_other_id);
              }
        }

    }

}




?>
