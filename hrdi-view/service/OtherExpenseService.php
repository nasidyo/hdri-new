<?php
    require_once '../connection/database.php';
    require_once '../model/OtherExpenseM.php';

    Class OtherExpenseService{
        public function addOtherExpense($OtherExpenseM){
            $sql  =" INSERT INTO EXPENSE_OTHER_TD ( EXPENSE_OTHER_ID, EXPENSE_DETAIL, STATUS, COMMENT , INSTITUTE_ID ,TYPE ) VALUES ( ?, ?, ?, ? ,? ,?)  ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $OtherExpenseM->getExpenseOtherId(),
                $OtherExpenseM->getExpenseDetail(),
                $OtherExpenseM->getStatus(),
                $OtherExpenseM->getComment(),
                $OtherExpenseM->getInstituteId(),
                $OtherExpenseM->getType()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateOtherExpense($OtherExpenseM){
            $sql  =" UPDATE EXPENSE_OTHER_TD SET  EXPENSE_DETAIL = ?, STATUS = ?, COMMENT = ? ,INSTITUTE_ID =?  WHERE EXPENSE_OTHER_ID = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $OtherExpenseM->getExpenseDetail(),
                $OtherExpenseM->getStatus(),
                $OtherExpenseM->getComment(),
                $OtherExpenseM->getInstituteId(),
                $OtherExpenseM->getExpenseOtherId()
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


         public function loadOtherExpense($Id){

            $sql  ="  SELECT EXPENSE_OTHER_ID, EXPENSE_DETAIL, STATUS, COMMENT , INSTITUTE_ID ,TYPE FROM EXPENSE_OTHER_TD where   EXPENSE_OTHER_ID=?    ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $OtherExpenseM = new OtherExpenseM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $OtherExpenseM->setExpenseOtherId($row['EXPENSE_OTHER_ID']);
                $OtherExpenseM->setExpenseDetail($row['EXPENSE_DETAIL']);
                $OtherExpenseM->setStatus($row['STATUS']);
                $OtherExpenseM->setComment($row['COMMENT']);
                $OtherExpenseM->setInstituteId($row['INSTITUTE_ID']);
                $OtherExpenseM->setType($row['TYPE']);
            }
            echo json_encode($OtherExpenseM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function loadOtherExpenseM($Id){

        $sql  ="  SELECT EXPENSE_OTHER_ID, EXPENSE_DETAIL, STATUS, COMMENT , INSTITUTE_ID ,TYPE FROM EXPENSE_OTHER_TD where   EXPENSE_OTHER_ID=?    ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $OtherExpenseM = new OtherExpenseM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $OtherExpenseM->setExpenseOtherId($row['EXPENSE_OTHER_ID']);
            $OtherExpenseM->setExpenseDetail($row['EXPENSE_DETAIL']);
            $OtherExpenseM->setStatus($row['STATUS']);
            $OtherExpenseM->setComment($row['COMMENT']);
            $OtherExpenseM->setInstituteId($row['INSTITUTE_ID']);
            $OtherExpenseM->setType($row['TYPE']);
        }

        sqlsrv_close($conn);
        return $OtherExpenseM;

 }


}


?>
