<?php
require '../connection/database.php';
require '../model/reportIncome.php';

$db = new Database();
$conn=  $db->getConnection();
if (isset($_POST['years_Id'])) {
    $years_Id = $_POST['years_Id'];
}
if (isset($_POST['actionPage'])) {
    $actionPage = $_POST['actionPage'];
}
if (isset($_POST['area_Id'])) {
    $area_Id = $_POST['area_Id'];
}
if (isset($_POST['idRiverBasin'])) {
    $idRiverBasin = $_POST['idRiverBasin'];
}

if (isset($_POST['typeOfAgri_id'])) {
    $typeOfAgri_id = $_POST['typeOfAgri_id'];
}
$agriList = '';
if (isset($_POST['agriList'])) {
    $agriList = $_POST['agriList'];
}
if (isset($_POST['typeofStandardId'])) {
    $typeofStandardId = $_POST['typeofStandardId'];
}

if($actionPage == 'Nofind'){
    $sql = " SELECT COUNT (DISTINCT pmt.Person_idPerson) as contOfPerson, rb.idRiverBasin, rb.nameRiverBasin as lable
        FROM PersonMarket_TD pmt 
        INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
        INNER JOIN RiverBasin rb ON rb.idRiverBasin = a.RiverBasin_idRiverBasin 
        WHERE  pmt.YearID = '".$years_Id."'
        GROUP BY rb.idRiverBasin , rb.nameRiverBasin ";
}else{
    if($idRiverBasin != '0') {
        $sql = " SELECT COUNT (DISTINCT pmt.Person_idPerson) as contOfPerson, a.target_name as lable, a.idArea 
          FROM PersonMarket_TD pmt 
          INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
          INNER JOIN RiverBasin rb ON rb.idRiverBasin = a.RiverBasin_idRiverBasin 
          WHERE  pmt.YearID = '".$years_Id."' AND rb.idRiverBasin = '".$idRiverBasin."'";
          if($typeOfAgri_id != '0'){
              $sql .= " AND pmt.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
          }
          if($typeofStandardId != 'ALL'){
              $sql .=" AND pmt.TypeOfStand_idTypeOfStand = '".$typeofStandardId."'";
          }
          if($agriList != ''){
              $imploded_arr = implode(',', $agriList);
              $sql .=" AND pmt.Agri_idAgri in (".$imploded_arr.")";
          }
          $sql .= " GROUP BY a.target_name, a.idArea ";
          if($area_Id != '0'){
              $sql =" SELECT COUNT (DISTINCT pmt.Person_idPerson) as contOfPerson, at2.nameArgi as lable, at2.idAgri 
                FROM PersonMarket_TD pmt 
                INNER JOIN Agri_TD at2 ON at2.idAgri = pmt.Agri_idAgri 
                INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
                INNER JOIN RiverBasin rb ON rb.idRiverBasin = a.RiverBasin_idRiverBasin 
                WHERE  pmt.YearID = '".$years_Id."' and a.idArea ='".$area_Id."'";
                if($typeOfAgri_id != '0'){
                  $sql .= " AND pmt.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
                }
                if($typeofStandardId != 'ALL'){
                    $sql .=" AND pmt.TypeOfStand_idTypeOfStand = '".$typeofStandardId."'";
                }
                if($agriList != ''){
                    $imploded_arr = implode(',', $agriList);
                    $sql .=" AND pmt.Agri_idAgri in (".$imploded_arr.")";
                }
                $sql .=" GROUP BY at2.nameArgi , at2.idAgri ";
          }
          
    }else{
      $sql = " SELECT COUNT (DISTINCT pmt.Person_idPerson) as contOfPerson, rb.idRiverBasin, rb.nameRiverBasin as lable
        FROM PersonMarket_TD pmt 
        INNER JOIN Area a ON a.idArea = pmt.Area_idArea 
        INNER JOIN RiverBasin rb ON rb.idRiverBasin = a.RiverBasin_idRiverBasin 
        WHERE  pmt.YearID = '".$years_Id."'";
        if($typeOfAgri_id != '0'){
          $sql .= " AND pmt.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
        }
        if($typeofStandardId != 'ALL'){
            $sql .=" AND pmt.TypeOfStand_idTypeOfStand = '".$typeofStandardId."'";
        }
        if($agriList != ''){
            $imploded_arr = implode(',', $agriList);
            $sql .=" AND pmt.Agri_idAgri in (".$imploded_arr.")";
        }
        $sql .=" GROUP BY rb.idRiverBasin , rb.nameRiverBasin ";
    }
}
$stmt = sqlsrv_query( $conn, $sql);
$data = array();
$datalable = [];
$dataset = [];
if( !$stmt ) {
    die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    array_push($datalable, $row['lable']);
    array_push($dataset, $row['contOfPerson']);
}
$row_array['datalable'] = $datalable;
$row_array['dataset'] = $dataset;
array_push($data, $row_array);

echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
?>