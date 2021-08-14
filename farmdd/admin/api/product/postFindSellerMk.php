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

$idSellerMember = isset($_POST['idSellerMember']) ? $_POST['idSellerMember'] : '';

$query = "SELECT * FROM SellerMember_MK 
INNER JOIN Prefix_TD ON SellerMember_MK.idPrefix = Prefix_TD.idPrefix
INNER JOIN TypeOfSeller_MK ON SellerMember_MK.idTypeOfSeller_MK = TypeOfSeller_MK.idTypeOfSeller_MK
INNER JOIN V_CODE_PROVINCE ON SellerMember_MK.vProvinceId_MK = V_CODE_PROVINCE.Code 
INNER JOIN V_CODE_AMPHUR ON SellerMember_MK.ampCode = V_CODE_AMPHUR.AMP_CODE AND PROV_CODE = SellerMember_MK .vProvinceId_MK 
INNER JOIN V_CODE_TAMBON ON SellerMember_MK.tambolCode = V_CODE_TAMBON.TAM_CODE AND SellerMember_MK.ampCode = V_CODE_TAMBON.AMP_CODE 
AND SellerMember_MK.vProvinceId_MK = V_CODE_TAMBON.PROV_CODE 
WHERE idSellerMember=?";
$params = array($idSellerMember);

if (
  !empty($idSellerMember)
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
        "sellerImg" => 'https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/'.$sellerImg,
        "typeOfMember" => $typeOfMember,
        "tamName" => $TAM_T,
        "ampName" => $AMP_T,
        "provName" => $PROV_T,
        "nameTypeOfSeller" => $nameTypeOfSeller,
      );
  
      array_push($sellerArray["sellerUser"], $buyerItem);
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

