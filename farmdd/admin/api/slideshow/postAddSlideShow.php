<?php
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

$slideImgId = isset($_POST['slideImgId']) ? $_POST['slideImgId'] : '';

$image_file = $_FILES["img"]['name'];
$imgType = $_FILES["img"]['type'];
$size = $_FILES["img"]['size'];
$temp = $_FILES["img"]['tmp_name'];
$path = '../../upload/slideshow' . $image_file;
move_uploaded_file($temp, '../../upload/slideshow/' . $image_file);
$time = date('Y-m-d H:i:s');

$query = "UPDATE SlideShowImg SET imgTitle=? WHERE slideImgId=?";

$params = array($image_file, $slideImgId);

if (
  !empty($image_file)
) {
  $stmt = $db->prepare($query);
  if ($stmt->execute($params)) {
    echo "True";
  } else {
    echo "False";
  }
}

