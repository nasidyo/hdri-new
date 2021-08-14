<?php
// required headers
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

include_once 'config/database.php';

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

$image_file = $_FILES["img"]['name'];
$imgType = $_FILES["img"]['type'];
$size = $_FILES["img"]['size'];
$temp = $_FILES["img"]['tmp_name'];
$path = '../upload/profile/' . $image_file;
move_uploaded_file($temp, '../upload/profile/' . $image_file);

$time = date('Y-m-d H:i:s');

$query = "INSERT INTO SellerMember_MK (idTypeOfSeller_MK, idPrefix, firstName, lastName,
idCard, gender, address, moo, postcode, phoneNumber, password, username, email, lineID, facebookName,
groupName, shopName, brandName, statusOfMember, registerDate, updateDate, road,
tambolCode, ampCode, vProvinceId_MK, vLinkAreaDetailId_MK, productType, sellerImg, typeOfMember) VALUES (?, ?, ?, ?,
?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$params = array($idTypeOfSeller, $prefix, $firstName, $lastName, $idCard, $gender, $address, $moo, $postcode,
$phoneNumber, $password, $username, $email, $lineId, $facebookName, $groupName, $shopName, $brandName, 0,
$time, $time, $road, $tambolCode, $ampCode, $vProvinceId, $vLinkAreaDetailId, $productType, $image_file, 'Seller');

if (
  !empty($vProvinceId) &&
  !empty($vLinkAreaDetailId)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    echo "True";
  } else {
    echo "False";
  }
}

