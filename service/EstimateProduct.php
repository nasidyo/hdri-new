
<?php 
require_once '../connection/database.php';
require '../model/EstimateM.php';
require '../service/date.php';

Class estimeteProductService{
    public function updateEstimateProduct ($EstimateM){
        $sql  =" UPDATE OutputValueCast_TD SET ";
        $sql.=" Weight = ?, Price= ? , Total= ?";
        $sql.=" WHERE idOutputValue = ? and Week = ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $EstimateM->getWeight(), $EstimateM->getPrice(), (float)round((float)round($EstimateM->getWeight(),2)*(float)round($EstimateM->getPrice(),2),2),$EstimateM->getIdOutputValue(), $EstimateM->getWeekNo() 
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function updateOutputValue ($EstimateM){
        $sql2 = "
            SELECT SUM(Weight) as weight, SUM(Price) as price, SUM(Total) as total
            FROM OutputValueCast_TD
            WHERE idOutputValue ='".$EstimateM->getIdOutputValue()."' and MonthNo = '".$EstimateM->getIdMonth()."'
        ";
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql2);
        
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {  
            $weight = $row['weight'];
            $price = $row['price'];
            $total = $row['total'];
            echo $weight;
            $updateSql =" UPDATE OutputValue_TD SET ";
            $updateSql.=" Weight = ?, Price = ?, Total = ?";
            $updateSql.=" WHERE idOutputValue = ?";
            $db = new Database();
            $conns =  $db->getConnection();
            $resules = sqlsrv_prepare($conns, $updateSql, array(
                $weight, $price, $total, $EstimateM->getIdOutputValue()
            ));
            if( !$resules ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $resules ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conns);
        }
    }
}
?>