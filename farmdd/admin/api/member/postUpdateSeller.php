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

$address = isset($_POST['address']) ? $_POST['address'] : '';
$ampCode = isset($_POST['ampCode']) ? $_POST['ampCode'] : '';
$brandName = isset($_POST['brandName']) ? $_POST['brandName'] : '';
$tambolCode = isset($_POST['tambolCode']) ? $_POST['tambolCode'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$facebookName = isset($_POST['facebookName']) ? $_POST['facebookName'] : '';
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$groupName = isset($_POST['groupName']) ? $_POST['groupName'] : '';
$idCard = isset($_POST['idCard']) ? $_POST['idCard'] : '';
$idTypeOfSeller = isset($_POST['idTypeOfSeller']) ? $_POST['idTypeOfSeller'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$lineId = isset($_POST['lineId']) ? $_POST['lineId'] : '';
$moo = isset($_POST['moo']) ? $_POST['moo'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
$prefix = isset($_POST['prefix']) ? $_POST['prefix'] : '';
$productType = isset($_POST['productType']) ? $_POST['productType'] : '';
$road = isset($_POST['road']) ? $_POST['road'] : '';
$shopName = isset($_POST['shopName']) ? $_POST['shopName'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$vLinkAreaDetailId = isset($_POST['vLinkAreaDetailId']) ? $_POST['vLinkAreaDetailId'] : '';
$vProvinceId = isset($_POST['vProvinceId']) ? $_POST['vProvinceId'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$statusOfMember = isset($_POST['statusOfMember']) ? $_POST['statusOfMember'] : '';
$idSellerMember = isset($_POST['idMember']) ? $_POST['idMember'] : '';
$time = date('Y-m-d H:i:s');

$image_file = isset($_FILES["img"]['name']) ? $_FILES["img"]['name'] : '';
$imgType = isset($_FILES["img"]['type']) ? $_FILES["img"]['type'] : '';
$size = isset($_FILES["img"]['size']) ? $_FILES["img"]['size'] : '';
$temp = isset($_FILES["img"]['tmp_name']) ? $_FILES["img"]['tmp_name'] : '';
$path = '../../upload/profile' . $image_file;

if (!empty($image_file)) {
  move_uploaded_file($temp, '../../upload/profile/' . $image_file);
  $query = "UPDATE SellerMember_MK SET idTypeOfSeller_MK=?, idPrefix=?, firstName=?, lastName=?,
  idCard=?, gender=?, address=?, moo=?, postcode=?, phoneNumber=?, password=?, email=?, lineID=?, facebookName=?,
  groupName=?, shopName=?, brandName=?, statusOfMember=?, updateDate=?, road=?, username=?,
  tambolCode=?, ampCode=?, vProvinceId_MK=?, vLinkAreaDetailId_MK=?, productType=?, sellerImg=?, typeOfMember=?
  WHERE idSellerMember=?";

  $params = array(
    $idTypeOfSeller, $prefix, $firstName, $lastName, $idCard, $gender, $address, $moo, $postcode,
    $phoneNumber, $password, $email, $lineId, $facebookName, $groupName, $shopName, $brandName, $statusOfMember,
    $time, $road, $username, $tambolCode, $ampCode, $vProvinceId, $vLinkAreaDetailId, $productType, $image_file, 'Seller',
    $idSellerMember
  );
} else {
  $query = "UPDATE SellerMember_MK SET idTypeOfSeller_MK=?, idPrefix=?, firstName=?, lastName=?,
  idCard=?, gender=?, address=?, moo=?, postcode=?, phoneNumber=?, password=?, email=?, lineID=?, facebookName=?,
  groupName=?, shopName=?, brandName=?, statusOfMember=?, updateDate=?, road=?, username=?,
  tambolCode=?, ampCode=?, vProvinceId_MK=?, vLinkAreaDetailId_MK=?, productType=?, typeOfMember=?
  WHERE idSellerMember=?";

  $params = array(
    $idTypeOfSeller, $prefix, $firstName, $lastName, $idCard, $gender, $address, $moo, $postcode,
    $phoneNumber, $password, $email, $lineId, $facebookName, $groupName, $shopName, $brandName, $statusOfMember,
    $time, $road, $username, $tambolCode, $ampCode, $vProvinceId, $vLinkAreaDetailId, $productType, 'Seller',
    $idSellerMember
  );
}


if (
  !empty($username) &&
  !empty($password)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    echo "True";
  } else {
    echo "False";
  }
}
