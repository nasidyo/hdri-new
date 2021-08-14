<?php
    require_once '../connection/database.php';
    require_once '../model/DebtIncomeM.php';

    Class DebtIncomeService{
        public function addDebtIncome($DebtIncomeM){
            $sql  =" INSERT INTO DEBT_INCOME   ";
            $sql  .=" ( DEBT_ID, INCOME_ID, CUSTOMER_ID, PAY, CREATE_DATE, CREATE_BY, DOC_NO ,STATUS ,ATTACH )   ";
            $sql  .="  VALUES ( ?, ?, ?, ?, ?, ?, ? ,? ,?)  ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $DebtIncomeM->getDebtId(),
                $DebtIncomeM->getIncomeId(),
                $DebtIncomeM->getCustomer(),
                $DebtIncomeM->getPay(),
                $DebtIncomeM->getCreateDate(),
                $DebtIncomeM->getCreateBy(),
                $DebtIncomeM->getDocNo(),
                $DebtIncomeM->getStatus(),
                $DebtIncomeM->getAttach()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
         }

         public function updateDebtIncome($DebtIncomeM){
            $sql  =" UPDATE";
            $sql  .="  DEBT_INCOME";
            $sql  .=" SET";
            $sql  .="    STATUS = ? ";
            $sql  .=" WHERE";
            $sql  .="    DEBT_ID = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $DebtIncomeM->getStatus(),
                $DebtIncomeM->getDebtId()
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
         public function loadDebtByIncomeId($Id){
            $sql  ="  SELECT DEBT_ID, INCOME_ID, CUSTOMER_ID, PAY,   CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, CREATE_DATE) ) , 103) CREATE_DATE , CREATE_BY, DOC_NO, STATUS, ATTACH FROM DEBT_INCOME WHERE INCOME_ID =?  ORDER BY  CREATE_DATE ,DEBT_ID ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $debtArr=array();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $DebTIncomeM = new DebtIncomeM();
                $DebTIncomeM->setIncomeId($row['INCOME_ID']);
                $DebTIncomeM->setCreateDate($row['CREATE_DATE']);
                $DebTIncomeM->setCreateBy($row['CREATE_BY']);
                $DebTIncomeM->setCustomer($row['CUSTOMER_ID']);
                $DebTIncomeM->setPay($row['PAY']);
                $DebTIncomeM->setDebtId($row['DEBT_ID']);
                $DebTIncomeM->setDocNo($row['DOC_NO']);
                $DebTIncomeM->setStatus($row['STATUS']);
                $DebTIncomeM->setAttach($row['ATTACH']);
                array_push( $debtArr, $DebTIncomeM );
            }
            echo json_encode( $debtArr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);
     }
    }


?>
