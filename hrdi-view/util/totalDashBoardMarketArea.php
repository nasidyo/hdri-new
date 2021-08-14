<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $area_Id = $_POST["area_Id"];
    $sql1 = "SELECT *
              FROM Market_TD
              ORDER BY idMarket";
    $stmt = sqlsrv_query( $conn, $sql1);
    $data = '<div class="row">';
    $count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $sql = "SELECT sum(pmt.TotalValue ) as TotalValue 
            FROM PersonMarket_TD pmt 
            WHERE pmt.YearID = '".$yearsId."' AND pmt.Area_idArea = '".$area_Id."' AND pmt.Market_idMarket = '".$row['idMarket']."'
        ";
        $TotalValue = 0;
        $stmtYears = sqlsrv_query($conn, $sql);
        if(sqlsrv_fetch( $stmtYears )) {
            $TotalValue = sqlsrv_get_field( $stmtYears, 0);
        }
        if($count == '0'){
            $data .= '<div class="col-lg-4 col-6">';
            $data .= '<div class="small-box bg-info">';
            $data .= '<div class="inner">';
            $data .= '<h3>'.number_format($TotalValue).'<sup style="font-size: 20px">&#3647;</sup></h3>';
            $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div></div></div>';
        }else{
            if($count%3 == 0){
                $data .= '</div><div class="row">';
                $data .= '<div class="col-lg-4 col-6">';
                $data .= '<div class="small-box bg-info">';
                $data .= '<div class="inner">';
                $data .= '<h3>'.number_format($TotalValue).'<sup style="font-size: 20px">&#3647;</sup></h3>';
                $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div></div></div>';
            }else{
                $data .= '<div class="col-lg-4 col-6">';
                $data .= '<div class="small-box bg-info">';
                $data .= '<div class="inner">';
                $data .= '<h3>'.number_format($TotalValue).'<sup style="font-size: 20px">&#3647;</sup></h3>';
                $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div></div></div>';
            }
        }
        $count ++;
    }
    $data .= '</div>';
    echo $data;
?>