<?php
 require '../connection/database.php';
 require '../model/RiverBasinCountM.php';
 
 $db = new Database();
 $conn=  $db->getConnection();
 $sql2=" SELECT ";
 $sql2.=" t1.idRiverBasin, ";
 $sql2.=" t1.nameRiverBasin, ";
 $sql2.=" ISNULL(  t1.all_member, 0 )  all_member, ";
 $sql2.=" ISNULL(  t2.not_member, 0 )  not_member, ";
 $sql2.=" ISNULL(  t3.member, 0 )  member ";
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
 $sql2.="          r.idRiverBasin = p.RiverBasin_idRiverBasin ";
 $sql2.="      GROUP BY ";
 $sql2.="          r.idRiverBasin , ";
 $sql2.="          r.nameRiverBasin ) t1  left join  ";
 $sql2.="  ( ";
 $sql2.="      SELECT ";
 $sql2.="          r.idRiverBasin , ";
 $sql2.="          r.nameRiverBasin , ";
 $sql2.="          COUNT(p.idPerson) not_member ";
 $sql2.="      FROM ";
 $sql2.="          RiverBasin r ";
 $sql2.="      LEFT JOIN ";
 $sql2.="          Person_TD p ";
 $sql2.="      ON ";
 $sql2.="          r.idRiverBasin = p.RiverBasin_idRiverBasin ";
 $sql2.="      WHERE ";
 $sql2.="          p.isMember IS NULL ";
 $sql2.="      OR  p.isMember='N' ";
 $sql2.="      GROUP BY ";
 $sql2.="          r.idRiverBasin , ";
 $sql2.="          r.nameRiverBasin ) t2  ";
 $sql2.="          on t1.idRiverBasin = t2.idRiverBasin    LEFT JOIN     ";    
 $sql2.="  ( ";
 $sql2.="      SELECT ";
 $sql2.="          r.idRiverBasin , ";
 $sql2.="          r.nameRiverBasin , ";
 $sql2.="          COUNT(p.idPerson) member ";
 $sql2.="      FROM ";
 $sql2.="          RiverBasin r ";
 $sql2.="      LEFT JOIN ";
 $sql2.="          Person_TD p ";
 $sql2.=" ON ";
 $sql2.="          r.idRiverBasin = p.RiverBasin_idRiverBasin ";
 $sql2.="      WHERE ";
 $sql2.=" p.isMember ='Y' ";
 $sql2.="      GROUP BY ";
 $sql2.="          r.idRiverBasin , ";
 $sql2.="          r.nameRiverBasin ) t3  on t1.idRiverBasin = t3.idRiverBasin  where all_member <> 0 ";
 $sql2.="          order by idRiverBasin   ";
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