<?php
    require_once '../connection/database.php';
    require_once '../model/SubPersonGroupM.php';

    Class SubPersonGroupService{
        public function addSubPersonGroup($SubPersonGroupM){
            $sql  =" INSERT ";
            $sql  .="  INTO ";
            $sql   .="      SubPersonGroup ";
            $sql   .="      ( ";
            $sql   .="         sub_group_id, ";
            $sql   .="          sub_group_name, ";
            $sql   .="          institute_id, ";
            $sql   .="          status ";
            $sql   .="      ) ";
            $sql   .="      VALUES ";
            $sql   .="      ( ";
            $sql   .="          ?,?,?,? ";
            $sql   .="      ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $SubPersonGroupM->getSubGroupId(),
               $SubPersonGroupM->getSubGroupName(),
               $SubPersonGroupM->getInstituteId(),
               $SubPersonGroupM->getStatus()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateSubPersonGroup($SubPersonGroupM){
            $sql  =" UPDATE ";
            $sql  .=" SubPersonGroup ";
            $sql  .=" SET ";
            $sql  .="     sub_group_name = ?, ";
            $sql  .="     status = ? ";
            $sql  .=" WHERE ";
            $sql  .="     sub_group_id =?  ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
               $SubPersonGroupM->getSubGroupName(),
               $SubPersonGroupM->getStatus(),
               $SubPersonGroupM->getSubGroupId()
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

         public function loadSubPersonGroup($Id){

            $sql  ="  SELECT      ";
            $sql  .="       sub_group_id, ";
            $sql  .="       sub_group_name, ";
            $sql  .="       institute_id, ";
            $sql  .="       status  ";
            $sql  .=" FROM ";
            $sql  .="   SubPersonGroup      ";
            $sql  .=" where sub_group_id  =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $SubPersonGroupM = new SubPersonGroupM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $SubPersonGroupM->setSubGroupId($row['sub_group_id']);
                $SubPersonGroupM->setSubGroupName($row['sub_group_name']);
                $SubPersonGroupM->setInstituteId($row['institute_id']);
                $SubPersonGroupM->setStatus($row['status']);

            }
            echo json_encode($SubPersonGroupM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }

     public function delSubPersonGroup($id){
        $db = new Database();
        $conn=  $db->getConnection();
        $sql2  =" DELETE FROM PersonGroup_TD  WHERE sub_group_id  = ? ";

        $stmt2 = sqlsrv_prepare($conn, $sql2, array($id));

        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $sql  =" DELETE FROM SubPersonGroup  WHERE sub_group_id  = ? ";

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
