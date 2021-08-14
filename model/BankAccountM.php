<?php
    Class BankAccountM implements JsonSerializable {

        protected  $bank_account_id;
        protected  $bank_no;
        protected  $bank_name;
        protected  $sub_group_id;
        protected  $status;

        public function getBankAccountId(){
            return $this->bank_account_id;
        }
        public function setBankAccountId($bank_account_id){
             $this->bank_account_id=$bank_account_id;
        }

        public function getBankNo(){
            return $this->bank_no;
        }
        public function setBankNo($bank_no){
             $this->bank_no=$bank_no;
        }

        public function getBankName(){
            return $this->bank_name;
        }
        public function setBankName($bank_name){
             $this->bank_name=$bank_name;
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

        public function jsonSerialize(){
            return
            [
                'bank_account_id'=>$this::getBankAccountId(),
                'bank_no'=>$this::getBankNo(),
                'bank_name'=>$this::getBankName(),
                'status'=> $this::getStatus(),
                'sub_group_id'=>$this::getSubGroupId()
            ];
        }
    }
?>
