<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM TypeOfSeller_MK";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $prefixArray = array();
  $prefixArray["sellType"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $prefix_item = array(
      "idTypeOfSeller" => $idTypeOfSeller_MK,
      "nameTypeOfSeller" => $nameTypeOfSeller
    );

    array_push($prefixArray["sellType"], $prefix_item);
  }

  http_response_code(200);

  echo json_encode($prefixArray);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}
