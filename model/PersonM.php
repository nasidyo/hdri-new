<?php
require_once '../model/LandM.php';


Class PersonM extends LandM implements JsonSerializable {
            protected  $idPerson;
            protected  $Province_idProvince;
            protected  $Area_idArea;
            protected  $Prefix_idPrefix;
            protected  $firstName;
            protected  $lastName;
            protected  $idcard;
            protected  $birthday;
            protected  $tribeName;
            protected  $religionName;
            protected  $pos_family;
            protected  $familyCount;
            protected  $address;
            protected  $road;
            protected  $moo;
            protected  $mooName;
            protected  $subMooName;
            protected  $districtName;
            protected  $Amphur_idAmphur;
            protected  $postcode;
            protected  $phoneNumber;
            protected  $email;
            protected  $EduStatus_idEduStatus;
            protected  $EduLevel_idEduLevel;
            protected  $occupFirst;
            protected  $occupSecond;
            protected  $earnPerYear;
            protected  $payPerYear;
            protected  $RoleInCommu_idRoleInCommu;
            protected  $roleOther;
            protected  $Occup_idOccup;
            protected  $EnrolFarmerStatus_idEnrolFarmerStatus;
            protected  $PositionInCommu_idPositionInCommu;
            protected  $Role_idRole;
            protected  $idcard_other;
            protected  $sessionid;
            protected  $updatedate;
            protected  $insertdate;
            protected  $hasCard;
            protected  $picName;
            protected  $statusPerson;
            protected  $registerDate;
            protected  $yearGetPay;
            protected  $idGroupVillage;
            protected  $RiverBasin_idRiverBasin;
            protected  $isMember;
            protected  $coop;
            protected $agriList;
            protected $isGroup;
            protected $landDetails;
            protected $yearEarnPay ;


            public function getIdPerson(){
                return $this->idPerson;
            }
            public function setIdPerson($idPerson){
                 $this->idPerson=$idPerson;
            }

            public function getProvince_idProvince(){
                return $this->Province_idProvince;
            }
            public function setProvince_idProvince($Province_idProvince){
                $this->Province_idProvince=$Province_idProvince;
            }
            public function getArea_idArea(){
                return $this->Area_idArea;
            }
            public function setArea_idArea($Area_idArea){
                $this->Area_idArea=$Area_idArea;
            }
            public function getPrefix_idPrefix(){
                return $this->Prefix_idPrefix;
            }
            public function setPrefix_idPrefix($Prefix_idPrefix){
                $this->Prefix_idPrefix=$Prefix_idPrefix;
            }
            public function getFirstName(){
                return $this->firstName;
            }
            public function setFirstName($firstName){
                $this->firstName=$firstName;
            }
            public function getLastName(){
                return $this->lastName;
            }
            public function setLastName($lastName){
                $this->lastName=$lastName;
            }
            public function getIdcard(){
                return $this->idcard;
            }
            public function setIdcard($idcard){
                $this->idcard=$idcard;
            }
            public function getBirthday(){
                return $this->birthday;
            }
            public function setBirthday($birthday){
                $this->birthday=$birthday;
            }
            public function getTribeName(){
                return $this->tribeName;
            }
            public function setTribeName($tribeName){
                $this->tribeName=$tribeName;
            }
            public function getReligionName(){
                return $this->religionName;
            }
            public function setReligionName($religionName){
                $this->religionName=$religionName;
            }
            public function getPosFamily(){
                return $this->pos_family;
            }
            public function setPosFamily($pos_family){
                $this->pos_family=$pos_family;
            }
            public function getFamilyCount(){
                return $this->familyCount;
            }
            public function setFamilyCount($familyCount){
                $this->familyCount=$familyCount;
            }
            public function getAddress(){
                return $this->address;
            }
            public function setAddress($address){
                $this->address=$address;
            }
            public function getRoad(){
                return $this->road;
            }
            public function setRoad($road){
                $this->road=$road;
            }
            public function getMoo(){
                return $this->moo;
            }
            public function setMoo($moo){
                $this->moo=$moo;
            }
            public function getMooName(){
                return $this->mooName;
            }
            public function setMooName($mooName){
                $this->mooName=$mooName;
            }
            public function getSubMooName(){
                return $this->subMooName;
            }
            public function setSubMooName($subMooName){
                $this->subMooName=$subMooName;
            }
            public function getDistrictName(){
                return $this->districtName;
            }
            public function setDistrictName($districtName){
                $this->districtName=$districtName;
            }
            public function getAmphurIdAmphur(){
                return $this->Amphur_idAmphur;
            }
            public function setAmphurIdAmphur($Amphur_idAmphur){
                $this->Amphur_idAmphur=$Amphur_idAmphur;
            }
            public function getPostcode(){
                return $this->postcode;
            }
            public function setPostcode($postcode){
                $this->postcode=$postcode;
            }
            public function getPhoneNumber(){
                return $this->phoneNumber;
            }
            public function setPhoneNumber($phoneNumber){
                $this->phoneNumber=$phoneNumber;
            }
            public function getEmail(){
                return $this->email;
            }
            public function setEmail($email){
                $this->email=$email;
            }
            public function getEduStatusIdEduStatus(){
                return $this->EduStatus_idEduStatus;
            }
            public function setEduStatusIdEduStatus($EduStatus_idEduStatus){
                $this->EduStatus_idEduStatus=$EduStatus_idEduStatus;
            }
            public function getEduLevelIdEduLevel(){
                return $this->EduLevel_idEduLevel;
            }
            public function setEduLevelIdEduLevel($EduLevel_idEduLevel){
                $this->EduLevel_idEduLevel=$EduLevel_idEduLevel;
            }
            public function getOccupFirst(){
                return $this->occupFirst;
            }
            public function setOccupFirst($occupFirst){
                $this->occupFirst=$occupFirst;
            }
            public function getOccupSecond(){
                return $this->occupSecond;
            }
            public function setOccupSecond($occupSecond){
                $this->occupSecond=$occupSecond;
            }
            public function getEarnPerYear(){
                return $this->earnPerYear;
            }
            public function setEarnPerYear($earnPerYear){
                $this->earnPerYear=$earnPerYear;
            }
            public function getPayPerYear(){
                return $this->payPerYear;
            }
            public function setPayPerYear($payPerYear){
                $this->payPerYear=$payPerYear;
            }
            public function getRoleInCommuIdRoleInCommu(){
                return $this->RoleInCommu_idRoleInCommu;
            }
            public function setRoleInCommuIdRoleInCommu($RoleInCommu_idRoleInCommu){
                $this->RoleInCommu_idRoleInCommu=$RoleInCommu_idRoleInCommu;
            }
            public function getRoleOther(){
                return $this->roleOther;
            }
            public function setRoleOther($roleOther){
                $this->roleOther=$roleOther;
            }
            public function getOccupIdOccup(){
                return $this->Occup_idOccup;
            }
            public function setOccupIdOccup($Occup_idOccup){
                $this->Occup_idOccup=$Occup_idOccup;
            }
            public function getEnrolFarmerStatusIdEnrolFarmerStatus(){
                return $this->EnrolFarmerStatus_idEnrolFarmerStatus;
            }
            public function setEnrolFarmerStatusIdEnrolFarmerStatus($EnrolFarmerStatus_idEnrolFarmerStatus){
                $this->EnrolFarmerStatus_idEnrolFarmerStatus=$EnrolFarmerStatus_idEnrolFarmerStatus;
            }
            public function getPositionInCommuIdPositionInCommu(){
                return $this->PositionInCommu_idPositionInCommu;
            }
            public function setPositionInCommuIdPositionInCommu($PositionInCommu_idPositionInCommu){
                $this->PositionInCommu_idPositionInCommu=$PositionInCommu_idPositionInCommu;
            }
            public function getRoleIdRole(){
                return $this->Role_idRole;
            }
            public function setRoleIdRole($Role_idRole){
                $this->Role_idRole=$Role_idRole;
            }
            public function getIdCardOther(){
                return $this->idcard_other;
            }
            public function setIdCardOther($idcard_other){
                $this->idcard_other=$idcard_other;
            }
            public function getSessionid(){
                return $this->sessionid;
            }
            public function setSessionid($sessionid){
                $this->sessionid=$sessionid;
            }
            public function getUpdatedate(){
                return $this->updatedate;
            }
            public function setUpdatedate($updatedate){
                $this->updatedate=$updatedate;
            }
            public function getInsertdate(){
                return $this->insertdate;
            }
            public function setInsertdate($insertdate){
                $this->insertdate=$insertdate;
            }
            public function getHasCard(){
                return $this->hasCard;
            }
            public function setHasCard($hasCard){
                $this->hasCard=$hasCard;
            }
            public function getPicName(){
                return $this->picName;
            }
            public function setPicName($picName){
                $this->picName=$picName;
            }
            public function getStatusPerson(){
                return $this->statusPerson;
            }
            public function setStatusPerson($statusPerson){
                $this->statusPerson=$statusPerson;
            }
            public function getRegisterDate(){
                return $this->registerDate;
            }
            public function setRegisterDate($registerDate){
                $this->registerDate=$registerDate;
            }
            public function getYearGetPay(){
                return $this->yearGetPay;
            }
            public function setYearGetPay($yearGetPay){
                $this->yearGetPay=$yearGetPay;
            }
            public function getIdGroupVillage(){
                return $this->idGroupVillage;
            }
            public function setIdGroupVillage($idGroupVillage){
                $this->idGroupVillage=$idGroupVillage;
            }
            public function getRiverBasin_idRiverBasin(){
                return $this->RiverBasin_idRiverBasin;
            }
            public function setRiverBasin_idRiverBasin($RiverBasin_idRiverBasin){
                $this->RiverBasin_idRiverBasin=$RiverBasin_idRiverBasin;
            }

            public function getIsMember(){
                return $this->isMember;
            }
            public function setIsMember($isMember){
                $this->isMember=$isMember;
            }

            public function getCoop(){
                return $this->coop;
            }
            public function setCoop($coop){
                 $this->coop=$coop;
            }

            public function getAgriList(){
                return $this->agriList;
            }
            public function setAgriList($agriList){
                 $this->agriList=$agriList;
            }

            public function getIsGroup(){
                return $this->isGroup;
            }
            public function setIsGroup($isGroup){
                $this->isGroup=$isGroup;
            }

            public function getLandDetails(){
                return $this->landDetails;
            }
            public function setLandDetails($landDetails){
                $this->landDetails=$landDetails;
            }

            public function getYearEarnPay(){
                return $this->yearEarnPay;
            }
            public function setYearEarnPay($yearEarnPay){
                $this->yearEarnPay=$yearEarnPay;
            }



            public function jsonSerialize()
                {
                    return
                    [
                        'idPerson'=> $this::getIdPerson(),
                        'Province_idProvince' => $this::getProvince_idProvince(),
                        'Area_idArea'=>$this::getArea_idArea(),
                        'Prefix_idPrefix'=>$this::getPrefix_idPrefix(),
                        'firstName'=>$this::getFirstName(),
                        'lastName'=>$this::getLastName(),
                        'idcard'=>$this::getIdcard(),
                        'birthday'=>$this::getBirthday(),
                        'tribeName'=>$this::getTribeName(),
                        'religionName'=>$this::getReligionName(),
                        'pos_family'=>$this::getPosFamily(),
                        'familyCount'=>$this::getFamilyCount(),
                        'address'=>$this::getAddress(),
                        'road'=>$this::getRoad(),
                        'moo'=>$this::getMoo(),
                        'mooName'=>$this::getMooName(),
                        'subMooName'=>$this::getSubMooName(),
                        'districtName'=>$this::getDistrictName(),
                        'Amphur_idAmphur'=>$this::getAmphurIdAmphur(),
                        'postcode'=>$this::getPostcode(),
                        'phoneNumber'=>$this::getPhoneNumber(),
                        'email'=>$this::getEmail(),
                        'EduStatus_idEduStatus'=>$this::getEduStatusIdEduStatus(),
                        'EduLevel_idEduLevel'=>$this::getEduLevelIdEduLevel(),
                        'occupFirst'=>$this::getOccupFirst(),
                        'occupSecond'=> $this::getOccupSecond(),
                        'earnPerYear'=>$this::getEarnPerYear(),
                        'payPerYear'=>$this::getPayPerYear(),
                        'RoleInCommu_idRoleInCommu'=>$this::getRoleInCommuIdRoleInCommu(),
                        'roleOther'=>$this::getRoleOther(),
                        'Occup_idOccup'=>$this::getOccupIdOccup(),
                        'EnrolFarmerStatus_idEnrolFarmerStatus'=>$this::getEnrolFarmerStatusIdEnrolFarmerStatus(),
                        'PositionInCommu_idPositionInCommu'=>$this::getPositionInCommuIdPositionInCommu(),
                        'Role_idRole'=>$this::getRoleIdRole(),
                        'idcard_other'=>$this::getIdCardOther(),
                        'sessionid'=>$this::getSessionid(),
                        'updatedate'=>$this::getUpdatedate(),
                        'insertdate'=>$this::getInsertdate(),
                        'hasCard'=>$this::getHasCard(),
                        'picName'=>$this::getPicName(),
                        'statusPerson'=>$this::getStatusPerson(),
                        'registerDate'=>$this::getRegisterDate(),
                        'yearGetPay'=>$this::getYearGetPay(),
                        'idGroupVillage'=>$this::getIdGroupVillage(),
                        'RiverBasin_idRiverBasin'=>$this::getRiverBasin_idRiverBasin(),
                        'isMember'=>$this::getIsMember(),
                        'idLand'=> $this::getIdLand(),
                        'plots'=>$this::getPlots(),
                        'sqaurewa'=>$this::getSqaureWa(),
                        'ngan'=>$this::getNgan(),
                        'rai'=>$this::getRai(),
                        'coop'=>$this::getCoop(),
                        'agriList'=>$this::getAgriList(),
                        'isGroup'=>$this::getIsGroup(),
                        'landDetails'=>$this::getLandDetails(),
                        'yearEarnPay'=>$this::getYearEarnPay()
                    ];
                }


}

?>
