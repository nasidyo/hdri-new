<?php
    require_once '../connection/database.php';
    require_once '../model/OrderM.php';

    Class OrderService{
        public function addOrder($orderM){
            $sql  =" INSERT";
            $sql  .="             INTO";
            $sql  .="                ORDER_TD";
            $sql  .="                (";
            $sql  .="                    ORDER_ID, ORDER_NAME, STATUS, COMMENT, UNIT_ID,";
            $sql  .="                    BALANCE, INSTITUTE_ID ,SUB_GROUP_ID ";
            $sql  .="                )";
            $sql  .="                VALUES";
            $sql  .="                (";
            $sql  .="                    ?, ?, ?, ?, ?, ";
            $sql  .="                    ?,  ? ,? ";
            $sql  .="                ) ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $orderM->getOrderId(),
               $orderM->getOrderName(),
               $orderM->getStatus(),
               $orderM->getComment(),
               $orderM->getUnitId(),
               $orderM->getBalance(),
               $orderM->getInstituteId(),
               $orderM->getSubGroupId()

            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateOrder($orderM){
            $sql  =" UPDATE";
            $sql  .="     ORDER_TD";
            $sql  .=" SET ";
            $sql  .="    ORDER_NAME = ?,";
            $sql  .="    STATUS = ?,";
            $sql  .="    COMMENT = ?,";
            $sql  .="    UNIT_ID = ?,";
            $sql  .="    BALANCE = ?,";
            $sql  .="    INSTITUTE_ID = ? ";
            $sql  .="WHERE";
            $sql  .="    ORDER_ID = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $orderM->getOrderName(),
                $orderM->getStatus(),
                $orderM->getComment(),
                $orderM->getUnitId(),
                $orderM->getBalance(),
                $orderM->getInstituteId(),
                $orderM->getOrderId()
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

         public function loadOrder($Id){

            $sql  ="  SELECT      ";
            $sql  .="    ort.ORDER_ID,      ";
            $sql  .="    ort.ORDER_NAME,      ";
            $sql  .="    ort.STATUS,      ";
            $sql  .="    ort.COMMENT,      ";
            $sql  .="    ort.UNIT_ID,      ";
            $sql  .="    ort.BALANCE,      ";
            $sql  .="    ort.INSTITUTE_ID ,      ";
            $sql  .="    ins.AREA_ID  ,  ort.SUB_GROUP_ID  ";

            $sql  .="FROM      ";
            $sql  .="    ORDER_TD ort ,      ";
            $sql  .="    INSTITUTE ins      ";
            $sql  .="WHERE      ";
            $sql  .="    ort.INSTITUTE_ID = ins.INSTITUTE_ID  AND  ort.ORDER_ID =?   ";




            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $orderM = new OrderM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $orderM->setOrderId($row['ORDER_ID']);
                $orderM->setOrderName($row['ORDER_NAME']);
                $orderM->setStatus($row['STATUS']);
                $orderM->setComment($row['COMMENT']);
                $orderM->setUnitId($row['UNIT_ID']);
                $orderM->setBalance($row['BALANCE']);
                $orderM->setInstituteId($row['INSTITUTE_ID']);
                $orderM->setAreaId($row['AREA_ID']);
                $orderM->setSubGroupId($row['SUB_GROUP_ID']);

            }
            echo json_encode($orderM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function loadOrderM($Id){

        $sql  ="  SELECT      ";
        $sql  .="    ort.ORDER_ID,      ";
        $sql  .="    ort.ORDER_NAME,      ";
        $sql  .="    ort.STATUS,      ";
        $sql  .="    ort.COMMENT,      ";
        $sql  .="    ort.UNIT_ID,      ";
        $sql  .="    ort.BALANCE,      ";
        $sql  .="    ort.INSTITUTE_ID ,      ";
        $sql  .="    ins.AREA_ID  ,ort.SUB_GROUP_ID      ";
        $sql  .="FROM      ";
        $sql  .="    ORDER_TD ort ,      ";
        $sql  .="    INSTITUTE ins      ";
        $sql  .="WHERE      ";
        $sql  .="    ort.INSTITUTE_ID = ins.INSTITUTE_ID  AND  ort.ORDER_ID =?   ";




        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $orderM = new OrderM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $orderM->setOrderId($row['ORDER_ID']);
            $orderM->setOrderName($row['ORDER_NAME']);
            $orderM->setStatus($row['STATUS']);
            $orderM->setComment($row['COMMENT']);
            $orderM->setUnitId($row['UNIT_ID']);
            $orderM->setBalance($row['BALANCE']);
            $orderM->setInstituteId($row['INSTITUTE_ID']);
            $orderM->setAreaId($row['AREA_ID']);
            $orderM->setSubGroupId($row['SUB_GROUP_ID']);

        }
        sqlsrv_close($conn);
        return $orderM;



 }
     public function updateBalance($id , $new_num ,$mode){
        $OrderM = self::loadOrderM($id);
        $oldNum = 0;
        $tmpNum=0;
        if($OrderM->getBalance()!=null && $OrderM->getBalance()>0){
            $oldNum = intval($OrderM->getBalance());
        }
        if($mode=='plus'){
            $tmpNum=$new_num+$oldNum;
        }else if($mode=='minus' &&  $oldNum >= $new_num ){
            $tmpNum=$oldNum-$new_num;
        }else{
            $tmpNum = $oldNum;
        }
        $sql  =" UPDATE";
        $sql  .="     ORDER_TD";
        $sql  .=" SET ";
        $sql  .="    BALANCE = ? ";
        $sql  .=" WHERE ";
        $sql  .="    ORDER_ID = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $params =array(
            $tmpNum,
            $OrderM->getOrderId()
        );
        $stmt = sqlsrv_prepare( $conn, $sql, $params);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close($conn);


     }




}


?>
