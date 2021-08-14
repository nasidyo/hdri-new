<?php
require_once '../service/OrgService.php';
require_once '../model/OrgM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $orgM = new OrgM();
            $seqService = new SeqService();
            $seq= $seqService->get("org_map_id");

            $orgM->setOrgMapId($seq);
            if (isset($_POST['account_year_id'])) {
                $orgM->setAccountYearId(intval($_POST['account_year_id']));
            }
            if (isset($_POST['org_id'])) {
                $orgM->setOrgId($_POST['org_id']);
            }
            if (isset($_POST['person_id'])) {
                $orgM->setPersonId($_POST['person_id']);
            }

            $orderService = new OrgService();
            $orderService->addOrg($orgM);

        }
        if($action=='update'){
            $orgM = new OrgM();
            if (isset($_POST['org_map_id'])) {
                $orgM->setOrgMapId($_POST['org_map_id']);
            }

            if (isset($_POST['account_year_id'])) {
                $orgM->setAccountYearId(intval($_POST['account_year_id']));
            }
            if (isset($_POST['org_id'])) {
                $orgM->setOrgId($_POST['org_id']);
            }
            if (isset($_POST['person_id'])) {
                $orgM->setPersonId($_POST['person_id']);
            }
            $orderService = new OrgService();
            $orderService->updateOrg($orgM);
        }




        if($action=='load'){
            if (isset($_POST['org_map_id'])) {
                $org_map_id = (int)$_POST['org_map_id'];
                $orderService = new OrgService();
                $orderService->loadOrg($org_map_id);
              }
        }

    }

}




?>
