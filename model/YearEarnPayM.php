<?php
    Class YearEarnPayM implements JsonSerializable {

        protected  $yearGetPay;
        protected  $idPerson;
        protected  $earnPerYear;
        protected  $payPerYear;
        protected  $idYearEarnPay;


        public function getYearGetPay(){
            return $this->yearGetPay;
        }
        public function setYearGetPay($yearGetPay){
             $this->yearGetPay=$yearGetPay;
        }
        public function getIdPerson(){
            return $this->idPerson;
        }
        public function setIdPerson($idPerson){
             $this->idPerson=$idPerson;
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
        public function getIdYearEarnPay(){
            return $this->idYearEarnPay;
        }
        public function setIdYearEarnPay($idYearEarnPay){
             $this->idYearEarnPay=$idYearEarnPay;
        }

        public function jsonSerialize(){
            return
            [
                'yearGetPay'=> $this::getYearGetPay(),
                'idPerson'=> $this::getIdPerson(),
                'earnPerYear' => $this::getEarnPerYear(),
                'payPerYear'=> $this::getPayPerYear(),
                'idYearEarnPay'=>$this::getIdYearEarnPay()
            ];
        }
    }
?>
