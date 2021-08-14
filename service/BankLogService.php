<?php
    require_once '../connection/database.php';
    require_once '../model/BankLogM.php';

    Class BankLogService{
        public function addBankLog($BankLogM){
            $sql  =" INSERT INTO BankLog ( bank_log_id, bank_account_id, deposit, withdraw, create_date, create_by ) VALUES ( ?, ?, ?, ?, ?, ? )";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $BankLogM->getBankLogId(),
                $BankLogM->getBankAccountId(),
                $BankLogM->getDeposit(),
                $BankLogM->getWithdraw(),
                $BankLogM->getCreateDate(),
                $BankLogM->getCreateBy()
            ));

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
