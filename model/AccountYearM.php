<?php
    Class AccountYearM implements JsonSerializable {

        protected  $account_year_id;
        protected  $account_year_start;
        protected  $account_year_end;
        protected  $status;
        protected  $current_bugget;
        protected  $sub_group_id;
        protected  $bank_bugget;
        protected  $stocks_amount;
        protected  $stocks_price;
        protected  $year_text;




        public function getAccountYearId(){
            return $this->account_year_id;
        }
        public function setAccountYearId($account_year_id){
             $this->account_year_id=$account_year_id;
        }

        public function getAccountYearStart(){
            return $this->account_year_start;
        }
        public function setAccountYearStart($account_year_start){
             $this->account_year_start=$account_year_start;
        }

        public function getAccountYearEnd(){
            return $this->account_year_end;
        }
        public function setAccountYearEnd($account_year_end){
             $this->account_year_end=$account_year_end;
        }

        public function getCurrentBugget(){
            return $this->current_bugget;
        }
        public function setCurrentBugget($current_bugget){
             $this->current_bugget=$current_bugget;
        }

        public function getStatus(){
            return $this->status;
        }
        public function setStatus($status){
             $this->status=$status;
        }
        public function getSubGroupId(){
            return $this->sub_group_id;
        }
        public function setSubGroupId($sub_group_id){
             $this->sub_group_id=$sub_group_id;
        }

        public function getBankBugget(){
            return $this->bank_bugget;
        }
        public function setBankBugget($bank_bugget){
             $this->bank_bugget=$bank_bugget;
        }

        public function getStocksAmount(){
            return $this->stocks_amount;
        }
        public function setStocksAmount($stocks_amount){
             $this->stocks_amount=$stocks_amount;
        }

        public function getStocksPrice(){
            return $this->stocks_price;
        }
        public function setStocksPrice($stocks_price){
             $this->stocks_price=$stocks_price;
        }

        public function getYearText(){
            return $this->year_text;
        }
        public function setYearText($year_text){
             $this->year_text=$year_text;
        }

        public function jsonSerialize(){
            return
            [
                'status'=> $this::getStatus(),
                'sub_group_id'=>$this::getSubGroupId(),
                'account_year_id'=>$this::getAccountYearId(),
                'account_year_start'=>$this::getAccountYearStart(),
                'account_year_end'=>$this::getAccountYearEnd(),
                'current_bugget'=>$this::getCurrentBugget(),
                'bank_bugget'=>$this::getBankBugget(),
                'stocks_amount'=>$this::getStocksAmount(),
                'stocks_price'=>$this::getStocksPrice(),
                'year_text'=>$this::getYearText()

            ];
        }
    }
?>
