<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $year='';
if (isset($_GET['year'])) {
   $year = $_GET['year'];
}
$area = '';
if (isset($_GET['area'])) {
   $area =$_GET['area'];
}
$sql= " SELECT temp.TypeOfArgi_idTypeOfArgi, temp.nameTypeOfArgi, SUM(temp.totalsell) totalsell, SUM(temp.totalplan) totalplan
      FROM ( SELECT DISTINCT pmt.TypeOfArgi_idTypeOfArgi ,toat.nameTypeOfArgi, ISNULL(sum(pmt.TotalValue), 0) totalsell, 0 totalplan
         FROM PersonMarket_TD pmt 
         INNER JOIN TypeOfArgi_TD toat ON pmt.TypeOfArgi_idTypeOfArgi = toat.idTypeOfArgi 
         where YearID = '".$year."' ";
         if($area != ''){
            $sql.=" and pmt.Area_idArea = ".$area;
         }
      $sql.="group by pmt.TypeOfArgi_idTypeOfArgi, toat.nameTypeOfArgi 
         UNION
         SELECT DISTINCT tp.TypeOfArgi_idTypeOfArgi ,toat2.nameTypeOfArgi, 0 totalsell, ISNULL(sum(tp.Total), 0) totalplan
         FROM TargetPlan_TD tp 
         INNER JOIN TypeOfArgi_TD toat2 ON tp.TypeOfArgi_idTypeOfArgi = toat2.idTypeOfArgi 
         where YearTarget_YearID = '".$year."' ";
         if($area != ''){
            $sql.=" and tp.Area_idArea = ".$area;
         }

      $sql.="group by tp.TypeOfArgi_idTypeOfArgi, toat2.nameTypeOfArgi 
      ) temp
      group by temp.TypeOfArgi_idTypeOfArgi, temp.nameTypeOfArgi
      order by temp.TypeOfArgi_idTypeOfArgi
";
// $sql = "SELECT pmt.TypeOfArgi_idTypeOfArgi ,toat.nameTypeOfArgi , sum(pmt.TotalValue) as TotalValue , sum (pmt.Volumn) as TotalVolumn
//       from PersonMarket_TD pmt 
//       inner join TypeOfArgi_TD toat ON pmt.TypeOfArgi_idTypeOfArgi = toat.idTypeOfArgi
//       where YearID = '".$year."' and TypeOfArgi_idTypeOfArgi IS not null ";
// if($area != ''){
//    $sql.="  and pmt.Area_idArea = ".$area;
// }
// $sql.="group by TypeOfArgi_idTypeOfArgi, nameTypeOfArgi
//       order by TotalValue DESC";
   $stmt = sqlsrv_query( $conn, $sql );
   $data = array();
   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $row_array['nameTypeOfArgi'] = $row['nameTypeOfArgi'];
      $row_array['totalsell'] = $row['totalsell'];
      $row_array['totalplan'] = $row['totalplan'];
      array_push($data, $row_array);
   }
   echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
   sqlsrv_close($conn);
?>
