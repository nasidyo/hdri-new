<?php
 require '../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2 = "
    SELECT pmk.idPersonMarket, per.firstName+' '+per.lastName as fullName, tyag.nameTypeOfArgi,
    CASE 
    WHEN ag.speciesArgi = '' THEN ag.nameArgi
    WHEN ag.speciesArgi IS NULL THEN ag.nameArgi  
    ELSE ag.nameArgi+'(พันธุ์:'+ag.speciesArgi+')' END as nameOFArgi, tos.nameTypeOfStand, gd.codeGrade, mk.nameMarket, cus.c_name
    FROM PersonMarket_TD pmk
    INNER JOIN Agri_TD ag ON pmk.Agri_idAgri = ag.idAgri
    INNER JOIN TypeOfArgi_TD tyag ON pmk.TypeOfArgi_idTypeOfArgi = tyag.idTypeOfArgi
    INNER JOIN TypeOfStand tos ON pmk.TypeOfStand_idTypeOfStand = tos.idTypeOfStand
    INNER JOIN Grade gd ON pmk.Grade_codeGrade = gd.idGrade
    INNER JOIN Person_TD per ON pmk.Person_idPerson = per.idPerson
    LEFT JOIN Market_TD mk ON pmk.Market_idMarket = mk.idMarket
    LEFT JOIN Customer_TD cus ON pmk.Customer_idCustomer = cus.idCustomer
    LEFT JOIN CustomerMarket_TD cusmk ON cus.idCustomer = cusmk.Customer_idCustomer and mk.idMarket = cusmk.Market_idMarket and pmk.Area_idArea = cusmk.Area_idArea
    WHERE pmk.Area_idArea ='".$_POST["area_Id"]."' and pmk.MonthNo = '".$_POST["monthsOfDeliver"]."' and pmk.YearID ='".$_POST["yearsOfDeliver"]."'
";
    $stmt = sqlsrv_query( $conn, $sql2 );
    $data="";
    $rows = sqlsrv_has_rows($stmt);
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $data .= "<tr>";
        $data.="<td><input type='checkbox' id='deliverProduct' name='deliverProduct' value='".$row['idPersonMarket']."'></td>";
        $data.="<td>".$row['fullName']."</td>";
        $data.="<td>".$row['nameTypeOfArgi']."</td>";
        $data.="<td>".$row['nameOFArgi']."</td>";
        $data.="<td>".$row['nameTypeOfStand']."</td>";
        $data.="<td>".$row['codeGrade']."</td>";
        $data.="<td>".$row['nameMarket']."</td>";
        $data.="<td>".$row['c_name']."</td>";
      $data.="</tr>";
    }
 echo  $data;


?>