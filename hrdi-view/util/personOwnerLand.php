<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2 = "
 SELECT
    l.idLand,
    p.idPerson,
    p.firstName
FROM
    Land_TD l ,
    Person_TD p
WHERE
    l.Person_idPerson = p.idPerson
AND p.idPerson = '". $_POST["person_id"]."'
";
$stmt = sqlsrv_query( $conn, $sql2 );
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$id_pre = $row["idLand"];
$name_pre = $row["idLand"];
$data .= "<option value='$id_pre'>$name_pre</option>";
}
echo $data;
?>
