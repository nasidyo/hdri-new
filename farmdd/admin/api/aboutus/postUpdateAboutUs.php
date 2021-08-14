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

$database = new Database();
$db = $database->getConnection();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$aboutTitle = isset($_POST['aboutTitle']) ? $_POST['aboutTitle'] : '';
$aboutBody = isset($_POST['aboutBody']) ? $_POST['aboutBody'] : '';

$time = date('Y-m-d H:i:s');

$query = "UPDATE aboutus_MK SET aboutTitle=?, aboutBody=? WHERE id=?";

$params = array($aboutTitle, $aboutBody, $id);

if (
  !empty($id) &&
  !empty($aboutBody)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    echo "True";
  } else {
    echo "False";
  }
}

