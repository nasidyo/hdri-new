<?php
Class PersonGroupM implements JsonSerializable {

        protected	$person_group_id;
        protected	$person_id;
        protected	$institute_id;
        protected	$year_register;
        protected	$position_id;
        protected	$sub_group_id;


        public function getPersonGroupId(){
            return $this->person_group_id;
        }
        public function setPersonGroupId($person_group_id){
             $this->person_group_id=$person_group_id;
        }

        public function getInstituteId(){
            return $this->institute_id;
        }
        public function setInstituteId($institute_id){
            $this->institute_id=$institute_id;
        }

        public function getPersonId(){
            return $this->person_id;
        }
        public function setPersonId($person_id){
            $this->person_id=$person_id;
        }
        public function getYearRegister(){
            return $this->year_register;
        }
        public function setYearRegister($year_register){
            $this->year_register=$year_register;
        }

        public function getPositionId(){
            return $this->position_id;
        }
        public function setPositionId($position_id){
            $this->position_id=$position_id;
        }
        public function getSubGroupId(){
            return $this->sub_group_id;
        }
        public function setSubGroupId($sub_group_id){
            $this->sub_group_id=$sub_group_id;
        }


    public function jsonSerialize()
    {
        return
        [
            'institute_id'=>$this::getInstituteId(),
            'person_group_id'=>$this::getPersonGroupId(),
            'person_id'=>$this::getPersonId(),
            'year_register'=>$this::getYearRegister(),
            'position_id'=>$this::getPositionId(),
            'sub_group_id'=>$this::getSubGroupId()
        ];
    }
}
?>
