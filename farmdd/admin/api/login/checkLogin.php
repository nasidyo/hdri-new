<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require 'userClass.php';
require 'database.php';
require 'SeqServiceLog.php';

$usrAd = $_POST['usr-Ad'] ? $_POST['usr-Ad'] : '';

if ($_POST['username'] != null and $_POST['password'] != null) {
  if ($usrAd == 'AD' and $_POST['username'] != 'admin') {
    $user = new User();
    $login = $user->check_login($_POST['username'], $_POST['password']);
    if ($login) {
      // Registration Success
      $seqService = new SeqService();
      $logSeq = $seqService->get("logAccess_seq");
      $user->saveLogLogin($_POST['username'], $logSeq);
      $user->loginLogTD($_POST['username']);
      echo json_encode(
        array(
          "msg" => "True"
        )
      );
      exit();
    } else {
      echo json_encode(
        array(
          "msg" => $_SESSION['msg']
        )
      );
      exit();
    }
  } else {
    $user = new User();
    $login = $user->check_login_withoutAD($_POST['username'], $_POST['password']);
    if ($login) {
      // Registration Success
      $seqService = new SeqService();
      $logSeq = $seqService->get("logAccess_seq");
      $user->saveLogLogin($_POST['username'], $logSeq);
      $user->loginLogTD($_POST['username']);
      echo json_encode(
        array(
          "msg" => "True"
        )
      );
      exit();
    } else {
      echo json_encode(
        array(
            "msg" => $_SESSION['msg']
        )
      );
      exit();
    }
  }
} else {
  echo json_encode(
    array(
      "msg" => "False"
    )
  );
  exit();
}
