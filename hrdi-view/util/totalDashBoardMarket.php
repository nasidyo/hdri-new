<?php
    require '../connection/database.php';
    $db = new Database();
    $conn=  $db->getConnection();
    $yearsId = $_POST["yearsId"];
    $sql = "SELECT mt.idMarket , mt.nameMarket , sum(pmt.TotalValue ) as TotalValue 
        FROM PersonMarket_TD pmt 
        INNER JOIN Market_TD mt ON pmt.Market_idMarket = mt.idMarket
        WHERE pmt.YearID = '".$yearsId."'
        GROUP BY mt.idMarket, mt.nameMarket 
        ";
    $stmt = sqlsrv_query( $conn, $sql);
    $data = '<div class="row">';
    $count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        if($count == '0'){
            $data .= '<div class="col-lg-4 col-6">';
            $data .= '<div class="small-box bg-info">';
            $data .= '<div class="inner">';
            $data .= '<h3>'.number_format($row['TotalValue']).'<sup style="font-size: 20px">&#3647;</sup></h3>';
            $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div></div></div>';
        }else{
            if($count%3 == 0){
                $data .= '</div><div class="row">';
                $data .= '<div class="col-lg-4 col-6">';
                $data .= '<div class="small-box bg-info">';
                $data .= '<div class="inner">';
                $data .= '<h3>'.number_format($row['TotalValue']).'<sup style="font-size: 20px">&#3647;</sup></h3>';
                $data .= '<p>'.$row['nameMarket'].'</p></div><div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div></div></div>';
            }else{
                $data .= '<div class="col-lg-4 col-6">';
                $data .= '<div class="small-box bg-info">';
                $data .= '<div class="inner">';
                $data .= '<h3>'.number_format($row['TotalValue']).'<sup style="font-size: 20px">&#3647;</sup></h3>';
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