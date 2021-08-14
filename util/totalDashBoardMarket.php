<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $passYearsId = $_POST["yearsId"]-1;
    $sql = "SELECT COALESCE(t1.TotalValue1,0) as TotalValue1 , COALESCE(t2.TotalValue2,0) as TotalValue2 , t3.nameMarket, t3.idMarket,  COALESCE(t3.TotalValueNow,0) as TotalValueNow
          from (SELECT sum(COALESCE(pmt.TotalValue,0)) as TotalValue1 
          FROM PersonMarket_TD pmt 
          WHERE pmt.YearID ='".$yearsId."') as t1 , 
          (SELECT sum(COALESCE(pmt1.TotalValue,0)) as TotalValue2
          FROM PersonMarket_TD pmt1
          WHERE pmt1.YearID ='".$passYearsId."') as t2 , 
          (SELECT mt.idMarket , mt.nameMarket , SUM( COALESCE(pmt.TotalValue,0) ) as TotalValueNow 
            FROM PersonMarket_TD pmt 
            RIGHT JOIN Market_TD mt ON pmt.Market_idMarket = mt.idMarket
            WHERE pmt.YearID = '".$yearsId."'
            GROUP BY mt.idMarket, mt.nameMarket) as t3";

    $stmt = sqlsrv_query( $conn, $sql);
    $data = '<div class="row">';
    $count = 0;
    $return_arr = array();
    $sumPrice = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      // $sumPrice = $sumPrice+$row['TotalValue'];
      $row_array['totalOnyers'] = $row['TotalValue1'];
      $row_array['totalPassyers'] = $row['TotalValue2'];
      $row_array['totalValueNow'] = $row['TotalValueNow'];
      $row_array['nameMarket'] = $row['nameMarket'];
      $sql2 = "SELECT SUM( COALESCE(pmt4.TotalValue,0) ) as TotalValuePast 
      FROM PersonMarket_TD pmt4 
      RIGHT JOIN Market_TD mt1 ON pmt4.Market_idMarket = mt1.idMarket
      WHERE pmt4.YearID = '".$passYearsId."' and mt1.idMarket = '".$row['idMarket']."'
      GROUP BY mt1.idMarket, mt1.nameMarket ";
      $stmt1 = sqlsrv_prepare($conn, $sql2 );
      if( !$stmt1 ) {
          die( print_r( sqlsrv_errors(), true));
      }
      if( sqlsrv_execute( $stmt1 ) === false ) {
          die( print_r( sqlsrv_errors(), true));
      }
      $rows1 = sqlsrv_has_rows($stmt1);
      if ($rows1 === true){
          while( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            $row_array['totoalValuePass'] = $row1['TotalValuePast'];
          }
      }else{
          $row_array['totoalValuePass'] = 0;
      }
        array_push($return_arr, $row_array);
    }
    echo json_encode($return_arr);
?>