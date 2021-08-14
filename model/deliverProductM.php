<?php 
    Class deliverProductM implements JsonSerializable {
        protected $idPersonMarket;
        protected $dateDeliver;
        protected $agri_Id;
        protected $area_Id;
        protected $customerMarket_Id;
        protected $market_Id;
        protected $customer_Id;
        protected $standardProduct_Id;
        protected $gardProduct_Id;
        protected $quality;
        protected $price;
        protected $totalPricre;
        protected $person_Id;
        protected $typeAgri_Id;
        protected $yearsId;
        protected $monthId;
        protected $statusId;
        protected $landDetail;
        protected $lossValue;
        protected $speciesId;

        protected  $Prefix_idPrefix;
        protected  $firstName;
        protected  $lastName;
        protected  $idcard;
        protected  $phoneNumber;
        protected  $statusPerson;

        protected  $logisticId;
        protected  $logisticDetail;

        protected  $dateCultivate;
        protected  $dateHarvest;

        public function getIdPersonMarket (){
            return $this->idPersonMarket;
        }
        public function setIdPersonMarket ($idPersonMarket){
             $this->idPersonMarket=$idPersonMarket;
        }
        public function getDateDeliver (){
            return $this->dateDeliver;
        }
        public function setDateDeliver ($dateDeliver){
             $this->dateDeliver=$dateDeliver;
        }
        public function getIdAgri (){
            return $this->agri_Id;
        }
        public function setIdAgri ($agri_Id){
             $this->agri_Id=$agri_Id;
        }
        public function getIdArea (){
            return $this->area_Id;
        }
        public function setIdArea ($area_Id){
             $this->area_Id=$area_Id;
        }
        public function getIdCustomerMarket (){
            return $this->customerMarket_Id;
        }
        public function setIdCustomerMarket ($customerMarket_Id){
             $this->customerMarket_Id=$customerMarket_Id;
        }
        public function getIdMarket (){
            return $this->market_Id;
        }
        public function setIdMarket ($market_Id){
             $this->market_Id=$market_Id;
        }
        public function getIdCustomer (){
            return $this->customer_Id;
        }
        public function setIdCustomer ($customer_Id){
             $this->customer_Id=$customer_Id;
        }
        public function getIdStandrdProduct (){
            return $this->standardProduct_Id;
        }
        public function setIdStandrdProduct ($standardProduct_Id){
             $this->standardProduct_Id=$standardProduct_Id;
        }
        public function getIdGardProduct (){
            return $this->gardProduct_Id;
        }
        public function setIdGardProduct ($gardProduct_Id){
             $this->gardProduct_Id=$gardProduct_Id;
        }
        public function getQuality (){
            return $this->quality;
        }
        public function setQuality ($quality){
             $this->quality=$quality;
        }
        public function getPrice (){
            return $this->price;
        }
        public function setPrice ($price){
             $this->price=$price;
        }
        public function getTotalPricre (){
            return $this->totalPricre;
        }
        public function setTotalPricre ($totalPricre){
             $this->totalPricre=$totalPricre;
        }
        public function getIdPerson (){
            return $this->person_Id;
        }
        public function setIdPerson ($person_Id){
             $this->person_Id=$person_Id;
        }
        public function getIdTypeAgri (){
            return $this->typeAgri_Id;
        }
        public function setIdTypeAgri ($typeAgri_Id){
             $this->typeAgri_Id=$typeAgri_Id;
        }
        public function getIdYears (){
            return $this->yearsId;
        }
        public function setIdYears ($yearsId){
             $this->yearsId=$yearsId;
        }
        public function getIdMonth (){
            return $this->monthId;
        }
        public function setIdMonth ($monthId){
             $this->monthId=$monthId;
        }
        public function getIdStatus (){
            return $this->statusId;
        }
        public function setIdStatus ($statusId){
             $this->statusId=$statusId;
        }
        public function getlandDetail (){
            return $this->landDetail;
        }
        public function setlandDetail ($landDetail){
             $this->landDetail=$landDetail;
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

        public function getStatusPerson(){
            return $this->statusPerson;
        }
        public function setStatusPerson($statusPerson){
            $this->statusPerson=$statusPerson;
        }
        public function getIdcard(){
            return $this->idcard;
        }
        public function setIdcard($idcard){
            $this->idcard=$idcard;
        }
        public function getPhoneNumber(){
            return $this->phoneNumber;
        }
        public function setPhoneNumber($phoneNumber){
            $this->phoneNumber=$phoneNumber;
        }
        public function getlossValue(){
            return $this->lossValue;
        }
        public function setlossValue($lossValue){
            $this->lossValue=$lossValue;
        }

        public function getlogisticId(){
            return $this->logisticId;
        }
        public function setlogisticId($logisticId){
            $this->logisticId=$logisticId;
        }
        public function getlogisticDetail(){
            return $this->logisticDetail;
        }
        public function setlogisticDetail($logisticDetail){
            $this->logisticDetail=$logisticDetail;
        }
        public function getSpeciesId(){
            return $this->speciesId;
        }
        public function setSpeciesId($speciesId){
            $this->speciesId=$speciesId;
        }

        public function getDateCultivate(){
            return $this->dateCultivate;
        }
        public function setDateCultivate($dateCultivate){
            $this->dateCultivate=$dateCultivate;
        }

        public function getDateHarvest(){
            return $this->dateHarvest;
        }
        public function setDateHarvest($dateHarvest){
            $this->dateHarvest=$dateHarvest;
        }

        public function jsonSerialize(){
            return
            [
                'idPersonMarket'=> $this::getIdPersonMarket(),
                'dateDeliver'=> $this::getDateDeliver(),
                'agri_Id'=> $this::getIdAgri(),
                'market_Id'=> $this::getIdMarket(),
                'customer_Id'=> $this::getIdCustomer(),
                'standardProduct_Id'=> $this::getIdStandrdProduct(),
                'gardProduct_Id'=> $this::getIdGardProduct(),
                'quality'=> $this::getQuality(),
                'price'=> $this::getPrice(),
                'totalPricre'=> $this::getTotalPricre(),
                'person_Id'=> $this::getIdPerson(),
                'typeAgri_Id'=> $this::getIdTypeAgri(),
                'yearsId'=> $this::getIdYears(),
                'monthId'=> $this::getIdMonth(),
                'setSpeciesId'=> $this::getSpeciesId(),
                'dateCultivate'=> $this::getDateCultivate(),
                'dateHarvest'=> $this::getDateHarvest()
            ];
        }
    }
?>