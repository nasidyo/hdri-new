<?php
Class OtherIncomeM implements JsonSerializable {

        protected	$income_other_id;
        protected   $income_detail;
        protected   $status;
        protected   $comment;
        protected  $institute_id;
        protected  $type;


    public function getIncomeOtherId(){
        return $this->income_other_id;
    }
    public function setIncomeOtherId($income_other_id){
         $this->income_other_id=$income_other_id;
    }
    public function getIncomeDetail(){
        return $this->income_detail;
    }
    public function setIncomeDetail($income_detail){
         $this->income_detail=$income_detail;
    }
    public function getComment(){
        return $this->comment;
    }
    public function setComment($comment){
         $this->comment=$comment;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
         $this->status=$status;
    }
    public function getInstituteId(){
        return $this->institute_id;
    }
    public function setInstituteId($institute_id){
         $this->institute_id=$institute_id;
    }
    public function getType(){
        return $this->type;
    }
    public function setType($type){
         $this->type=$type;
    }

    public function jsonSerialize()
    {
        return
        [
            'income_other_id'=>$this::getIncomeOtherId(),
            'income_detail'=>$this::getIncomeDetail(),
            'comment'=>$this::getComment(),
            'status'=>$this::getStatus(),
            'institute_id'=>$this::getInstituteId(),
            'type'=>$this::getType()
        ];
    }
}
?>
