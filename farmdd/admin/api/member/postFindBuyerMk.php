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

$idBuyerMember = isset($_POST['idBuyerMember']) ? $_POST['idBuyerMember'] : '';

$query = "SELECT * FROM BuyerMember_MK 
INNER JOIN Prefix_TD ON BuyerMember_MK.idPrefix = Prefix_TD.idPrefix
INNER JOIN V_CODE_PROVINCE ON BuyerMember_MK.provinceCode = V_CODE_PROVINCE.Code 
INNER JOIN V_CODE_AMPHUR ON BuyerMember_MK.Amp_CODE = V_CODE_AMPHUR.AMP_CODE AND PROV_CODE = BuyerMember_MK.provinceCode 
INNER JOIN V_CODE_TAMBON ON BuyerMember_MK.TAM_CODE = V_CODE_TAMBON.TAM_CODE AND BuyerMember_MK.Amp_CODE = V_CODE_TAMBON.AMP_CODE 
AND BuyerMember_MK.provinceCode = V_CODE_TAMBON.PROV_CODE 
WHERE BuyerMember_MK.idBuyerMember = ?";
$params = array($idBuyerMember);

if (
  !empty($idBuyerMember)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $buyerArray = array();
      $buyerArray["buyerUser"] = array();

      $buyerItem = array(
        "idBuyerMember" => $idBuyerMember,
        "idPrefix" => $idPrefix,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "idCard" => $idCard,
        "gender" => $gender,
        "address" => $address,
        "moo" => $moo,
        "postCode" => $postcode,
        "phoneNumber" => $phoneNumber,
        "email" => $email,
        "lineID" => $lineID,
        "statusOfMember" => $statusOfMember,
        "facebookName" => $facebookName,
        "road" => $road,
        "tambolCode" => $TAM_CODE,
        "ampCode" => $Amp_CODE,
        "vProvinceId_MK" => $provinceCode,
        "buyerImg" => 'https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/'.$buyerImg,
        "typeOfMember" => $typeOfMember,
        "tamName" => $TAM_T,
        "ampName" => $AMP_T,
        "provName" => $PROV_T,
        "statusOfMember" => $statusOfMember
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
}

