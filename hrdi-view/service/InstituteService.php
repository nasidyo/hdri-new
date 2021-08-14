<?php
    require_once '../connection/database.php';
    require_once '../model/InstituteM.php';

    Class InstituteService{
        public function addInsitute($InstituteM){
            $sql  =" INSERT INTO INSTITUTE ( INSTITUTE_ID, INSTITUTE_NAME, AREA_ID, STATUS ) VALUES ( ?, ?, ?, ? )   ";


            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $InstituteM->getInstituteId(),
                $InstituteM->getInstituteName(),
                $InstituteM->getAreaId(),
                $InstituteM->getStatus()));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateInsitute($InstituteM){
            $sql  =" UPDATE INSTITUTE SET ";
            $sql.="  INSTITUTE_NAME =? ,  STATUS=?   where INSTITUTE_ID  =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $InstituteM->getInstituteName(),

                $InstituteM->getStatus(),
                $InstituteM->getInstituteId()
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


         public function loadInsitute($InstituteId){

            $sql  ="  SELECT INSTITUTE_ID, INSTITUTE_NAME, AREA_ID, STATUS   FROM INSTITUTE where INSTITUTE_ID =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($InstituteId));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $instituteM = new InstituteM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

                $instituteM->setInstituteId($row['INSTITUTE_ID']);
                $instituteM->setInstituteName($row['INSTITUTE_NAME']);
                $instituteM->setAreaId($row['AREA_ID']);
                $instituteM->setStatus($row['STATUS']);

            }
            echo json_encode($instituteM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function delInsitute($InstituteId){

        $sql  =" DELETE FROM INSTITUTE WHERE INSTITUTE_ID = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($InstituteId));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }


    }

    }


?>
