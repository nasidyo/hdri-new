<?php
    Class BusinessGroupM implements JsonSerializable {

        protected $business_group_id;
        protected $business_group_name;
        protected $sub_group_id;
        protected $status;


        public function getBusinessGroupId(){
            return $this->business_group_id;
        }
        public function setBusinessGroupId($business_group_id){
             $this->business_group_id=$business_group_id;
        }

        public function getBusinessGroupName(){
            return $this->business_group_name;
        }
        public function setBusinessGroupName($business_group_name){
             $this->business_group_name=$business_group_name;
        }

        public function getSubGroupId(){
            return $this->sub_group_id;
        }
        public function setSubGroupId($sub_group_id){
             $this->sub_group_id=$sub_group_id;
        }

        public function getStatus(){
            return $this->status;
        }
        public function setStatus($status){
             $this->status=$status;
        }

        public function jsonSerialize(){
            return
            [
                'sub_group_id'=> $this::getSubGroupId(),
                'business_group_id'=> $this::getBusinessGroupId(),
                'business_group_name'=> $this::getBusinessGroupName(),
                'status'=> $this::getStatus()
            ];
        }
    }
?>
