<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');

include_once 'config/database.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$username = '';
$password = '';
$time = date('Y-m-d H:i:s');

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;

$saveLogQuery = "INSERT INTO LoginLogTD (username, loginDate) VALUES (?, ?)";
$logParams = array($username, $time);
$stmtLog = $db->prepare($saveLogQuery);
$stmtLog->execute($logParams);

$query = "SELECT TOP 1 * FROM BuyerMember_MK WHERE username=? AND pass=?";
$params = array($username, $password);
$stmt = $db->prepare($query);

$stmt->execute($params);
$num = $stmt->rowCount();

if ($num != 0) {
  $user = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $userData = array(
      "idBuyerMember" => $idBuyerMember,
      "ampCode" => $Amp_CODE,
      "tamCode" => $TAM_CODE,
      "idPrefix" => $idPrefix,
      "firstName" => $firstName,
      "lastName" => $lastName,
      "idCard" => $idCard,
      "gender" => $gender,
      "address" => $address,
      "postcode" => $postcode,
      "phoneNumber" => $phoneNumber,
      "username" => $username,
      "email" => $email,
      "lineID" => $lineID,
      "typeOfMember" => $typeOfMember,
      "statusOfMember" => $statusOfMember,
      "buyerImg" => $buyerImg,
      "facebookName" => $facebookName,
    );
    array_push($user, $userData);
  }

  $secret_key = "YOUR_SECRET_KEY";
  $issuer_claim = "THE_ISSUER"; // this can be the servername
  $audience_claim = "THE_AUDIENCE";
  $issuedat_claim = time(); // issued at
  $notbefore_claim = $issuedat_claim + 10; //not before in seconds
  $expire_claim = $issuedat_claim + 3600; // expire time in seconds
  $token = array(
    "iss" => $issuer_claim,
    "aud" => $audience_claim,
    "iat" => $issuedat_claim,
    "nbf" => $notbefore_claim,
    "exp" => $expire_claim,
    "data" => $user
  );
  http_response_code(200);

  $jwt = JWT::encode($token, $secret_key);
  echo json_encode(
    array(
      "message" => "Successful login.",
      "jwt" => $jwt,
      "user" => $user,
      "expireAt" => $expire_claim
    )
  );
} else {
  $query = "SELECT TOP 1 * FROM SellerMember_MK WHERE username=? AND password=?";
  $params = array($username, $password);
  $stmt = $db->prepare($query);
  $stmt->execute($params);
  $num = $stmt->rowCount();
  if ($num != 0) {
    $user = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $userData = array(
        "idSellerMember" => $idSellerMember,
        "ampCode" => $idTypeOfSeller_MK,
        "idPrefix" => $idPrefix,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "idCard" => $idCard,
        "gender" => $gender,
        "address" => $address,
        "moo" => $moo,
        "postcode" => $postcode,
        "phoneNumber" => $phoneNumber,
        "username" => $username,
        "email" => $email,
        "lineID" => $lineID,
        "facebookName" => $facebookName,
        "groupName" => $groupName,
        "shopName" => $shopName,
        "brandName" => $brandName,
        "statusOfMember" => $statusOfMember,
        "road" => $road,
        "typeOfMember" => $typeOfMember,
        "tambolCode" => $tambolCode,
        "ampCode" => $ampCode,
        "vProvinceId_MK" => $vProvinceId_MK,
        "vLinkAreaDetailId_MK" => $vLinkAreaDetailId_MK,
        "productType" => $productType,
        "sellerImg" => $sellerImg,
      );
      array_push($user, $userData);
    }

    $secret_key = "YOUR_SECRET_KEY";
    $issuer_claim = "THE_ISSUER"; // this can be the servername
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
    $expire_claim = $issuedat_claim + 60; // expire time in seconds
    $token = array(
      "iss" => $issuer_claim,
      "aud" => $audience_claim,
      "iat" => $issuedat_claim,
      "nbf" => $notbefore_claim,
      "exp" => $expire_claim,
      "data" => $user
    );
    http_response_code(200);

    $jwt = JWT::encode($token, $secret_key);
    echo json_encode(
      array(
        "message" => "Successful login.",
        "jwt" => $jwt,
        "user" => $user,
        "expireAt" => $expire_claim
      )
    );
  } else {
    http_response_code(401);
    echo json_encode(array("message" => "Login failed."));
  }
}
