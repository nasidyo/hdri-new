<?php
 require '../connection/database.php';

 
 $db = new Database();
 $conn=  $db->getConnection();
 
if (isset($_GET['idArea'])) {
    $idArea = $_GET['idArea'];
}
if (isset($_GET['idMarket'])) {
    $idMarket = $_GET['idMarket'];
}

 $sql2=" SELECT ";
 $sql2.="    lt.list_taget_agri_id, ";
 $sql2.="       lt.area_id, ";
 $sql2.="       lt.status, ";
 $sql2.="       lt.agri_id, ";
 $sql2.="       lt.TypeOfArgi_idTypeOfArgi , ";
 $sql2.="       concat (ag.nameArgi, ";
 $sql2.="       CASE ";
 $sql2.="           WHEN ag.speciesArgi IS NULL ";
 $sql2.="           THEN concat(' (เกรด :',g.codeGrade,')') ";
 $sql2.="           WHEN ag.speciesArgi ='' ";
 $sql2.="            THEN concat(' (เกรด :',g.codeGrade,')') ";
 $sql2.="            ELSE concat('( พันธุ์ :',ag.speciesArgi, ' เกรด :',g.codeGrade , ')') ";
 $sql2.="        END ) nameArgi , ";
 $sql2.="        ta.nameTypeOfArgi ";
 $sql2.="    FROM ";
 $sql2.="        list_taget_agri lt , ";
 $sql2.="        Agri_TD ag , ";
 $sql2.="        TypeOfArgi_TD ta , ";
 $sql2.="        Grade  g ";
 $sql2.="     WHERE ";
 $sql2.="        lt.agri_id = ag.idAgri ";
 $sql2.="    AND ag.TypeOfArgi_idTypeOfArgi = ta.idTypeOfArgi ";
 $sql2.="    and lt.grade = g.idGrade ";
 $sql2.="   AND  lt.area_id =".$idArea." "; 


 $stmt = sqlsrv_prepare($conn, $sql2);

 $data="";
 if( !$stmt ) {
  die( print_r( sqlsrv_errors(), true));
}
if( sqlsrv_execute( $stmt ) === false ) {
  die( print_r( sqlsrv_errors(), true));
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $id_pre=$row["agri_id"];
    $name_pre=$row["nameArgi"];
    if($id_pre != "0"){
        $data .= "<option value='$id_pre'> $name_pre</option>";
    }
 }
 echo $data;
 

?>