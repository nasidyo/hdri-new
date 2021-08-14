<?php
 require '../../connection/database.php';
 $db = new Database();
 $conn=  $db->getConnection();
 $idMarket=0;
 if (isset($_GET['idMarket'])) {
    $idMarket = $_GET['idMarket'];
  }
  $year='';
  if (isset($_GET['year'])) {
     $year = $_GET['year'];
   }

 $sql2="  SELECT
            mt.nameMarket ,
            mt.idMarket,
            tp.YearTarget_YearID,
            DATENAME(month, DATEADD(month,  CAST ( tp.month_id as int) -1, CAST('2008-01-01' AS datetime))) monthName ,
            SUM( ISNULL( tp.Total,0)) TotalAmount
            FROM
            TargetPlan_TD tp ,
            Market_TD mt ,
            CustomerMarket_TD cm
            WHERE
                tp.market_id = cm.idCustomerMarket
            AND cm.Market_idMarket =mt.idMarket
            and mt.idMarket=".$idMarket."
            and tp.YearTarget_YearID ='".$year."'
            GROUP BY
            mt.nameMarket ,
            mt.idMarket,
            tp.YearTarget_YearID,
            tp.month_id
            ORDER BY
            tp.YearTarget_YearID,
            LEN(tp.month_id) ,tp.month_id ";

 $stmt = sqlsrv_query( $conn, $sql2 );
 $data = array();
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['monthName'] = $row['monthName'];
    $row_array['TotalAmount'] = $row['TotalAmount'];
    array_push($data, $row_array);
 }
 echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
 sqlsrv_close($conn);

?>
