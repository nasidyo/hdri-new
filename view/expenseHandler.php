<?php
require_once '../service/ExpenseService.php';
require_once '../model/ExpenseM.php';
require_once '../service/SeqService.php';
require_once '../service/OrderService.php';
require_once '../model/OrderM.php';
require_once '../service/OtherExpenseService.php';
require_once '../service/AccountYearService.php';

require_once '../model/StocksM.php';
require_once '../service/StocksService.php';


require_once '../model/SavingM.php';
require_once '../service/SavingService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        $exp=0;
        if($action=='add'){
            $expenseM = new expenseM();
            $seqService = new SeqService();
            $seq= $seqService->get("expense_id");
            $expenseM->setExpenseId( $seq);
            if (isset($_POST['order_id'])) {
                $expenseM->setOrderId(intval($_POST['order_id']));
            }
            if (isset($_POST['create_by'])) {
                $expenseM->setCreateBy(intval($_POST['create_by']));
            }
            if (isset($_POST['expense_by'])) {
                $expenseM->setExpenseBy(intval($_POST['expense_by']));
            }
            if (isset($_POST['customer'])) {
                $expenseM->setCustomer(intval($_POST['customer']));
            }
            if (isset($_POST['discount'])) {
                $expenseM->setDiscount(floatval($_POST['discount']));
            }
            if (isset($_POST['amount'])) {
                $expenseM->setAmount(floatval($_POST['amount']));
            }
            if (isset($_POST['price'])) {
                $expenseM->setPrice(floatval($_POST['price']));
            }
            if (isset($_POST['expense_other_id'])) {
                $expenseM->setExpenseOtherId($_POST['expense_other_id']);
            }
            if (isset($_POST['debt'])) {
                $expenseM->setDebt(floatval($_POST['debt']));
            }
            if (isset($_POST['market_id'])) {
                $expenseM->setMarketId(intval($_POST['market_id']));
            }
            if (isset($_POST['institute_id'])) {
                $expenseM->setInstituteId(intval($_POST['institute_id']));
            }
            if (isset($_POST['expense_amount'])) {
                $expenseM->setExpenseAmount(floatval($_POST['expense_amount']));
            }
            if (isset($_POST['expense_date'])) {
                $expenseM->setExpenseDate($_POST['expense_date']);
            }
            if (isset($_POST['other_customer'])) {
                $expenseM->setOtherCustomer($_POST['other_customer']);
            }
            if (isset($_POST['discount'])) {
                $expenseM->setDiscount(floatval($_POST['discount']));
            }
            if (isset($_POST['doc_no'])) {
                $expenseM->setDocNo($_POST['doc_no']);
            }
            if (isset($_POST['canceled'])) {
                $expenseM->setCanceled($_POST['canceled']);
            }

            if (isset($_POST['canceled'])) {
                $expenseM->setCanceled($_POST['canceled']);
            }
            if (isset($_POST['sub_group_id'])) {
                $expenseM->setSubGroupId($_POST['sub_group_id']);
            }
            if (isset($_POST['business_group_id'])) {
                $expenseM->setBusinessGroupId($_POST['business_group_id']);
            }
            if (isset($_POST['exp'])) {
                $exp = floatval($_POST['exp']);
            }

            $AccountYearService = new AccountYearService();
            $AccountYearM  =  $AccountYearService->loadAccountInYear($expenseM->getExpenseDate(), $expenseM->getSubGroupId());

            var_dump('AccountYearM '.$AccountYearM);
            try {
                $OrderService = new OrderService();
                $mode="plus";
                $expense_other_id=$expenseM->getExpenseOtherId();
                $OtherExpenseService = new OtherExpenseService();

                    if($AccountYearM->getCurrentBugget() < $expenseM->getPrice()){
                        echo 'จำนวนเงินสดน้อยกว่ารายจ่าย';
                        exit ;
                    }

                    if( $expenseM->getExpenseAmount() !=0){
                        if($expense_other_id > 0){

                            $OtherExpenseM =  $OtherExpenseService->loadOtherExpenseM($expense_other_id);

                            if($OtherExpenseM->getType()=="B"){
                                    if( $AccountYearM != null ){
                                        $oldBankAmount =$AccountYearM->getBankBugget();
                                        $oldCurrentAmount =$AccountYearM->getCurrentBugget();
                                        $newBankAmount =   $oldBankAmount + $expenseM->getPrice();
                                        $newCurrentAmount =   $oldCurrentAmount - $expenseM->getPrice();
                                        $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                                        $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                    }
                            }else if($OtherExpenseM->getType()=="S"){
                                if( $AccountYearM != null ){
                                    if( $expenseM->getPrice() % 10 !=0){
                                        echo'จำนวนเงินค่าหุ้นไม่สัมพันธ์กับราคา';
                                        exit;
                                    }

                                    if($expenseM->getCustomer()==0 && $expenseM->getOtherCustomer() !=""){
                                        echo 'โปรดเลือกสมาชิกกลุ่มที่ต้องการขายหุ้น';
                                        exit;
                                    }
                                        $oldStocksAmount =$AccountYearM->getStocksAmount();
                                        $oldStocksAmountNet =$expenseM->getPrice() / $AccountYearM->getStocksPrice() ;
                                        $newStocksAmount = $oldStocksAmount - $oldStocksAmountNet;
                                        $newCurrentAmount = $AccountYearM->getCurrentBugget() - $expenseM->getPrice();

                                        $StocksService = new StocksService();
                                        $stocksArr =  $StocksService->loadStocksByUser($expenseM->getCustomer());

                                        if(!empty($stocksArr)){
                                            $allStocks =0;
                                            foreach ($stocksArr as $stocks)
                                            {
                                                $allStocks +=$stocks->getAmount();
                                            }
                                            $stocksValue = $AccountYearM->getStocksPrice() * $allStocks ;
                                          if( $stocksValue >=0 && $stocksValue >= $expenseM->getPrice() ){
                                              $diffStocks =  ($stocksValue - $expenseM->getPrice())/$AccountYearM->getStocksPrice();
                                            try{
                                                $StocksService->delStocksByPerson($expenseM->getCustomer());
                                            }catch(Exception $e) {
                                                exit;
                                            }  finally {
                                                if($diffStocks>0){
                                                    $StocksM = new StocksM();
                                                    $seqService = new SeqService();
                                                    $seqStocks= $seqService->get("stocks_id");
                                                    $StocksM->setStocksId( $seqStocks);
                                                    $StocksM->setPersonId($expenseM->getCustomer()) ;
                                                    $StocksM->setAmount($diffStocks);
                                                    $StocksM->setSubGroupId($expenseM->getSubGroupId());
                                                    $StocksM->setCreateDate( $expenseM->getExpenseDate());
                                                    $StocksService->addStocks( $StocksM);
                                                }

                                            }

                                          }else{
                                           echo'จำนวนราคาไม่ถูกต้องหุ้นปัจจุบัน :'.$allStocks.' หน่วย มูลค่า :'. $stocksValue.' บาท';
                                            exit;
                                          }

                                          $AccountYearService->updateStocks($AccountYearM->getAccountYearId() , $newStocksAmount);
                                          $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                        }else{
                                            echo'โปรดตรวจสอบจำนวนหุ้นที่ถืออยู่';
                                            exit();
                                        }
                                }
                            }
                            else if($OtherExpenseM->getType()=="A"){
                                $SavingService = new SavingService();
                                if( $AccountYearM != null ){
                                     $account = $SavingService->loadSavingByUser($expenseM->getCustomer())[0];
                                     try{

                                            $SavingM = new SavingM();
                                            $SavingM->setSavingId( $account->getSavingId());
                                            $SavingM->setPersonId($expenseM->getCustomer()) ;
                                            $SavingM->setAmount( $account->getAmount() - $expenseM->getPrice() );
                                            $SavingM->setSubGroupId($expenseM->getSubGroupId());
                                            $SavingService->updateSaving($SavingM);

                                     }catch (Exception $e) {
                                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                                        exit;
                                     }finally{
                                        $oldBankAmount =$AccountYearM->getCurrentBugget();
                                        $newCurrentAmount =   $oldBankAmount - $expenseM->getPrice();
                                        $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                     }

                                }

                            }
                            else if($OtherExpenseM->getType()=="I"){
                                $SavingService = new SavingService();
                                if( $AccountYearM != null ){
                                     $account = $SavingService->loadSavingByUser($expenseM->getCustomer())[0];
                                     try{

                                            $SavingM = new SavingM();
                                            $SavingM->setSavingId( $account->getSavingId());
                                            $SavingM->setPersonId($expenseM->getCustomer()) ;
                                            $SavingM->setAmount( $account->getAmount() + $expenseM->getPrice() );
                                            $SavingM->setSubGroupId($expenseM->getSubGroupId());
                                            $SavingService->updateSaving($SavingM);

                                     }catch (Exception $e) {
                                        echo 'Caught exception: ',  $e->getMessage(), "\n";
                                        exit;
                                     }

                                }

                            }
                            else{
                                if( $AccountYearM != null ){
                                    $oldBankAmount =$AccountYearM->getCurrentBugget();
                                    $newCurrentAmount =   $oldBankAmount - $expenseM->getExpenseAmount();
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);

                                }
                            }
                        }
                    }

            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            } finally {

                $order_id=$expenseM->getOrderId();
                if( $order_id !=0){
                    $new_num= $expenseM->getAmount();
                    $OrderService->updateBalance($order_id , $new_num ,$mode);
                }
                $expenseService = new ExpenseService();
                $expenseService->addExpense($expenseM);

                if( $AccountYearM != null ){
                    $oldBankAmount =$AccountYearM->getCurrentBugget();
                    $newCurrentAmount =   $oldBankAmount - $expenseM->getExpenseAmount();
                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                }
            }
        }
        if($action=='update'){
            $expenseM = new expenseM();
            if (isset($_POST['expense_id'])) {
                $expenseM->setExpenseId($_POST['expense_id']);
            }
            if (isset($_POST['update_by'])) {
                $expenseM->setUpdateBy($_POST['update_by']);
            }
            if (isset($_POST['comment'])) {
                $expenseM->setComment($_POST['comment']);
            }
            if (isset($_POST['canceled'])) {
                $expenseM->setCanceled($_POST['canceled']);
            }
            if (isset($_POST['expense_amount'])) {
                $expenseM->setExpenseAmount(floatval($_POST['expense_amount']));
            }
            if (isset($_POST['debt'])) {
                $expenseM->setDebt(floatval($_POST['debt']));
            }
            if (isset($_POST['sub_group_id'])) {
                $expenseM->setSubGroupId($_POST['sub_group_id']);
            }
            $expenseService = new ExpenseService();
            $expense=  $expenseService->loadExpenseM($expenseM->getExpenseId());
            try {

                    $tempStatus =$expenseM->getCanceled();
                if( $expenseM->getCanceled()=='Y'){


                    $mode="minus";
                    $new_num= $expenseM->getAmount();
                    $order_id=$expenseM->getOrderId();
                    $OrderService = new OrderService();
                    $OrderService->updateBalance($order_id , $new_num ,$mode);
                    $OtherExpenseService = new OtherExpenseService();
                    $AccountYearService = new AccountYearService();

                    $expense_other_id=$expense->getExpenseOtherId();

                    if($expense_other_id > 0){

                        $OtherExpenseM =  $OtherExpenseService->loadOtherExpenseM($expense_other_id);
                        $AccountYearM  =  $AccountYearService->loadAccountInYear($expense->getExpenseDate() ,$expenseM->getSubGroupId());

                            if($OtherExpenseM->getType()=="B"){
                                if( $AccountYearM != null ){
                                    $oldBankAmount =$AccountYearM->getCurrentBugget();
                                    $newBankAmount =   $oldBankAmount - $expense->getExpenseAmount();
                                    $newCurrentAmount =   $oldBankAmount + $expense->getExpenseAmount();
                                    $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                }
                        }else if($OtherExpenseM->getType()=="S"){

                            $oldStocksAmount =$AccountYearM->getStocksAmount();
                            $oldStocksAmountNet =$expense->getExpenseAmount() / $AccountYearM->getStocksPrice() ;
                            $newStocksAmount = $oldStocksAmount + $oldStocksAmountNet;

                            $newCurrentAmount = $AccountYearM->getCurrentBugget() + $expense->getExpenseAmount();

                            $AccountYearService->updateStocks($AccountYearM->getAccountYearId() , $newStocksAmount);
                            $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                            $StocksService = new StocksService();
                            $stocksArr =  $StocksService->loadStocksByUser($expense->getCustomer());

                            $allStocks =0;
                            foreach ($stocksArr as $stocks)
                            {
                                $allStocks +=$stocks->getAmount();
                            }
                            $stocksValue = $AccountYearM->getStocksPrice() * $allStocks ;
                          if( $stocksValue >=0 && $stocksValue >= $expense->getExpenseAmount() ){
                              $diffStocks =  ($stocksValue + $expense->getExpenseAmount())/$AccountYearM->getStocksPrice();
                            try{
                                $StocksService->delStocksByPerson($expense->getCustomer());
                            }catch(Exception $e) {
                                exit;
                            }  finally {
                                if($diffStocks>0){
                                    $StocksM = new StocksM();
                                    $seqService = new SeqService();
                                    $seqStocks= $seqService->get("stocks_id");
                                    $StocksM->setStocksId( $seqStocks);
                                    $StocksM->setPersonId($expense->getCustomer()) ;
                                    $StocksM->setAmount($diffStocks);
                                    $StocksM->setSubGroupId($expense->getSubGroupId());
                                    $StocksM->setCreateDate( $expense->getExpenseDate());
                                    $StocksService->addStocks( $StocksM);
                                }

                            }

                          }else{
                            $diffStocks =$expense->getExpenseAmount()/$AccountYearM->getStocksPrice();
                            $StocksM = new StocksM();
                            $seqService = new SeqService();
                            $seqStocks= $seqService->get("stocks_id");
                            $StocksM->setStocksId( $seqStocks);
                            $StocksM->setPersonId($expense->getCustomer()) ;
                            $StocksM->setAmount($diffStocks);
                            $StocksM->setSubGroupId($expense->getSubGroupId());
                            $StocksM->setCreateDate( $expense->getExpenseDate());
                            $StocksService->addStocks( $StocksM);
                          }

                        }
                        else if($OtherExpenseM->getType()=="A"){
                            $SavingService = new SavingService();
                            if( $AccountYearM != null ){
                                 $account = $SavingService->loadSavingByUser($expense->getCustomer())[0];
                                 try{

                                        $SavingM = new SavingM();
                                        $SavingM->setSavingId( $account->getSavingId());
                                        $SavingM->setPersonId($expense->getCustomer()) ;
                                        $SavingM->setAmount($expense->getPrice()+ $account->getAmount());
                                        $SavingM->setSubGroupId($expenseM->getSubGroupId());
                                        $SavingService->updateSaving($SavingM);

                                 }catch (Exception $e) {
                                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                                    exit;
                                 }finally{
                                    $oldBankAmount =$AccountYearM->getCurrentBugget();
                                    $newCurrentAmount =   $oldBankAmount + $expense->getPrice();
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                 }

                            }

                        }
                        else if($OtherExpenseM->getType()=="I"){
                            $SavingService = new SavingService();
                            if( $AccountYearM != null ){
                                 $account = $SavingService->loadSavingByUser($expense->getCustomer())[0];
                                 try{

                                        $SavingM = new SavingM();
                                        $SavingM->setSavingId( $account->getSavingId());
                                        $SavingM->setPersonId($expense->getCustomer()) ;
                                        $SavingM->setAmount($expense->getPrice()- $account->getAmount());
                                        $SavingM->setSubGroupId($expenseM->getSubGroupId());
                                        $SavingService->updateSaving($SavingM);

                                 }catch (Exception $e) {
                                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                                    exit;
                                 }

                            }

                        }

                        else{
                            $AccountYearM  =  $AccountYearService->loadAccountInYear($expense->getExpenseDate(), $expenseM->getSubGroupId());

                            if( $AccountYearM != null ){
                                $oldBankAmount =$AccountYearM->getCurrentBugget();
                                $newCurrentAmount =   $oldBankAmount + $expense->getExpenseAmount();
                                $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                            }
                        }

                    }else{

                        $AccountYearM  =  $AccountYearService->loadAccountInYear($expense->getExpenseDate(), $expenseM->getSubGroupId());

                        if( $AccountYearM != null ){
                            $oldBankAmount =$AccountYearM->getCurrentBugget();
                            $newCurrentAmount =   $oldBankAmount + $expense->getExpenseAmount();
                            $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                        }
                    }
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            } finally {
                $expenseM->setCanceled( $tempStatus);
                $expenseService = new ExpenseService();
                $expenseService->updateExpense($expenseM);

            }


        }


        if($action=='delete'){
            if (isset($_POST['expense_id'])) {
                $expense_id = (int)$_POST['expense_id'];
                $expenseService = new ExpenseService();
                $expenseService->delExpense($expense_id);

              }
        }

        if($action=='load'){
            if (isset($_POST['expense_id'])) {
                $expense_id = (int)$_POST['expense_id'];
                $expenseService = new ExpenseService();
                $expenseService->loadExpense($expense_id);
              }
        }

    }

}




?>
