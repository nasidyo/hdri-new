<?php
    Class SavingM implements JsonSerializable {

        protected  $saving_id;
        protected  $person_id;
        protected  $amount;
        protected  $create_date;
        protected  $sub_group_id;

        public function getSavingId(){
            return $this->saving_id;
        }
        public function setSavingId($saving_id){
             $this->saving_id=$saving_id;
        }

        public function getPersonId(){
            return $this->person_id;
        }
        public function setPersonId($person_id){
             $this->person_id=$person_id;
        }

        public function getAmount(){
            return $this->amount;
        }
        public function setAmount($amount){
             $this->amount=$amount;
        }

        public function getCreateDate(){
            return $this->create_date;
        }
        public function setCreateDate($create_date){
             $this->create_date=$create_date;
        }

        public function setSubGroupId($sub_group_id){
             $this->sub_group_id=$sub_group_id;
        }
        public function getSubGroupId(){
            return $this->sub_group_id;
        }


        public function jsonSerialize(){
            return
            [
                'saving_id'=> $this::getSavingId(),
                'person_id'=>$this::getPersonId(),
                'amount'=>$this::getAmount(),
                'create_date'=>$this::getCreateDate(),
                'sub_group_id'=>$this::getSubGroupId()
            ];
        }
    }
?>
