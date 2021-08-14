<?php
require_once '../service/PersonGroupService.php';
require_once '../model/PersonGroupM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];

        if($action=='add'){
            $PersonGroupM = new PersonGroupM();
            $seqService = new SeqService();
            $seq= $seqService->get("person_group");

            $PersonGroupM->setPersonGroupId( $seq);

            if (isset($_POST['institute_id'])) {
                $PersonGroupM->setInstituteId($_POST['institute_id']);
            }
            if (isset($_POST['person_id'])) {
                $PersonGroupM->setPersonId($_POST['person_id']);
            }
            if (isset($_POST['year_register'])) {
                $PersonGroupM->setYearRegister($_POST['year_register']);
            }
            if (isset($_POST['position_id'])) {
                $PersonGroupM->setPositionId($_POST['position_id']);
            }
            if (isset($_POST['sub_group_id'])) {
                $PersonGroupM->setSubGroupId($_POST['sub_group_id']);
            }


           $PersonGroupService = new PersonGroupService();
           $PersonGroupService->addPersonGroup($PersonGroupM);

        }
        if($action=='update'){
            $PersonGroupM = new PersonGroupM();
            if (isset($_POST['person_group_id'])) {
                $PersonGroupM->setPersonGroupId( $_POST['person_group_id']);
            }
            if (isset($_POST['institute_id'])) {
                $PersonGroupM->setInstituteId($_POST['institute_id']);
            }
            if (isset($_POST['person_id'])) {
                $PersonGroupM->setPersonId($_POST['person_id']);
            }
            if (isset($_POST['year_register'])) {
                $PersonGroupM->setYearRegister($_POST['year_register']);
            }
            if (isset($_POST['position_id'])) {
                $PersonGroupM->setPositionId($_POST['position_id']);
            }
            if (isset($_POST['sub_group_id'])) {
                $PersonGroupM->setSubGroupId($_POST['sub_group_id']);
            }

            $PersonGroupService = new PersonGroupService();
            $PersonGroupService->updatePersonGroup($PersonGroupM);
        }


        if($action=='delete'){
            if (isset($_POST['person_id']) && isset($_POST['institute_id']) && isset($_POST['sub_group_id'])) {
                $person_id = $_POST['person_id'];
                $institute_id= $_POST['institute_id'];
                $sub_group_id= $_POST['sub_group_id'];
                $PersonGroupService = new PersonGroupService();
                $PersonGroupService->delPerson($person_id,$institute_id, $sub_group_id);

              }
        }

        if($action=='load'){
            if (isset($_POST['person_group_id'])) {
                $person_group_id = (int)$_POST['person_group_id'];
                $PersonGroupService = new PersonGroupService();
                $PersonGroupService->loadPersonGroup($person_group_id);
              }
        }

        if($action=='loadPersonGroup'){
            if (isset($_POST['person_id'])) {
                $person_id = (int)$_POST['person_id'];
                $PersonGroupService = new PersonGroupService();
                $PersonGroupService->loadPersonGroupByPersonId($person_id);
              }
        }




    }

}




?>
