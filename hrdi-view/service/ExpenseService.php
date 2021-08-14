<?php
    require_once '../connection/database.php';
    require_once '../model/ExpenseM.php';

    Class ExpenseService{
        public function addExpense($ExpenseM){
            $sql  =" INSERT INTO EXPENSE_TD (  ";
            $sql  .="    EXPENSE_ID, ORDER_ID, CREATE_DATE, CREATE_BY, UPDATE_DATE,  ";
            $sql  .="    UPDATE_BY, EXPENSE_BY, CUSTOMER, DISCOUNT, AMOUNT,  ";
            $sql  .="    PRICE, EXPENSE_OTHER_ID, DEBT, MARKET_ID, INSTITUTE_ID , EXPENSE_AMOUNT ,EXPENSE_DATE , OTHER_CUSTOMER , DOC_NO ,CANCELED ,SUB_GROUP_ID , BUSINESS_GROUP_ID ) ";
            $sql  .="  VALUES ( ?, ?, GETDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? )  ";


            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $ExpenseM->getExpenseId(),
                $ExpenseM->getOrderId(),
                $ExpenseM->getCreateBy(),
                $ExpenseM->getUpdateDate(),
                $ExpenseM->getUpdateBy(),
                $ExpenseM->getExpenseBy(),
                $ExpenseM->getCustomer(),
                $ExpenseM->getDiscount(),
                $ExpenseM->getAmount(),
                $ExpenseM->getPrice(),
                $ExpenseM->getExpenseOtherId(),
                $ExpenseM->getDebt(),
                $ExpenseM->getMarketId(),
                $ExpenseM->getInstituteId(),
                $ExpenseM->getExpenseAmount(),
                $ExpenseM->getExpenseDate(),
                $ExpenseM->getOtherCustomer(),
                $ExpenseM->getDocNo(),
                $ExpenseM->getCanceled(),
                $ExpenseM->getSubGroupId(),
                $ExpenseM->getBusinessGroupId()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateExpense($ExpenseM){
            $sql  =" UPDATE";
            $sql  .="  EXPENSE_TD";
            $sql  .=" SET";
            $sql  .="     UPDATE_DATE = getDate(),";
            $sql  .="     UPDATE_BY = ?,";
            $sql  .="     COMMENT = ?,";
            $sql  .="     CANCELED = ? , ";
            $sql  .="     EXPENSE_AMOUNT = ?,";
            $sql  .="     DEBT = ? ";
            $sql  .=" WHERE";
            $sql  .="    EXPENSE_ID = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $ExpenseM->getUpdateBy(),
                $ExpenseM->getComment(),
                $ExpenseM->getCanceled(),
                $ExpenseM->getExpenseAmount(),
                $ExpenseM->getDebt(),
                $ExpenseM->getExpenseId()
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


         public function loadExpense($Id){

            $sql  ="  SELECT      ";
            $sql  .="       EX.EXPENSE_ID,     ";
            $sql  .="       EX.ORDER_ID,     ";
            $sql  .="       EX.CREATE_DATE,     ";
            $sql  .="       EX.CREATE_BY,     ";
            $sql  .="       EX.UPDATE_DATE,     ";
            $sql  .="       EX.UPDATE_BY,     ";
            $sql  .="       EX.EXPENSE_BY,     ";
            $sql  .="       EX.CUSTOMER,     ";
            $sql  .="       EX.DISCOUNT,     ";
            $sql  .="       EX.AMOUNT,     ";
            $sql  .="       EX.PRICE,     ";
            $sql  .="       EX.EXPENSE_OTHER_ID,     ";
            $sql  .="       EX.DEBT,     ";
            $sql  .="       EX.MARKET_ID,     ";
            $sql  .="       EX.INSTITUTE_ID,     ";
            $sql  .="       EX.EXPENSE_AMOUNT,     ";
            $sql  .="       EX.EXPENSE_DATE,     ";
            $sql  .="       EX.OTHER_CUSTOMER,     ";
            $sql  .="       EX.DOC_NO ,     ";
            $sql  .="       O.ORDER_NAME,     ";
            $sql  .="       EO.EXPENSE_DETAIL  ,   ";
            $sql  .="       EX.CANCELED ,     ";
            $sql  .="       EX.COMMENT ,   ";
            $sql  .="       EX.SUB_GROUP_ID ,    ";
            $sql  .="       EX.BUSINESS_GROUP_ID     ";
            $sql  .="   FROM     ";
            $sql  .="       EXPENSE_TD EX     ";
            $sql  .="   LEFT JOIN     ";
            $sql  .="       ORDER_TD O     ";
            $sql  .="   ON     ";
            $sql  .="       EX.ORDER_ID = O.ORDER_ID     ";
            $sql  .="   LEFT JOIN     ";
            $sql  .="       EXPENSE_OTHER_TD EO     ";
            $sql  .="   ON     ";
            $sql  .="       EX.EXPENSE_OTHER_ID =EO.EXPENSE_OTHER_ID     ";
            $sql  .="       where EX.EXPENSE_ID =?     ";



            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $ExpenseM = new ExpenseM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $ExpenseM->setExpenseId($row['EXPENSE_ID']);
                $ExpenseM->setOrderId($row['ORDER_ID']);
                $ExpenseM->setCreateDate($row['CREATE_DATE']);
                $ExpenseM->setCreateBy($row['CREATE_BY']);
                $ExpenseM->setUpdateDate($row['UPDATE_DATE']);
                $ExpenseM->setUpdateBy($row['UPDATE_BY']);
                $ExpenseM->setExpenseBy($row['EXPENSE_BY']);
                $ExpenseM->setCustomer($row['CUSTOMER']);
                $ExpenseM->setDiscount($row['DISCOUNT']);
                $ExpenseM->setAmount($row['AMOUNT']);
                $ExpenseM->setPrice($row['PRICE']);
                $ExpenseM->setExpenseOtherId($row['EXPENSE_OTHER_ID']);
                $ExpenseM->setDebt($row['DEBT']);
                $ExpenseM->setMarketId($row['MARKET_ID']);
                $ExpenseM->setInstituteId($row['INSTITUTE_ID']);
                $ExpenseM->setExpenseAmount($row['EXPENSE_AMOUNT']);
                $ExpenseM->setExpenseDate($row['EXPENSE_DATE']);
                $ExpenseM->setOtherCustomer($row['OTHER_CUSTOMER']);
                $ExpenseM->setDocNo($row['DOC_NO']);
                $ExpenseM->setOrderName($row['ORDER_NAME']);
                $ExpenseM->setExpenseDetail($row['EXPENSE_DETAIL']);
                $ExpenseM->setCanceled($row['CANCELED']);
                $ExpenseM->setComment($row['COMMENT']);
                $ExpenseM->setSubGroupId($row['SUB_GROUP_ID']);
                $ExpenseM->setBusinessGroupId($row['BUSINESS_GROUP_ID']);

            }
            echo json_encode($ExpenseM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function loadExpenseM($Id){

        $sql  ="  SELECT      ";
        $sql  .="       EX.EXPENSE_ID,     ";
        $sql  .="       EX.ORDER_ID,     ";
        $sql  .="       EX.CREATE_DATE,     ";
        $sql  .="       EX.CREATE_BY,     ";
        $sql  .="       EX.UPDATE_DATE,     ";
        $sql  .="       EX.UPDATE_BY,     ";
        $sql  .="       EX.EXPENSE_BY,     ";
        $sql  .="       EX.CUSTOMER,     ";
        $sql  .="       EX.DISCOUNT,     ";
        $sql  .="       EX.AMOUNT,     ";
        $sql  .="       EX.PRICE,     ";
        $sql  .="       EX.EXPENSE_OTHER_ID,     ";
        $sql  .="       EX.DEBT,     ";
        $sql  .="       EX.MARKET_ID,     ";
        $sql  .="       EX.INSTITUTE_ID,     ";
        $sql  .="       EX.EXPENSE_AMOUNT,     ";
        $sql  .="       convert(varchar , EX.EXPENSE_DATE ) EXPENSE_DATE,      ";
        $sql  .="       EX.OTHER_CUSTOMER,     ";
        $sql  .="       EX.DOC_NO ,     ";
        $sql  .="       O.ORDER_NAME,     ";
        $sql  .="       EO.EXPENSE_DETAIL  ,   ";
        $sql  .="       EX.CANCELED ,     ";
        $sql  .="       EX.COMMENT ,   ";
        $sql  .="       EX.SUB_GROUP_ID ,    ";
        $sql  .="       EX.BUSINESS_GROUP_ID     ";
        $sql  .="   FROM     ";
        $sql  .="       EXPENSE_TD EX     ";
        $sql  .="   LEFT JOIN     ";
        $sql  .="       ORDER_TD O     ";
        $sql  .="   ON     ";
        $sql  .="       EX.ORDER_ID = O.ORDER_ID     ";
        $sql  .="   LEFT JOIN     ";
        $sql  .="       EXPENSE_OTHER_TD EO     ";
        $sql  .="   ON     ";
        $sql  .="       EX.EXPENSE_OTHER_ID =EO.EXPENSE_OTHER_ID     ";
        $sql  .="       where EX.EXPENSE_ID =?     ";



        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $ExpenseM = new ExpenseM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $ExpenseM->setExpenseId($row['EXPENSE_ID']);
            $ExpenseM->setOrderId($row['ORDER_ID']);
            $ExpenseM->setCreateDate($row['CREATE_DATE']);
            $ExpenseM->setCreateBy($row['CREATE_BY']);
            $ExpenseM->setUpdateDate($row['UPDATE_DATE']);
            $ExpenseM->setUpdateBy($row['UPDATE_BY']);
            $ExpenseM->setExpenseBy($row['EXPENSE_BY']);
            $ExpenseM->setCustomer($row['CUSTOMER']);
            $ExpenseM->setDiscount($row['DISCOUNT']);
            $ExpenseM->setAmount($row['AMOUNT']);
            $ExpenseM->setPrice($row['PRICE']);
            $ExpenseM->setExpenseOtherId($row['EXPENSE_OTHER_ID']);
            $ExpenseM->setDebt($row['DEBT']);
            $ExpenseM->setMarketId($row['MARKET_ID']);
            $ExpenseM->setInstituteId($row['INSTITUTE_ID']);
            $ExpenseM->setExpenseAmount($row['EXPENSE_AMOUNT']);
            $ExpenseM->setExpenseDate($row['EXPENSE_DATE']);
            $ExpenseM->setOtherCustomer($row['OTHER_CUSTOMER']);
            $ExpenseM->setDocNo($row['DOC_NO']);
            $ExpenseM->setOrderName($row['ORDER_NAME']);
            $ExpenseM->setExpenseDetail($row['EXPENSE_DETAIL']);
            $ExpenseM->setCanceled($row['CANCELED']);
            $ExpenseM->setComment($row['COMMENT']);
            $ExpenseM->setSubGroupId($row['SUB_GROUP_ID']);
            $ExpenseM->setBusinessGroupId($row['BUSINESS_GROUP_ID']);


        }
        sqlsrv_close($conn);
        return  $ExpenseM;


 }


     public function delExpense($id){

        $sql  =" DELETE FROM EXPENSE_TD WHERE EXPENSE_ID = ? ";
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


    public function updateDebtExpense($id,$debt ,$update_by){
        $sql  ="  SELECT      ";
        $sql  .="       EX.EXPENSE_ID,     ";
        $sql  .="       EX.DEBT,     ";
        $sql  .="       EX.EXPENSE_AMOUNT     ";
        $sql  .="   FROM     ";
        $sql  .="       EXPENSE_TD EX     ";
        $sql  .="       where EX.EXPENSE_ID =?     ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $ExpenseM = new ExpenseM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

            $ExpenseM->setExpenseId($row['EXPENSE_ID']);
            $ExpenseM->setDebt($row['DEBT']);
            $ExpenseM->setExpenseAmount($row['EXPENSE_AMOUNT']);
        }
        $oldDebt = $ExpenseM->getDebt();
        $oldExpenseAmount = $ExpenseM->getExpenseAmount();
      if($oldDebt >=0){
                $newDebt =  $oldDebt-$debt;
                $newExpenseAmount = $oldExpenseAmount + $debt;
                $sql2  =" UPDATE";
                $sql2  .="  EXPENSE_TD";
                $sql2  .=" SET";
                $sql2  .="     UPDATE_DATE = getDate(),";
                $sql2  .="     UPDATE_BY = ? ,";
                $sql2  .="     EXPENSE_AMOUNT = ?,";
                $sql2  .="     DEBT = ? ";
                $sql2  .=" WHERE";
                $sql2  .="    EXPENSE_ID = ? ";

                $db = new Database();
                $conn=  $db->getConnection();
                $params =array(
                    $update_by,
                    $newExpenseAmount,
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


     function cancelDebtExpense($id,$debtId,$debtAmount,$user){

        $sql  ="  SELECT      ";
        $sql  .="       INC.EXPENSE_ID,     ";
        $sql  .="       INC.DEBT,     ";
        $sql  .="       INC.EXPENSE_AMOUNT     ";
        $sql  .="   FROM     ";
        $sql  .="       EXPENSE_TD INC     ";
        $sql  .="       where INC.EXPENSE_ID =?     ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $ExpenseM = new ExpenseM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

            $ExpenseM->setExpenseId($row['EXPENSE_ID']);
            $ExpenseM->setDebt($row['DEBT']);
            $ExpenseM->setExpenseAmount($row['EXPENSE_AMOUNT']);
        }
        $oldDebt = (float)$ExpenseM->getDebt();
        $oldExpenseAmount = $ExpenseM->getExpenseAmount();
      if($oldDebt >=0){
                $newDebt =  round ((float)$oldDebt+(float)$debtAmount,2,PHP_ROUND_HALF_UP);
                $newExpenseAmount =round (  (float)$oldExpenseAmount - (float)$debtAmount,2,PHP_ROUND_HALF_UP);
                $sql2  =" UPDATE";
                $sql2  .="  EXPENSE_TD";
                $sql2  .=" SET";
                $sql2  .="     UPDATE_DATE = getDate(),";
                $sql2  .="     UPDATE_BY = ? ,";
                $sql2  .="     EXPENSE_AMOUNT = ?,";
                $sql2  .="     DEBT = ? ";
                $sql2  .=" WHERE";
                $sql2  .="    EXPENSE_ID = ? ";

                $db = new Database();
                $conn=  $db->getConnection();
                $params =array(
                    $user,
                    $newExpenseAmount,
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


                $sql  =" DELETE FROM DEBT_EXPENSE  WHERE DEBT_ID = ? ";

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
