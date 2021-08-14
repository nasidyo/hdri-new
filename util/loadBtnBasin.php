<?php 
require '../connection/database.php';
        $yearsId = $_POST["yearsId"];
        $passYearsId = $_POST["yearsId"]-1;

        $sql = "SELECT COALESCE(t1.TotalValue1,0) as TotalValue1 , COALESCE(t2.TotalValue2,0) as TotalValue2 , t3.idRiverBasin, t3.nameRiverBasin,  COALESCE(t3.TotalValueNow,0) as TotalValueNow
            from (SELECT sum(COALESCE(pmt.TotalValue,0)) as TotalValue1 
            FROM PersonMarket_TD pmt 
            WHERE pmt.YearID ='".$yearsId."') as t1 , 
            (SELECT sum(COALESCE(pmt1.TotalValue,0)) as TotalValue2
                FROM PersonMarket_TD pmt1
                WHERE pmt1.YearID ='".$passYearsId."') as t2 , 
            (SELECT mb.idRiverBasin , mb.nameRiverBasin , SUM( COALESCE(pmt.TotalValue,0) ) as TotalValueNow 
                FROM PersonMarket_TD pmt 
                INNER JOIN Area a ON a.idArea = pmt.Area_idArea
                INNER JOIN MainBasin mb ON mb.idRiverBasin = a.RiverBasin_idRiverBasin 
                WHERE pmt.YearID = '".$yearsId."'
                GROUP BY mb.idRiverBasin, mb.nameRiverBasin) as t3 ";
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
            $row_array['idRiverBasin'] = $row['idRiverBasin'];
            $row_array['nameRiverBasin'] = $row['nameRiverBasin'];
            $sql2 = "SELECT SUM( COALESCE(pmt4.TotalValue,0) ) as TotalValuePast 
                FROM PersonMarket_TD pmt4 
                INNER JOIN Area a ON a.idArea = pmt4.Area_idArea
                INNER JOIN MainBasin mb ON mb.idRiverBasin = a.RiverBasin_idRiverBasin
                WHERE pmt4.YearID = '".$passYearsId."' and mb.idRiverBasin = '".$row['idRiverBasin']."'";
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