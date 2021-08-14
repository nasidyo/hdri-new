<?php 
// require '../connection/database.php';
//         $yearsId = $_POST["yearsId"];
//         // $sql2 = "
//         //     SELECT DISTINCT vlad.idRiverBasin , vlad.nameRiverBasin ,SUM (pmt.TotalValue ) as totalvalue
//         //     FROM MainBasin vlad 
//         //     INNER JOIN Area a ON a.RiverBasin_idRiverBasin = vlad.idRiverBasin 
//         //     INNER JOIN PersonMarket_TD pmt ON pmt.Area_idArea = a.idArea 
//         //     WHERE vlad.idRiverBasin NOT IN (1,22) and a.target_area_type_id in (3,10 ,5) and YearID ='".$yearsId."'
//         //     GROUP BY vlad.idRiverBasin,  vlad.nameRiverBasin ";
//         $sql2 = "SELECT DISTINCT a.target_area_type_id, a.areaType ,SUM (pmt.TotalValue ) as totalvalue
//                 FROM Area a 
//                 INNER JOIN PersonMarket_TD pmt ON pmt.Area_idArea = a.idArea 
//                 WHERE a.RiverBasin_idRiverBasin NOT IN (1,22) and a.target_area_type_id in (3,10 ,5) and YearID ='".$yearsId."'
//                 GROUP BY a.target_area_type_id, a.areaType";
//         $db = new Database();
//         $conn = $db->getConnection();
//         $stmt = sqlsrv_query( $conn, $sql2 );
//         if( !$stmt ) {
//             die( print_r( sqlsrv_errors(), true));
//         }
//         $return_arr = array();
//         $count = 1;
//         $data1 = '';
//         $data = '';
//         $totoal = 0;
//         // $Btn = "<div class='form-group row'><div class='col-md-1'></div><div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary basins active' onclick='return reportNewF.a1_onclick(0)' id='basin_0'>ทุกลุ่มน้ำ</button></center></div>";
//         while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//             $totoal = $totoal+$row['totalvalue'];
//             if($count%2 == 0){
//                 if($count != 0){
//                     $data .= '</div><div class="row">';
//                     // $Btn .= "</div> <div class='form-group row'><div class='col-md-1'></div>";
//                 }
//             }
//             $data .= '<div class="col-lg-6 col-6">';
//                 $data .= '<div class="small-box bg-info">';
//                 $data .= '<div class="inner">';
//                 $data .= '<h3>'.number_format($row['totalvalue']).'<sup style="font-size: 20px">&#3647;</sup></h3>';
//                 $data .= '<p>'.$row['areaType'].'</p></div><div class="icon">
//                 <i class="ion ion-stats-bars"></i>
//                     </div>
//                     <a href="javascript:reportNewF.a1_onclick('.$row['target_area_type_id'].');" id="basin_'.$row['target_area_type_id'].'" class="small-box-footer basins">More info <i class="fas fa-arrow-circle-right"></i></a>
//                 </div></div>';
//             // $Btn .="<div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary basins' onclick='return reportNewF.a1_onclick(".$row['fbasin_id'].")' id='basin_".$row['fbasin_id']."'>".$row['fbasin_name']."</button></center></div>";
//             $count ++;
//         }
//         $data .= '</div>';
//         $data1 .= '<div class="form-group row"><div class="col-lg-6 col-6">';
//         $data1 .= '<div class="small-box bg-info">';
//         $data1 .= '<div class="inner">';
//         $data1 .= '<h3>'.number_format($totoal).'<sup style="font-size: 20px">&#3647;</sup></h3>';
//         $data1 .= '<p>ทุกโครงการ</p></div><div class="icon">
//                         <i class="ion ion-stats-bars"></i>
//                     </div>
//                     <a href="javascript:reportNewF.a1_onclick(0);" id="basin_0" class="small-box-footer basins active">More info <i class="fas fa-arrow-circle-right"></i></a>
//                     </div></div>';
//         $data1 = $data1.$data;
//         echo $data1;

require '../connection/database.php';
        $yearsId = $_POST["yearsId"];
        $passYearsId = $_POST["yearsId"]-1;

        $sql = "SELECT COALESCE(t1.TotalValue1,0) as TotalValue1 , COALESCE(t2.TotalValue2,0) as TotalValue2 , t3.target_area_type_id, t3.areaType,  COALESCE(t3.TotalValueNow,0) as TotalValueNow
            from (SELECT sum(COALESCE(pmt.TotalValue,0)) as TotalValue1 
            FROM PersonMarket_TD pmt 
            WHERE pmt.YearID ='".$yearsId."') as t1 , 
            (SELECT sum(COALESCE(pmt1.TotalValue,0)) as TotalValue2
                FROM PersonMarket_TD pmt1
                WHERE pmt1.YearID ='".$passYearsId."') as t2 , 
            (SELECT a.target_area_type_id , a.areaType , SUM( COALESCE(pmt.TotalValue,0) ) as TotalValueNow 
                FROM PersonMarket_TD pmt 
                INNER JOIN Area a ON a.idArea = pmt.Area_idArea
                WHERE pmt.YearID = '".$yearsId."'
                GROUP BY a.target_area_type_id, a.areaType) as t3 ";
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_query( $conn, $sql);
        $data = '<div class="row">';
        $count = 0;
        $return_arr = array();
        $sumPrice = 0;
        // $Btn = "<div class='form-group row'><div class='col-md-1'></div><div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary basins active' onclick='return reportNewF.a1_onclick(0)' id='basin_0'>ทุกลุ่มน้ำ</button></center></div>";
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['totalOnyers'] = $row['TotalValue1'];
            $row_array['totalPassyers'] = $row['TotalValue2'];
            $row_array['totalValueNow'] = $row['TotalValueNow'];
            $row_array['target_area_type_id'] = $row['target_area_type_id'];
            $row_array['areaType'] = $row['areaType'];
            $sql2 = "SELECT SUM( COALESCE(pmt4.TotalValue,0) ) as TotalValuePast 
                FROM PersonMarket_TD pmt4 
                INNER JOIN Area a ON a.idArea = pmt4.Area_idArea
                WHERE pmt4.YearID = '".$passYearsId."' and a.target_area_type_id = '".$row['target_area_type_id']."'";
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
            //$sql2 = "SELECT SUM( COALESCE(pmt4.TotalValue,0) ) as TotalValuePast
            //     $totoal = $totoal+$row['totalvalue'];
            //     if($count%3 == 0){
            //         if($count != 0){
            //             $data .= '</div><div class="row">';
            //             // $Btn .= "</div> <div class='form-group row'><div class='col-md-1'></div>";
            //         }
            //     }
            //     $data .= '<div class="col-lg-4 col-6">';
            //         $data .= '<div class="small-box bg-info">';
            //         $data .= '<div class="inner">';
            //         $data .= '<h3>'.number_format($row['totalvalue']).'<sup style="font-size: 20px">&#3647;</sup></h3>';
            //         $data .= '<p>'.$row['nameRiverBasin'].'</p></div><div class="icon">
            //         <i class="ion ion-stats-bars"></i>
            //             </div>
            //             <a href="javascript:reportNewF.a1_onclick('.$row['idRiverBasin'].');" id="basin_'.$row['idRiverBasin'].'" class="small-box-footer basins">More info <i class="fas fa-arrow-circle-right"></i></a>
            //         </div></div>';
            //     // $Btn .="<div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary basins' onclick='return reportNewF.a1_onclick(".$row['fbasin_id'].")' id='basin_".$row['fbasin_id']."'>".$row['fbasin_name']."</button></center></div>";
            //     $count ++;
            // }
            // $data .= '</div>';
            // $data1 .= '<div class="form-group row"><div class="col-lg-4 col-6">';
            // $data1 .= '<div class="small-box bg-info">';
            // $data1 .= '<div class="inner">';
            // $data1 .= '<h3>'.number_format($totoal).'<sup style="font-size: 20px">&#3647;</sup></h3>';
            // $data1 .= '<p>ทุกลุ่มน้ำ</p></div><div class="icon">
            //                 <i class="ion ion-stats-bars"></i>
            //             </div>
            //             <a href="javascript:reportNewF.a1_onclick(0);" id="basin_0" class="small-box-footer basins active">More info <i class="fas fa-arrow-circle-right"></i></a>
            //             </div></div>';
            // $data1 = $data1.$data;
            // echo $data1;
?>