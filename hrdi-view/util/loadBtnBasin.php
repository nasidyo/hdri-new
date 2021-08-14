<?php 
require '../connection/database.php';
        $yearsId = $_POST["yearsId"];
        $sql2 = "
            SELECT DISTINCT vlad.idRiverBasin , vlad.nameRiverBasin ,SUM (pmt.TotalValue ) as totalvalue
            FROM MainBasin vlad 
            INNER JOIN Area a ON a.RiverBasin_idRiverBasin = vlad.idRiverBasin 
            INNER JOIN PersonMarket_TD pmt ON pmt.Area_idArea = a.idArea 
            WHERE vlad.idRiverBasin NOT IN (1,22) and a.target_area_type_id in (3,10 ,5) and YearID ='".$yearsId."'
            GROUP BY vlad.idRiverBasin,  vlad.nameRiverBasin ";
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_query( $conn, $sql2 );
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $return_arr = array();
        $count = 1;
        $data1 = '';
        $data = '';
        $totoal = 0;
        // $Btn = "<div class='form-group row'><div class='col-md-1'></div><div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary basins active' onclick='return reportNewF.a1_onclick(0)' id='basin_0'>ทุกลุ่มน้ำ</button></center></div>";
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $totoal = $totoal+$row['totalvalue'];
            if($count%3 == 0){
                if($count != 0){
                    $data .= '</div><div class="row">';
                    // $Btn .= "</div> <div class='form-group row'><div class='col-md-1'></div>";
                }
            }
            $data .= '<div class="col-lg-4 col-6">';
                $data .= '<div class="small-box bg-info">';
                $data .= '<div class="inner">';
                $data .= '<h3>'.number_format($row['totalvalue']).'<sup style="font-size: 20px">&#3647;</sup></h3>';
                $data .= '<p>'.$row['nameRiverBasin'].'</p></div><div class="icon">
                <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="javascript:reportNewF.a1_onclick('.$row['idRiverBasin'].');" id="basin_'.$row['idRiverBasin'].'" class="small-box-footer basins">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div></div>';
            // $Btn .="<div class='col-md-3'><center><button type='button' class='btn waves-effect waves-light btn-rounded btn-outline-primary basins' onclick='return reportNewF.a1_onclick(".$row['fbasin_id'].")' id='basin_".$row['fbasin_id']."'>".$row['fbasin_name']."</button></center></div>";
            $count ++;
        }
        $data .= '</div>';
        $data1 .= '<div class="form-group row"><div class="col-lg-4 col-6">';
        $data1 .= '<div class="small-box bg-info">';
        $data1 .= '<div class="inner">';
        $data1 .= '<h3>'.number_format($totoal).'<sup style="font-size: 20px">&#3647;</sup></h3>';
        $data1 .= '<p>ทุกลุ่มน้ำ</p></div><div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="javascript:reportNewF.a1_onclick(0);" id="basin_0" class="small-box-footer basins active">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div></div>';
        $data1 = $data1.$data;
        echo $data1;
?>