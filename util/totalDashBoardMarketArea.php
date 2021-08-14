<?php
    // require '../connection/database.php';
    // $db = new Database();
    // $conn=  $db->getConnection();
    // $yearsId = $_POST["yearsId"];
    // $area_Id = $_POST["area_Id"];
    // $sql1 = "SELECT *
    //           FROM Market_TD
    //           ORDER BY idMarket";
    // $stmt = sqlsrv_query( $conn, $sql1);
    // $data = '<div class="row">';
    // $count = 0;
    // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    //     $sql = "SELECT sum(pmt.TotalValue ) as TotalValue 
    //         FROM PersonMarket_TD pmt 
    //         WHERE pmt.YearID = '".$yearsId."' AND pmt.Area_idArea = '".$area_Id."' AND pmt.Market_idMarket = '".$row['idMarket']."'
    //     ";
    //     $TotalValue = 0;
    //     $stmtYears = sqlsrv_query($conn, $sql);
    //     if(sqlsrv_fetch( $stmtYears )) {
    //         $TotalValue = sqlsrv_get_field( $stmtYears, 0);
    //     }
    //     if($count == '0'){
    //         $data .= '<div class="col-lg-4 col-6">';
    //         $data .= '<div class="small-box bg-info">';
    //         $data .= '<div class="inner">';
    //         $data .= '<h3>'.number_format($TotalValue).'<sup style="font-size: 20px">&#3647;</sup></h3>';
    //         $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
    //         <i class="ion ion-stats-bars"></i>
    //       </div></div></div>';
    //     }else{
    //         if($count%3 == 0){
    //             $data .= '</div><div class="row">';
    //             $data .= '<div class="col-lg-4 col-6">';
    //             $data .= '<div class="small-box bg-info">';
    //             $data .= '<div class="inner">';
    //             $data .= '<h3>'.number_format($TotalValue).'<sup style="font-size: 20px">&#3647;</sup></h3>';
    //             $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
    //             <i class="ion ion-stats-bars"></i>
    //           </div></div></div>';
    //         }else{
    //             $data .= '<div class="col-lg-4 col-6">';
    //             $data .= '<div class="small-box bg-info">';
    //             $data .= '<div class="inner">';
    //             $data .= '<h3>'.number_format($TotalValue).'<sup style="font-size: 20px">&#3647;</sup></h3>';
    //             $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
    //             <i class="ion ion-stats-bars"></i>
    //           </div></div></div>';
    //         }
    //     }
    //     $count ++;
    // }
    // $data .= '</div>';
    // echo $data;

    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $passYearsId = $_POST["yearsId"]-1;
    $area_Id = $_POST["area_Id"];
    $return_arr = array();
    $sql1 = "SELECT *
               FROM Market_TD
               ORDER BY idMarket";
    $stmt = sqlsrv_query( $conn, $sql1);
    $data = '<div class="row">';
    $count = 0;
    while( $row1 = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $row_array['nameMarket'] = $row1['nameMarket'];
        $sql = "SELECT COALESCE(t1.TotalValue1,0) as TotalValue1 , COALESCE(t2.TotalValue2,0) as TotalValue2 , t3.nameMarket, t3.idMarket,  COALESCE(t3.TotalValueNow,0) as TotalValueNow
            from (SELECT sum(COALESCE(pmt.TotalValue,0)) as TotalValue1 
            FROM PersonMarket_TD pmt 
            WHERE pmt.YearID ='".$yearsId."' AND pmt.Area_idArea = '".$area_Id."') as t1 , 
            (SELECT sum(COALESCE(pmt1.TotalValue,0)) as TotalValue2
            FROM PersonMarket_TD pmt1
            WHERE pmt1.YearID ='".$passYearsId."' AND pmt1.Area_idArea = '".$area_Id."' AND pmt1.Market_idMarket= '".$row1['idMarket']."') as t2 , 
            (SELECT mt2.idMarket , mt2.nameMarket , SUM( COALESCE(pmt3.TotalValue,0) ) as TotalValueNow 
                FROM PersonMarket_TD pmt3
                RIGHT JOIN Market_TD mt2 ON pmt3.Market_idMarket = mt2.idMarket
                WHERE pmt3.YearID = '".$yearsId."' AND pmt3.Area_idArea = '".$area_Id."' AND pmt3.Market_idMarket= '".$row1['idMarket']."' 
                GROUP BY mt2.idMarket, mt2.nameMarket) as t3 ";

        $stmt1 = sqlsrv_query( $conn, $sql);
        // $data = '<div class="row">';
        $count = 0;
        
        $sumPrice = 0;
        // echo $sql;
        $rows4 = sqlsrv_has_rows($stmt1);
        if ($rows4 === true){
            while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ) {
            // $sumPrice = $sumPrice+$row['TotalValue'];
                $row_array['totalOnyers'] = $row['TotalValue1'];
                $row_array['totalPassyers'] = $row['TotalValue2'];
                $row_array['totalValueNow'] = $row['TotalValueNow'];
            }
        }else{
            $row_array['totalOnyers'] = 0;
            $row_array['totalPassyers'] = 0;
            $row_array['totalValueNow'] = 0;
        }
        $sql2 = "SELECT SUM( COALESCE(pmt4.TotalValue,0) ) as TotalValuePast 
            FROM PersonMarket_TD pmt4 
            RIGHT JOIN Market_TD mt1 ON pmt4.Market_idMarket = mt1.idMarket
            WHERE pmt4.YearID = '".$passYearsId."' AND pmt4.Area_idArea = '".$area_Id."' AND pmt4.Market_idMarket= '".$row1['idMarket']."'
            GROUP BY mt1.idMarket, mt1.nameMarket ";
            $stmt3 = sqlsrv_prepare($conn, $sql2 );
            if( !$stmt3 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt3 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $rows3 = sqlsrv_has_rows($stmt3);
            if ($rows3 === true){
                while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
                    $row_array['totoalValuePass'] = $row3['TotalValuePast'];
                }
            }else{
                $row_array['totoalValuePass'] = 0;
            }
        array_push($return_arr, $row_array);
    }
    echo json_encode($return_arr);
?>