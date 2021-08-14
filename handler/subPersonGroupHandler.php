<?php
require_once '../service/SubPersonGroupService.php';
require_once '../model/SubPersonGroupM.php';
require_once '../service/SeqService.php';

require_once '../service/OtherExpenseService.php';
require_once '../model/OtherExpenseM.php';

require_once '../service/OtherIncomeService.php';
require_once '../model/OtherIncomeM.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        $SubPersonGroupService = new SubPersonGroupService();
        if($action=='add'){
            $SubPersonGroupM = new SubPersonGroupM();
            $seqService = new SeqService();
            $seq= $seqService->get("sub_group_id");

            $SubPersonGroupM->setSubGroupId($seq);

            if (isset($_POST['institute_id'])) {
                $SubPersonGroupM->setInstituteId($_POST['institute_id']);
            }
            if (isset($_POST['sub_group_name'])) {
                $SubPersonGroupM->setSubGroupName($_POST['sub_group_name']);
            }
            if (isset($_POST['person_group_id'])) {
                $SubPersonGroupM->setPersonGroupId($_POST['person_group_id']);
            }
            if (isset($_POST['status'])) {
                $SubPersonGroupM->setStatus($_POST['status']);
            }
           $SubPersonGroupService->addSubPersonGroup($SubPersonGroupM);

           $OtherExpenseService =new OtherExpenseService();
           $OtherExpenseMBK = new OtherExpenseM();
           $seqOthExBank= $seqService->get("other_expense_id");
           $OtherExpenseMBK->setExpenseOtherId($seqOthExBank);
           $OtherExpenseMBK->setExpenseDetail("ฝากเงินธนาคาร");
           $OtherExpenseMBK->setStatus("Y");
           $OtherExpenseMBK->setType("B");
           $OtherExpenseMBK->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherExpenseService->addOtherExpense($OtherExpenseMBK);

           $OtherExpenseM = new OtherExpenseM();
           $seqOthExStocks= $seqService->get("other_expense_id");
           $OtherExpenseM->setExpenseOtherId($seqOthExStocks);
           $OtherExpenseM->setExpenseDetail("ค่าหุ้น");
           $OtherExpenseM->setStatus("Y");
           $OtherExpenseM->setType("S");
           $OtherExpenseM->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherExpenseService->addOtherExpense($OtherExpenseM);

           $OtherExpenseM = new OtherExpenseM();
           $seqOthExSaving= $seqService->get("other_expense_id");
           $OtherExpenseM->setExpenseOtherId($seqOthExSaving);
           $OtherExpenseM->setExpenseDetail("ถอนเงินออมทรัทย์");
           $OtherExpenseM->setStatus("Y");
           $OtherExpenseM->setType("A");
           $OtherExpenseM->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherExpenseService->addOtherExpense($OtherExpenseM);

           $OtherExpenseM = new OtherExpenseM();
           $seqOthExSaving= $seqService->get("other_expense_id");
           $OtherExpenseM->setExpenseOtherId($seqOthExSaving);
           $OtherExpenseM->setExpenseDetail("จ่ายดอกเบี้ย");
           $OtherExpenseM->setStatus("Y");
           $OtherExpenseM->setType("I");
           $OtherExpenseM->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherExpenseService->addOtherExpense($OtherExpenseM);



           $OtherIncomeService =new OtherIncomeService();
           $OtherIncomeMBK = new OtherIncomeM();
           $seqOthInBank= $seqService->get("other_income_id");
           $OtherIncomeMBK->setIncomeOtherId( $seqOthInBank);
           $OtherIncomeMBK->setIncomeDetail("ถอนเงินธนาคาร");
           $OtherIncomeMBK->setStatus("Y");
           $OtherIncomeMBK->setType("B");
           $OtherIncomeMBK->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherIncomeService->addOtherIncome($OtherIncomeMBK);

           $OtherIncomeM = new OtherIncomeM();
           $seqOthInStocks= $seqService->get("other_income_id");
           $OtherIncomeM->setIncomeOtherId( $seqOthInStocks);
           $OtherIncomeM->setIncomeDetail("ค่าหุ้น");
           $OtherIncomeM->setStatus("Y");
           $OtherIncomeM->setType("S");
           $OtherIncomeM->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherIncomeService->addOtherIncome($OtherIncomeM);

           $OtherIncomeM = new OtherIncomeM();
           $seqOthInSaving= $seqService->get("other_income_id");
           $OtherIncomeM->setIncomeOtherId( $seqOthInSaving);
           $OtherIncomeM->setIncomeDetail("ฝากเงินออมทรัทย์");
           $OtherIncomeM->setStatus("Y");
           $OtherIncomeM->setType("A");
           $OtherIncomeM->setInstituteId( $SubPersonGroupM->getInstituteId());
           $OtherIncomeService->addOtherIncome($OtherIncomeM);





        }
        if($action=='update'){
            $SubPersonGroupM = new SubPersonGroupM();

            if (isset($_POST['sub_group_id'])) {
                $SubPersonGroupM->setSubGroupId($_POST['sub_group_id']);
            }
            if (isset($_POST['institute_id'])) {
                $SubPersonGroupM->setInstituteId($_POST['institute_id']);
            }
            if (isset($_POST['sub_group_name'])) {
                $SubPersonGroupM->setSubGroupName($_POST['sub_group_name']);
            }

            if (isset($_POST['status'])) {
                $SubPersonGroupM->setStatus($_POST['status']);
            }
            $SubPersonGroupService->updateSubPersonGroup($SubPersonGroupM);
        }
        if($action=='load'){
            if (isset($_POST['sub_group_id'])) {
                $sub_group_id = (int)$_POST['sub_group_id'];
                $SubPersonGroupService->loadSubPersonGroup($sub_group_id);
              }
        }
        if($action=='delete'){
            if (isset($_POST['sub_group_id'])) {
                $sub_group_id = (int)$_POST['sub_group_id'];
                $SubPersonGroupService->delSubPersonGroup($sub_group_id);
              }
        }

    }

}




?>
