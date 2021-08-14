<?php 
    Class EstimateM implements JsonSerializable {
        protected $idOutputValue;
        protected $MonthNo;
        protected $WeekNo;
        protected $Weight;
        protected $Price;
        protected $total;

        public function getIdOutputValue(){
            return $this->idOutputValue;
        }
        public function setIdOutputValue($idOutputValue){
             $this->idOutputValue=$idOutputValue;
        }
        public function getIdMonth(){
            return $this->MonthNo;
        }
        public function setIdMonth($MonthNo){
             $this->MonthNo=$MonthNo;
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
            return $this->total;
        }
        public function setTotal($total){
             $this->total=$total;
        }
        public function getWeekNo(){
            return $this->WeekNo;
        }
        public function setWeekNo($WeekNo){
             $this->WeekNo=$WeekNo;
        }

        public function jsonSerialize(){
            return
            [
                'idOutputValue'=> $this::getIdOutputValue(),
                'MonthNo'=> $this::getIdMonth(),
                'idYears'=> $this::getIdYears(),
                'Weight'=> $this::getWeight(),
                'Price'=> $this::getPrice(),
                'Total'=> $this::getTotal()
            ];
        }
    }
?>