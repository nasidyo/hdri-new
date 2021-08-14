<?php
require_once '../service/UserService.php';
require_once '../model/UserM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action =$_POST['action'];
        if($action=='load_AD'){
            if (isset($_POST['emp_id'])) {
                $emp_id = (int)$_POST['emp_id'];
                $UserService = new UserService();
                $UserService->loadUserFromAD($emp_id);
            }
        }
        if($action=='load_User'){
            if (isset($_POST['emp_id'])) {
                $emp_id = (int)$_POST['emp_id'];
                $UserService = new UserService();
                $UserService->loadUser($emp_id);
            }
        }
        if($action=='createUser'){
            $UserM = new UserM();
            if (isset($_POST['data'])) {
                foreach($_POST['data'] as $data) {
                    $UserM->setPrefix($data['user_Prefix']);
                    $UserM->setFirstname(urldecode($data['user_FristName']));
                    $UserM->setLastname(urldecode($data['user_LastName']));
                    $UserM->setUsername($data['user_name']);
                    $UserM->setPassword($data['user_password']);
                    $UserM->setEmail(str_replace("%40", "@", $data['user_email']));
                    $UserM->setStatus($data['user_status']);
                    $UserM->setPermis($data['user_typePermission']);
                    $UserService = new UserService();
                    $UserService->createNewUser($UserM);
                    foreach($data['user_targetAreaList'] as $area) {
                        $UserM->setArea_Id($area);
                        $UserService = new UserService();
                        $UserService->createUserAndArea($UserM);
                    }
                }
            }
        }
        if($action=='editUser'){
            // echo $_POST['user_targetAreaList'];
            $UserM = new UserM();
            if (isset($_POST['emp_id'])) {
                $UserM->setStaff_Id($_POST['emp_id']);
            }
            if (isset($_POST['user_Prefix'])) {
                $UserM->setPrefix($_POST['user_Prefix']);
            }
            if (isset($_POST['user_FristName'])) {
                $UserM->setFirstname($_POST['user_FristName']);
            }
            if (isset($_POST['user_LastName'])) {
                $UserM->setLastname($_POST['user_LastName']);
            }
            if (isset($_POST['user_name'])) {
                $UserM->setUsername($_POST['user_name']);
            }
            if (isset($_POST['user_password'])) {
                $UserM->setPassword($_POST['user_password']);
            }
            if (isset($_POST['user_email'])) {
                $UserM->setEmail($_POST['user_email']);
            }
            if (isset($_POST['user_status'])) {
                $UserM->setStatus($_POST['user_status']);
            }
            if (isset($_POST['user_typePermission'])) {
                $UserM->setPermis($_POST['user_typePermission']);
            }
            $UserService = new UserService();
            $UserService->userDetailUser($UserM);
            $UserService->deleteAreaFromUpdat($UserM->getStaff_Id(), $_POST['user_targetAreaList']);
            if (isset($_POST['user_targetAreaList'])) {
                $user_targetAreaList = explode( ',', $_POST['user_targetAreaList'] );
                foreach($user_targetAreaList as $area) {
                    echo $area;
                    $UserService = new UserService();
                    $UserService->updateUserAndArea($UserM->getStaff_Id(), $area);
                }
            }
        }
        if($action=='deleteUser'){
            $UserService = new UserService();
            $UserService->deleteUser($_POST['emp_id']);
        }
    }

}




?>
