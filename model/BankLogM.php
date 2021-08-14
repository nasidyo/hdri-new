<?php
    Class BankLogM implements JsonSerializable {

        protected  $bank_account_id;
        protected  $bank_log_id;
        protected  $deposit;
        protected  $withdraw;
        protected  $create_date;
        protected  $create_by;



        public function getBankAccountId(){
            return $this->bank_account_id;
        }
        public function setBankAccountId($bank_account_id){
             $this->bank_account_id=$bank_account_id;
        }

        public function getBankLogId(){
            return $this->bank_log_id;
        }
        public function setBankLogId($bank_log_id){
             $this->bank_log_id=$bank_log_id;
        }

        public function getDeposit(){
            return $this->deposit;
        }
        public function setDeposit($deposit){
             $this->deposit=$deposit;
        }

        public function getWithdraw(){
            return $this->withdraw;
        }
        public function setWithdraw($withdraw){
             $this->withdraw=$withdraw;
        }

        public function getCreateDate(){
            return $this->create_date;
        }
        public function setCreateDate($create_date){
             $this->create_date=$create_date;
        }
        public function getCreateBy(){
            return $this->create_by;
        }
        public function setCreateBy($create_by){
             $this->create_by=$create_by;
        }

        public function jsonSerialize(){
            return
            [
                'bank_log_id'=> $this::getBankLogId(),
                'bank_account_id'=>$this::getBankAccountId(),
                'deposit'=>$this::getDeposit(),
                'withdraw'=>$this::getWithdraw(),
                'create_date'=>$this::getCreateDate(),
                'create_by'=>$this::getCreateBy()
            ];
        }
    }
?>
