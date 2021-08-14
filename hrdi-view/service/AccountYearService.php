<?php
    require_once '../connection/database.php';
    require_once '../model/AccountYearM.php';

    Class AccountYearService{
        public function addAccountYear($AccountYearM){
            $sql  =" INSERT INTO AccountYear ( account_year_id, account_year_start, account_year_end, status, current_bugget, sub_group_id ,bank_bugget, stocks_amount, stocks_price, year_text ) ";
            $sql  .="   VALUES ( ?, ?, ?, ?, ?, ? ,? ,?,?,? ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $AccountYearM->getAccountYearId(),
                $AccountYearM->getAccountYearStart(),
                $AccountYearM->getAccountYearEnd(),
                $AccountYearM->getStatus(),
                $AccountYearM->getCurrentBugget(),
                $AccountYearM->getSubGroupId(),
                $AccountYearM->getBankBugget(),
                $AccountYearM->getStocksAmount(),
                $AccountYearM->getStocksPrice(),
                $AccountYearM->getYearText()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateAccountYear($AccountYearM){
            $sql  =" UPDATE ";
            $sql  .=" AccountYear ";
            $sql  .=" SET ";
            $sql  .="     account_year_start = ?, ";
            $sql  .="     account_year_end = ?, ";
            $sql  .="     status = ?, ";
            $sql  .="     current_bugget = ? ";
            $sql  .=" WHERE ";
            $sql  .="     account_year_id = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $AccountYearM->getAccountYearStart(),
                $AccountYearM->getAccountYearEnd(),
                $AccountYearM->getStatus(),
                $AccountYearM->getCurrentBugget(),
                $AccountYearM->getAccountYearId()

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

         public function loadAccountYear($Id){

            $sql  =" SELECT account_year_id, account_year_start, account_year_end, status, current_bugget, sub_group_id, bank_bugget, stocks_amount, stocks_price, year_text FROM AccountYear where account_year_id =?";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $AccountYearM = new AccountYearM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $AccountYearM->setAccountYearId($row['account_year_id']);
                $AccountYearM->setAccountYearStart($row['account_year_start']);
                $AccountYearM->setAccountYearEnd($row['account_year_end']);
                $AccountYearM->setStatus($row['status']);
                $AccountYearM->setCurrentBugget($row['current_bugget']);
                $AccountYearM->setSubGroupId($row['sub_group_id']);

                $AccountYearM->setBankBugget($row['bank_bugget']);
                $AccountYearM->setStocksAmount($row['stocks_amount']);
                $AccountYearM->setStocksPrice($row['stocks_price']);
                $AccountYearM->setYearText($row['year_text']);


            }
            echo json_encode($AccountYearM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function loadAccountYearM($Id){

        $sql  ="  SELECT account_year_id, account_year_start, account_year_end, status, current_bugget, sub_group_id FROM AccountYear WHERE account_year_id=? ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $AccountYearM = new AccountYearM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $AccountYearM->setAccountYearId($row['account_year_id']);
            $AccountYearM->setAccountYearStart($row['account_year_start']);
            $AccountYearM->setAccountYearEnd($row['account_year_end']);
            $AccountYearM->setStatus($row['status']);
            $AccountYearM->setCurrentBugget($row['current_bugget']);
            $AccountYearM->setSubGroupId($row['sub_group_id']);
        }
        sqlsrv_close($conn);
        return   $AccountYearM;
 }



 public function loadAccountInYear($date,$sub_group_id){

    $sql  =" SELECT account_year_id, account_year_start,bank_bugget ,  account_year_end, status, current_bugget, sub_group_id , stocks_amount , stocks_price FROM AccountYear WHERE account_year_start <=? and account_year_end >= ? and sub_group_id =? ";

    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql, array($date,$date,$sub_group_id));

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $AccountYearM = new AccountYearM();
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $AccountYearM->setAccountYearId($row['account_year_id']);
        $AccountYearM->setAccountYearStart($row['account_year_start']);
        $AccountYearM->setAccountYearEnd($row['account_year_end']);
        $AccountYearM->setStatus($row['status']);
        $AccountYearM->setCurrentBugget($row['current_bugget']);
        $AccountYearM->setSubGroupId($row['sub_group_id']);
        $AccountYearM->setStocksAmount($row['stocks_amount']);
        $AccountYearM->setStocksPrice($row['stocks_price']);
        $AccountYearM->setBankBugget($row['bank_bugget']);
    }

    sqlsrv_close($conn);

    return   $AccountYearM;
}



 public function updateBank($id,$value){
    $sql  =" UPDATE ";
    $sql  .=" AccountYear ";
    $sql  .=" SET ";
    $sql  .="     bank_bugget = ? ";
    $sql  .=" WHERE ";
    $sql  .="     account_year_id = ? ";

    $db = new Database();
    $conn=  $db->getConnection();
    $params =array(
        $value,
        $id
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


 public function updateStocks($id,$value){
    $sql  =" UPDATE ";
    $sql  .=" AccountYear ";
    $sql  .=" SET ";
    $sql  .="     stocks_amount = ? ";
    $sql  .=" WHERE ";
    $sql  .="     account_year_id = ? ";

    $db = new Database();
    $conn=  $db->getConnection();
    $params =array(
        $value,
        $id
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


 public function updateCurrent($id,$value){
    $sql  =" UPDATE ";
    $sql  .=" AccountYear ";
    $sql  .=" SET ";
    $sql  .="     current_bugget = ? ";
    $sql  .=" WHERE ";
    $sql  .="     account_year_id = ? ";

    $db = new Database();
    $conn=  $db->getConnection();
    $params =array(
        $value,
        $id
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
