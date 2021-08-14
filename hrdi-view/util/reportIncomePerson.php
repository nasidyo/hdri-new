<?php
require '../connection/database.php';
require '../model/reportIncome.php';

$db = new Database();
$conn=  $db->getConnection();
if (isset($_POST['actionPage'])) {
  $actionPage = $_POST['actionPage'];
}
if (isset($_POST['area_Id'])) {
  $area_Id = $_POST['area_Id'];
}
if (isset($_POST['yearsId'])) {
  $yearsId = $_POST['yearsId'];
}

if (isset($_POST['typeOfAgri_id'])) {
  $typeOfAgri_id = $_POST['typeOfAgri_id'];
}
if (isset($_POST['agri'])) {
  $agri = $_POST['agri'];
}
if (isset($_POST['month_id'])) {
  $month_id = $_POST['month_id'];
}
if (isset($_POST['farmer_Id'])) {
  $farmer_Id = $_POST['farmer_Id'];
}
if($actionPage == 'show') {
    $sql2 = "
    SELECT TOP 5 pes.idPerson, pes.firstName+' '+pes.lastName as fullName, COALESCE(SUM(TotalValue),'0') AS totalIncomePerson
    FROM Person_TD pes
    LEFT JOIN PersonMarket_TD pesmk ON pes.idPerson = pesmk.Person_idPerson and pesmk.YearID = '".$yearsId."'
    WHERE pes.Area_idArea = '".$area_Id."'
    GROUP BY idPerson, firstName, lastName
    ORDER BY totalIncomePerson DESC";
}else{
  if($farmer_Id != '0'){
    $sql2 = "
      SELECT pes.idPerson, tyag.nameTypeOfArgi, 
      CASE 
      WHEN pesmk.species_Id = '' THEN ag.nameArgi
      WHEN pesmk.species_Id IS NULL THEN ag.nameArgi
      ELSE ag.nameArgi+'(พันธุ์:'+sa.species_name+')' END as nameOFArgi, COALESCE(SUM(TotalValue),'0') AS totalIncomePerson
      FROM Person_TD pes
      LEFT JOIN PersonMarket_TD pesmk ON pes.idPerson = pesmk.Person_idPerson and pesmk.YearID = '".$yearsId."'
      LEFT JOIN Agri_TD ag ON pesmk.Agri_idAgri = ag.idAgri
      LEFT JOIN SpeciesArgi_TD sa ON ag.idAgri = sa.Agri_idAgri and pesmk.species_Id = sa.species_Id 
      LEFT JOIN TypeOfArgi_TD tyag ON pesmk.TypeOfArgi_idTypeOfArgi = tyag.idTypeOfArgi
      WHERE pes.Area_idArea = '".$area_Id."' and pesmk.Person_idPerson = '".$farmer_Id."'";
      if ($month_id != '0') {
        $sql2 .="and pesmk.MonthNo = '".$month_id."'";
      }
      if ($typeOfAgri_id !='0'){
        $sql2 .="and pesmk.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
      }
      if ($agri !='0' && $agri != null){
        $sql2 .="and pesmk.Agri_idAgri = '".$agri."'";
      }
      $sql2 .="
        GROUP BY idPerson, nameTypeOfArgi, nameArgi, speciesArgi, pesmk.species_Id, species_name
        ORDER BY totalIncomePerson DESC
      ";
  }else{
    $sql2 = "
    SELECT TOP 5 pes.idPerson, pes.firstName+' '+pes.lastName as fullName, COALESCE(SUM(TotalValue),'0') AS totalIncomePerson
    FROM Person_TD pes
    LEFT JOIN PersonMarket_TD pesmk ON pes.idPerson = pesmk.Person_idPerson and pesmk.YearID = '".$yearsId."'
    LEFT JOIN Agri_TD ag ON pesmk.Agri_idAgri = ag.idAgri
    LEFT JOIN TypeOfArgi_TD tyag ON pesmk.TypeOfArgi_idTypeOfArgi = tyag.idTypeOfArgi
    WHERE pes.Area_idArea = '".$area_Id."'";
    if ($month_id != '0') {
      $sql2 .="and pesmk.MonthNo = '".$month_id."'";
    }
    if ($typeOfAgri_id !='0'){
      $sql2 .="and pesmk.TypeOfArgi_idTypeOfArgi = '".$typeOfAgri_id."'";
    }
    if ($agri !='0' && $agri != null){
      $sql2 .="and pesmk.Agri_idAgri = '".$agri."'";
    }
    $sql2 .="
      GROUP BY idPerson, firstName, lastName
      ORDER BY totalIncomePerson DESC";
  }
}
$stmt = sqlsrv_query( $conn, $sql2 );
$data = array();
if( !$stmt ) {
    die( print_r( sqlsrv_errors(), true));
  }
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
  if($actionPage == 'show') {
      $incomePerson =new IncomePerson();
      $incomePerson->setIdPerson($row["idPerson"]);
      $incomePerson->setfullName($row["fullName"]);
      $incomePerson->setTotalIncomePerson($row["totalIncomePerson"]);
  }else{
      if($farmer_Id != '0') {
        $incomePerson =new IncomePerson();
        $incomePerson->setIdPerson($row["idPerson"]);
        $incomePerson->setNameTypeOfArgi($row["nameTypeOfArgi"]);
        $incomePerson->setNameArgi($row["nameOFArgi"]);
        $incomePerson->setTotalIncomePerson($row["totalIncomePerson"]);
      }else{
        $incomePerson =new IncomePerson();
        $incomePerson->setIdPerson($row["idPerson"]);
        $incomePerson->setfullName($row["fullName"]);
        $incomePerson->setTotalIncomePerson($row["totalIncomePerson"]);
      }
  }
   $data[] = $incomePerson ;
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 

?>