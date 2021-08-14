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

$username = isset($_POST['username']) ? $_POST['username'] : '';
$time = date('Y-m-d H:i:s');

$query = "SELECT * FROM SellerMember_MK WHERE username= ?";
$params = array($username);

if (
  !empty($username)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $sellerArray = array();
      $sellerArray["sellerUser"] = array();

      $buyerItem = array(
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
        "typeOfMember" => $typeOfMember,
      );
  
      array_push($sellerArray["sellerUser"], $buyerItem);
    }
  
    $queryProvince = "SELECT * FROM V_CODE_PROVINCE WHERE Code= ?";
    $provinceParams = array($sellerArray["sellerUser"][0]["vProvinceId_MK"]);
    $stmt = $db->prepare($queryProvince);
    $stmt->execute($provinceParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sellerArray["sellerUser"][0]["provinceName"] = $Name;
    }

    $queryAmphur = "SELECT * FROM V_CODE_AMPHUR WHERE PROV_CODE= ?";
    $amphurParams = array($sellerArray["sellerUser"][0]["vProvinceId_MK"]);
    $stmt = $db->prepare($queryAmphur);
    $stmt->execute($amphurParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sellerArray["sellerUser"][0]["amphurName"] = $AMP_T;
    }

    $queryTambol = "SELECT * FROM V_CODE_TAMBON WHERE TAM_CODE = ?";
    $tambolParams = array($sellerArray["sellerUser"][0]["tambolCode"]);
    $stmt = $db->prepare($queryTambol);
    $stmt->execute($tambolParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sellerArray["sellerUser"][0]["tambolName"] = $TAM_T;
    }

    $queryPrefix = "SELECT * FROM Prefix WHERE idPrefix= ?";
    $prefixParams = array($sellerArray["sellerUser"][0]["idPrefix"]);
    $stmt = $db->prepare($queryPrefix);
    $stmt->execute($prefixParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sellerArray["sellerUser"][0]["prefixNameTh"] = $prefixNameTh;
    }

    $queryArea = "SELECT * FROM Area WHERE idArea= ?";
    $areaParams = array($sellerArray["sellerUser"][0]["vLinkAreaDetailId_MK"]);
    $stmt = $db->prepare($queryArea);
    $stmt->execute($areaParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sellerArray["sellerUser"][0]["areaName"] = $areaName;
    }

    $querySellerType = "SELECT * FROM TypeOfSeller_MK WHERE idTypeOfSeller_MK= ?";
    $sellerTypeParams = array($sellerArray["sellerUser"][0]["idTypeOfSeller_MK"]);
    $stmt = $db->prepare($querySellerType);
    $stmt->execute($sellerTypeParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $sellerArray["sellerUser"][0]["nameTypeOfSeller"] = $nameTypeOfSeller;
    }
    

    http_response_code(200);
    echo json_encode($sellerArray);
  } else {
    http_response_code(404);
  
    echo json_encode(
      array("message" => "No Contents found.")
    );
  }
}

