<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once './api/config/database.php';
require './includes/PHPMailer-master/src/PHPMailer.php';
require './includes/PHPMailer-master/src/SMTP.php';
require './includes/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$db = $database->getConnection();

$id = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$username = '';
$sendEmail = '';

if ($type == 'buyer') {
  $stmt = $db->prepare("SELECT * FROM BuyerMember_MK WHERE username=?");
  $stmt->execute([$id]); 
  $user = $stmt->fetch();
  $username = ($user["username"]);
}

if ($type == 'seller') {
  $stmt = $db->prepare("SELECT * FROM SellerMember_MK WHERE username=?");
  $stmt->execute([$id]); 
  $user = $stmt->fetch();
  $username = ($user["username"]);
}

if ($username == '') {
  echo json_encode(
    array("errMsg" => "ไม่พบ User นี้ในระบบ", "status" => 500)
  );
  exit();
}

if ($type == 'buyer') {
  $stmt = $db->prepare("SELECT * FROM BuyerMember_MK WHERE email=?");
  $stmt->execute([$email]); 
  $user = $stmt->fetch();
  $sendEmail = ($user["email"]);
}

if ($type == 'seller') {
  $stmt = $db->prepare("SELECT * FROM SellerMember_MK WHERE email=?");
  $stmt->execute([$email]); 
  $user = $stmt->fetch();
  $sendEmail = ($user["email"]);
}

if ($sendEmail == '') {
  echo json_encode(
    array("errMsg" => "ไม่พบ Email นี้ในระบบ", "status" => 500)
  );
  exit();
}


if ($type == 'buyer') {
    $query = "SELECT * FROM BuyerMember_MK WHERE username = ? AND email = ?";
}

if ($type == 'seller') {
    $query = "SELECT * FROM SellerMember_MK WHERE username =? AND email =?";
}


$params = array($id, $email);
$sendPassword = '';
$sendEmail = '';
if (
    !empty($id) &&
    !empty($email)
  ) {
    $stmt = $db->prepare($query);
    if ($stmt->execute($params)) { 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          if ($type == 'buyer') {
            $sendPassword = $pass;
            $sendEmail = $email;
          }
          
          if ($type == 'seller') {
            $sendPassword = $password;
            $sendEmail = $email;
          }
        }

          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->CharSet = "utf-8";
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = "true";
          $mail->SMTPSecure = 'tls';
          $mail->Port = "587";
          $mail->isHTML();
          $mail->Username = 'kingdomsouleater@gmail.com';
          $mail->Password = 'tatexty142547581425';
          $mail->Subject = 'รหัสผ่านของดีบนดอยออนไลน์';
          $mail->setFrom('kingdomsouleater@gmail.com', 'ของดีบนดอยออนไลน์');
          $mail->Body = 'พาสเวิร์ดของ Username '.$username. ' คือ '. $sendPassword;
          $mail->addAddress($sendEmail);

          if(!$mail->send()) {
              echo 'Mailer Error: ' . $mail->ErrorInfo;
              exit();
          } else {
              echo 'ส่งรหัสผ่านไปยังอีเมลล์สำเร็จ';
              exit();
          }
          

  }
} else {
  echo 'ไม่พบ Username หรือ Email กรุณาตรวจสอบอีกครั้ง';
}


// $mail->smtpClose();
?>