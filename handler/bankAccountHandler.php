<?php
require_once '../service/BankAccountService.php';
require_once '../model/BankAccountM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $BankAccountM = new BankAccountM();
            $seqService = new SeqService();
            $seq= $seqService->get("bank_account_id");

            $BankAccountM->setBankAccountId($seq);
            if (isset($_POST['bank_no'])) {
                $BankAccountM->setBankNo($_POST['bank_no']);
            }
            if (isset($_POST['bank_name'])) {
                $BankAccountM->setBankName($_POST['bank_name']);
            }

            if (isset($_POST['status'])) {
                $BankAccountM->setStatus($_POST['status']);
            }

            if (isset($_POST['sub_group_id'])) {
                $BankAccountM->setSubGroupId($_POST['sub_group_id']);
            }


            $BankAccountService = new BankAccountService();
            $BankAccountService->addBankAccount($BankAccountM);

        }
        if($action=='update'){
            $BankAccountM = new BankAccountM();


            if (isset($_POST['bank_account_id'])) {
                $BankAccountM->setBankAccountId($_POST['bank_account_id']);
            }

            if (isset($_POST['bank_no'])) {
                $BankAccountM->setBankNo($_POST['bank_no']);
            }
            if (isset($_POST['bank_name'])) {
                $BankAccountM->setBankName($_POST['bank_name']);
            }

            if (isset($_POST['status'])) {
                $BankAccountM->setStatus($_POST['status']);
            }

            if (isset($_POST['sub_group_id'])) {
                $BankAccountM->setSubGroupId($_POST['sub_group_id']);
            }

            $BankAccountService = new BankAccountService();
            $BankAccountService->updateBankAccount($BankAccountM);
        }




        if($action=='load'){
            if (isset($_POST['bank_account_id'])) {
                $bank_account_id = (int)$_POST['bank_account_id'];
                $BankAccountService = new BankAccountService();
                $BankAccountService->loadBankAccount($bank_account_id);
              }
        }



    }

}




?>
