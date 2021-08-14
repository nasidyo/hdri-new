<?php
    require_once '../connection/database.php';
    require_once '../model/IncomeM.php';

    Class IncomeService{
        public function addIncome($IncomeM){
            $sql  =" INSERT";
            $sql  .="                INTO";
            $sql  .="                    INCOME_TD";
            $sql  .="                            (";
            $sql  .="                                INCOME_ID,ORDER_ID,CREATE_DATE,CREATE_BY,UPDATE_DATE,";
            $sql  .="                                UPDATE_BY,RECEIVE_BY,CUSTOMER, DISCOUNT,AMOUNT,";
            $sql  .="                                PRICE,MARKET_ID,INSTITUTE_ID,DEBT,RECEIVE_DATE,";
            $sql  .="                                DOC_NO,COMMENT,CANCELED,OTHER_CUSTOMER,RECEIVE_AMOUNT,INCOME_OTHER_ID ,SUB_GROUP_ID , BUSINESS_GROUP_ID ";
            $sql  .="                            )";
            $sql  .="                            VALUES";
            $sql  .="                            (";
            $sql  .="                                ?,?,getDate(),?,?,";
            $sql  .="                                ?,?,?,?,?,";
            $sql  .="                                ?,?,?,?,?,";
            $sql  .="                                ?,?,?,?,? ,? ,? ,? ";
            $sql  .="                            ) ";


            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $IncomeM->getIncomeId(),
                $IncomeM->getOrderId(),
                $IncomeM->getCreateBy(),
                $IncomeM->getUpdateDate(),

                $IncomeM->getUpdateBy(),
                $IncomeM->getReceiveBy(),
                $IncomeM->getCustomer(),
                $IncomeM->getDiscount(),
                $IncomeM->getAmount(),

                $IncomeM->getPrice(),
                $IncomeM->getMarketId(),
                $IncomeM->getInstituteId(),
                $IncomeM->getDebt(),
                $IncomeM->getReceiveDate(),

                $IncomeM->getDocNo(),
                $IncomeM->getComment(),
                $IncomeM->getCanceled(),
                $IncomeM->getOtherCustomer(),
                $IncomeM->getReceiveAmount(),
                $IncomeM->getIncomeOtherId(),
                $IncomeM->getSubGroupId(),
                $IncomeM->getBusinessGroupId()

            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateIncome($IncomeM){
            $sql  =" UPDATE";
            $sql  .="  INCOME_TD";
            $sql  .=" SET";
            $sql  .="     UPDATE_DATE = getDate(),";
            $sql  .="     UPDATE_BY = ?,";
            $sql  .="     COMMENT = ?,";
            $sql  .="     CANCELED = ?, ";
            $sql  .="     RECEIVE_AMOUNT = ?, ";
            $sql  .="     DEBT = ? ";
            $sql  .=" WHERE";
            $sql  .="    INCOME_ID = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $IncomeM->getUpdateBy(),
                $IncomeM->getComment(),
                $IncomeM->getCanceled(),
                $IncomeM->getReceiveAmount(),
                $IncomeM->getDebt(),
                $IncomeM->getIncomeId()
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

         public function loadIncome($Id){

            $sql  ="  SELECT      ";
            $sql  .="     INC.INCOME_ID,  ";
            $sql  .="     INC.ORDER_ID,  ";
            $sql  .="     INC.CREATE_DATE,  ";
            $sql  .="     INC.CREATE_BY,  ";
            $sql  .="     INC.UPDATE_DATE,  ";
            $sql  .="     INC.UPDATE_BY,  ";
            $sql  .="     INC.RECEIVE_BY,  ";
            $sql  .="     INC.CUSTOMER,  ";
            $sql  .="     INC.DISCOUNT,  ";
            $sql  .="     INC.AMOUNT,  ";
            $sql  .="     INC.PRICE,  ";
            $sql  .="     INC.MARKET_ID,  ";
            $sql  .="     INC.INSTITUTE_ID,  ";
            $sql  .="     INC.DEBT,  ";
            $sql  .="     INC.RECEIVE_DATE,  ";
            $sql  .="     INC.DOC_NO,  ";
            $sql  .="     INC.COMMENT,  ";
            $sql  .="     INC.CANCELED,  ";
            $sql  .="     INC.OTHER_CUSTOMER,  ";
            $sql  .="     INC.RECEIVE_AMOUNT,  ";
            $sql  .="     O.ORDER_NAME ,  INC.INCOME_OTHER_ID , ";
            $sql  .="       INC.SUB_GROUP_ID ,    ";
            $sql  .="       INC.BUSINESS_GROUP_ID  ,    iot.INCOME_DETAIL   ";
            $sql  .=" FROM  ";
            $sql  .="     INCOME_TD INC  ";
            $sql  .=" LEFT JOIN ";
            $sql  .="    ORDER_TD O ";
            $sql  .="ON ";
            $sql  .="    INC.ORDER_ID = O.ORDER_ID ";
            $sql  .="  LEFT JOIN INCOME_OTHER_TD iot ON inc.INCOME_OTHER_ID = iot.INCOME_OTHER_ID ";
            $sql  .=" WHERE  ";
            $sql  .="       INC.INCOME_ID=?     ";



            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $IncomeM = new IncomeM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $IncomeM->setIncomeId($row['INCOME_ID']);
                $IncomeM->setOrderId($row['ORDER_ID']);
                $IncomeM->setCreateDate($row['CREATE_DATE']);
                $IncomeM->setCreateBy($row['CREATE_BY']);
                $IncomeM->setUpdateDate($row['UPDATE_DATE']);
                $IncomeM->setUpdateBy($row['UPDATE_BY']);
                $IncomeM->setReceiveBy($row['RECEIVE_BY']);
                $IncomeM->setCustomer($row['CUSTOMER']);
                $IncomeM->setDiscount($row['DISCOUNT']);
                $IncomeM->setAmount($row['AMOUNT']);
                $IncomeM->setPrice($row['PRICE']);
                $IncomeM->setDebt($row['DEBT']);
                $IncomeM->setMarketId($row['MARKET_ID']);
                $IncomeM->setInstituteId($row['INSTITUTE_ID']);
                $IncomeM->setReceiveAmount($row['RECEIVE_AMOUNT']);
                $IncomeM->setReceiveDate($row['RECEIVE_DATE']);
                $IncomeM->setDocNo($row['DOC_NO']);
                $IncomeM->setOrderName($row['ORDER_NAME']);
                $IncomeM->setCanceled($row['CANCELED']);
                $IncomeM->setComment($row['COMMENT']);
                $IncomeM->setOtherCustomer($row['OTHER_CUSTOMER']);
                $IncomeM->setIncomeOtherId($row['INCOME_OTHER_ID']);
                $IncomeM->setSubGroupId($row['SUB_GROUP_ID']);
                $IncomeM->setBusinessGroupId($row['BUSINESS_GROUP_ID']);
                $IncomeM->setIncomeDetail($row['INCOME_DETAIL']);

            }

            echo json_encode($IncomeM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function loadIncomeM($Id){

        $sql  ="  SELECT      ";
        $sql  .="     INC.INCOME_ID,  ";
        $sql  .="     INC.ORDER_ID,  ";
        $sql  .="     INC.CREATE_DATE,  ";
        $sql  .="     INC.CREATE_BY,  ";
        $sql  .="     INC.UPDATE_DATE,  ";
        $sql  .="     INC.UPDATE_BY,  ";
        $sql  .="     INC.RECEIVE_BY,  ";
        $sql  .="     INC.CUSTOMER,  ";
        $sql  .="     INC.DISCOUNT,  ";
        $sql  .="     INC.AMOUNT,  ";
        $sql  .="     INC.PRICE,  ";
        $sql  .="     INC.MARKET_ID,  ";
        $sql  .="     INC.INSTITUTE_ID,  ";
        $sql  .="     INC.DEBT,  ";
        $sql  .="     convert(varchar , INC.RECEIVE_DATE ) RECEIVE_DATE,  ";
        $sql  .="     INC.DOC_NO,  ";
        $sql  .="     INC.COMMENT,  ";
        $sql  .="     INC.CANCELED,  ";
        $sql  .="     INC.OTHER_CUSTOMER,  ";
        $sql  .="     INC.RECEIVE_AMOUNT,  ";
        $sql  .="     O.ORDER_NAME ,  INC.INCOME_OTHER_ID , ";
        $sql  .="       INC.SUB_GROUP_ID ,    ";
        $sql  .="       INC.BUSINESS_GROUP_ID     ";
        $sql  .=" FROM  ";
        $sql  .="     INCOME_TD INC   ";
        $sql  .=" LEFT JOIN ";
        $sql  .="    ORDER_TD O ";
        $sql  .="ON ";
        $sql  .="    INC.ORDER_ID = O.ORDER_ID ";
        $sql  .=" WHERE  ";
        $sql  .="       INC.INCOME_ID=?     ";



        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $IncomeM = new IncomeM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $IncomeM->setIncomeId($row['INCOME_ID']);
            $IncomeM->setOrderId($row['ORDER_ID']);
            $IncomeM->setCreateDate($row['CREATE_DATE']);
            $IncomeM->setCreateBy($row['CREATE_BY']);
            $IncomeM->setUpdateDate($row['UPDATE_DATE']);
            $IncomeM->setUpdateBy($row['UPDATE_BY']);
            $IncomeM->setReceiveBy($row['RECEIVE_BY']);
            $IncomeM->setCustomer($row['CUSTOMER']);
            $IncomeM->setDiscount($row['DISCOUNT']);
            $IncomeM->setAmount($row['AMOUNT']);
            $IncomeM->setPrice($row['PRICE']);
            $IncomeM->setDebt($row['DEBT']);
            $IncomeM->setMarketId($row['MARKET_ID']);
            $IncomeM->setInstituteId($row['INSTITUTE_ID']);
            $IncomeM->setReceiveAmount($row['RECEIVE_AMOUNT']);
            $IncomeM->setReceiveDate($row['RECEIVE_DATE']);
            $IncomeM->setDocNo($row['DOC_NO']);
            $IncomeM->setOrderName($row['ORDER_NAME']);
            $IncomeM->setCanceled($row['CANCELED']);
            $IncomeM->setComment($row['COMMENT']);
            $IncomeM->setOtherCustomer($row['OTHER_CUSTOMER']);
            $IncomeM->setIncomeOtherId($row['INCOME_OTHER_ID']);
            $IncomeM->setSubGroupId($row['SUB_GROUP_ID']);
            $IncomeM->setBusinessGroupId($row['BUSINESS_GROUP_ID']);

        }
        sqlsrv_close($conn);
        return $IncomeM;


 }


      public function updateDebtIncome($id,$debt ,$update_by){
        $sql  ="  SELECT      ";
        $sql  .="       INC.INCOME_ID,     ";
        $sql  .="       INC.DEBT,     ";
        $sql  .="       INC.RECEIVE_AMOUNT     ";
        $sql  .="   FROM     ";
        $sql  .="       INCOME_TD INC     ";
        $sql  .="       where INC.INCOME_ID =?     ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $IncomeM = new IncomeM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

            $IncomeM->setIncomeId($row['INCOME_ID']);
            $IncomeM->setDebt($row['DEBT']);
            $IncomeM->setReceiveAmount($row['RECEIVE_AMOUNT']);
        }
        $oldDebt = $IncomeM->getDebt();
        $oldIncomeAmount = $IncomeM->getReceiveAmount();
      if($oldDebt >0){
                $newDebt =  $oldDebt-$debt;
                $newIncomeAmount = $oldIncomeAmount + $debt;
                $sql2  =" UPDATE";
                $sql2  .="  INCOME_TD";
                $sql2  .=" SET";
                $sql2  .="     UPDATE_DATE = getDate(),";
                $sql2  .="     UPDATE_BY = ? ,";
                $sql2  .="     RECEIVE_AMOUNT = ?,";
                $sql2  .="     DEBT = ? ";
                $sql2  .=" WHERE";
                $sql2  .="    INCOME_ID = ? ";

                $db = new Database();
                $conn=  $db->getConnection();
                $params =array(
                    $update_by,
                    $newIncomeAmount,
                    $newDebt,
                    $id
                );

                $stmt = sqlsrv_prepare( $conn, $sql2, $params);
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                sqlsrv_close($conn);
      }
     }


     function cancelDebtIncome($id,$debtId,$debtAmount,$user){

        $sql  ="  SELECT      ";
        $sql  .="       INC.INCOME_ID,     ";
        $sql  .="       INC.DEBT,     ";
        $sql  .="       INC.RECEIVE_AMOUNT     ";
        $sql  .="   FROM     ";
        $sql  .="       INCOME_TD INC     ";
        $sql  .="       where INC.INCOME_ID =?     ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $IncomeM = new IncomeM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

            $IncomeM->setIncomeId($row['INCOME_ID']);
            $IncomeM->setDebt($row['DEBT']);
            $IncomeM->setReceiveAmount($row['RECEIVE_AMOUNT']);
        }
        $oldDebt = (float)$IncomeM->getDebt();
        $oldIncomeAmount = $IncomeM->getReceiveAmount();
      if($oldDebt >=0){
                $newDebt =  round ((float)$oldDebt+(float)$debtAmount,2,PHP_ROUND_HALF_UP);
                $newIncomeAmount =round (  (float)$oldIncomeAmount - (float)$debtAmount,2,PHP_ROUND_HALF_UP);
                $sql2  =" UPDATE";
                $sql2  .="  INCOME_TD";
                $sql2  .=" SET";
                $sql2  .="     UPDATE_DATE = getDate(),";
                $sql2  .="     UPDATE_BY = ? ,";
                $sql2  .="     RECEIVE_AMOUNT = ?,";
                $sql2  .="     DEBT = ? ";
                $sql2  .=" WHERE";
                $sql2  .="    INCOME_ID = ? ";

                $db = new Database();
                $conn=  $db->getConnection();
                $params =array(
                    $user,
                    $newIncomeAmount,
                    $newDebt,
                    $id
                );

                $stmt = sqlsrv_prepare( $conn, $sql2, $params);
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }


                $sql  =" DELETE FROM DEBT_INCOME  WHERE DEBT_ID = ? ";

                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array($debtId));

                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                sqlsrv_close($conn);
            }
     }






}


?>
