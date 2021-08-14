<?php
 require '../connection/database.php';
 require '../model/AreaCountM.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $idRiverBasin=0;
if (isset($_GET['idRiverBasin'])) {
  $idRiverBasin = $_GET['idRiverBasin'];
}

 $sql2=" SELECT ";
 $sql2.="  t1.idArea,";
 $sql2.="   t1.areaName ,";
 $sql2.="   ISNULL( t1.all_member , 0 ) all_member,";
 $sql2.="   ISNULL( t2.member, 0 )      member";
 $sql2.="   FROM ";
 $sql2.="  (";
 $sql2.="      SELECT";
 $sql2.="          a.idArea,";
 $sql2.="          a.areaName ,";
 $sql2.="          COUNT (p.idPerson) all_member";
 $sql2.="     FROM";
 $sql2.="          Area a";
 $sql2.="     LEFT JOIN";
 $sql2.="          Person_TD p";
 $sql2.="      ON";
 $sql2.="          p.Area_idArea = a.idArea";
 $sql2.="      WHERE";
 $sql2.="          a.RiverBasin_idRiverBasin =?";
 $sql2.="      GROUP BY";
 $sql2.="          a.areaName ,";
 $sql2.="          a.idArea ) t1";
 $sql2.="  LEFT JOIN";
 $sql2.="  (";
 $sql2.="      SELECT";
 $sql2.="          a.idArea,";
 $sql2.="          a.areaName ,";
 $sql2.="          COUNT (ra.idPerson) member";
 $sql2.="      FROM";
 $sql2.="          Area a";
 $sql2.="      LEFT JOIN";
 $sql2.="           ( select DISTINCT  idPerson , idArea from RegisterAgri_TD )  ra  ";
 $sql2.="      ON";
 $sql2.="          a.idArea =ra.idArea";
 $sql2.="      LEFT JOIN";
 $sql2.="          Person_TD p";
 $sql2.="      ON";
 $sql2.="          ra.idPerson = p.idPerson";
 $sql2.="      WHERE";
 $sql2.="          a.RiverBasin_idRiverBasin =?";
 $sql2.="      GROUP BY";
 $sql2.="          a.areaName,";
 $sql2.="          a.idArea ) t2";
 $sql2.="  ON";
 $sql2.="  t1.idArea = t2.idArea";
 $sql2.="  WHERE";
 $sql2.="   all_member <> 0";
 $sql2.="  ORDER BY";
 $sql2.="  t1.idArea ";

 /*$sql2.=" t1.idArea, ";
 $sql2.=" t1.areaName , ";
 $sql2.="  ISNULL( t1.all_member , 0 ) all_member, ";
 $sql2.="  ISNULL( t2.member, 0 )      member ";
 $sql2.=" FROM ";
 $sql2.="  ( ";
 $sql2.="      SELECT ";
 $sql2.="          a.idArea, ";
 $sql2.="          a.areaName , ";
 $sql2.="          COUNT (p.idPerson) all_member ";
 $sql2.="      FROM ";
 $sql2.="          Area a ";
 $sql2.="      LEFT JOIN ";
 $sql2.="          Person_TD p ";
 $sql2.="      ON ";
 $sql2.="          p.Area_idArea = a.idArea ";
 $sql2.="      WHERE ";
 $sql2.="          a.RiverBasin_idRiverBasin =? ";
 $sql2.="      GROUP BY ";
 $sql2.="          a.areaName , ";
 $sql2.="          a.idArea ) t1 ";
 $sql2.=" LEFT JOIN ";
 $sql2.="  ( ";
 $sql2.="      SELECT ";
 $sql2.="          a.idArea, ";
 $sql2.="          a.areaName , ";
 $sql2.="          COUNT (p.idPerson) member ";
 $sql2.="      FROM ";
 $sql2.="          Area a ";
 $sql2.="      LEFT JOIN ";
 $sql2.="          Person_TD p ";
 $sql2.="      ON ";
 $sql2.="          p.Area_idArea = a.idArea ";
 $sql2.="      WHERE ";
 $sql2.="          p.isMember ='Y' ";
 $sql2.="      AND a.RiverBasin_idRiverBasin =? ";
 $sql2.="      GROUP BY ";
 $sql2.="          a.areaName, ";
 $sql2.="          a.idArea ) t2 ";
 $sql2.=" ON ";
 $sql2.="  t1.idArea = t2.idArea where all_member <> 0 ";
 $sql2.=" ORDER BY ";
 $sql2.="  t1.idArea  ";*/
 $stmt = sqlsrv_prepare($conn, $sql2, array($idRiverBasin,$idRiverBasin));
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $areaCountM =new AreaCountM();
   $areaCountM->setIdArea($row["idArea"]);
   $areaCountM->setAreaName($row["areaName"]);
   $areaCountM->setAllMember($row["all_member"]);
   $areaCountM->setMember($row["member"]);
   $data[] = $areaCountM ;

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


?>
