<?php
 require '../connection/database.php';
 require '../model/ArgiM.php';
 
 $db = new Database();
 $conn=  $db->getConnection();
 $idArgiGroup=0;
if (isset($_GET['idArgiGroup'])) {
  $idArgiGroup = $_GET['idArgiGroup'];
}

 $sql2=" SELECT ";
 $sql2.=" idAgri , 
 CASE 
 WHEN speciesArgi = '' THEN nameArgi
 WHEN speciesArgi IS NULL THEN nameArgi  
 ELSE nameArgi+'(พันธุ์:'+speciesArgi+')' END as nameOFArgi ";
 $sql2.=" FROM Agri_TD ";
 $sql2.=" WHERE ";
 $sql2.="  TypeOfArgi_idTypeOfArgi in (  ";
 if(is_array($idArgiGroup) ){
  for($i=0;$i<count($idArgiGroup) ; $i++){
    $sql2.=$idArgiGroup[$i];
    if($i!=count($idArgiGroup)-1){
      $sql2.=", ";
    }
  }
 }else{
  $sql2.=$idArgiGroup;
 }
 
 $sql2.=" ) ";
 $sql2.=" Order by nameOFArgi ";
 
 $stmt = sqlsrv_prepare($conn, $sql2);
 $data = array();

 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
  $argiM = new ArgiM();
  $argiM->setIdAgri($row["idAgri"]);
  $argiM->setNameArgi($row["nameOFArgi"]);
  
   $data []= $argiM;
   
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 

?>