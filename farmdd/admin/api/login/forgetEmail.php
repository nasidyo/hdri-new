<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once '../config/database.php';
require '../../includes/PHPMailer-master/src/PHPMailer.php';
require '../../includes/PHPMailer-master/src/SMTP.php';
require '../../includes/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = "true";
$mail->SMTPSecure = 'tls';
$mail->Port = "587";
$mail->isHTML();
$mail->Username = 'kingdomsouleater@gmail.com';
$mail->Password = 'tatexty142547581425';
$mail->Subject = 'รหัสผ่านของดีบนดอยออนไลน์';
$mail->setFrom = 'kingdomsouleater@gmail.com';
$mail->Body = 'Test';
$mail->AddAddress = 'kingdomsouleater@gmail.com';


if ($mail->Send()) {
    echo "True";
} else {
    echo "False";
}

$mail->smtpClose();
?>