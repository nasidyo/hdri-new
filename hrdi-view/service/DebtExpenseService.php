<?php
    require_once '../connection/database.php';
    require_once '../model/DebtExpenseM.php';

    Class DebtExpenseService{
        public function addDebtExpense($DebtExpenseM){
            $sql  =" INSERT INTO DEBT_EXPENSE   ";
            $sql  .=" ( DEBT_ID, EXPENSE_ID, CUSTOMER_ID, PAY, CREATE_DATE, CREATE_BY, DOC_NO ,STATUS ,ATTACH )   ";
            $sql  .="  VALUES ( ?, ?, ?, ?, ?, ?, ? ,?,? )  ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $DebtExpenseM->getDebtId(),
                $DebtExpenseM->getExpenseId(),
                $DebtExpenseM->getCustomer(),
                $DebtExpenseM->getPay(),
                $DebtExpenseM->getCreateDate(),
                $DebtExpenseM->getCreateBy(),
                $DebtExpenseM->getDocNo(),
                $DebtExpenseM->getStatus(),
                $DebtExpenseM->getAttach()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
         }

         public function updateDebtExpense($DebtExpenseM){
            $sql  =" UPDATE";
            $sql  .="  DEBT_EXPENSE";
            $sql  .=" SET";
            $sql  .="    STATUS = ? ";
            $sql  .=" WHERE";
            $sql  .="    DEBT_ID = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $DebtExpenseM->getStatus(),
                $DebtExpenseM->getDebtId()
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
         public function loadDebtByExpenseId($Id){
            $sql  ="  SELECT DEBT_ID, EXPENSE_ID, CUSTOMER_ID, PAY, CONVERT(VARCHAR ,CONVERT(DATE ,DATEADD(YEAR, 543, CREATE_DATE) ) , 103) CREATE_DATE , CREATE_BY, DOC_NO, STATUS,ATTACH FROM DEBT_EXPENSE WHERE EXPENSE_ID =?  ORDER BY  CREATE_DATE ,DEBT_ID ";
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
                $DebTExpenseM = new DebtExpenseM();
                $DebTExpenseM->setExpenseId($row['EXPENSE_ID']);
                $DebTExpenseM->setCreateDate($row['CREATE_DATE']);
                $DebTExpenseM->setCreateBy($row['CREATE_BY']);
                $DebTExpenseM->setCustomer($row['CUSTOMER_ID']);
                $DebTExpenseM->setPay($row['PAY']);
                $DebTExpenseM->setDebtId($row['DEBT_ID']);
                $DebTExpenseM->setDocNo($row['DOC_NO']);
                $DebTExpenseM->setStatus($row['STATUS']);
                $DebTExpenseM->setAttach($row['ATTACH']);
                array_push( $debtArr, $DebTExpenseM );
            }
            echo json_encode( $debtArr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);
     }
    }


?>
