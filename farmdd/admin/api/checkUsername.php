<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$username = '';

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;

$query = "SELECT username FROM BuyerMember_MK WHERE username=?";
$params = array($username);
$stmt = $db->prepare($query);

$stmt->execute($params);
$num = $stmt->rowCount();
if ($num != 0) {
  $user = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $userData = array(
      "username" => $username,
    );
    array_push($user, $userData);
  }

  http_response_code(200);

  echo json_encode(
    array(
      "username" => $user
    )
  );
} else {
  $query = "SELECT username FROM SellerMember_MK WHERE username=?";
  $params = array($username);
  $stmt = $db->prepare($query);
  $stmt->execute($params);
  $num = $stmt->rowCount();
  if ($num != 0) {
    $user = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $userData = array(
        "username" => $username,
      );
      array_push($user, $userData);
    }

    http_response_code(200);

    echo json_encode(
      array(
        "username" => $user
      )
    );
  } else {
    echo json_encode(array("message" => "Not Found"));
  }
}
