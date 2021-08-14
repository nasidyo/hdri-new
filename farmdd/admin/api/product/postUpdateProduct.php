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
include_once '../../includes/resize-class.php';

$database = new Database();
$db = $database->getConnection();

$detailOfProduct = isset($_POST['detailOfProduct']) ? $_POST['detailOfProduct'] : '';
$idAgri = isset($_POST['idAgri']) ? $_POST['idAgri'] : '';
$idTypeOfArgi = isset($_POST['idTypeOfArgi']) ? $_POST['idTypeOfArgi'] : '';
$madeByOrder = isset($_POST['madeByOrder']) ? $_POST['madeByOrder'] : '';
$priceBegin = isset($_POST['priceBegin']) ? $_POST['priceBegin'] : '';
$priceEnd = isset($_POST['priceEnd']) ? $_POST['priceEnd'] : '';
$sizeOfProduct = isset($_POST['sizeOfProduct']) ? $_POST['sizeOfProduct'] : '';
$speciesArgi = isset($_POST['speciesArgi']) ? $_POST['speciesArgi'] : '';
$typeOfStand = isset($_POST['typeOfStand']) ? $_POST['typeOfStand'] : '';
$monthOfProduct = isset($_POST['monthOfProduct']) ? $_POST['monthOfProduct'] : '';
$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
$idSellerMember = isset($_POST['idSellerMember']) ? $_POST['idSellerMember'] : '';
$speciesArgi = isset($_POST['speciesArgi']) ? $_POST['speciesArgi'] : '';
$titleImg = isset($_POST['titleImg']) ? $_POST['titleImg'] : '';
$idTypeOfArgi = isset($_POST['idTypeOfArgi']) ? $_POST['idTypeOfArgi'] : '';
$suggestOption = isset($_POST['suggestOption']) ? $_POST['suggestOption'] : '0';
$publish = isset($_POST['publish']) ? $_POST['publish'] : '0';
$idProductOfMemberMk = isset($_POST['idProductOfMemberMk']) ? $_POST['idProductOfMemberMk'] : '';
$titleImgPath = 'https://farmtd.hrdi.or.th/farmdd/admin/upload/product/' . $titleImg;
$time = date('Y-m-d H:i:s');

if ($titleImg == '') {
  $query = "UPDATE ProductOfMember_MK SET unit=?, idTypeOfStand=?,
  idAgri=?, detailOfProduct=?, sizeOfProduct=?, priceBegin=?, priceEnd=?, monthOfProduct=?,
  madeByOrder=?, speciesArgi=?, idTypeOfArgi=?, suggestSta=?, publish=?, updateDate=? WHERE idSellerMember=? AND idProductOfMember_MK=?";

  $params = array(
    $unit, $typeOfStand,
    $idAgri, $detailOfProduct, $sizeOfProduct, $priceBegin, $priceEnd, $monthOfProduct,
    $madeByOrder, $speciesArgi, $idTypeOfArgi, $suggestOption, $publish, $time, $idSellerMember, $idProductOfMemberMk
  );
} else {
  $query = "UPDATE ProductOfMember_MK SET unit=?, idTypeOfStand=?,
    idAgri=?, detailOfProduct=?, sizeOfProduct=?, priceBegin=?, priceEnd=?, monthOfProduct=?,
    madeByOrder=?, speciesArgi=?, titleImg=?, idTypeOfArgi=?, suggestSta=?, publish=?, updateDate=? WHERE idSellerMember=? AND idProductOfMember_MK=?";

  $params = array(
    $unit, $typeOfStand,
    $idAgri, $detailOfProduct, $sizeOfProduct, $priceBegin, $priceEnd, $monthOfProduct,
    $madeByOrder, $speciesArgi, $titleImgPath, $idTypeOfArgi, $suggestOption, $publish, $time, $idSellerMember, $idProductOfMemberMk, 
  );
}


if (
  !empty($idSellerMember) &&
  !empty($idAgri)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    $queryProduct = "SELECT TOP 1 idProductOfMember_MK FROM ProductOfMember_MK ORDER BY idProductOfMember_MK DESC";
    $stmt = $db->prepare($queryProduct);
    $stmt->execute();
    $row = $stmt->fetch();
    $sellerId = $row['idProductOfMember_MK'];
    $imgCount = 0;
    if (isset($_FILES['img']['name'])) {
      $imgCount = count($_FILES['img']['name']);
    }

    if ($imgCount > 0) {
      for ($i = 0; $i < $imgCount; $i++) {
        $imgName = $_FILES['img']['name'][$i];
        $path = '../../upload/product/' . $imgName;
        move_uploaded_file($_FILES['img']['tmp_name'][$i], $path);
        $resizeObj = new resize('../../upload/product/'.$imgName);
        $resizeObj->resizeImage(800, 800);
        $resizeObj->saveImage('../../upload/product/'.$imgName);
        $queryAddProduct = "INSERT INTO ProductImg_MK (imgTitle, productIdMk)
        VALUES (?, ?)";
        $imgParams = array($imgName, $sellerId);
        $stmt = $db->prepare($queryAddProduct);
        $stmt->execute($imgParams);
      }
    }
    echo "True";
  } else {
    echo "False";
  }
}
