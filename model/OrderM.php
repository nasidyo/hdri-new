<?php
    Class OrderM implements JsonSerializable {

        protected  $order_id;
        protected  $order_name;
        protected  $status;
        protected  $comment;
        protected  $unit_id;
        protected  $balance;
        protected  $institute_id;
        protected  $area_id;
        protected   $sub_group_id;

        public function getInstituteId(){
            return $this->institute_id;
        }
        public function setInstituteId($institute_id){
             $this->institute_id=$institute_id;
        }
        public function getOrderId(){
            return $this->order_id;
        }
        public function setOrderId($order_id){
             $this->order_id=$order_id;
        }
        public function getOrderName(){
            return $this->order_name;
        }
        public function setOrderName($order_name){
             $this->order_name=$order_name;
        }


        public function getComment(){
            return $this->comment;
        }
        public function setComment($comment){
             $this->comment=$comment;
        }
        public function getUnitId(){
            return $this->unit_id;
        }
        public function setUnitId($unit_id){
             $this->unit_id=$unit_id;
        }
        public function getBalance(){
            return $this->balance;
        }
        public function setBalance($balance){
             $this->balance=$balance;
        }
        public function getStatus(){
            return $this->status;
        }
        public function setStatus($status){
             $this->status=$status;
        }

        public function getAreaId(){
            return $this->area_id;
        }
        public function setAreaId($area_id){
             $this->area_id=$area_id;
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
                'institute_id'=> $this::getInstituteId(),
                'order_id'=> $this::getOrderId(),
                'order_name' => $this::getOrderName(),
                'status'=> $this::getStatus(),
                'unit_id'=>$this::getUnitId(),
                'comment'=>$this::getComment(),
                'balance'=>$this::getBalance(),
                'sub_group_id'=>$this::getSubGroupId(),
                'area_id'=>$this::getAreaId()
            ];
        }
    }
?>
