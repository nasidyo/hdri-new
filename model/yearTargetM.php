<?php
    Class yearM implements JsonSerializable {

        protected  $yearId;
        protected  $startDate;
        protected  $endDate;
        protected  $yearName;

        public function getYearId(){
            return $this->yearId;
        }
        public function setYearId($yearId){
             $this->yearId=$yearId;
        }

        public function getStartDate(){
            return $this->startDate;
        }
        public function setStartDate($startDate){
             $this->startDate=$startDate;
        }

        public function getEndDate(){
            return $this->endDate;
        }
        public function setEndDate($endDate){
             $this->endDate=$endDate;
        }

        public function getYearName(){
            return $this->yearName;
        }
        public function setYearName($yearName){
             $this->yearName=$yearName;
        }


        public function jsonSerialize(){
            return
            [
                'yearId'=> $this::getYearId(),
                'startDate'=> $this::getStartDate(),
                'endDate'=> $this::getEndDate(),
                'yearName'=> $this::getYearName()
            ];
        }
    }
?>
