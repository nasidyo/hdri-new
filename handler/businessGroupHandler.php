<?php
require_once '../service/BusinessGroupService.php';
require_once '../model/BusinessGroupM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        $BusinessGroupService = new BusinessGroupService();
        if($action=='add'){
            $BusinessGroupM = new BusinessGroupM();
            $seqService = new SeqService();
            $seq= $seqService->get("business_group_id");

            $BusinessGroupM->setBusinessGroupId($seq);

            if (isset($_POST['business_group_name'])) {
                $BusinessGroupM->setBusinessGroupName($_POST['business_group_name']);
            }
            if (isset($_POST['sub_group_id'])) {
                $BusinessGroupM->setSubGroupId($_POST['sub_group_id']);
            }

            if (isset($_POST['status'])) {
                $BusinessGroupM->setStatus($_POST['status']);
            }
           $BusinessGroupService->addBusinessGroup($BusinessGroupM);

        }
        if($action=='update'){
            $BusinessGroupM = new BusinessGroupM();

            if (isset($_POST['business_group_id'])) {
                $BusinessGroupM->setBusinessGroupId($_POST['business_group_id']);
            }

            if (isset($_POST['business_group_name'])) {
                $BusinessGroupM->setBusinessGroupName($_POST['business_group_name']);
            }
            if (isset($_POST['sub_group_id'])) {
                $BusinessGroupM->setSubGroupId($_POST['sub_group_id']);
            }

            if (isset($_POST['status'])) {
                $BusinessGroupM->setStatus($_POST['status']);
            }
            $BusinessGroupService->updateBusinessGroup($BusinessGroupM);
        }
        if($action=='load'){
            if (isset($_POST['business_group_id'])) {
                $business_group_id = (int)$_POST['business_group_id'];
                $BusinessGroupService->loadBusinessGroup($business_group_id);
              }
        }


    }

}




?>
