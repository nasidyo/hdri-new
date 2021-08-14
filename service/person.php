
<?php
    require_once '../connection/database.php';
    require '../service/SeqService.php';
    require '../model/PersonM.php';
    require '../service/LandService.php';
    require '../model/YearEarnPayM.php';


    require_once '../model/RegisterAgriM.php';
    require_once '../service/RegisterAgriService.php';
    require_once '../service/LandDetailService.php';
    require_once '../service/YearEarnPayService.php';


    Class PersonService{

         public function addPerson($personM){
            $sql  =" INSERT INTO Person_TD ";
            $sql.="  ( idPerson, Province_idProvince, Area_idArea, Prefix_idPrefix, firstName,  ";
            $sql.="    lastName, idcard, birthday, tribeName, religionName ,";
            $sql.="    pos_family, familyCount, address, road, moo, ";
            $sql.="    mooName, subMooName, districtName, Amphur_idAmphur, postcode, ";
            $sql.="    phoneNumber, email, EduStatus_idEduStatus, EduLevel_idEduLevel, occupFirst, ";
            $sql.="    occupSecond, earnPerYear, payPerYear, RoleInCommu_idRoleInCommu, roleOther, ";
            $sql.="    Occup_idOccup, EnrolFarmerStatus_idEnrolFarmerStatus, PositionInCommu_idPositionInCommu, Role_idRole, idcard_other, ";
            $sql.="    sessionid, updatedate, insertdate, hasCard, picName,";
            $sql.="    statusPerson,registerDate, yearGetPay, idGroupVillage, RiverBasin_idRiverBasin,  ";
            $sql.="    isMember, coop ,isGroup ) ";
            $sql.=" VALUES ( ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ?, getdate(), ?, ?, ?, ";
            $sql.=" ?, ?, ?, ?, ?, ";
            $sql.=" ? , ? ,?";
            $sql.=" ) ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $personM->getIdPerson(), $personM->getProvince_idProvince(),$personM->getArea_idArea(),$personM->getPrefix_idPrefix(),$personM->getFirstName() ,
                $personM->getLastName(), $personM->getIdcard(),$personM->getBirthday(),$personM->getTribeName(),$personM->getReligionName(),
                $personM->getPosFamily(),$personM->getFamilyCount(),$personM->getAddress(),$personM->getRoad(),$personM->getMoo(),
                $personM->getMooName(),$personM->getSubMooName(),$personM->getDistrictName(),$personM->getAmphurIdAmphur(),$personM->getPostcode(),
                $personM->getPhoneNumber(),$personM->getEmail(),$personM->getEduStatusIdEduStatus(),$personM->getEduLevelIdEduLevel(),$personM->getOccupFirst(),
                $personM->getOccupSecond(),0,0,$personM->getRoleInCommuIdRoleInCommu(),$personM->getRoleOther(),
                $personM->getOccupIdOccup(), $personM->getEnrolFarmerStatusIdEnrolFarmerStatus(),$personM->getPositionInCommuIdPositionInCommu(),$personM->getRoleIdRole(),$personM->getIdCardOther(),
                $personM->getSessionid(), $personM->getInsertdate(),$personM->getHasCard(),$personM->getPicName(),
                $personM->getStatusPerson(),$personM->getRegisterDate(), $personM->getYearGetPay(),$personM->getIdGroupVillage(),$personM->getRiverBasin_idRiverBasin(),
                $personM->getIsMember(), $personM->getCoop() ,$personM->getIsGroup()
        ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        $landService = new LandService();
        $landService->addLand($personM);
        $registerAgriService = new RegisterAgriService();
        if( $personM->getAgriList()!=null){
            $registerAgriM  = new RegisterAgriM();
            $date = DateTime::createFromFormat("Y-m-d", date("Y-m-d"));
            $registerAgriM->setIdPerson($personM->getIdPerson());
            $registerAgriM->setIdAgri($personM->getAgriList());
            $registerAgriM->setIdArea($personM->getArea_idArea());
            $registerAgriM->setRegister_year($date->format("Y")+543);
            $registerAgriService->saveRegisAgri($registerAgriM);

        }else{

            $registerAgriService->delRegisterAgriByPerson($personM->getIdPerson());

        }

        $YearEarnPayArr =array();
            if( $personM->getYearEarnPay()!=null){
                $YearEarnPayArr=  $personM->getYearEarnPay();

                for ($x = 0; $x < count($YearEarnPayArr); $x++) {
                    $YearEarnPayM = new YearEarnPayM();
                    $YearEarnPayM->setYearGetPay($YearEarnPayArr[$x]["yearGetPay"]);
                    $YearEarnPayM->setEarnPerYear( floatval(preg_replace('/[^\d.]/', '', $YearEarnPayArr[$x]["earnPerYear"])));
                    $YearEarnPayM->setPayPerYear( floatval(preg_replace('/[^\d.]/', '', $YearEarnPayArr[$x]["payPerYear"])));
                    $YearEarnPayM->setIdPerson($personM->getIdPerson());
                    $YearEarnPayM->setIdYearEarnPay($YearEarnPayArr[$x]["idYearEarnPay"]);
                    if( $YearEarnPayM->getIdYearEarnPay()>0){
                        $YearEarnPayService = new YearEarnPayService();
                        $YearEarnPayService->updateYearEarnPay($YearEarnPayM);
                    }else{
                        // insert
                        $YearEarnPayService = new YearEarnPayService();
                        $YearEarnPayService->addYearEarnPay($YearEarnPayM);
                    }


                  }

            }
            sqlsrv_close($conn);

         }



         public function updatePerson($personM){
            $sql  =" UPDATE Person_TD SET ";
            $sql.="  Province_idProvince =?, Area_idArea = ?, Prefix_idPrefix = ?, firstName =?, lastName = ?,  ";
            $sql.="  idcard =?, birthday = ?, tribeName = ?, religionName = ?, pos_family =?,  ";
            $sql.="  familyCount = ?, address =?, road = ?, moo = ?, mooName =?,  ";
            $sql.="  subMooName = ?, districtName =?, Amphur_idAmphur = ?, postcode = ?, phoneNumber = ?,  ";
            $sql.="  email =?, EduStatus_idEduStatus = ?, EduLevel_idEduLevel = ?, occupFirst = ?, occupSecond = ?,  ";
            $sql.="  earnPerYear = ?, payPerYear = ?, RoleInCommu_idRoleInCommu = ?, roleOther =?, Occup_idOccup = ?,  ";
            $sql.="  EnrolFarmerStatus_idEnrolFarmerStatus = ?, PositionInCommu_idPositionInCommu = ?, Role_idRole = ?, idcard_other =?, sessionid = ?,  ";
            $sql.="  updatedate = getDate() , insertdate = ?, hasCard = ?, picName = ?, statusPerson = ?,  ";
            $sql.="  registerDate = ?, yearGetPay = ?, idGroupVillage = ?, RiverBasin_idRiverBasin = ? , isMember =? , coop=? , isGroup =? WHERE idPerson = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $personM->getProvince_idProvince(),$personM->getArea_idArea(),$personM->getPrefix_idPrefix(),$personM->getFirstName() , $personM->getLastName(),
                $personM->getIdcard(),$personM->getBirthday(),$personM->getTribeName(),$personM->getReligionName(), $personM->getPosFamily(),
                $personM->getFamilyCount(),$personM->getAddress(),$personM->getRoad(),$personM->getMoo(),$personM->getMooName(),
                $personM->getSubMooName(),$personM->getDistrictName(),$personM->getAmphurIdAmphur(),$personM->getPostcode(), $personM->getPhoneNumber(),
                $personM->getEmail(),$personM->getEduStatusIdEduStatus(),$personM->getEduLevelIdEduLevel(),$personM->getOccupFirst(),$personM->getOccupSecond(),
                $personM->getEarnPerYear(),$personM->getPayPerYear(),$personM->getRoleInCommuIdRoleInCommu(),$personM->getRoleOther(),$personM->getOccupIdOccup(),
                $personM->getEnrolFarmerStatusIdEnrolFarmerStatus(),$personM->getPositionInCommuIdPositionInCommu(),$personM->getRoleIdRole(),$personM->getIdCardOther(),$personM->getSessionid(),
                 $personM->getInsertdate(),$personM->getHasCard(),$personM->getPicName(),$personM->getStatusPerson(),
                $personM->getRegisterDate(), $personM->getYearGetPay(),$personM->getIdGroupVillage(),$personM->getRiverBasin_idRiverBasin(),$personM->getIsMember(),$personM->getCoop(),$personM->getIsGroup() ,$personM->getIdPerson()

            );

            $stmt = sqlsrv_prepare( $conn, $sql, $params);
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }




            $landService = new LandService();
            $landService->updateLand($personM);
            $registerAgriService = new RegisterAgriService();
            if( $personM->getAgriList()!=null){

                $registerAgriM  = new RegisterAgriM();
                $date = DateTime::createFromFormat("Y-m-d", date("Y-m-d"));
                $registerAgriM->setIdPerson($personM->getIdPerson());
                $registerAgriM->setIdAgri($personM->getAgriList());
                $registerAgriM->setIdArea($personM->getArea_idArea());
                $registerAgriM->setRegister_year($date->format("Y")+543);
                $registerAgriService->saveRegisAgri($registerAgriM);

            }else{

                $registerAgriService->delRegisterAgriByPerson($personM->getIdPerson());

            }
            $YearEarnPayArr =array();
            if( $personM->getYearEarnPay()!=null){
                $YearEarnPayArr=  $personM->getYearEarnPay();

                for ($x = 0; $x < count($YearEarnPayArr); $x++) {
                    $YearEarnPayM = new YearEarnPayM();
                    $YearEarnPayM->setYearGetPay($YearEarnPayArr[$x]["yearGetPay"]);
                    $YearEarnPayM->setEarnPerYear( floatval(preg_replace('/[^\d.]/', '', $YearEarnPayArr[$x]["earnPerYear"])));
                    $YearEarnPayM->setPayPerYear( floatval(preg_replace('/[^\d.]/', '', $YearEarnPayArr[$x]["payPerYear"])));
                    $YearEarnPayM->setIdPerson($YearEarnPayArr[$x]["idPerson"]);
                    $YearEarnPayM->setIdYearEarnPay($YearEarnPayArr[$x]["idYearEarnPay"]);
                    if( $YearEarnPayM->getIdYearEarnPay()>0){
                        $YearEarnPayService = new YearEarnPayService();
                        $YearEarnPayService->updateYearEarnPay($YearEarnPayM);
                    }else{
                        // insert
                        $YearEarnPayService = new YearEarnPayService();
                        $YearEarnPayService->addYearEarnPay($YearEarnPayM);
                    }


                  }

            }

            sqlsrv_close($conn);
         }

         public function loadPersonById($id){

                $sql  =" SELECT idPerson, Province_idProvince, Area_idArea, Prefix_idPrefix, firstName,";
                $sql  .="  lastName,   REPLACE(idcard,'-','') idcard, birthday, tribeName, religionName, ";
                $sql  .="  pos_family, familyCount, address, road, moo, ";
                $sql  .="  mooName, subMooName, districtName, Amphur_idAmphur, postcode, ";
                $sql  .="  phoneNumber, email, EduStatus_idEduStatus, EduLevel_idEduLevel, occupFirst, ";
                $sql  .="  occupSecond,  FORMAT(earnPerYear,'######.##') earnPerYear,FORMAT(payPerYear,'######.##') payPerYear, RoleInCommu_idRoleInCommu, roleOther, ";
                $sql  .="  Occup_idOccup, EnrolFarmerStatus_idEnrolFarmerStatus, PositionInCommu_idPositionInCommu, Role_idRole, idcard_other, ";
                $sql  .="  sessionid, updatedate, insertdate, hasCard, picName, ";
                $sql  .="  statusPerson, registerDate, yearGetPay, idGroupVillage, RiverBasin_idRiverBasin ,isMember ,coop ,isGroup ";
                $sql  .="  FROM Person_TD where idPerson=? ";


                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array($id));

                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $personM = new PersonM();
                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {


                        $personM->setIdPerson($row['idPerson']);
                        $personM->setProvince_idProvince($row['Province_idProvince']);
                        $personM->setArea_idArea($row['Area_idArea']);
                        $personM->setPrefix_idPrefix($row['Prefix_idPrefix']);
                        $personM->setFirstName($row['firstName']);

                        $personM->setLastName($row['lastName']);
                        $personM->setIdcard($row['idcard']);
                        $personM->setBirthday($row['birthday']);
                        $personM->setTribeName($row['tribeName']);
                        $personM->setReligionName($row['religionName']);

                        $personM->setPosFamily($row['pos_family']);
                        $personM->setFamilyCount($row['familyCount']);
                        $personM->setAddress($row['address']);
                        $personM->setRoad($row['road']);
                        $personM->setMoo($row['moo']);

                        $personM->setMooName($row['mooName']);
                        $personM->setSubMooName($row['subMooName']);
                        $personM->setDistrictName($row['districtName']);
                        $personM->setAmphurIdAmphur($row['Amphur_idAmphur']);
                        $personM->setPostcode($row['postcode']);


                        $personM->setPhoneNumber($row['phoneNumber']);
                        $personM->setEmail($row['email']);
                        $personM->setEduStatusIdEduStatus($row['EduStatus_idEduStatus']);
                        $personM->setEduLevelIdEduLevel($row['EduLevel_idEduLevel']);
                        $personM->setOccupFirst($row['occupFirst']);

                        $personM->setOccupSecond($row['occupSecond']);
                        $personM->setEarnPerYear($row['earnPerYear']);
                        $personM->setPayPerYear($row['payPerYear']);
                        $personM->setIdGroupVillage($row['idGroupVillage']);
                        $personM->setRiverBasin_idRiverBasin($row['RiverBasin_idRiverBasin']);
                        $personM->setIsMember($row['isMember']);

                        $personM->setPicName($row['picName']);
                        $personM->setStatusPerson($row['statusPerson']);

                        $personM->setCoop($row['coop']);
                        $personM->setIsGroup($row['isGroup']);
                        $landService = new LandService();
                        $landM= $landService->loadLand($personM->getIdPerson());

                        $personM->setPlots($landM->getPlots());
                        $personM->setRai($landM->getRai());
                        $personM->setNgan($landM->getNgan());
                        $personM->setSqaureWa($landM->getSqaureWa());


                        $registerAgriService = new RegisterAgriService();
                        $regisArgi = $registerAgriService->loadRegisterAgri($personM->getIdPerson());
                        $personM->setAgriList($regisArgi);

                         $landDetailService  = new LandDetailService();
                         $landDetailsM = $landDetailService->loadLandDetailM($personM->getIdPerson());


                        $personM->setLandDetails($landDetailsM);
		

                        $YearEarnPayService = new YearEarnPayService();
                        $YearEarnPayM =   $YearEarnPayService->loadYearEarnPayByPerson($personM->getIdPerson());
                        $personM->setYearEarnPay( $YearEarnPayM);
                        echo json_encode($personM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

                }
                sqlsrv_close($conn);

         }

         public function updatePersonMember($personIdArr,  $val){
            $personIdArrs = json_decode( $personIdArr[0], true );
          $sql  =" UPDATE Person_TD SET ";
            if(count($personIdArrs)==1){
                $sql.=" isMember ='".$val."' WHERE idPerson = ".$personIdArrs[0];
            }else if(count($personIdArrs)>1){
                $sql.=" isMember ='".$val."' WHERE idPerson in (";
                for ($i = 0; $i < count($personIdArrs); $i++) {
                    $sql.=$personIdArrs[$i];

                    if($i != (count($personIdArrs)-1)){

                        $sql.=",";
                    }
                  }
                  $sql.=" )";
            }
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_query($conn, $sql);

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
         }

         public function updatePersonGroup($personIdArr,  $val){
            $personIdArrs = json_decode( $personIdArr[0], true );
          $sql  =" UPDATE Person_TD SET ";
            if(count($personIdArrs)==1){
                $sql.=" isGroup ='".$val."' WHERE idPerson = ".$personIdArrs[0];
            }else if(count($personIdArrs)>1){
                $sql.=" isGroup ='".$val."' WHERE idPerson in (";
                for ($i = 0; $i < count($personIdArrs); $i++) {
                    $sql.=$personIdArrs[$i];

                    if($i != (count($personIdArrs)-1)){

                        $sql.=",";
                    }
                  }
                  $sql.=" )";
            }
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_query($conn, $sql);

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
         }

 	 public function delPerson($person_id){

            $sql  =" DELETE FROM Person_TD WHERE idPerson = ? ";

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
