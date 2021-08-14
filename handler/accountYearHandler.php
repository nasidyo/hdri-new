<?php
require_once '../service/AccountYearService.php';
require_once '../model/AccountYearM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $AccountYearM = new AccountYearM();
            $seqService = new SeqService();
            $seq= $seqService->get("account_year_id");

            $AccountYearM->setAccountYearId($seq);
            if (isset($_POST['account_year_start'])) {
                $AccountYearM->setAccountYearStart($_POST['account_year_start']);
            }
            if (isset($_POST['account_year_end'])) {
                $AccountYearM->setAccountYearEnd($_POST['account_year_end']);
            }
            if (isset($_POST['current_bugget'])) {
                $AccountYearM->setCurrentBugget($_POST['current_bugget']);
            }
            if (isset($_POST['status'])) {
                $AccountYearM->setStatus($_POST['status']);
            }
            if (isset($_POST['sub_group_id'])) {
                $AccountYearM->setSubGroupId($_POST['sub_group_id']);
            }

            if (isset($_POST['bank_bugget'])) {
                $AccountYearM->setBankBugget($_POST['bank_bugget']);
            }
            if (isset($_POST['stocks_amount'])) {
                $AccountYearM->setStocksAmount($_POST['stocks_amount']);
            }
            if (isset($_POST['stocks_price'])) {
                $AccountYearM->setStocksPrice($_POST['stocks_price']);
            }
            if (isset($_POST['year_text'])) {
                $AccountYearM->setYearText($_POST['year_text']);
            }
            $AccountYearService = new AccountYearService();
            $AccountYearService->addAccountYear($AccountYearM);

        }
        if($action=='update'){
            $AccountYearM = new AccountYearM();
            if (isset($_POST['account_year_id'])) {
                $AccountYearM->setAccountYearId($_POST['account_year_id']);
            }

            if (isset($_POST['account_year_start'])) {
                $AccountYearM->setAccountYearStart($_POST['account_year_start']);
            }
            if (isset($_POST['account_year_end'])) {
                $AccountYearM->setAccountYearEnd($_POST['account_year_end']);
            }
            if (isset($_POST['current_bugget'])) {
                $AccountYearM->setCurrentBugget($_POST['current_bugget']);
            }
            if (isset($_POST['status'])) {
                $AccountYearM->setStatus($_POST['status']);
            }
            if (isset($_POST['sub_group_id'])) {
                $AccountYearM->setSubGroupId($_POST['sub_group_id']);
            }
            if (isset($_POST['bank_bugget'])) {
                $AccountYearM->setBankBugget($_POST['bank_bugget']);
            }
            if (isset($_POST['stocks_amount'])) {
                $AccountYearM->setStocksAmount($_POST['stocks_amount']);
            }
            if (isset($_POST['stocks_price'])) {
                $AccountYearM->setStocksPrice($_POST['stocks_price']);
            }
            if (isset($_POST['year_text'])) {
                $AccountYearM->setYearText($_POST['year_text']);
            }

            $AccountYearService = new AccountYearService();
            $AccountYearService->updateAccountYear($AccountYearM);
        }



        if($action=='load'){
            if (isset($_POST['account_year_id'])) {
                $account_year_id = (int)$_POST['account_year_id'];
                $AccountYearService = new AccountYearService();
                $AccountYearService->loadAccountYear($account_year_id);
              }
        }



    }

}
