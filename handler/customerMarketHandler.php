<?php
require_once '../service/CustomerMarketService.php';
require_once '../model/CustomerMarketM.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $CustomerMarketM = new CustomerMarketM();

            if (isset($_POST['customer_id'])) {
                $CustomerMarketM->setIdCustomer($_POST['customer_id']);
            }
            if (isset($_POST['idMarket'])) {
                $CustomerMarketM->setIdMarket($_POST['idMarket']);
            }
            if (isset($_POST['idArea'])) {
                $CustomerMarketM->setIdArea($_POST['idArea']);
            }
            


            $CustomerMarketService = new CustomerMarketService();
            $CustomerMarketService->addCustomerMarket($CustomerMarketM);

        }
        if($action=='update'){
            $CustomerMarketM = new CustomerMarketM();
            if (isset($_POST['customer_id'])) {
                $CustomerMarketM->setIdCustomer($_POST['customer_id']);
            }
            if (isset($_POST['idMarket'])) {
                $CustomerMarketM->setIdMarket($_POST['idMarket']);
            }
            if (isset($_POST['idArea'])) {
                $CustomerMarketM->setIdArea($_POST['idArea']);
            }
            if (isset($_POST['customer_market_id'])) {
                $CustomerMarketM->setIdCustomerMarket($_POST['customer_market_id']);
            }

            $CustomerMarketService = new CustomerMarketService();
            $CustomerMarketService->updateCustomerMarket($CustomerMarketM);
        }


        if($action=='delete'){
            if (isset($_POST['customer_market_id'])) {
                $customer_market_id = (int)$_POST['customer_market_id'];
                $CustomerMarketService = new CustomerMarketService();
                $CustomerMarketService->delCustomerMarket($customer_market_id);
              }
        }

        if($action=='load'){
            if (isset($_POST['customer_market_id'])) {
                $customer_market_id = (int)$_POST['customer_market_id'];
                $CustomerMarketService = new CustomerMarketService();
                $CustomerMarketService->loadCustomerMarket($customer_market_id);
              }
        }

    }

}




?>
