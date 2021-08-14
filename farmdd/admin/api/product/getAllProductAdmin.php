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

$query = "SELECT * FROM ProductOfMember_MK 
INNER JOIN TypeOfArgi_TD ON TypeOfArgi_TD.idTypeOfArgi = ProductOfMember_MK.idTypeOfArgi
-- INNER JOIN TypeOfStand ON ProductOfMember_MK.idTypeOfStand = TypeOfStand.idTypeOfStand
-- INNER JOIN Agri_TD ON ProductOfMember_MK.idAgri = Agri_TD.idAgri
INNER JOIN Unit_MK ON ProductOfMember_MK.unit = Unit_MK.idUnit
INNER JOIN SellerMember_MK ON ProductOfMember_MK.idSellerMember = SellerMember_MK.idSellerMember 
LEFT JOIN TypeOfSeller_MK ON SellerMember_MK.idTypeOfSeller_MK = TypeOfSeller_MK.idTypeOfSeller_MK ORDER BY idProductOfMember_MK DESC
-- LEFT JOIN SpeciesArgi_TD ON ProductOfMember_MK.speciesArgi = SpeciesArgi_TD.species_Id";
$stmt = $db->prepare($query);
$stmt->execute();

if ($stmt->execute()) {

  $productArr = array();
  $productArr["productMk"] = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $productItem = array(
      "idProductOfMemberMk" => $idProductOfMember_MK,
      "idSellerMember" => $idSellerMember,
      "unit" => $unit,
      "idTypeOfStand" => $idTypeOfStand,
      "idAgri" => $idAgri,
      "detailOfProduct" => $detailOfProduct,
      "sizeOfProduct" => $sizeOfProduct,
      "priceBegin" => $priceBegin,
      "priceEnd" => $priceEnd,
      "monthOfProduct" => $monthOfProduct,
      "madeByOrder" => $madeByOrder,
      "speciesArgi" => $speciesArgi,
      // "speciesName" => $species_name,
      "titleImg" => $titleImg,
      "idTypeOfArgi" => $idTypeOfArgi,
      "nameTypeOfArgi" => $nameTypeOfArgi,
      "nameTypeOfArgiMk" => $nameTypeOfArgi_MK,
      "nameUnit" => $nameUnit,
      // "nameArgi" => $nameArgi,
      "groupName" => $groupName,
      "idTypeOfSellerMk" => $idTypeOfSeller_MK,
      "nameTypeOfSeller" => $nameTypeOfSeller,
      "suggestSta" => $suggestSta,
      "publish" => $publish,
      "firstName" => $firstName,
      "lastName" => $lastName,
      "addDate" => $addDate,
    );

    array_push($productArr["productMk"], $productItem);
  }

  http_response_code(200);

  echo json_encode($productArr);
} else {
  http_response_code(404);

  echo json_encode(
    array("message" => "No Contents found.")
  );
}
