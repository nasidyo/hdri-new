
<?php 
    require_once '../connection/database.php';
    require_once '../model/RegisterAgriM.php';

    Class RegisterAgriService{

        public function saveRegisAgri($regisAgri){
              
            $idPerson =0;
            if($regisAgri!=null){
                $idPerson =$regisAgri->getIdPerson();
                $regisGM =  $this::loadRegisterAgriCheck($idPerson,$regisAgri->getIdAgri());

                // check ui delete 
               $regisAgriDB =  $this::loadRegisterAgri($idPerson);
               $a = array_map('intval', explode(',', $regisAgri->getIdAgri()));
               $b = array();
              if(is_array($regisAgriDB)){
                for ($i = 0; $i <count($regisAgriDB); $i++) {
                    $groupDB = (int)$regisAgriDB[$i]->getIdAgri();
                    array_push($b, $groupDB);
                 
              }
            }

            function udiff($a,$b) {
                if ($a===$b) {
                    return 0;
                }
                return ($a>$b)?1:-1;
            }
        

            $resultDel =array_udiff($b,$a,"udiff");
            $resultAdd =array_udiff($a,$b,"udiff");

            $argiIdArrToInsert=array();
            if(!empty($resultAdd)){
                foreach ($resultAdd as &$value) {
                  $pos=  strpos($regisAgri->getIdAgri(),(string)$value);
                    if($pos >=0 ){
                        array_push($argiIdArrToInsert,(string)$value);
                    }
                }
               
            }
            if(!empty($argiIdArrToInsert)){
               
                $regisAgri->setIdAgri(implode(",",$argiIdArrToInsert));
                $this::insertAgri($regisAgri);
            }
            if(!empty($resultDel)){
                foreach ($resultDel as &$value) {
                  $this::delRegisterAgri($idPerson,$value);
                } 
            }
            return true;
            }
        }

        public function insertAgri($regisAgri){
         

          $agriList  = explode(",",$regisAgri->getIdAgri());
          $db = new Database();
          $conn=  $db->getConnection();
          $seqService = new SeqService();
        
          for($i=0;$i<count($agriList);$i++){
            $seqRegisAgri= $seqService->get("regisArgi_id");
            
            $idAgri =  (int)$agriList[$i];
            $sql  =" INSERT INTO RegisterAgri_TD (regisAgri_id, idPerson,idAgri,idArea, register_year ) VALUES (".$seqRegisAgri.", ".$regisAgri->getIdPerson().", ".$idAgri." ,".$regisAgri->getIdArea().",'".$regisAgri->getRegister_year()."')";
            $stmt = sqlsrv_prepare($conn, $sql);
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
           
          } 
          sqlsrv_close($conn);
        }
        


         public function loadRegisterAgriCheck($idPerson,$idAgrirArr){
            $sql  ="  SELECT regisAgri_id ,idPerson,idArea, idAgri , register_year FROM RegisterAgri_TD where idAgri in (".$idAgrirArr.")";
            $sql  .="  and idPerson=?  ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($idPerson));
           

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $rigisArr =  array();
      
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $regisAM = new RegisterAgriM();
                $regisAM->setRegisAgri_id($row['regisAgri_id']);
                $regisAM->setIdPerson($row['idPerson']);
                $regisAM->setIdAgri($row['idAgri']);
                $regisAM->setIdArea($row['idArea']);
                $regisAM->setRegister_year($row['register_year']);

                array_push($rigisArr, $regisAM);
               
            }
            sqlsrv_close($conn);
            return $rigisArr;
          
         
     }
         


         public function loadRegisterAgri($idPerson){

            $sql  ="  SELECT ra.regisAgri_id , ra.idPerson, ra.idArea, ra.idAgri , ra.register_year, atd.TypeOfArgi_idTypeOfArgi FROM RegisterAgri_TD ra, .Agri_TD atd WHERE atd.idAgri = ra.idAgri AND ra.idPerson= ? ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($idPerson));
           
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            
            $rigisArr =  array();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $regisAM = new RegisterAgriM();
                $regisAM->setRegisAgri_id($row['regisAgri_id']);
                $regisAM->setIdPerson($row['idPerson']);
                $regisAM->setIdAgri($row['idAgri']);
                $regisAM->setIdArea($row['idArea']);
                $regisAM->setRegister_year($row['register_year']);
                $regisAM->setTypeOfArgi_idTypeOfArgi($row['TypeOfArgi_idTypeOfArgi']);
                  array_push($rigisArr, $regisAM);
   
            }
            return  $rigisArr;
            sqlsrv_close($conn);
         
     }

     public function delRegisterAgri($person_id ,$idAgri){
          
        $sql  =" DELETE FROM RegisterAgri_TD WHERE idPerson = ?  and  idAgri =?";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($person_id , $idAgri));
       
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }


    }


    public function delRegisterAgriByPerson($person_id ){
          
        $sql  =" DELETE FROM RegisterAgri_TD WHERE idPerson = ? ";

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