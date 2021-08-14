<?php
require_once '../service/OtherExpenseService.php';
require_once '../model/OtherExpenseM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $OtherExpenseM = new OtherExpenseM();
            $seqService = new SeqService();
            $seq= $seqService->get("other_expense_id");

            $OtherExpenseM->setExpenseOtherId( $seq);


            if (isset($_POST['expense_detail'])) {

                $OtherExpenseM->setExpenseDetail($_POST['expense_detail']);
            }
            if (isset($_POST['status'])) {
                $OtherExpenseM->setStatus($_POST['status']);
            }
            if (isset($_POST['comment'])) {
                $OtherExpenseM->setComment($_POST['comment']);
            }
            if (isset($_POST['institute_id'])) {
                $OtherExpenseM->setInstituteId($_POST['institute_id']);
            }




            $OtherExpenseService = new OtherExpenseService();
            $OtherExpenseService->addOtherExpense($OtherExpenseM);


        }
        if($action=='update'){
            $OtherExpenseM = new OtherExpenseM();
            if (isset($_POST['expense_detail'])) {
                $OtherExpenseM->setExpenseDetail($_POST['expense_detail']);
            }
            if (isset($_POST['status'])) {
                $OtherExpenseM->setStatus($_POST['status']);
            }
            if (isset($_POST['comment'])) {
                $OtherExpenseM->setComment($_POST['comment']);
            }
            if (isset($_POST['expense_other_id'])) {
                $OtherExpenseM->setExpenseOtherId($_POST['expense_other_id']);
            }
            if (isset($_POST['institute_id'])) {
                $OtherExpenseM->setInstituteId($_POST['institute_id']);
            }




            $OtherExpenseService = new OtherExpenseService();
            $OtherExpenseService->updateOtherExpense($OtherExpenseM);

        }
        if($action=='load'){
            if (isset($_POST['expense_other_id'])) {
                $expense_other_id = (int)$_POST['expense_other_id'];
                $OtherExpenseService = new OtherExpenseService();
                $OtherExpenseService->loadOtherExpense($expense_other_id);
              }
        }

    }

}




?>
