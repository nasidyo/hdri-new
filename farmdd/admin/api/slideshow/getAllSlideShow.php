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

$query = "SELECT * FROM SlideShowImg";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $slideArr = array();
  $slideArr["slideShowImg"] = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $slideItem = array(
      "slideImgId" => $slideImgId,
      "imgTitle" => 'https://farmtd.hrdi.or.th/farmdd/admin/upload/slideshow/'.$imgTitle,
      "imgName" => $imgTitle,
    );

    array_push($slideArr["slideShowImg"], $slideItem);
  }

  http_response_code(200);

  echo json_encode($slideArr);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}
