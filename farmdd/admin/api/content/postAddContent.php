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

$contentTitle = $_POST["contentTitle"];
$contentWriter = $_POST["contentWriter"];
$contentType = $_POST["contentType"];
$contentPublish = $_POST["contentPublish"];
$contentBody = $_POST["contentBody"];
$contentFirstPage = $_POST["contentFirstPage"];

$image_file = $_FILES["contentImg"]['name'];
$imgType = $_FILES["contentImg"]['type'];
$size = $_FILES["contentImg"]['size'];
$temp = $_FILES["contentImg"]['tmp_name'];
$path = '../../upload/' . $image_file;

if (
  !empty($contentTitle) &&
  !empty($contentWriter) &&
  !empty($contentBody) &&
  !empty($path) &&
  !empty($contentType)
) {

  if ($imgType == "image/jpg" || $imgType == "image/jpeg" || $imgType == "image/gif" || $imgType == "image/png") {
      if ($size < 5000000) {
        move_uploaded_file($temp, '../../upload/' . $image_file);
        $time = date('Y-m-d H:i:s');
        $content->content_title = $contentTitle;
        $content->content_writer = $contentWriter;
        $content->content_publish = $contentPublish;
        $content->content_type = $contentType;
        $content->content_img = $image_file;
        $content->content_body = $contentBody;
        $content->content_firstpage = $contentFirstPage;
        $content->content_time = $time;

        if ($content->create()) {
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
