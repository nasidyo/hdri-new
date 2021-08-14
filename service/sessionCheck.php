<?php
    session_start();
    require '../service/user.php';
    $user = new User();
    $uid = $_SESSION['uid'];
    if (!$user->get_session()){
        header("location:login.php");
        exit();
    }

    if (isset($_GET['q'])){
        $user->user_logout();
        header("location:login.php");
        exit();
    }
    $user->getUserLogin_Info();

    $user->getUserArea();

    if(isset( $_SESSION['AreaAll'])){
        $user->getUserRB() ;
    }
    $user->checkCurrentUrl();

?>
