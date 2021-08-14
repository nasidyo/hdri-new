<?php
    Class InstituteM implements JsonSerializable {

        protected  $institute_id;
        protected  $institute_name;
        protected  $area_id;
        protected  $status;

        public function getInstituteId(){
            return $this->institute_id;
        }
        public function setInstituteId($institute_id){
             $this->institute_id=$institute_id;
        }

        public function getInstituteName(){
            return $this->institute_name;
        }
        public function setInstituteName($institute_name){
             $this->institute_name=$institute_name;
        }

        public function getAreaId(){
            return $this->area_id;
        }
        public function setAreaId($area_id){
             $this->area_id=$area_id;
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
                'institute_id'=> $this::getInstituteId(),
                'institute_name'=> $this::getInstituteName(),
                'area_id'=> $this::getAreaId(),
                'status'=> $this::getStatus()
            ];
        }
    }
?>
