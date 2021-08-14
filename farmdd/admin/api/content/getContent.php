<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once '../config/database.php';
include_once '../objects/content.php';

$database = new Database();
$db = $database->getConnection();

$product = new Content($db);

if ($stmt = $product->read()) {

  $contents_arr = array();
  $contents_arr["content"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $content_item = array(
      "contentId" => $content_id,
      "contentTitle" => $content_title,
      "contentWriter" => $content_writer,
      "contentImg" => $content_img,
      "contentBody" => $content_body,
      "contentTime" => $content_time,
      "contentType" => $content_type,
      "contentPublish" => $content_publish,
      "contentTypeTitle" => $ctype_title,
      "contentFirstPage" => $content_firstpage,
    );

    array_push($contents_arr["content"], $content_item);
  }

  http_response_code(200);

  echo json_encode($contents_arr);
} else {

  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}
