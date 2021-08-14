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
$agriId = isset($_POST['agriId']) ? $_POST['agriId'] : '';

$query = "SELECT * FROM SpeciesArgi_TD WHERE Agri_idAgri=?";
$params = array($agriId);
$stmt = $db->prepare($query);

if ($stmt->execute($params)) {

  $speciesArr = array();
  $speciesArr["species"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $spieciesItem = array(
      "speciesId" => $species_Id,
      "speciesName" => $species_name,
      "agriId" => $Agri_idAgri,
    );

    array_push($speciesArr["species"], $spieciesItem);
  }

  http_response_code(200);

  echo json_encode($speciesArr);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}