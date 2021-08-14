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

$idArea = isset($_POST['idArea']) ? $_POST['idArea'] : '';

$query = "SELECT TOP 1 * FROM vLinkAreaDetail WHERE target_id=?";
$stmt = $db->prepare($query);
$params = array($idArea);
if ($stmt->execute($params)) {

  $targetArray = array();
  $targetArray["targetLL"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $targetItem = array(
      "idArea" => $target_area_type_id,
      "areaName" => $target_area_type_title,
      "targetId" => $target_id,
      "targetName" => $target_name,
      "targetCodeGis" => $target_code_gis,
      "provinceId" => $PROVINCE_ID,
      "provinceName" => $PROVINCE_NAME,
      "tambolId" => $TAMBOL_ID,
      "tambolName" => $TAMBOL_NAME_THA,
      "ampId" => $AMPHUR_ID,
      "ampName" => $AMPHUR_NAME_THA,
      "villId" => $VILLAGE_ID,
      "villName" => $VILLAGE_NAME_THA,
      "moo" => $MOO,
      "x" => $x,
      "y" => $y,
      "h" => $h,
      "lat" => $LAT,
      "long" => $LONG,
      "fbasinId" => $fbasin_id,
      "fbasinName" => $fbasin_name,
    );

    array_push($targetArray["targetLL"], $targetItem);
  }

  http_response_code(200);

  echo json_encode($targetArray);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}

