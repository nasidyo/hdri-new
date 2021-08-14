<?php
 require '../connection/database.php';

 $db = new Database();
 $conn=  $db->getConnection();
 $idRiverBasin =0;
 $year =0;
 $area =0;
    if (isset($_GET['idRiverBasin'])) {
     $idRiverBasin =$_GET['idRiverBasin'];
    }
    if (isset($_GET['year'])) {
        $year =$_GET['year'];
    }
    if (isset($_GET['area'])) {
        $area =$_GET['area'];
    }
    $sql2  ="    SELECT    ";
    $sql2  .="    mk.idMarket ,  ";
    $sql2  .="    mk.nameMarket ,  ";
    $sql2  .="    SUM( ISNULL(tp.Weight,0))     Volumn,  ";
    $sql2  .="    SUM( ISNULL(tp.Price,0) )     Value,  ";
    $sql2  .="    SUM( ISNULL(tp.Total,0)) TotalValue   ";
    $sql2  .=" FROM  ";
    $sql2  .="    Market_TD mk  ";
    $sql2  .="    left join CustomerMarket_TD cm on mk.idMarket = cm.Market_idMarket  ";
    $sql2  .="    left join TargetPlan_TD tp on cm.idCustomerMarket = tp.market_id  ";
    $sql2  .="    left join Area a on tp.Area_idArea = a.idArea  ";
    $sql2  .="    left join RiverBasin rb on a.RiverBasin_idRiverBasin = rb.idRiverBasin  ";
    $sql2  .="    left join YearTB y on tp.YearTarget_YearID = y.idYearTB ";
    $sql2  .="    where 1=1  ";
    if($idRiverBasin!=0){
        $sql2.=" and  rb.idRiverBasin = ".$idRiverBasin;
    }
    if($year !=0){
        $sql2.="  and tp.YearTarget_YearID = ".$year;
    }
    if($area !=0){
        $sql2.="  and tp.Area_idArea = ".$area;
    }
    $sql2  .="    group by mk.idMarket ,  ";
    $sql2  .="    mk.nameMarket    ";

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
        $row_array['idMarket'] = $row['idMarket'];
        $row_array['nameMarket'] = $row['nameMarket'];
        $row_array['Volumn'] = $row['Volumn'];
        $row_array['Value'] = $row['Value'];
        $row_array['TotalValue'] = $row['TotalValue'];
        array_push($return_arr, $row_array);

    }
    sqlsrv_close($conn);
    echo json_encode($return_arr);
?>
