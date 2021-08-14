<?php
require_once '../service/OrderService.php';
require_once '../model/OrderM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $orderM = new OrderM();
            $seqService = new SeqService();
            $seq= $seqService->get("order_id");

            $orderM->setOrderId($seq);
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
            if (isset($_POST['sub_group_id'])) {
                $orderM->setSubGroupId($_POST['sub_group_id']);
            }


            $orderService = new OrderService();
            $orderService->addOrder($orderM);

        }
        if($action=='update'){
            $orderM = new OrderM();

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


            $orderService = new OrderService();
            $orderService->updateOrder($orderM);
        }


        if($action=='delete'){
            if (isset($_POST['order_id'])) {
                $order_id = (int)$_POST['order_id'];
                $orderService = new OrderService();
                $orderService->delOrder($order_id);
              }
        }

        if($action=='load'){
            if (isset($_POST['order_id'])) {
                $order_id = (int)$_POST['order_id'];
                $orderService = new OrderService();
                $orderService->loadOrder($order_id);
              }
        }

        if($action=='updateBalance'){

            $mode="";
            $new_num=0;
            $order_id=0;

               if (isset($_POST['mode'])) {
                 $mode =$_POST['mode'];
                }
                if (isset($_POST['new_num'])) {
                    $new_num =$_POST['new_num'];
                }
                if (isset($_POST['order_id'])) {
                    $order_id =$_POST['order_id'];
                }
                $OrderService = new OrderService();
                $OrderService->updateBalance($order_id , $new_num ,$mode);
        }


    }

}




?>
