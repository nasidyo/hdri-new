<?php
    require_once '../connection/database.php';
    require_once '../model/BusinessGroupM.php';

    Class BusinessGroupService{
        public function addBusinessGroup($BusinessGroupM){
            $sql  =" INSERT ";
            $sql  .="  INTO ";
            $sql   .="      BusinessGroup ";
            $sql   .="      ( ";
            $sql   .="         business_group_id, ";
            $sql   .="         business_group_name, ";
            $sql   .="         sub_group_id, ";
            $sql   .="         status ";
            $sql   .="      ) ";
            $sql   .="      VALUES ";
            $sql   .="      ( ";
            $sql   .="          ?,?,?,? ";
            $sql   .="      ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $BusinessGroupM->getBusinessGroupId(),
                $BusinessGroupM->getBusinessGroupName(),
                $BusinessGroupM->getSubGroupId(),
                $BusinessGroupM->getStatus()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateBusinessGroup($BusinessGroupM){
            $sql  =" UPDATE ";
            $sql  .=" BusinessGroup ";
            $sql  .=" SET ";
            $sql   .="      business_group_name=? , ";
            $sql   .="      status =? ";
            $sql  .=" WHERE ";
            $sql   .="      business_group_id =?  ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $BusinessGroupM->getBusinessGroupName(),
                $BusinessGroupM->getStatus(),
                $BusinessGroupM->getBusinessGroupId()
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

         public function loadBusinessGroup($Id){

            $sql  ="  SELECT      ";
            $sql   .="         business_group_id, ";
            $sql   .="         business_group_name, ";
            $sql   .="         sub_group_id, ";
            $sql   .="         status ";
            $sql  .=" FROM ";
            $sql  .="   BusinessGroup      ";
            $sql  .=" where business_group_id  =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $BusinessGroupM = new BusinessGroupM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $BusinessGroupM->setBusinessGroupId($row['business_group_id']);
                $BusinessGroupM->setBusinessGroupName($row['business_group_name']);
                $BusinessGroupM->setSubGroupId($row['sub_group_id']);
                $BusinessGroupM->setStatus($row['status']);
            }
            echo json_encode($BusinessGroupM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

        }

}


?>
