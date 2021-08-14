<?php
    Class SubPersonGroupM implements JsonSerializable {
        protected $sub_group_id;
        protected $sub_group_name;
        protected $institute_id;
        protected $status;


        public function getSubGroupId(){
            return $this->sub_group_id;
        }
        public function setSubGroupId($sub_group_id){
             $this->sub_group_id=$sub_group_id;
        }

        public function getSubGroupName(){
            return $this->sub_group_name;
        }
        public function setSubGroupName($sub_group_name){
             $this->sub_group_name=$sub_group_name;
        }

        public function getInstituteId(){
            return $this->institute_id;
        }
        public function setInstituteId($institute_id){
             $this->institute_id=$institute_id;
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
                'sub_group_name'=> $this::getSubGroupName(),
                'institute_id'=> $this::getInstituteId(),
                'status'=> $this::getStatus()

            ];
        }
    }
?>
