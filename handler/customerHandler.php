<?php
require_once '../service/CustomerService.php';
require_once '../model/CustomerM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $CustomerM = new CustomerM();



            if (isset($_POST['name'])) {
                $CustomerM->setName($_POST['name']);
            }
            if (isset($_POST['sname'])) {
                $CustomerM->setSname($_POST['sname']);
            }
            if (isset($_POST['status'])) {
                $CustomerM->setStatus($_POST['status']);
            }
            if (isset($_POST['address'])) {
                $CustomerM->setAddress($_POST['address']);
            }
            if (isset($_POST['phone'])) {
                $CustomerM->setPhone($_POST['phone']);
            }
            if (isset($_POST['comment'])) {
                $CustomerM->setComment($_POST['comment']);
            }


            $customerService = new CustomerService();
            $customerService->addCustomer($CustomerM);

        }
        if($action=='update'){
            $CustomerM = new CustomerM();


            if (isset($_POST['customer_id'])) {
                $CustomerM->setCustomerId($_POST['customer_id']);
            }
            if (isset($_POST['name'])) {
                $CustomerM->setName($_POST['name']);
            }
            if (isset($_POST['sname'])) {
                $CustomerM->setSname($_POST['sname']);
            }
            if (isset($_POST['status'])) {
                $CustomerM->setStatus($_POST['status']);
            }
            if (isset($_POST['address'])) {
                $CustomerM->setAddress($_POST['address']);
            }
            if (isset($_POST['phone'])) {
                $CustomerM->setPhone($_POST['phone']);
            }
            if (isset($_POST['comment'])) {
                $CustomerM->setComment($_POST['comment']);
            }

            $customerService = new CustomerService();
            $customerService->updateCustomer($CustomerM);
        }


        if($action=='delete'){
            if (isset($_POST['customer_id'])) {
                $customer_id = (int)$_POST['customer_id'];
                $customerService = new CustomerService();
                $customerService->delCustomer($customer_id);
              }
        }

        if($action=='load'){
            if (isset($_POST['customer_id'])) {
                $customer_id = (int)$_POST['customer_id'];
                $customerService = new CustomerService();
                $customerService->loadCustomer($customer_id);
              }
        }

    }

}




?>
