<?php
require_once '../service/DebtIncomeService.php';
require_once '../service/IncomeService.php';

require_once '../model/DebtIncomeM.php';
require_once '../service/SeqService.php';

require_once '../service/AccountYearService.php';
require_once '../model/AccountYearM.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $DebtIncomeM = new DebtIncomeM();
            $seqService = new SeqService();
            $seq= $seqService->get("debt_income_id");
            $isTransfer =false;
            $DebtIncomeM->setDebtId( $seq);


            if (isset($_POST['create_by'])) {
                $DebtIncomeM->setCreateBy(intval($_POST['create_by']));
            }

            if (isset($_POST['customer'])) {
                $DebtIncomeM->setCustomer(intval($_POST['customer']));
            }

            if (isset($_POST['pay'])) {
                $DebtIncomeM->setPay(floatval($_POST['pay']));
            }

            if (isset($_POST['doc_no'])) {
                $DebtIncomeM->setDocNo($_POST['doc_no']);
            }
            if (isset($_POST['status'])) {
                $DebtIncomeM->setStatus($_POST['status']);
            }
            if (isset($_POST['income_id'])) {
                $DebtIncomeM->setIncomeId($_POST['income_id']);
            }
            if (isset($_POST['debtDate'])) {
                $DebtIncomeM->setCreateDate($_POST['debtDate']);
            }

            $pathImage='../img/Attach/';
            if(isset($_FILES["file"]["type"]))
            {



                $temp = explode(".", $_FILES["file"]["name"]);
                $newfilename = time().'.'.end($temp);
                move_uploaded_file($_FILES['file']['tmp_name'],  $pathImage.  $newfilename);
                $DebtIncomeM->setAttach($newfilename);
            }
            if (isset($_POST['transfer'])) {
                if($_POST['transfer']=='Y'){
                    $isTransfer = true;
                }
            }


            $AccountYearService = new AccountYearService();
            $IncomeService = new IncomeService();
            $income =  $IncomeService->loadIncomeM($DebtIncomeM->getIncomeId());
            try{

                $AccountYearM  =  $AccountYearService->loadAccountInYear($income->getReceiveDate(), $income->getSubGroupId());

                if( $AccountYearM != null  && !$isTransfer){
                    $oldCurrentAmount =$AccountYearM->getCurrentBugget();
                    $newCurrentAmount =   $oldCurrentAmount + $DebtIncomeM->getPay();
                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                }else if( $AccountYearM != null  && $isTransfer ){
                    $oldBankAmount =$AccountYearM->getBankBugget();
                    $newBankAmount =   $oldBankAmount + $DebtIncomeM->getPay();
                    $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                }

            } catch (Exception $e) {
                echo $e;
                exit;
            } finally {

                $DebtIncomeService = new DebtIncomeService();
                $DebtIncomeService->addDebtIncome($DebtIncomeM);

            }


        }
        if($action=='update'){
            $DebtIncomeM = new DebtIncomeM();
            if (isset($_POST['debt_id'])) {
                $DebtIncomeM->setDebtId( $seq);
            }

            if (isset($_POST['create_by'])) {
                $DebtIncomeM->setCreateBy(intval($_POST['create_by']));
            }

            if (isset($_POST['customer'])) {
                $DebtIncomeM->setCustomer(intval($_POST['customer']));
            }

            if (isset($_POST['pay'])) {
                $DebtIncomeM->setPay(floatval($_POST['pay']));
            }

            if (isset($_POST['doc_no'])) {
                $DebtIncomeM->setDocNo($_POST['doc_no']);
            }
            if (isset($_POST['status'])) {
                $DebtIncomeM->setStatus($_POST['status']);
            }
            if (isset($_POST['income_id'])) {
                $DebtIncomeM->setIncome_id($_POST['income_id']);
            }

            $DebtIncomeService = new DebtIncomeService();
            $DebtIncomeService->updateDebtIncome($DebtIncomeM);
        }
        if($action=='load'){
            if (isset($_POST['income_id'])) {
                $income_id = (int)$_POST['income_id'];
                $DebtIncomeService = new DebtIncomeService();
                $DebtIncomeService->loadDebtByIncomeId($income_id);

              }
        }
        if($action=='calDebt'){
            if (isset($_POST['income_id'])) {
                $id = floatval($_POST['income_id']);
              }
              if (isset($_POST['debt'])) {
                $debt = floatval($_POST['debt']);
              }
              if (isset($_POST['update_by'])) {
                $update_by = floatval($_POST['update_by']);
              }


              $IncomeService = new IncomeService();
              $IncomeService->updateDebtIncome($id,$debt,$update_by);
        }

        if($action=='cancelDebt'){
            $isTransfer =false;


            if (isset($_POST['income_id'])) {
                $id = intval($_POST['income_id']);
              }
              if (isset($_POST['debtId'])) {
                $debtId = intval($_POST['debtId']);
              }
              if (isset($_POST['debtAmount'])) {
                $debtAmount = floatval($_POST['debtAmount']);
              }

              if (isset($_POST['user'])) {
                $user = (int)$_POST['user'];
              }
              if (isset($_POST['attach']) && $_POST['attach']!='null') {
                    $isTransfer =true;
              }

              $AccountYearService = new AccountYearService();
              $IncomeService = new IncomeService();
              $income =  $IncomeService->loadIncomeM($id);
              try{

                  $AccountYearM  =  $AccountYearService->loadAccountInYear($income->getReceiveDate(), $income->getSubGroupId());

                  if( $AccountYearM != null  && !$isTransfer){
                      $oldCurrentAmount =$AccountYearM->getCurrentBugget();
                      $newCurrentAmount =   $oldCurrentAmount - $debtAmount;
                      $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                  }else if( $AccountYearM != null  && $isTransfer ){
                      $oldBankAmount =$AccountYearM->getBankBugget();
                      $newBankAmount =   $oldBankAmount - $debtAmount;
                      $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                  }

              } catch (Exception $e) {
                  echo $e;
                  exit;
              } finally {

                $IncomeService = new IncomeService();
                $IncomeService->cancelDebtIncome($id,$debtId,$debtAmount,$user);

              }

        }

    }

}




?>
