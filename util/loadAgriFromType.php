<?php
$typeOfAgriId = '0';
if (isset($_POST['typeOfAgriId'])) {
  $typeOfAgriId = $_POST['typeOfAgriId'];
}
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $sql2=" SELECT ";
    $sql2.=" idAgri , 
    CASE 
    WHEN speciesArgi = '' THEN nameArgi
    WHEN speciesArgi IS NULL THEN nameArgi  
    ELSE nameArgi+'(พันธุ์:'+speciesArgi+')' END as nameOFArgi";
    $sql2.=" FROM Agri_TD ";
    $sql2.=" WHERE ";
    $sql2.=" TypeOfArgi_idTypeOfArgi = '".$typeOfAgriId."'";
    $sql2.=" Order by nameOFArgi ";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="<option value='0'>กรุณาเลือก</option>";
    $rows = sqlsrv_has_rows($stmt);
      while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $id_pre=$row["idAgri"];
        $name_pre=$row["nameOFArgi"];
        $data .="<option value='$id_pre'> $name_pre</option>";
      }
    echo  $data;

?>