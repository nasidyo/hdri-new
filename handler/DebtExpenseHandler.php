<?php
require_once '../service/DebtExpenseService.php';
require_once '../service/ExpenseService.php';

require_once '../model/DebtExpenseM.php';
require_once '../service/SeqService.php';
require_once '../service/AccountYearService.php';
require_once '../model/AccountYearM.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $DebtExpenseM = new DebtExpenseM();
            $seqService = new SeqService();
            $seq= $seqService->get("debt_expense_id");
            $isTransfer =false;

            $DebtExpenseM->setDebtId( $seq);


            if (isset($_POST['create_by'])) {
                $DebtExpenseM->setCreateBy(intval($_POST['create_by']));
            }

            if (isset($_POST['customer'])) {
                $DebtExpenseM->setCustomer(intval($_POST['customer']));
            }

            if (isset($_POST['pay'])) {
                $DebtExpenseM->setPay(floatval($_POST['pay']));
            }

            if (isset($_POST['doc_no'])) {
                $DebtExpenseM->setDocNo($_POST['doc_no']);
            }
            if (isset($_POST['status'])) {
                $DebtExpenseM->setStatus($_POST['status']);
            }
            if (isset($_POST['expense_id'])) {
                $DebtExpenseM->setExpenseId($_POST['expense_id']);
            }
            if (isset($_POST['debtDate'])) {
                $DebtExpenseM->setCreateDate($_POST['debtDate']);
            }
            $pathImage='../img/Attach/';
            if(isset($_FILES["file"]["type"]))
            {



                $temp = explode(".", $_FILES["file"]["name"]);
                $newfilename = time().'.'.end($temp);
                move_uploaded_file($_FILES['file']['tmp_name'],  $pathImage.  $newfilename);
                $DebtExpenseM->setAttach($newfilename);
            }
            if (isset($_POST['transfer'])) {
                if($_POST['transfer']=='Y'){
                    $isTransfer = true;
                }
            }


            $AccountYearService = new AccountYearService();
            $ExpenseService = new ExpenseService();
            $expense =  $ExpenseService->loadExpenseM($DebtExpenseM->getExpenseId());
            echo 'isTransfer :'.$isTransfer;
            try{
                $AccountYearM  =  $AccountYearService->loadAccountInYear($expense->getExpenseDate() ,$expense->getSubGroupId());
              var_dump( $AccountYearM);
                if( $AccountYearM != null  && !$isTransfer ){
                    $oldCurrentAmount =$AccountYearM->getCurrentBugget();
                    $newCurrentAmount =   $oldCurrentAmount - $DebtExpenseM->getPay();
                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                }else{
                    $oldBankAmount =$AccountYearM->getBankBugget();
                    $newBankAmount =   $oldBankAmount - $DebtExpenseM->getPay();
                    $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                }

            } catch (Exception $e) {
                exit;
            } finally {
                $DebtExpenseService = new DebtExpenseService();
                $DebtExpenseService->addDebtExpense($DebtExpenseM);
            }



        }
        if($action=='update'){
            $DebtExpenseM = new DebtExpenseM();
            if (isset($_POST['debt_id'])) {
                $DebtExpenseM->setDebtId( $seq);
            }

            if (isset($_POST['create_by'])) {
                $DebtExpenseM->setCreateBy(intval($_POST['create_by']));
            }

            if (isset($_POST['customer'])) {
                $DebtExpenseM->setCustomer(intval($_POST['customer']));
            }

            if (isset($_POST['pay'])) {
                $DebtExpenseM->setPay(floatval($_POST['pay']));
            }

            if (isset($_POST['doc_no'])) {
                $DebtExpenseM->setDocNo($_POST['doc_no']);
            }
            if (isset($_POST['status'])) {
                $DebtExpenseM->setStatus($_POST['status']);
            }
            if (isset($_POST['expense_id'])) {
                $DebtExpenseM->setExpense_id($_POST['expense_id']);
            }

            $DebtExpenseService = new DebtExpenseService();
            $DebtExpenseService->updateDebtExpense($DebtExpenseM);
        }
        if($action=='load'){
            if (isset($_POST['expense_id'])) {
                $expense_id = (int)$_POST['expense_id'];
                $DebtExpenseService = new DebtExpenseService();
                $DebtExpenseService->loadDebtByExpenseId($expense_id);

              }
        }
        if($action=='calDebt'){
            if (isset($_POST['expense_id'])) {
                $id = (int)$_POST['expense_id'];
              }
              if (isset($_POST['debt'])) {
                $debt = floatval($_POST['debt']);
              }
              if (isset($_POST['update_by'])) {
                $update_by = (int)$_POST['update_by'];
              }


              $ExpenseService = new ExpenseService();
              $ExpenseService->updateDebtExpense($id,$debt,$update_by);
        }

        if($action=='cancelDebt'){
            $isTransfer =false;
            if (isset($_POST['expense_id'])) {
                $id = intval($_POST['expense_id']);
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
          $ExpenseService = new ExpenseService();
          $expense =  $ExpenseService->loadExpenseM($id);
          try{

              $AccountYearM  =  $AccountYearService->loadAccountInYear($expense->getExpenseDate(),$expense->getSubGroupId());
              if( $AccountYearM != null  && !$isTransfer ){
                  $oldCurrentAmount =$AccountYearM->getCurrentBugget();
                  $newCurrentAmount =   $oldCurrentAmount + $debtAmount;
                  $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
              }else{
                  $oldBankAmount =$AccountYearM->getBankBugget();
                  $newBankAmount =   $oldBankAmount + $debtAmount;
                  $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
              }

          } catch (Exception $e) {
              echo $e;
              exit;
          } finally {
            $ExpenseService = new ExpenseService();
            $ExpenseService->cancelDebtExpense($id,$debtId,$debtAmount,$user);
          }

        }

    }

}




?>
