<?php
require_once '../service/yearService.php';
require_once '../model/yearTargetM.php';
require_once '../service/SeqService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){
        $action = $_POST['action'];
        if($action=='addYearTarget'){
            $yearM = new yearM();
            if(isset($_POST['yearName'])){
                $yearName = $_POST['yearName'];
                $yearM->setYearName($yearName);
            }
            if(isset($_POST['dtp_input_start'])){
                $date  = strtotime($_POST['dtp_input_start']);
                $day   = date('d',$date);
                $month = date('m',$date);
                $year  = date('Y',$date)-543;
                $dtp_input_startStamp = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                $yearM->setStartDate($dtp_input_startStamp);
            }
            if(isset($_POST['dtp_input_end'])){
                $date  = strtotime($_POST['dtp_input_end']);
                $day   = date('d',$date);
                $month = date('m',$date);
                $year  = date('Y',$date)-543;
                $dtp_input_EndStamp = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                $yearM->setEndDate($dtp_input_EndStamp);
            }
            $seqService = new SeqService();
            $yearId = $seqService->get("yearTB_seq");
            $yearM->setYearId($yearId);
            $yearService = new yearService();
            $yearService->createNewYearTB($yearM);
        }
        if($action=='loadYearDetail'){
            $yearService = new yearService();
            $yearService->LoadYearTB((int)$_POST['yearId']);
        }
        if($action=='editYearTarget'){
            $yearM = new yearM();
            if(isset($_POST['yearName_edit'])){
                $yearName = $_POST['yearName_edit'];
                $yearM->setYearName($yearName);
            }
            if(isset($_POST['dtp_input_start_edit'])){
                $date  = strtotime($_POST['dtp_input_start_edit']);
                $day   = date('d',$date);
                $month = date('m',$date);
                $year  = date('Y',$date)-543;
                $dtp_input_startStamp = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                $yearM->setStartDate($dtp_input_startStamp);
            }
            if(isset($_POST['dtp_input_end_edit'])){
                $date  = strtotime($_POST['dtp_input_end_edit']);
                $day   = date('d',$date);
                $month = date('m',$date);
                $year  = date('Y',$date)-543;
                $dtp_input_EndStamp = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                $yearM->setEndDate($dtp_input_EndStamp);
            }
            if(isset($_POST['idYearTB_edit'])){
                $yearM->setYearId((int)$_POST['idYearTB_edit']);
            }
            $yearService = new yearService();
            $yearService->updateYearTB($yearM);
        }
    }

}




?>
