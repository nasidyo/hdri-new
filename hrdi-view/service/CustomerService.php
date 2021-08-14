<?php
    require_once '../connection/database.php';
    require_once '../model/CustomerM.php';

    Class CustomerService{
        public function addCustomer($CustomerM){
            $sql  =" INSERT";
            $sql  .="  INTO Customer_TD (  c_name, c_sname, c_status , c_address, c_phone, c_comment )
            values (  ?, ? , ?, ?, ? ,? ) ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $CustomerM->getName(),
               $CustomerM->getSname(),
               $CustomerM->getStatus(),
               $CustomerM->getAddress(),
               $CustomerM->getPhone(),
               $CustomerM->getComment()

            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateCustomer($CustomerM){
            $sql  =" UPDATE";
            $sql  .="     Customer_TD ";
            $sql  .=" SET ";
            $sql  .="     c_name  = ?, ";
            $sql  .="     c_sname  = ? , ";
            $sql  .="     c_status  = ? , ";
            $sql  .="     c_address  = ?, ";
            $sql  .="     c_phone  = ?, ";
            $sql  .="     c_comment  = ? ";
            $sql  .=" WHERE";
            $sql  .="    idCustomer = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $CustomerM->getName(),
                $CustomerM->getSname(),
                $CustomerM->getStatus(),
                $CustomerM->getAddress(),
                $CustomerM->getPhone(),
                $CustomerM->getComment(),
                $CustomerM->getCustomerId()
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

         public function loadCustomer($Id){

            $sql  ="  SELECT      ";
            $sql  .="   idCustomer, ";
            $sql  .="   c_name, ";
            $sql  .="   c_sname, ";
            $sql  .="   c_status , ";
            $sql  .="   c_address, ";
            $sql  .="   c_phone, ";
            $sql  .="   c_comment ";
            $sql  .=" FROM ";
            $sql  .="   Customer_TD ";
            $sql  .="  where idCustomer = ?  ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $CustomerM = new CustomerM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $CustomerM->setCustomerId($row['idCustomer']);
                $CustomerM->setName($row['c_name']);
                $CustomerM->setSname($row['c_sname']);
                $CustomerM->setStatus($row['c_status']);
                $CustomerM->setAddress($row['c_address']);
                $CustomerM->setPhone($row['c_phone']);
                $CustomerM->setComment($row['c_comment']);
            }
            echo json_encode($CustomerM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function delCustomer($id){

        $sql  =" DELETE FROM PersonMarket_TD WHERE Customer_idCustomer = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $sql2 =" DELETE tp 
                FROM TargetPlan_TD as tp
                INNER JOIN CustomerMarket_TD as cmk 
                    ON tp.market_id = cmk.idCustomerMarket
                WHERE cmk.idCustomerMarket = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_prepare($conn, $sql2, array($id));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $sql3  =" DELETE FROM CustomerMarket_TD WHERE Customer_idCustomer = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_prepare($conn, $sql3, array($id));
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt3 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $sql4  =" DELETE FROM Customer_TD WHERE idCustomer = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt4 = sqlsrv_prepare($conn, $sql4, array($id));

        if( !$stmt4 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt4 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }


     }



}


?>
