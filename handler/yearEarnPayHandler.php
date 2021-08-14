<?php
require_once '../service/YearEarnPayService.php';
require_once '../model/YearEarnPayM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $YearEarnPayM = new YearEarnPayM();
            if (isset($_POST['person_id'])) {
                $YearEarnPayM->setIdPerson(intval($_POST['person_id']));
            }
            if (isset($_POST['year_get_pay'])) {
                $YearEarnPayM->setYearGetPay($_POST['year_get_pay']);
            }
            if (isset($_POST['earn_per_year'])) {
                $YearEarnPayM->setEarnPerYear(intval($_POST['earn_per_year']));
            }
            if (isset($_POST['pay_per_year'])) {
                $YearEarnPayM->setPayPerYear(intval($_POST['pay_per_year']));
            }
            $YearEarnPayService = new YearEarnPayService();
            $YearEarnPayService->addYearEarnPay($YearEarnPayM);

        }
        if($action=='update'){
            $YearEarnPayM = new YearEarnPayM();

            if (isset($_POST['order_id'])) {
                $orderM->setOrderId(intval($_POST['order_id']));
            }
            if (isset($_POST['institute_id'])) {
                $orderM->setInstituteId(intval($_POST['institute_id']));
            }
            if (isset($_POST['order_name'])) {
                $orderM->setOrderName($_POST['order_name']);
            }
            if (isset($_POST['balance'])) {
                $orderM->setBalance(intval($_POST['balance']));
            }
            if (isset($_POST['unit_id'])) {
                $orderM->setUnitId(intval($_POST['unit_id']));
            }
            if (isset($_POST['status'])) {
                $orderM->setStatus($_POST['status']);
            }
            if (isset($_POST['comment'])) {
                $orderM->setComment($_POST['comment']);
            }


            $YearEarnPayService = new YearEarnPayService();
            $YearEarnPayService->updateYearEarnPay($YearEarnPayM);
        }


        if($action=='delete'){
            if (isset($_POST['id_year_earn_pay'])) {
                $id_year_earn_pay = (int)$_POST['id_year_earn_pay'];
                $YearEarnPayService = new YearEarnPayService();
                $YearEarnPayService->delYearEarnPay($id_year_earn_pay);
              }
        }

        if($action=='load'){
            if (isset($_POST['order_id'])) {
                $order_id = (int)$_POST['order_id'];
                $orderService = new OrderService();
                $orderService->loadOrder($order_id);
              }
        }

    }

}




?>
