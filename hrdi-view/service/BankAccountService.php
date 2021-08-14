<?php
    require_once '../connection/database.php';
    require_once '../model/BankAccountM.php';

    Class BankAccountService{
        public function addBankAccount($BankAccountM){
            $sql  =" INSERT INTO BankAccount ( bank_account_id, bank_no, bank_name, sub_group_id, status ) VALUES ( ?, ?, ?, ?, ? )            ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $BankAccountM->getBankAccountId(),
                $BankAccountM->getBankNo(),
                $BankAccountM->getBankName(),
                $BankAccountM->getSubGroupId(),
                $BankAccountM->getStatus()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateBankAccount($BankAccountM){
            $sql  =" UPDATE BankAccount SET bank_no = ?, bank_name = ?, sub_group_id = ?, status = ?  WHERE bank_account_id = ?  ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $BankAccountM->getBankNo(),
                $BankAccountM->getBankName(),
                $BankAccountM->getSubGroupId(),
                $BankAccountM->getStatus(),
                $BankAccountM->getBankAccountId()
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

         public function loadBankAccount($Id){

            $sql  ="  SELECT bank_account_id, bank_no, bank_name, sub_group_id, status FROM BankAccount WHERE bank_account_id=? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $BankAccountM = new BankAccountM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $BankAccountM->setBankAccountId($row['bank_account_id']);
                $BankAccountM->setBankNo($row['bank_no']);
                $BankAccountM->setBankName($row['bank_name']);
                $BankAccountM->setStatus($row['status']);
                $BankAccountM->setSubGroupId($row['sub_group_id']);

            }
            echo json_encode($BankAccountM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function loadBankAccountM($Id){

        $sql  ="  SELECT bank_account_id, bank_no, bank_name, sub_group_id, status FROM BankAccount WHERE bank_account_id=? ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $BankAccountM = new BankAccountM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $BankAccountM->setBankAccountId($row['bank_account_id']);
            $BankAccountM->setBankNo($row['bank_no']);
            $BankAccountM->setBankName($row['bank_name']);
            $BankAccountM->setStatus($row['status']);
            $BankAccountM->setSubGroupId($row['sub_group_id']);

        }
        sqlsrv_close($conn);
        return   $BankAccountM;
 }

}


?>
