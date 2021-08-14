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

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$table = isset($_POST['table']) ? $_POST['table'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$sellerId = isset($_POST['sellerId']) ? $_POST['sellerId'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$query = "UPDATE $table SET statusOfMember = 0 WHERE username= ?";

$params = array($username);

if (
  !empty($username)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    if ($status == 'update') {
      $query2 = "UPDATE ProductOfMember_MK SET suggestSta = 0, publish = 0 WHERE idSellerMember = $sellerId";
      $stmt2 = $db->prepare($query2);
      $stmt2->execute();
      echo 'True';
    } else {
      echo 'True';
    }
  } else {
    echo "False";
  }
}

