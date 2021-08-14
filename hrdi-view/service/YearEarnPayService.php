<?php
    require_once '../connection/database.php';
    require_once '../model/YearEarnPayM.php';

    Class YearEarnPayService{
        public function addYearEarnPay($YearEarnPayM){
            $sql  =" INSERT";
            $sql  .="  INTO YearEarnPay_TD ( yearGetPay, idPerson, earnPerYear, payPerYear )  ";
            $sql  .="   VALUES ( ?, ?, ?, ? )   ";


            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $YearEarnPayM->getYearGetPay(),
               $YearEarnPayM->getIdPerson(),
               $YearEarnPayM->getEarnPerYear(),
               $YearEarnPayM->getPayPerYear()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateYearEarnPay($YearEarnPayM){
            $sql  =" UPDATE ";
            $sql  .=" YearEarnPay_TD ";
            $sql  .=" SET ";
            $sql  .="     yearGetPay = ?, ";
            $sql  .="     idPerson = ?, ";
            $sql  .="     earnPerYear = ?, ";
            $sql  .="     payPerYear = ? ";
            $sql  .=" WHERE ";
            $sql  .="     idYearEarnPay = ?";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $YearEarnPayM->getYearGetPay(),
                $YearEarnPayM->getIdPerson(),
                $YearEarnPayM->getEarnPerYear(),
                $YearEarnPayM->getPayPerYear(),
                $YearEarnPayM->getIdYearEarnPay()

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

         public function loadYearEarnPay($Id){

            $sql  ="  SELECT      ";
            $sql  .=" yearGetPay,   ";
            $sql  .=" idPerson,   ";
            $sql  .=" earnPerYear,   ";
            $sql  .=" payPerYear,   ";
            $sql  .=" idYearEarnPay   ";
            $sql  .=" FROM   ";
            $sql  .="  YearEarnPay_TD    ";
            $sql  .="  where  idYearEarnPay =?   ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $YearEarnPayM = new YearEarnPayM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $YearEarnPayM->seYearGetPay($row['yearGetPay']);
                $YearEarnPayM->setIdPerson($row['idPerson']);
                $YearEarnPayM->setEarnPerYear($row['earnPerYear']);
                $YearEarnPayM->setPayPerYear($row['payPerYear']);
                $YearEarnPayM->setIdYearEarnPay($row['idYearEarnPay']);
            }
            echo json_encode($YearEarnPayM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function loadYearEarnPayByPerson($Id){

        $sql  ="  SELECT      ";
        $sql  .=" yearGetPay,   ";
        $sql  .=" idPerson,   ";
        $sql  .=" dbo.toMoney(cast( earnPerYear as DECIMAL(10,2)))  earnPerYear ,   ";
        $sql  .=" dbo.toMoney(cast( payPerYear as DECIMAL(10,2)))  payPerYear ,   ";
        $sql  .=" idYearEarnPay   ";
        $sql  .=" FROM   ";
        $sql  .="  YearEarnPay_TD    ";
        $sql  .="  where  idPerson =?  order by  yearGetPay ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $payArr =  array();

        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $YearEarnPayM = new YearEarnPayM();
            $YearEarnPayM->setYearGetPay($row['yearGetPay']);
            $YearEarnPayM->setIdPerson($row['idPerson']);
            $YearEarnPayM->setEarnPerYear($row['earnPerYear']);
            $YearEarnPayM->setPayPerYear($row['payPerYear']);
            $YearEarnPayM->setIdYearEarnPay($row['idYearEarnPay']);
            array_push($payArr, $YearEarnPayM);
        }
        return  $payArr;
        sqlsrv_close($conn);

 }

     public function delYearEarnPay($id){

        $sql  =" DELETE FROM YearEarnPay_TD WHERE idYearEarnPay = ? ";

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
