
<?php 
    require_once '../connection/database.php';
    require_once '../model/PersonM.php';

    Class LandService{
        public function addLand($personM){
            $sql  =" INSERT INTO Land (  Person_idPerson , unit1  , unit2, unit3, unit4 ) VALUES (  ?, ?, ?, ?, ? )    ";
         
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(  $personM->getIdPerson(),$personM->getPlots() ,$personM->getRai() ,$personM->getNgan(),$personM->getSqaureWa()));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }


         
         public function updateLand($personM){
            $sql  =" UPDATE Land SET ";
            $sql.="  unit1 =? , unit2=?, unit3=?, unit4 =?  where Person_idPerson =? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(   
                $personM->getPlots(),
                $personM->getRai(),
                $personM->getNgan(),
                $personM->getSqaureWa(),
                $personM->getIdPerson()
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


         public function loadLand($idPerson){

            $sql  ="  SELECT idLand, Person_idPerson, unit1, unit2, unit3, unit4 FROM Land where Person_idPerson=? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($idPerson));
           
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $personM = new PersonM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $personM->setPlots($row['unit1']);
                $personM->setRai($row['unit2']);
                $personM->setNgan($row['unit3']);
                $personM->setSqaureWa($row['unit4']);
   
            }
            return  $personM;
            sqlsrv_close($conn);
         
     }

     public function delLand($person_id){
          
        $sql  =" DELETE FROM Land WHERE Person_idPerson = ? ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($person_id));
       
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }


    }

}



?>