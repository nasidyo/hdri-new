<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM ProductImg_MK WHERE productIdMk=?";
$stmt = $db->prepare($query);
$params = array($_POST["idProductOfMemberMk"]);

if ($stmt->execute($params)) {

  $productImgArr = array();
  $productImgArr["productImgMk"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $productItem = array(
      "productImgId" => $productImgId,
      "imgTitle" => "https://farmtd.hrdi.or.th/farmdd/admin/upload/product/".$imgTitle,
      "productIdMk" => $productIdMk,
      "imgName" => $imgTitle
    );

    array_push($productImgArr["productImgMk"], $productItem);
  }

  http_response_code(200);

  echo json_encode($productImgArr);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}

