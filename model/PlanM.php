<?php 
    Class PlanM implements JsonSerializable {
        protected $idTargetPlan;
        protected $idTargetPlanRef;
        protected $idSendStatusPlan;
        protected $idOutputValue;
        protected $Area_idArea;
        protected $YearTarget_YearID;
        protected $speciesId;
        protected $TypeOfArgi_idTypeOfArgi;
        protected $Agri_idAgri;
        protected $Weight;
        protected $Price;
        protected $Total;
        protected $MonthId;
        protected $MarketId;
        protected $StatusTypeId;
        protected $attribute;
        protected $valueAttribute;

        public function getIdSendStatusPlan(){
            return $this->idSendStatusPlan;
        }
        public function setIdSendStatusPlan($idSendStatusPlan){
             $this->idSendStatusPlan=$idSendStatusPlan;
        }
        public function getIdTargetPlanRef(){
            return $this->idTargetPlanRef;
        }
        public function setIdTargetPlanRef($idTargetPlanRef){
             $this->idTargetPlanRef=$idTargetPlanRef;
        }
        public function getIdTargetPlan(){
            return $this->idTargetPlan;
        }
        public function setIdTargetPlan($idTargetPlan){
             $this->idTargetPlan=$idTargetPlan;
        }
        public function getIdOutputValue(){
            return $this->idOutputValue;
        }
        public function setIdOutputValue($idOutputValue){
             $this->idOutputValue=$idOutputValue;
        }
        public function getIdArea(){
            return $this->Area_idArea;
        }
        public function setIdArea($Area_idArea){
             $this->Area_idArea=$Area_idArea;
        }
        public function getIdTypeOfArgi(){
            return $this->TypeOfArgi_idTypeOfArgi;
        }
        public function setIdTypeOfArgi($TypeOfArgi_idTypeOfArgi){
             $this->TypeOfArgi_idTypeOfArgi=$TypeOfArgi_idTypeOfArgi;
        }
        public function getIdAgri(){
            return $this->Agri_idAgri;
        }
        public function setIdAgri($Agri_idAgri){
             $this->Agri_idAgri=$Agri_idAgri;
        }
        
        public function getIdYears(){
            return $this->YearTarget_YearID;
        }
        public function setIdYears($YearTarget_YearID){
             $this->YearTarget_YearID=$YearTarget_YearID;
        }
        public function getWeight(){
            return $this->Weight;
        }
        public function setWeight($Weight){
             $this->Weight=$Weight;
        }
        public function getPrice(){
            return $this->Price;
        }
        public function setPrice($Price){
             $this->Price=$Price;
        }
        public function getTotal(){
            return $this->Total;
        }
        public function setTotal($Total){
            $this->Total=$Total;
        }
        public function getMonthId(){
            return $this->MonthId;
        }
        public function setMonthId($MonthId){
            $this->MonthId=$MonthId;
        }
        public function getMarketId(){
            return $this->MarketId;
        }
        public function setMarketId($MarketId){
            $this->MarketId=$MarketId;
        }
        public function getStatusTypeId(){
            return $this->StatusTypeId;
        }
        public function setStatusTypeId($StatusTypeId){
            $this->StatusTypeId=$StatusTypeId;
        }

        public function getAttribute(){
            return $this->attribute;
        }
        public function setAttribute($attribute){
            $this->attribute=$attribute;
        }
        public function getValueAttribute(){
            return $this->valueAttribute;
        }
        public function setValueAttribute($valueAttribute){
            $this->valueAttribute=$valueAttribute;
        }
        public function getSpeciesId(){
            return $this->speciesId;
        }
        public function setSpeciesId($speciesId){
            $this->speciesId=$speciesId;
        }
        public function jsonSerialize(){
            return
            [
                'idTargetPlan'=> $this::getIdTargetPlan(),
                'idArea'=> $this::getIdArea(),
                'idYears'=> $this::getIdYears(),
                'weight'=> $this::getWeight(),
                'price'=> $this::getPrice(),
                'total'=> $this::getTotal()
            ];
        }
    }
?>