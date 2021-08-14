<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
include_once 'config/database.php';

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();
$secret_key = "YOUR_SECRET_KEY";
$jwt = null;

$data = json_decode(file_get_contents("php://input"));

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode(" ", $authHeader);
/*echo json_encode(array(
    "message" => "sd" .$arr[1]
));*/

 $jwt = $arr[0];

 if($jwt){

     try {

         $decoded = JWT::decode($jwt, $secret_key, array('HS256'));


         echo json_encode(array(
             "message" => "Access granted:",
         ));

     }catch (Exception $e){

     http_response_code(401);

     echo json_encode(array(
         "message" => "Access denied.",
         "error" => $e->getMessage()
     ));
 }

}
