<?php
require '../../connection/database.php';
$db = new Database();
$conn=  $db->getConnection();
   $area ='';
   if (isset($_GET['area'])) {
      $area =$_GET['area'];
   }
   $sql= " SELECT temp.idYearTB, SUM(temp.totalsell) totalsell, SUM(temp.totalplan) totalplan
         FROM ( SELECT DISTINCT TOP 5 yt.idYearTB, ISNULL(sum(pmt.TotalValue), 0) totalsell, 0 totalplan
            FROM YearTB yt 
            INNER JOIN PersonMarket_TD pmt ON yt.idYearTB = pmt.YearID ";
            if($area != ''){
               $sql.="  where pmt.Area_idArea = ".$area;
            }
         $sql.="group by yt.idYearTB 
            order by yt.idYearTB DESC
            UNION
            SELECT DISTINCT TOP 5 yt2.idYearTB, 0 totalsell, ISNULL(sum(tp.Total), 0) totalplan
            FROM YearTB yt2 
            INNER JOIN TargetPlan_TD tp ON yt2.idYearTB = tp.YearTarget_YearID ";
            if($area != ''){
               $sql.="  where tp.Area_idArea = ".$area;
            }

         $sql.="group by yt2.idYearTB 
            order by yt2.idYearTB DESC
         ) temp
         group by temp.idYearTB 
         order by temp.idYearTB DESC
   ";
// $sql = "SELECT top 5 yt.idYearTB, sum( pmt.TotalValue ) as TotalValue, sum(pmt.Volumn) as TotalVolumn 
//    from YearTB yt 
//    INNER JOIN PersonMarket_TD pmt ON yt.idYearTB = pmt.YearID ";
//    if($area != ''){
//       $sql.="  where pmt.Area_idArea = ".$area;
//    }
// $sql.="group by idYearTB 
//    order by idYearTB DESC ";

   $stmt = sqlsrv_query( $conn, $sql );
   $data = array();
   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $row_array['yearName'] = $row['idYearTB'];
      $row_array['totalsell'] = $row['totalsell'];
      $row_array['totalplan'] = $row['totalplan'];
      array_push($data, $row_array);
   }
   echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
   sqlsrv_close($conn);
?>
