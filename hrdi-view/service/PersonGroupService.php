<?php
    require_once '../connection/database.php';
    require_once '../model/PersonGroupM.php';

    Class PersonGroupService{
        public function addPersonGroup($PersonGroupM){
            $sql  =" INSERT";
            $sql  .=" INTO ";
            $sql  .="     PersonGroup_TD ";
            $sql  .="     ( ";
            $sql  .="         person_group_id, ";
            $sql  .="         person_id, ";
            $sql  .="         institute_id, ";
            $sql  .="         year_register, ";
            $sql  .="         position_id ,";
            $sql  .="         sub_group_id ";
            $sql  .="    ) ";
            $sql  .="     VALUES ";
            $sql  .="     (  ";
            $sql  .="         ?,?,?,?,?,? ";
            $sql  .="     ) ";


            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $PersonGroupM->getPersonGroupId(),
               $PersonGroupM->getPersonId(),
               $PersonGroupM->getInstituteId(),
               $PersonGroupM->getYearRegister(),
               $PersonGroupM->getPositionId(),
               $PersonGroupM->getSubGroupId()

            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updatePersonGroup($PersonGroupM){
            $sql  =" UPDATE ";
            $sql  .=" PersonGroup_TD ";
            $sql  .=" SET ";
            $sql  .="     person_id = ?, ";
            $sql  .="     institute_id = ?, ";
            $sql  .="     position_id = ?, ";
            $sql  .="     year_register =? ,";
            $sql  .="     sub_group_id =? ";
            $sql  .="  WHERE ";
            $sql  .="     person_group_id = ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
               $PersonGroupM->getPersonId(),
               $PersonGroupM->getInstituteId(),
               $PersonGroupM->getPositionId(),
               $PersonGroupM->getYearRegister(),
               $PersonGroupM->getSubGroupId(),
               $PersonGroupM->getPersonGroupId()
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

         public function loadPersonGroup($Id){

            $sql  ="  SELECT      ";
            $sql  .="   person_group_id, ";
            $sql  .="   person_id, ";
            $sql  .="   institute_id, ";
            $sql  .="   position_id, ";
            $sql  .="   year_register , ";
            $sql  .="   sub_group_id  ";
            $sql  .=" FROM ";
            $sql  .="   PersonGroup_TD      ";
            $sql  .=" where person_group_id =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $PersonGroupM = new PersonGroupM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

                $PersonGroupM->setPersonId($row['person_group_id']);
                $PersonGroupM->setInstituteId($row['person_id']);
                $PersonGroupM->setPositionId($row['institute_id']);
                $PersonGroupM->setYearRegister($row['position_id']);
                $PersonGroupM->setPersonGroupId($row['year_register']);
                $PersonGroupM->setSubGroupId($row['sub_group_id']);

            }
            echo json_encode($PersonGroupM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function loadPersonGroupByPersonId($Id){

        $sql  ="  SELECT      ";
        $sql  .=" pg.person_group_id, ";
        $sql  .=" pg.person_id, ";
        $sql  .="  pg.institute_id, ";
        $sql  .="  pg.sub_group_id, ";
        $sql  .="   a.areaName, ";
        $sql  .="   ins.INSTITUTE_NAME, ";
        $sql  .="  spg.sub_group_name ";
        $sql  .=" FROM ";
        $sql  .="  PersonGroup_TD pg , ";
        $sql  .="  SubPersonGroup spg , ";
        $sql  .="  INSTITUTE ins , ";
        $sql  .="   Area a ";
        $sql  .=" WHERE ";
        $sql  .=" pg.sub_group_id = spg.sub_group_id ";
        $sql  .=" and pg.institute_id =ins.INSTITUTE_ID ";
        $sql  .=" and ins.AREA_ID = a.idArea ";
        $sql  .="  and   pg.person_id = ?  ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $return_arr = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $row_array['areaName'] = $row['areaName'];
            $row_array['INSTITUTE_NAME'] = $row['INSTITUTE_NAME'];
            $row_array['sub_group_name'] = $row['sub_group_name'];
            array_push($return_arr, $row_array);
        }
        echo json_encode($return_arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);

 }


     public function delPerson($person_id,$institute_id,$sub_group_id){

        $sql  =" DELETE FROM PersonGroup_TD  WHERE person_id = ? and institute_id= ? and sub_group_id=? ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($person_id,$institute_id,$sub_group_id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

     }





}


?>
