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

$query = "SELECT * FROM SellerMember_MK 
INNER JOIN TypeOfSeller_MK ON SellerMember_MK.idTypeOfSeller_MK  = TypeOfSeller_MK.idTypeOfSeller_MK 
LEFT JOIN Area ON SellerMember_MK.vLinkAreaDetailId_MK = Area.idArea 
ORDER BY statusOfMember ASC";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $sellerArray = array();
  $sellerArray["sellerUser"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $sellerItem = array(
      "idSellerMember" => $idSellerMember,
      "idTypeOfSeller_MK" => $idTypeOfSeller_MK,
      "idPrefix" => $idPrefix,
      "firstName" => $firstName,
      "lastName" => $lastName,
      "idCard" => $idCard,
      "gender" => $gender,
      "address" => $address,
      "moo" => $moo,
      "postCode" => $postcode,
      "phoneNumber" => $phoneNumber,
      "username" => $username,
      "password" => $password,
      "email" => $email,
      "lineID" => $lineID,
      "groupName" => $groupName,
      "typeOfMember" => $typeOfMember,
      "shopName" => $shopName,
      "brandName" => $brandName,
      "statusOfMember" => $statusOfMember,
      "facebookName" => $facebookName,
      "road" => $road,
      "tambolCode" => $tambolCode,
      "ampCode" => $ampCode,
      "vProvinceId_MK" => $vProvinceId_MK,
      "vLinkAreaDetailId_MK" => $vLinkAreaDetailId_MK,
      "productType" => $productType,
      "sellerImg" => $sellerImg,
      "memberImg" => 'https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/'.$sellerImg,
      "nameTypeOfSeller" => $nameTypeOfSeller,
      "registerDate" => $registerDate,
      "areaName" => $areaName
    );

    array_push($sellerArray["sellerUser"], $sellerItem);
  }

  http_response_code(200);

  echo json_encode($sellerArray);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}

