<?php
    require_once '../connection/database.php';
    require_once '../model/OtherIncomeM.php';

    Class OtherIncomeService{
        public function addOtherIncome($OtherIncomeM){
            $sql  =" INSERT INTO INCOME_OTHER_TD ( INCOME_OTHER_ID, INCOME_DETAIL, STATUS, COMMENT , INSTITUTE_ID ,TYPE) VALUES ( ?, ?, ?, ? ,? ,?)  ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $OtherIncomeM->getIncomeOtherId(),
                $OtherIncomeM->getIncomeDetail(),
                $OtherIncomeM->getStatus(),
                $OtherIncomeM->getComment(),
                $OtherIncomeM->getInstituteId(),
                $OtherIncomeM->getType()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateOtherIncome($OtherIncomeM){
            $sql  =" UPDATE INCOME_OTHER_TD SET  INCOME_DETAIL = ?, STATUS = ?, COMMENT = ? ,INSTITUTE_ID =?  WHERE INCOME_OTHER_ID = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $OtherIncomeM->getIncomeDetail(),
                $OtherIncomeM->getStatus(),
                $OtherIncomeM->getComment(),
                $OtherIncomeM->getInstituteId(),
                $OtherIncomeM->getIncomeOtherId()
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


         public function loadOtherIncome($Id){

            $sql  ="  SELECT INCOME_OTHER_ID, INCOME_DETAIL, STATUS, COMMENT , INSTITUTE_ID FROM INCOME_OTHER_TD where   INCOME_OTHER_ID=?    ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $OtherIncomeM = new OtherIncomeM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $OtherIncomeM->setIncomeOtherId($row['INCOME_OTHER_ID']);
                $OtherIncomeM->setIncomeDetail($row['INCOME_DETAIL']);
                $OtherIncomeM->setStatus($row['STATUS']);
                $OtherIncomeM->setComment($row['COMMENT']);
                $OtherIncomeM->setInstituteId($row['INSTITUTE_ID']);
            }
            echo json_encode($OtherIncomeM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function loadOtherIncomeM($Id){

        $sql  ="  SELECT INCOME_OTHER_ID, INCOME_DETAIL, STATUS, COMMENT , INSTITUTE_ID ,TYPE FROM INCOME_OTHER_TD where   INCOME_OTHER_ID=?    ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $OtherIncomeM = new OtherIncomeM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $OtherIncomeM->setIncomeOtherId($row['INCOME_OTHER_ID']);
            $OtherIncomeM->setIncomeDetail($row['INCOME_DETAIL']);
            $OtherIncomeM->setStatus($row['STATUS']);
            $OtherIncomeM->setComment($row['COMMENT']);
            $OtherIncomeM->setInstituteId($row['INSTITUTE_ID']);
            $OtherIncomeM->setType($row['TYPE']);
        }

        sqlsrv_close($conn);
        return  $OtherIncomeM;

 }


}


?>
