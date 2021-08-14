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

include_once '../config/database.php';

include_once '../objects/content.php';

$database = new Database();
$db = $database->getConnection();

$content = new Content($db);

$image_file = $_FILES["uploadImg"]['name'];
$imgType = $_FILES["uploadImg"]['type'];
$size = $_FILES["uploadImg"]['size'];
$temp = $_FILES["uploadImg"]['tmp_name'];
$path = '../../upload' . $image_file;
$time = date('Y-m-d H:i:s');

if (
  !empty($image_file)
) {

  if ($imgType == "image/jpg" || $imgType == "image/jpeg" || $imgType == "image/gif" || $imgType == "image/png") {
      if ($size < 5000000) {
        move_uploaded_file($temp, '../../upload/' . $image_file);
        $query = "INSERT INTO files_MK (name, type, size, uploaded_date)
        VALUES(?, ?, ?, ?)";

        $params = array($image_file, $imgType, $size, $time);
        $stmt = $db->prepare($query);

        if ($stmt->execute($params)) {
          http_response_code(201);
          echo json_encode(array("message" => "เพิ่มข้อมูลสำเร็จ"));
        } else {
          http_response_code(503);
          echo json_encode(array("message" => "ไม่สามารถเพิ่มข้อมูลได้ ErrorCode 503"));
        }
      } else {
        http_response_code(423);
        echo json_encode(array("message" => "รูปมีชนาดใหญ่เกินไป"));
      }
  } else {
    http_response_code(423);
    echo json_encode(array("message" => "อัพโหลดได้เฉพาะ JPG, JPEG, GIF, PNG เท่านั้น"));
  }
} else {
  http_response_code(400);
  echo json_encode(array("message" => "ไม่สามารถเพิ่มข้อมูลได้ ErrorCode 400"));
}
