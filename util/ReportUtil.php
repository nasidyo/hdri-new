<?php 
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $idRiverBasin =0;
   if (isset($_GET['idRiverBasin'])) {
     $idRiverBasin =$_GET['idRiverBasin'];
    }
    $sql2  ="    select  ";
    $sql2  .="     t1.idRiverBasin , ";
    $sql2  .="     t1.nameRiverBasin, ";
    $sql2  .="     t1.Volumn, ";
    $sql2  .="     t1.Value, ";
    $sql2  .="     t1.TotalValue, "; 
    $sql2  .="     t2.Price, ";
    $sql2  .="     t2.Weight, ";
    $sql2  .="     t2.Total ";
    $sql2  .="  from ";
    $sql2  .="  ( SELECT ";
    $sql2  .=" rb.idRiverBasin , ";
    $sql2  .="  rb.nameRiverBasin, ";
    $sql2  .="  SUM( ISNULL(pm.Volumn,0))     Volumn, ";
    $sql2  .="  SUM( ISNULL(pm.Value,0))      Value, ";
    $sql2  .="  SUM( ISNULL(pm.TotalValue,0)) TotalValue ";
    $sql2  .="  FROM ";
    $sql2  .="  PersonMarket_TD pm ";
    $sql2  .="  RIGHT JOIN ";
    $sql2  .="  Area a ";
    $sql2  .="  ON ";
    $sql2  .="  pm.Area_idArea = a.idArea ";
    $sql2  .="  RIGHT JOIN ";
    $sql2  .="  RiverBasin rb ";
    $sql2  .="  ON ";
    $sql2  .="  a.RiverBasin_idRiverBasin = rb.idRiverBasin where rb.idRiverBasin != '1' and rb.idRiverBasin != '22' ";
    $sql2  .="  GROUP BY rb.idRiverBasin , rb.nameRiverBasin ) t1 , ( ";
    $sql2  .="  SELECT ";
    $sql2  .="  rb.idRiverBasin , ";
    $sql2  .="  rb.nameRiverBasin, ";
    $sql2  .="  SUM(ISNULL( tp.Price,0)) Price, ";
    $sql2  .="  SUM(ISNULL(tp.Weight,0)) Weight , ";
    $sql2  .="  SUM(ISNULL(tp.Total,0))  Total ";
    $sql2  .="  FROM ";
    $sql2  .="  RiverBasin rb ";
    $sql2  .="  LEFT JOIN ";
    $sql2  .="  Area a ";
    $sql2  .="  ON ";
    $sql2  .="  rb.idRiverBasin = a.RiverBasin_idRiverBasin ";
    $sql2  .="  LEFT JOIN ";
    $sql2  .="  TargetPlan_TD tp ";
    $sql2  .="  ON ";
    $sql2  .="  a.idArea = tp.Area_idArea where rb.idRiverBasin != '1' and rb.idRiverBasin != '22'";
    $sql2  .="  GROUP BY ";
    $sql2  .="  rb.idRiverBasin , ";
    $sql2  .="  rb.nameRiverBasin ";
    $sql2  .="  ) t2 where t1.idRiverBasin = t2.idRiverBasin  ";
    if($idRiverBasin!=0){
        $sql2.=" and  t1.idRiverBasin = ".$idRiverBasin;
    }
  
    $return_arr = array();
    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql2 );

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['idRiverBasin'] = $row['idRiverBasin'];
        $row_array['nameRiverBasin'] = $row['nameRiverBasin'];
        $row_array['Volumn'] = $row['Volumn'];
        $row_array['Value'] = $row['Value'];
        $row_array['TotalValue'] = $row['TotalValue'];

        $row_array['Price'] = $row['Price'];
        $row_array['Weight'] = $row['Weight'];
        $row_array['Total'] = $row['Total'];
        array_push($return_arr, $row_array);

    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>