<?php
Class DebtIncomeM implements JsonSerializable {
        protected	$debt_id;
        protected	$income_id;
        protected	$pay;
        protected	$create_date;
        protected	$create_by;
        protected	$customer;
        protected	$doc_no;
        protected	$status;
        protected	$attach;

    public function getIncomeId(){
        return $this->income_id;
    }
    public function setIncomeId($income_id){
            $this->income_id=$income_id;
    }
    public function getCreateDate(){
        return $this->create_date;
    }
    public function setCreateDate($create_date){
         $this->create_date=$create_date;
    }
    public function getCreateBy(){
        return $this->create_by;
    }
    public function setCreateBy($create_by){
         $this->create_by=$create_by;
    }
    public function getCustomer(){
        return $this->customer;
    }
    public function setCustomer($customer){
         $this->customer=$customer;
    }
    public function getPay(){
        return $this->pay;
    }
    public function setPay($pay){
         $this->pay=$pay;
    }
    public function getDebtId(){
        return $this->debt_id;
    }
    public function setDebtId($debt_id){
         $this->debt_id=$debt_id;
    }
    public function getDocNo(){
        return $this->doc_no;
    }
    public function setDocNo($doc_no){
         $this->doc_no=$doc_no;
    }

    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
         $this->status=$status;
    }

    public function getAttach(){
        return $this->attach;
    }
    public function setAttach($attach){
         $this->attach=$attach;
    }


    public function jsonSerialize()
    {
        return
        [
            'income_id'=> $this::getIncomeId(),
            'create_date'=>$this::getCreateDate(),
            'create_by'=>$this::getCreateBy(),
            'customer'=>$this::getCustomer(),
            'pay'=>$this::getPay(),
            'debt_id'=>$this::getDebtId(),
            'doc_no'=>$this::getDocNo(),
            'status'=>$this::getStatus(),
            'attach'=>$this::getAttach()
        ];
    }
}
?>
