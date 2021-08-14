<?php
require_once '../service/IncomeService.php';
require_once '../model/IncomeM.php';
require_once '../service/SeqService.php';
require_once '../service/OrderService.php';
require_once '../model/OrderM.php';

require_once '../service/OtherIncomeService.php';
require_once '../service/AccountYearService.php';
require_once '../model/AccountYearM.php';


require_once '../model/StocksM.php';
require_once '../service/StocksService.php';


require_once '../model/SavingM.php';
require_once '../service/SavingService.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $incomeM = new incomeM();
            $seqService = new SeqService();
            $seq= $seqService->get("income_id");

            $incomeM->setIncomeId($seq);

            if (isset($_POST['order_id'])) {
                $incomeM->setOrderId(intval($_POST['order_id']));
            }
            if (isset($_POST['create_by'])) {
                $incomeM->setCreateBy(intval($_POST['create_by']));
            }
            if (isset($_POST['receive_by'])) {
                $incomeM->setReceiveBy(intval($_POST['receive_by']));
            }
            if (isset($_POST['customer'])) {
                $incomeM->setCustomer(intval($_POST['customer']));
            }
            if (isset($_POST['discount'])) {
                $incomeM->setDiscount(floatval($_POST['discount']));
            }
            if (isset($_POST['amount'])) {
                $incomeM->setAmount(floatval($_POST['amount']));
            }
            if (isset($_POST['price'])) {
                $incomeM->setPrice(floatval($_POST['price']));
            }
            if (isset($_POST['income_other_id'])) {
                $incomeM->setIncomeOtherId(intval($_POST['income_other_id']));
            }
            if (isset($_POST['debt'])) {
                $incomeM->setDebt(floatval($_POST['debt']));
            }
            if (isset($_POST['market_id'])) {
                $incomeM->setMarketId(intval($_POST['market_id']));
            }
            if (isset($_POST['institute_id'])) {
                $incomeM->setInstituteId(intval($_POST['institute_id']));
            }
            if (isset($_POST['receive_amount'])) {
                $incomeM->setReceiveAmount($_POST['receive_amount']);
            }
            if (isset($_POST['receive_date'])) {
                $incomeM->setReceiveDate($_POST['receive_date']);
            }
            if (isset($_POST['other_customer'])) {
                $incomeM->setOtherCustomer($_POST['other_customer']);
            }
            if (isset($_POST['discount'])) {
                $incomeM->setDiscount(floatval($_POST['discount']));
            }
            if (isset($_POST['doc_no'])) {
                $incomeM->setDocNo($_POST['doc_no']);
            }
            if (isset($_POST['canceled'])) {
                $incomeM->setCanceled($_POST['canceled']);
            }

            if (isset($_POST['sub_group_id'])) {
                $incomeM->setSubGroupId($_POST['sub_group_id']);
            }
            if (isset($_POST['business_group_id'])) {
                $incomeM->setBusinessGroupId($_POST['business_group_id']);
            }


            try {

                $income_other_id=$incomeM->getIncomeOtherId();
                $OtherIncomeService = new OtherIncomeService();
                $AccountYearService = new AccountYearService();
                if( $incomeM->getReceiveAmount()!=0){
                    if($income_other_id > 0){

                        $OtherIncomeM =  $OtherIncomeService->loadOtherIncomeM($income_other_id);
                        $AccountYearM  =  $AccountYearService->loadAccountInYear($incomeM->getReceiveDate() ,$incomeM->getSubGroupId());

                        if($OtherIncomeM->getType()=="B"){
                                if( $AccountYearM != null ){
                                    $oldBankAmount =$AccountYearM->getBankBugget();

                                    $oldCurrentAmount =$AccountYearM->getCurrentBugget();
                                    $newBankAmount =   $oldBankAmount - $incomeM->getPrice();

                                    $newCurrentAmount =   $oldCurrentAmount + $incomeM->getPrice();
                                    $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                }
                        }else if($OtherIncomeM->getType()=="S"){
                            if( $AccountYearM != null ){
                                if( $incomeM->getPrice() % 10 !=0){
                                    echo 'จำนวนเงินค่าหุ้นไม่สัมพันธ์กับราคา';
                                    exit ;
                                }

                                if($incomeM->getCustomer()==0 && $incomeM->getOtherCustomer() !=""){
                                    echo 'โปรดเลือกสมาชิกกลุ่มที่ต้องการซื้อหุ้น';
                                    exit ;
                                }

                                    $oldStocksAmount =$AccountYearM->getStocksAmount();
                                    $oldStocksAmountNet =$incomeM->getPrice() / $AccountYearM->getStocksPrice() ;
                                    $newStocksAmount = $oldStocksAmount + $oldStocksAmountNet;
                                    $newCurrentAmount = $AccountYearM->getCurrentBugget() + $incomeM->getPrice();
                                    $AccountYearService->updateStocks($AccountYearM->getAccountYearId() , $newStocksAmount);
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);

                                    $StocksM = new StocksM();
                                    $seqStocks= $seqService->get("stocks_id");
                                    $StocksM->setStocksId( $seqStocks);
                                    $StocksM->setPersonId($incomeM->getCustomer()) ;
                                    $StocksM->setAmount($oldStocksAmountNet);
                                    $StocksM->setSubGroupId($incomeM->getSubGroupId());
                                    $StocksM->setCreateDate( $incomeM->getReceiveDate());
                                    $StocksService = new StocksService();
                                    $StocksService->addStocks( $StocksM);


                            }
                        }
                        else if($OtherIncomeM->getType()=="A"){
                            $SavingService = new SavingService();
                            if( $AccountYearM != null ){
                                 $account = $SavingService->loadSavingByUser($incomeM->getCustomer());
                                 try{
                                    if( $account==null){ // case insert
                                        $SavingM = new SavingM();
                                        $seqSaving= $seqService->get("saving_seq");
                                        $SavingM->setSavingId( $seqSaving);
                                        $SavingM->setPersonId($incomeM->getCustomer()) ;
                                        $SavingM->setAmount($incomeM->getPrice());
                                        $SavingM->setSubGroupId($incomeM->getSubGroupId());
                                        $SavingM->setCreateDate( $incomeM->getReceiveDate());

                                        $SavingService->addSaving($SavingM);
                                     }else{ // update balance
                                        $acc = $account[0];
                                        $SavingM = new SavingM();

                                        $SavingM->setSavingId( $acc->getSavingId());
                                        $SavingM->setPersonId($incomeM->getCustomer()) ;
                                        $SavingM->setAmount($incomeM->getPrice()+ $acc->getAmount());
                                        $SavingM->setSubGroupId($incomeM->getSubGroupId());
                                        $SavingM->setCreateDate( $incomeM->getReceiveDate());
                                        $SavingService->updateSaving($SavingM);
                                     }
                                 }catch (Exception $e) {
                                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                                    exit;
                                 }finally{
                                    $oldBankAmount =$AccountYearM->getCurrentBugget();
                                    $newCurrentAmount =   $oldBankAmount + $incomeM->getPrice();
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                 }

                            }

                        }
                        else{
                            $AccountYearM  =  $AccountYearService->loadAccountInYear($incomeM->getReceiveDate(),$incomeM->getSubGroupId());

                            if( $AccountYearM != null ){
                                $oldBankAmount =$AccountYearM->getCurrentBugget();
                                $newCurrentAmount =   $oldBankAmount + $incomeM->getPrice();
                                $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                            }
                        }
                    }else{
                        $AccountYearM  =  $AccountYearService->loadAccountInYear($incomeM->getReceiveDate(),$incomeM->getSubGroupId());
                        if( $AccountYearM != null ){
                            $oldBankAmount =$AccountYearM->getCurrentBugget();
                            $newCurrentAmount =   $oldBankAmount + $incomeM->getPrice();
                            $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                        }
                    }
                }


            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                exit;
            } finally {
            $OrderService = new OrderService();
            $validate = false;
            if($incomeM->getOrderId()!=0){
                $OrderM = $OrderService->loadOrderM($incomeM->getOrderId());
                $balance =  $OrderM->getBalance();
                if($balance==0 ){
                    echo 'สินค้าในคลังหมดแล้ว';
                    exit;
                }else{
                    $validate = true;
                }
            }else{
                $validate = true;
            }
            if($validate){
                try {
                    $IncomeService = new IncomeService();
                    $IncomeService->addIncome($incomeM);

                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                } finally {
                    $order_id=$incomeM->getOrderId();
                    if( $order_id !=0 &&  $incomeM->getCanceled()=='N'){
                        $mode="minus";
                        $new_num= $incomeM->getAmount();
                        $OrderService->updateBalance($order_id , $new_num ,$mode);
                    }


                }
            }
         }

    }
        if($action=='update'){
            $incomeM = new incomeM();
            if (isset($_POST['income_id'])) {
                $incomeM->setIncomeId($_POST['income_id']);
            }
            if (isset($_POST['update_by'])) {
                $incomeM->setUpdateBy($_POST['update_by']);
            }
            if (isset($_POST['comment'])) {
                $incomeM->setComment($_POST['comment']);
            }
            if (isset($_POST['canceled'])) {
                $incomeM->setCanceled($_POST['canceled']);
            }
            if (isset($_POST['receive_amount'])) {
                $incomeM->setReceiveAmount(floatval($_POST['receive_amount']));
            }if (isset($_POST['debt'])) {
                $incomeM->setDebt(floatval($_POST['debt']));
            }

            try {
                  $tmpStatus = $incomeM->getCanceled();
                  $IncomeService = new IncomeService();
                  $income =  $IncomeService->loadIncomeM($incomeM->getIncomeId());
                  $AccountYearService = new AccountYearService();
                if( $incomeM->getCanceled()=='Y'){

                    $incomeM=  $IncomeService->loadIncomeM($incomeM->getIncomeId());
                    $mode="plus";
                    $new_num= $incomeM->getAmount();
                    $order_id=$incomeM->getOrderId();
                    $OrderService = new OrderService();
                    $OrderService->updateBalance($order_id , $new_num ,$mode);

                    $income_other_id=$income->getIncomeOtherId();
                    $OtherIncomeService = new OtherIncomeService();

                    if($income_other_id>0){

                        $OtherIncomeM =  $OtherIncomeService->loadOtherIncomeM($income_other_id);
                        $AccountYearM  =  $AccountYearService->loadAccountInYear($incomeM->getReceiveDate(),$incomeM->getSubGroupId());


                         if($OtherIncomeM->getType()=="B"){
                            if( $AccountYearM != null ){
                                $oldBankAmount =$AccountYearM->getCurrentBugget();
                                $newBankAmount =   $oldBankAmount + $incomeM->getPrice();
                                $newCurrentAmount =   $oldBankAmount - $incomeM->getPrice();
                                $AccountYearService->updateBank($AccountYearM->getAccountYearId() ,$newBankAmount);
                                $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                            }

                         }else if($OtherIncomeM->getType()=="S"){

                            $oldStocksAmount =$AccountYearM->getStocksAmount();
                            $oldStocksAmountNet =$incomeM->getPrice() / $AccountYearM->getStocksPrice() ;
                            $newStocksAmount = $oldStocksAmount - $oldStocksAmountNet;
                            $newCurrentAmount = $AccountYearM->getCurrentBugget() - $incomeM->getPrice();
                            $AccountYearService->updateStocks($AccountYearM->getAccountYearId() , $newStocksAmount);
                            $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);


                            $StocksService = new StocksService();
                            $stocksArr =  $StocksService->loadStocksByUser($incomeM->getCustomer());

                            if(!empty($stocksArr)){
                                $allStocks =0;
                                foreach ($stocksArr as $stocks)
                                {
                                    $allStocks +=$stocks->getAmount();
                                }
                                $stocksValue = $AccountYearM->getStocksPrice() * $allStocks ;
                              if( $stocksValue >=0 && $stocksValue >= $incomeM->getPrice() ){
                                  $diffStocks =  ($stocksValue - $incomeM->getPrice())/$AccountYearM->getStocksPrice();
                                try{
                                    $StocksService->delStocksByPerson($incomeM->getCustomer());
                                }catch(Exception $e) {
                                    exit;
                                }  finally {
                                    if($diffStocks!=0){
                                        $StocksM = new StocksM();
                                        $seqService = new SeqService();
                                        $seqStocks= $seqService->get("stocks_id");
                                        $StocksM->setStocksId( $seqStocks);
                                        $StocksM->setPersonId($incomeM->getCustomer()) ;
                                        $StocksM->setAmount($diffStocks);
                                        $StocksM->setSubGroupId($incomeM->getSubGroupId());
                                        $StocksM->setCreateDate( $incomeM->getReceiveDate());
                                        $StocksService = new StocksService();
                                        $StocksService->addStocks( $StocksM);
                                    }

                                }
                              }else{
                                echo 'จำนวนราคาไม่ถูกต้องหุ้นปัจจุบัน :'.$allStocks.' หน่วย มูลค่า :'. $stocksValue.' บาท';
                                exit;
                              }

                            }
                         }
                         else if($OtherIncomeM->getType()=="A"){
                            $SavingService = new SavingService();
                            if( $AccountYearM != null ){
                                echo 'Customer :'.$income->getCustomer();
                                 $account = $SavingService->loadSavingByUser($income->getCustomer())[0];
                                 var_dump($account);
                                 try{
                                    if( $account!=null){ // case insert
                                        $SavingM = new SavingM();

                                        $SavingM->setSavingId( $account->getSavingId());
                                        $SavingM->setPersonId($income->getCustomer()) ;
                                        $SavingM->setAmount($account->getAmount() - $income->getPrice());
                                        $SavingM->setSubGroupId($incomeM->getSubGroupId());
                                        $SavingService->updateSaving($SavingM);
                                     }
                                 }catch (Exception $e) {
                                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                                    exit;
                                 }finally{
                                    $oldBankAmount =$AccountYearM->getCurrentBugget();
                                    $newCurrentAmount =   $oldBankAmount - $income->getPrice();
                                    $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                                 }

                            }

                        }else{
                            $AccountYearM  =  $AccountYearService->loadAccountInYear($income->getReceiveDate(),$incomeM->getSubGroupId());
                            if( $AccountYearM != null ){
                                $oldBankAmount =$AccountYearM->getCurrentBugget();
                                $newCurrentAmount =   $oldBankAmount - $incomeM->getReceiveAmount();
                                $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                            }
                         }
                    }else{

                         $AccountYearM  =  $AccountYearService->loadAccountInYear($income->getReceiveDate(),$incomeM->getSubGroupId());

                            if( $AccountYearM != null ){
                                $oldBankAmount =$AccountYearM->getCurrentBugget();
                                $newCurrentAmount =   $oldBankAmount - $incomeM->getReceiveAmount() ;
                                $AccountYearService->updateCurrent($AccountYearM->getAccountYearId() ,$newCurrentAmount);
                            }
                    }


                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                exit;
            } finally {
                $incomeM->setCanceled($tmpStatus);
                $IncomeService = new IncomeService();
                $IncomeService->updateIncome($incomeM);

            }
        }
        if($action=='load'){
            if (isset($_POST['income_id'])) {
                $income_id = (int)$_POST['income_id'];
                $IncomeService = new IncomeService();
                $IncomeService->loadIncome($income_id);
            }
        }

    }

}




?>
