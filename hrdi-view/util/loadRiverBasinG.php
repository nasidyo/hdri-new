<?php
 require '../connection/database.php';
 require '../model/RiverBasinCountM.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $sql2=" SELECT ";
 $sql2.=" t1.idRiverBasin, ";
 $sql2.=" t1.nameRiverBasin, ";
 $sql2.="  ISNULL( t1.all_member, 0 ) all_member, ";
 $sql2.="  ISNULL( t3.member, 0 )     member , ";
 $sql2.="  all_member - member        not_member ";
 $sql2.=" FROM ";
 $sql2.="  ( ";
 $sql2.="      SELECT ";
 $sql2.="          r.idRiverBasin , ";
 $sql2.="          r.nameRiverBasin , ";
 $sql2.="          COUNT(p.idPerson) all_member ";
 $sql2.="      FROM ";
 $sql2.="          RiverBasin r ";
 $sql2.="      LEFT JOIN ";
 $sql2.="          Person_TD p ";
 $sql2.="      ON ";
 $sql2.="         r.idRiverBasin = p.RiverBasin_idRiverBasin ";
 $sql2.="     GROUP BY ";
 $sql2.="         r.idRiverBasin , ";
 $sql2.="         r.nameRiverBasin ) t1 ";
 $sql2.=" LEFT JOIN ";
 $sql2.="  ( ";
 $sql2.="      SELECT ";
 $sql2.="         COUNT(t.person_id) member, ";
 $sql2.="          t.idRiverBasin , ";
 $sql2.="          t.nameRiverBasin ";
 $sql2.="      FROM ";
 $sql2.="          ( ";
 $sql2.="             SELECT DISTINCT ";
 $sql2.="                 pg.person_id, ";
 $sql2.="                 rb.idRiverBasin , ";
 $sql2.="                 rb.nameRiverBasin ";
 $sql2.="             FROM ";
 $sql2.="                 PersonGroup_TD pg , ";
 $sql2.="                 INSTITUTE ins, ";
 $sql2.="                 Area a , ";
 $sql2.="                 RiverBasin rb ";
 $sql2.="             WHERE ";
 $sql2.="                 pg.institute_id = ins.INSTITUTE_ID ";
 $sql2.="             AND ins.AREA_ID = a.idArea ";
 $sql2.="             AND a.RiverBasin_idRiverBasin = rb.idRiverBasin ) AS t ";
 $sql2.="     GROUP BY ";
 $sql2.="         t.idRiverBasin , ";
 $sql2.="         t.nameRiverBasin ) t3 ";
 $sql2.=" ON ";
 $sql2.="  t1.idRiverBasin = t3.idRiverBasin ";
 $sql2.=" WHERE ";
 $sql2.="  all_member <> 0 ";
 $sql2.=" ORDER BY ";
 $sql2.="  idRiverBasin  ";

 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $riverCountM =new RiverBasinCountM();
   $riverCountM->setIdRiverBasin($row["idRiverBasin"]);
   $riverCountM->setNameRiverBasin($row["nameRiverBasin"]);
   $riverCountM->setAllMember($row["all_member"]);
   $riverCountM->setNotMember($row["not_member"]);
   $riverCountM->setMember($row["member"]);
   $data[] = $riverCountM ;

 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


?>
