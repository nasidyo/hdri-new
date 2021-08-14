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

$query = "SELECT * FROM BuyerMember_MK WHERE username= ?";
$params = array($username);

if (
  !empty($username)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $buyerArray = array();
      $buyerArray["buyerUser"] = array();

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
        "moo" => $moo,
        "road" => $road,
        "pass" => $pass,
        "postCode" => $postcode,
        "email" => $email,
        "lineID" => $lineID,
        "typeOfMember" => $typeOfMember,
        "statusOfMember" => $statusOfMember,
        "questionOfVisit" => $questionOfVisit,
        "questionOfObjective" => $questionOfObjective,
        "buyerImg" => $buyerImg,
        "facebookName" => $facebookName,
        "provinceCode" => $provinceCode,
        "provinceName" => null,
      );
  
      array_push($buyerArray["buyerUser"], $buyerItem);
    }
  
    $queryProvince = "SELECT * FROM V_CODE_PROVINCE WHERE Code= ?";
    $provinceParams = array($buyerArray["buyerUser"][0]["provinceCode"]);
    $stmt = $db->prepare($queryProvince);
    $stmt->execute($provinceParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $buyerArray["buyerUser"][0]["provinceName"] = $Name;
    }

    $queryAmphur = "SELECT * FROM V_CODE_AMPHUR WHERE PROV_CODE= ?";
    $amphurParams = array($buyerArray["buyerUser"][0]["provinceCode"]);
    $stmt = $db->prepare($queryAmphur);
    $stmt->execute($amphurParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $buyerArray["buyerUser"][0]["amphurName"] = $AMP_T;
    }

    $queryTambol = "SELECT * FROM V_CODE_TAMBON WHERE TAM_CODE= ?";
    $tambolParams = array($buyerArray["buyerUser"][0]["tamCode"]);
    $stmt = $db->prepare($queryTambol);
    $stmt->execute($tambolParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $buyerArray["buyerUser"][0]["tambolName"] = $TAM_T;
    }

    $queryPrefix = "SELECT * FROM Prefix WHERE idPrefix= ?";
    $prefixParams = array($buyerArray["buyerUser"][0]["idPrefix"]);
    $stmt = $db->prepare($queryPrefix);
    $stmt->execute($prefixParams);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $buyerArray["buyerUser"][0]["prefixNameTh"] = $prefixNameTh;
    }

    http_response_code(200);
    echo json_encode($buyerArray);
  } else {
    http_response_code(404);
  
    echo json_encode(
      array("message" => "No Contents found.")
    );
  }
}

