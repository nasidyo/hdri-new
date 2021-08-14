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

$query = "SELECT * FROM vLinkAreaDetail";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $prefixArray = array();
  $prefixArray["vLinkAreaDetail"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $prefix_item = array(
      "targetAreaTypeId" => $target_area_type_id,
      "targetAreaTypeTitle" => $target_area_type_title, 
      "targetId" => $target_id,
      "targetName" => $target_name,
      "targetCodeGis" => $target_code_gis,
      "provinceId" => $PROVINCE_ID,
      "provinceName" => $PROVINCE_NAME,
      "tambolId" => $TAMBOL_ID,
      "tambolNameTha" => $TAMBOL_NAME_THA,
      "amphurId" => $AMPHUR_ID,
      "amphurNameTHA" => $AMPHUR_NAME_THA,
      "villageId" => $VILLAGE_ID,
      "villageNameTHA" => $VILLAGE_NAME_THA,
      "moo" => $MOO,
      "x" => $x,
      "y" => $y,
      "h" => $h,
      "lat" => $LAT,
      "long" => $LONG,
      "fbasinId" => $fbasin_id,
      "fbasinName" => $fbasin_name
    );

    array_push($prefixArray["vLinkAreaDetail"], $prefix_item);
  }

  http_response_code(200);

  echo json_encode($prefixArray);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}
