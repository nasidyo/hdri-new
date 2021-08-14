<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM files_MK";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $imageArray = array();
  $imageArray["images"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $prefix_item = array(
      "id" => $id,
      "name" => $name,
      "type" => $type,
      "size" => $size,
      "uploaded_date" => $uploaded_date,
    );

    array_push($imageArray["images"], $prefix_item);
  }

  http_response_code(200);

  echo json_encode($imageArray);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}
