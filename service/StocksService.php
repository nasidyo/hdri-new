<?php
    require_once '../connection/database.php';
    require_once '../model/StocksM.php';
    Class StocksService{
        public function addStocks($StocksM){
            $sql  =" INSERT INTO Stocks ( stocks_id, person_id, amount, create_date, sub_group_id ) VALUES ( ?, ?, ?, ?, ? ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $StocksM->getStocksId(),
                $StocksM->getPersonId(),
                $StocksM->getAmount(),
                $StocksM->getCreateDate(),
                $StocksM->getSubGroupId()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateStocks($StocksM){
            $sql  =" UPDATE Stocks SET  person_id =? , amount = ?, create_date = ?, sub_group_id = ? WHERE stocks_id = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $StocksM->getPersonId(),
                $StocksM->getAmount(),
                $StocksM->getCreateDate(),
                $StocksM->getSubGroupId(),
                $StocksM->getStocksId()
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

         public function loadStocks($Id){

            $sql  =" SELECT stocks_id, person_id, amount, create_date, sub_group_id FROM Stocks where stocks_id = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $StocksM = new StocksM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $StocksM->setStocksId($row['stocks_id']);
                $StocksM->setPersonId($row['person_id']);
                $StocksM->setAmount($row['amount']);
                $StocksM->setCreateDate($row['create_date']);
                $StocksM->setSubGroupId($row['sub_group_id']);

            }
            echo json_encode($StocksM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function loadStocksM($Id){
        $sql  =" SELECT stocks_id, person_id, amount, create_date, sub_group_id FROM Stocks where stocks_id = ? ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $StocksM = new StocksM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $StocksM->setStocksId($row['stocks_id']);
            $StocksM->setPersonId($row['person_id']);
            $StocksM->setAmount($row['amount']);
            $StocksM->setCreateDate($row['create_date']);
            $StocksM->setSubGroupId($row['sub_group_id']);

        }
        sqlsrv_close($conn);
        return   $StocksM;
 }


 public function loadStocksByUser($Id){
    $sql  =" SELECT stocks_id, person_id, amount, create_date, sub_group_id FROM Stocks where person_id = ? order by create_date ";

    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql, array($Id));

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $StocksMList =[];
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $StocksM = new StocksM();
        $StocksM->setStocksId($row['stocks_id']);
        $StocksM->setPersonId($row['person_id']);
        $StocksM->setAmount($row['amount']);
        $StocksM->setCreateDate($row['create_date']);
        $StocksM->setSubGroupId($row['sub_group_id']);
        array_push($StocksMList , $StocksM );
    }
    sqlsrv_close($conn);
    return   $StocksMList;
}


public function delStocksByPerson($id){

    $sql  =" DELETE FROM Stocks WHERE person_id = ? ";

    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql, array($id));

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

 }

}


?>
