<?php
Class OtherExpenseM implements JsonSerializable {

        protected	$expense_other_id;
        protected   $expense_detail;
        protected   $status;
        protected   $comment;
        protected  $institute_id;
        protected  $type;


    public function getExpenseOtherId(){
        return $this->expense_other_id;
    }
    public function setExpenseOtherId($expense_other_id){
         $this->expense_other_id=$expense_other_id;
    }
    public function getExpenseDetail(){
        return $this->expense_detail;
    }
    public function setExpenseDetail($expense_detail){
         $this->expense_detail=$expense_detail;
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
            'expense_other_id'=>$this::getExpenseOtherId(),
            'expense_detail'=>$this::getExpenseDetail(),
            'comment'=>$this::getComment(),
            'status'=>$this::getStatus(),
            'institute_id'=>$this::getInstituteId(),
            'type'=>$this::getType()
        ];
    }
}
?>
