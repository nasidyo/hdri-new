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
$amphurCode = isset($_POST['amphurCode']) ? $_POST['amphurCode'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$facebookName = isset($_POST['facebookName']) ? $_POST['facebookName'] : '';
$idCard = isset($_POST['idCard']) ? $_POST['idCard'] : '';
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$lineId = isset($_POST['lineId']) ? $_POST['lineId'] : '';
$moo = isset($_POST['moo']) ? $_POST['moo'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
$prefix = isset($_POST['prefix']) ? $_POST['prefix'] : '';
$provinceCode = isset($_POST['provinceCode']) ? $_POST['provinceCode'] : '';
$questionOfObjective = isset($_POST['questionOfObjective']) ? $_POST['questionOfObjective'] : '';
$questionOfVisit = isset($_POST['questionOfVisit']) ? $_POST['questionOfVisit'] : '';
$road = isset($_POST['road']) ? $_POST['road'] : '';
$typeOfMember = isset($_POST['typeOfMember']) ? $_POST['typeOfMember'] : '';
$statusOfMember = isset($_POST['statusOfMember']) ? $_POST['statusOfMember'] : '';
$tambolCode = isset($_POST['tambolCode']) ? $_POST['tambolCode'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$idMember = isset($_POST['idMember']) ? $_POST['idMember'] : '';

$image_file = isset($_FILES["img"]['name']) ? $_FILES["img"]['name'] : '';
$imgType = isset($_FILES["img"]['type']) ? $_FILES["img"]['type'] : '';
$size = isset($_FILES["img"]['size']) ? $_FILES["img"]['size'] : '';
$temp = isset($_FILES["img"]['tmp_name']) ? $_FILES["img"]['tmp_name'] : '';
$path = '../../upload/profile' . $image_file;

$time = date('Y-m-d H:i:s');

if (!empty($image_file)) {
  move_uploaded_file($temp, '../../upload/profile/' . $image_file);
  $query = "UPDATE BuyerMember_MK SET Amp_CODE=?, TAM_CODE=?, idPrefix=?, firstName=?, lastName=?,
  idCard=?, gender=?, address=?, postCode=?, phoneNumber=?, username=?, pass=?, email=?, lineID=?, typeOfMember=?,
  statusOfMember=?, updateDate=?, questionOfVisit=?, questionOfObjective=?, buyerImg=?, facebookName=?,
  provinceCode=?, moo=?, road=? WHERE idBuyerMember=?";

  $params = array($amphurCode, $tambolCode, $prefix, $firstName, $lastName,
  $idCard, $gender, $address, $postcode, $phoneNumber, $username, $password, $email, $lineId, $typeOfMember,
  $statusOfMember, $time, $questionOfVisit, $questionOfObjective, $image_file, $facebookName, $provinceCode,
  $moo, $road, $idMember);
} else {
  $query = "UPDATE BuyerMember_MK SET Amp_CODE=?, TAM_CODE=?, idPrefix=?, firstName=?, lastName=?,
  idCard=?, gender=?, address=?, postCode=?, phoneNumber=?, username=?, pass=?, email=?, lineID=?, typeOfMember=?,
  statusOfMember=?, updateDate=?, questionOfVisit=?, questionOfObjective=?, facebookName=?,
  provinceCode=?, moo=?, road=? WHERE idBuyerMember=?";

  $params = array($amphurCode, $tambolCode, $prefix, $firstName, $lastName,
  $idCard, $gender, $address, $postcode, $phoneNumber, $username, $password, $email, $lineId, $typeOfMember,
  $statusOfMember, $time, $questionOfVisit, $questionOfObjective, $facebookName, $provinceCode,
  $moo, $road, $idMember);
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
