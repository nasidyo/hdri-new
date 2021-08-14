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

include_once '../../config/database.php';

include_once '../../objects/content_type.php';

$database = new Database();
$db = $database->getConnection();

$contentType = new ContentType($db);

$cType = $_POST["contentType"];

if (
  !empty($cType)
) {

  $contentType->ctype_title = $cType;

  if ($contentType->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "เพิ่มประเภทบทความสำเร็จ"));
  } else {
    http_response_code(500);
    echo json_encode(array("message" => "เกิดข้อผิดพลาด"));
  }
}
