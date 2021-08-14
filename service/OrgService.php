<?php
    require_once '../connection/database.php';
    require_once '../model/OrgM.php';

    Class OrgService{
        public function addOrg($OrderM){
            $sql  =" INSERT INTO OrganizationMap ( org_map_id, account_year_id, org_id, person_id ) VALUES ( ?, ?, ?, ? ) ";


            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
               $OrderM->getOrgMapId(),
               $OrderM->getAccountYearId(),
               $OrderM->getOrgId(),
               $OrderM->getPersonId()


            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateOrg($OrderM){
            $sql  =" UPDATE OrganizationMap SET  account_year_id = ?, org_id = ?, person_id = ? WHERE org_map_id = ?  ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(

                $OrderM->getAccountYearId(),
                $OrderM->getOrgId(),
                $OrderM->getPersonId(),
                $OrderM->getOrgMapId()
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

         public function loadOrg($Id){

            $sql  ="  SELECT om.org_map_id, om.account_year_id, om.org_id, om.person_id  FROM OrganizationMap om WHERE om.org_map_id = ?      ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $OrderM = new OrgM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $OrderM->setOrgMapId($row['org_map_id']);
                $OrderM->setAccountYearId($row['account_year_id']);
                $OrderM->setOrgId($row['org_id']);
                $OrderM->setPersonId($row['person_id']);

            }
            echo json_encode($OrderM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }




}


?>
