
<?php 
require_once '../connection/database.php';
require '../model/yearTargetM.php';
require '../service/date.php';

Class yearService {
    public function createNewYearTB ($yearM) {
        $sql  =" INSERT";
            $sql  .="  INTO YearTB ( idYearTB, nameYear, dateStart, dateStop)
            values (  ?, ?, ?, ? ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $yearM->getYearId(),
                $yearM->getYearName(),
                $yearM->getStartDate(),
                $yearM->getEndDate(),
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

    }

    public function LoadYearTB ($id) {
        $sql = "SELECT idYearTB, nameYear, FORMAT(dateStart, 'yyyy,MM,dd') as dateStartSTR, FORMAT(dateStop, 'yyyy,MM,dd') as dateStopSTR
                FROM YearTB
                WHERE idYearTB = ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $yearM = new yearM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $yearM->setYearId($row['idYearTB']);
            $yearM->setYearName($row['nameYear']);
            $yearM->setStartDate($row['dateStartSTR']);
            $yearM->setEndDate($row['dateStopSTR']);
        }
        echo json_encode($yearM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }

    public function updateYearTB ($yearM) {
        $sql  =" UPDATE YearTB SET nameYear = ?, dateStart = ?, dateStop=?";
            $sql  .=" WHERE idYearTB = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $yearM->getYearName(),
                $yearM->getStartDate(),
                $yearM->getEndDate(),
                $yearM->getYearId()
            );
            $stmt = sqlsrv_prepare( $conn, $sql, $params);
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
    }
}
?>