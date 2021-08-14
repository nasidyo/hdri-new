<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $idRiverBasin =0;
  $year =0;

   if (isset($_GET['idRiverBasin'])) {
     $idRiverBasin =$_GET['idRiverBasin'];
    }

    if (isset($_GET['year'])) {
        $year =$_GET['year'];
       }
    $sql2  ="    SELECT  ";
    $sql2  .="    t1.idArea ,  ";
    $sql2  .="    t1.areaName,  ";
    $sql2  .="    t1.Volumn,  ";
    $sql2  .="    t1.Value,  ";
    $sql2  .="    t1.TotalValue,  ";
    $sql2  .="    t2.Price,  ";
    $sql2  .="    t2.Weight,  ";
    $sql2  .="    t2.Total  ";
    $sql2  .="FROM  ";
    $sql2  .="    (  ";
    $sql2  .="        SELECT  ";
    $sql2  .="            a.idArea ,  ";
    $sql2  .="            a.areaName,  ";
    $sql2  .="            a.RiverBasin_idRiverBasin,  ";
    $sql2  .="            SUM( ISNULL(pm.Volumn,0))     Volumn,  ";
    $sql2  .="            SUM( ISNULL(pm.Value,0))      Value,  ";
    $sql2  .="            SUM( ISNULL(pm.TotalValue,0)) TotalValue  ";
    $sql2  .="        FROM  ";
    $sql2  .="            PersonMarket_TD pm  ";
    $sql2  .="        RIGHT JOIN  ";
    $sql2  .="            Area a  ";
    $sql2  .="        ON  ";
    $sql2  .="            pm.Area_idArea = a.idArea  ";
    $sql2  .="        RIGHT JOIN  ";
    $sql2  .="            RiverBasin rb  ";
    $sql2  .="        ON  ";
    $sql2  .="            a.RiverBasin_idRiverBasin = rb.idRiverBasin  ";
    $sql2  .="        RIGHT JOIN ";
    $sql2  .="               YearTB y ";
    $sql2  .="            ON ";
    $sql2  .="               pm.YearID = y.idYearTB  ";
       if($year != 0){
        $sql2  .="        where pm.YearID = ".$year."and rb.idRiverBasin != '1' and rb.idRiverBasin != '22'";
       }
    $sql2  .="        GROUP BY  ";
    $sql2  .="            a.idArea ,  ";
    $sql2  .="            a.areaName ,  ";
    $sql2  .="            a.RiverBasin_idRiverBasin ) t1 ,  ";
    $sql2  .="    (  ";
    $sql2  .="        SELECT  ";
    $sql2  .="            a.idArea ,  ";
    $sql2  .="            a.areaName,  ";
    $sql2  .="           a.RiverBasin_idRiverBasin,  ";
    $sql2  .="            SUM(ISNULL( tp.Price,0)) Price,  ";
    $sql2  .="            SUM(ISNULL(tp.Weight,0)) Weight ,  ";
    $sql2  .="            SUM(ISNULL(tp.Total,0))  Total  ";
    $sql2  .="        FROM  ";
    $sql2  .="            RiverBasin rb  ";
    $sql2  .="        LEFT JOIN  ";
    $sql2  .="            Area a  ";
    $sql2  .="        ON  ";
    $sql2  .="            rb.idRiverBasin = a.RiverBasin_idRiverBasin  ";
    $sql2  .="        LEFT JOIN  ";
    $sql2  .="            TargetPlan_TD tp  ";
    $sql2  .="       ON  ";
    $sql2  .="           a.idArea = tp.Area_idArea  ";
    $sql2  .="        RIGHT JOIN ";
    $sql2  .="               YearTB y ";
    $sql2  .="            ON ";
    $sql2  .="               tp.YearTarget_YearID = y.idYearTB  ";
       if($year != 0){
        $sql2  .="        where  tp.YearTarget_YearID = ".$year."and rb.idRiverBasin != '1' and rb.idRiverBasin != '22'";
       }
    $sql2  .="        GROUP BY  ";
    $sql2  .="           a.idArea ,  ";
    $sql2  .="           a.areaName ,  ";
    $sql2  .="            a.RiverBasin_idRiverBasin) t2  ";
    $sql2  .=" WHERE  ";
    $sql2  .="    t1.idArea = t2.idArea  ";
    if($idRiverBasin!=0){
        $sql2  .=" AND t1.RiverBasin_idRiverBasin = ".$idRiverBasin;
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
        $row_array['idArea'] = $row['idArea'];
        $row_array['areaName'] = $row['areaName'];
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
