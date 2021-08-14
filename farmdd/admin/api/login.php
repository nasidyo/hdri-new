<?php
    require '../../service/user.php';
    require '../../connection/database.php';
    require '../../service/SeqServiceLog.php';
    require '../config/database.php';
    $timeConfig = date('Y-m-d H:i:s');
    $databaseConfig = new Database();
    $dbConfig = $databaseConfig->getConnection();
    $querydbConfig = "INSERT INTO LoginLogTD (username, loginDate) VALUES (?, ?)";
    $paramsdbConfig = array($_POST['emailusername'], $timeConfig);
    $stmtdbConfig = $dbdbConfig->prepare($querydbConfig);
    if($stmtdbConfig->execute($paramsdbConfig)) {
        echo 'True';
    }

    // if ($_POST['emailusername'] != null and $_POST['password']!= null) {
    //     if($_POST['usr-Ad'] == 'AD' and $_POST['emailusername'] != 'admin') {
    //         $user = new User();
    //         $login = $user->check_login($_POST['emailusername'], $_POST['password']);
    //         echo $login;
    //         if ($login) {
    //             // Registration Success
    //             $seqService = new SeqService();
    //             $logSeq= $seqService->get("logAccess_seq");
    //             $user->saveLogLogin($_POST['emailusername'], $logSeq);
    //             header("location: ../dashboard.php");
    //             exit();
    //         } else {
    //             header("location: ../login.php");
    //             exit();
    //         }
    //     } else {
    //         $user = new User();
    //         $login = $user->check_login_withoutAD($_POST['emailusername'], $_POST['password']);

    //         if ($login) {
    //             // Registration Success
    //             $seqService = new SeqService();
    //             $logSeq= $seqService->get("logAccess_seq");
    //             $user->saveLogLogin($_POST['emailusername'], $logSeq);
    //             header("location: ../dashboard.php");
    //             exit();
    //         } else {
    //             header("location: ../login.php");
    //             exit();
    //         }
    //     }
    // } else {
    //     header("location: ../login.php");
    //     exit();
    // }
?>