<?php
    Class CustomerM implements JsonSerializable {

        protected  $customer_id;
        protected  $name;
        protected  $sname;
        protected  $status;
        protected  $address;
        protected  $phone;
        protected  $comment;


        public function getCustomerId(){
            return $this->customer_id;
        }
        public function setCustomerId($customer_id){
             $this->customer_id=$customer_id;
        }
        public function getName(){
            return $this->name;
        }
        public function setName($name){
             $this->name=$name;
        }

        public function getSname(){
            return $this->sname;
        }
        public function setSname($sname){
             $this->sname=$sname;
        }
        public function getStatus(){
            return $this->status;
        }
        public function setStatus($status){
             $this->status=$status;
        }
        public function getAddress(){
            return $this->address;
        }
        public function setAddress($address){
             $this->address=$address;
        }
        public function getPhone(){
            return $this->phone;
        }
        public function setPhone($phone){
             $this->phone=$phone;
        }

        public function getComment(){
            return $this->comment;
        }
        public function setComment($comment){
             $this->comment=$comment;
        }



        public function jsonSerialize(){
            return
            [
                'customer_id'=> $this::getCustomerId(),
                'name'=> $this::getName(),
                'sname'=> $this::getSname(),
                'status'=> $this::getStatus(),
                'address'=> $this::getAddress(),
                'phone'=> $this::getPhone(),
                'comment'=> $this::getComment()

            ];
        }
    }
?>
