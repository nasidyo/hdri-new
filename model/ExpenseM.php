<?php
Class ExpenseM implements JsonSerializable {
        protected	$expense_id;
        protected	$order_id;
        protected	$create_date;
        protected	$create_by;
        protected	$update_date;
        protected	$update_by;
        protected	$expense_by;
        protected	$customer;
        protected	$discount;
        protected	$amount;
        protected	$price;
        protected	$expense_other_id;
        protected	$debt;
        protected	$market_id;
        protected	$institute_id;
        protected   $expense_amount;
        protected   $expense_date;
        protected   $other_custoer;
        protected   $doc_no;
        protected   $order_name;
        protected   $expense_detail;
        protected   $canceled;
        protected   $comment;

        protected   $sub_group_id;
        protected   $business_group_id;


    public function getExpenseId(){
        return $this->expense_id;
    }
    public function setExpenseId($expense_id){
         $this->expense_id=$expense_id;
    }
    public function getOrderId(){
        return $this->order_id;
    }
    public function setOrderId($order_id){
         $this->order_id=$order_id;
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
    public function getUpdateDate(){
        return $this->update_date;
    }
    public function setUpdateDate($update_date){
         $this->update_date=$update_date;
    }
    public function getUpdateBy(){
        return $this->update_by;
    }
    public function setUpdateBy($update_by){
         $this->update_by=$update_by;
    }

    public function getExpenseBy(){
        return $this->expense_by;
    }
    public function setExpenseBy($expense_by){
         $this->expense_by=$expense_by;
    }

    public function getCustomer(){
        return $this->customer;
    }
    public function setCustomer($customer){
         $this->customer=$customer;
    }
    public function getDiscount(){
        return $this->discount;
    }
    public function setDiscount($discount){
         $this->discount=$discount;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function setAmount($amount){
         $this->amount=$amount;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
         $this->price=$price;
    }

    public function getExpenseOtherId(){
        return $this->expense_other_id;
    }
    public function setExpenseOtherId($expense_other_id){
         $this->expense_other_id=$expense_other_id;
    }
    public function getDebt(){
        return $this->debt;
    }
    public function setDebt($debt){
         $this->debt=$debt;
    }
    public function getMarketId(){
        return $this->market_id;
    }
    public function setMarketId($market_id){
         $this->market_id=$market_id;
    }
    public function getInstituteId(){
        return $this->institute_id;
    }
    public function setInstituteId($institute_id){
         $this->institute_id=$institute_id;
    }
    public function getExpenseAmount(){
        return $this->expense_amount;
    }
    public function setExpenseAmount($expense_amount){
         $this->expense_amount=$expense_amount;
    }
    public function getExpenseDate(){
        return $this->expense_date;
    }
    public function setExpenseDate($expense_date){
         $this->expense_date=$expense_date;
    }

    public function getOtherCustomer(){
        return $this->other_custoer;
    }
    public function setOtherCustomer($other_custoer){
         $this->other_custoer=$other_custoer;
    }

    public function getDocNo(){
        return $this->doc_no;
    }
    public function setDocNo($doc_no){
         $this->doc_no=$doc_no;
    }

    public function getOrderName(){
        return $this->order_name;
    }
    public function setOrderName($order_name){
         $this->order_name=$order_name;
    }

    public function getExpenseDetail(){
        return $this->expense_detail;
    }
    public function setExpenseDetail($expense_detail){
         $this->expense_detail=$expense_detail;
    }

    public function getCanceled(){
        return $this->canceled;
    }
    public function setCanceled($canceled){
         $this->canceled=$canceled;
    }
    public function getComment(){
        return $this->comment;
    }
    public function setComment($comment){
         $this->comment=$comment;
    }

    public function getSubGroupId(){
        return $this->sub_group_id;
    }
    public function setSubGroupId($sub_group_id){
         $this->sub_group_id=$sub_group_id;
    }
    public function getBusinessGroupId(){
        return $this->business_group_id;
    }
    public function setBusinessGroupId($business_group_id){
         $this->business_group_id=$business_group_id;
    }



    public function jsonSerialize()
    {
        return
        [
            'expense_id'=> $this::getExpenseId(),
            'order_id' => $this::getOrderId(),
            'create_date'=>$this::getCreateDate(),
            'create_by'=>$this::getCreateBy(),
            'update_date'=>$this::getUpdateDate(),
            'update_by'=>$this::getUpdateBy(),
            'expense_by'=>$this::getExpenseBy(),
            'customer'=>$this::getCustomer(),
            'discount'=>$this::getDiscount(),
            'amount'=>$this::getAmount(),
            'price'=>$this::getPrice(),
            'expense_other_id'=>$this::getExpenseOtherId(),
            'debt'=>$this::getDebt(),
            'market_id'=>$this::getMarketId(),
            'institute_id'=>$this::getInstituteId(),
            'expense_amount'=>$this::getExpenseAmount(),
            'expense_date'=>$this::getExpenseDate(),
            'other_customer'=>$this::getOtherCustomer(),
            'doc_no'=>$this::getDocNo(),
            'order_name'=>$this::getOrderName(),
            'expense_detail'=>$this::getExpenseDetail(),
            'comment'=>$this::getComment(),
            'canceled'=>$this::getCanceled(),
            'sub_group_id'=>$this::getSubGroupId(),
            'business_group_id'=>$this::getBusinessGroupId()
        ];
    }
}
?>
