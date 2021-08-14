<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM BuyerMember_MK ORDER BY statusOfMember ASC";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $buyerArray = array();
  $buyerArray["buyerUser"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $buyerItem = array(
      "idBuyerMember" => $idBuyerMember,
      "ampCode" => $Amp_CODE,
      "tamCode" => $TAM_CODE,
      "idPrefix" => $idPrefix,
      "firstName" => $firstName,
      "lastName" => $lastName,
      "idCard" => $idCard,
      "gender" => $gender,
      "address" => $address,
      "postCode" => $postcode,
      "phoneNumber" => $phoneNumber,
      "username" => $username,
      "pass" => $pass,
      "email" => $email,
      "lineID" => $lineID,
      "typeOfMember" => $typeOfMember,
      "statusOfMember" => $statusOfMember,
      "questionOfVisit" => $questionOfVisit,
      "questionOfObjective" => $questionOfObjective,
      "buyerImg" => $buyerImg,
      "memberImg" => 'https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/'.$buyerImg,
      "facebookName" => $facebookName,
      "registerDate" => $registerDate
    );

    array_push($buyerArray["buyerUser"], $buyerItem);
  }

  http_response_code(200);

  echo json_encode($buyerArray);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}

