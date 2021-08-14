<?php
Class IncomeM implements JsonSerializable {
        protected	$income_id;
        protected	$order_id;
        protected	$create_date;
        protected	$create_by;
        protected	$update_date;
        protected	$update_by;
        protected	$receive_by;
        protected	$customer;
        protected	$discount;
        protected	$amount;
        protected	$price;
        protected	$market_id;
        protected	$institute_id;
        protected	$debt;
        protected   $receive_date;
        protected   $other_custoer;
        protected   $doc_no;
        protected   $order_name;
        protected   $canceled;
        protected   $comment;
        protected   $receive_amount;
        protected   $income_other_id;
        protected   $sub_group_id;
        protected   $business_group_id;
        protected   $income_detail;
        

    public function getIncomeId(){
        return $this->income_id;
    }
    public function setIncomeId($income_id){
         $this->income_id=$income_id;
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

    public function getReceiveBy(){
        return $this->receive_by;
    }
    public function setReceiveBy($receive_by){
         $this->receive_by=$receive_by;
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

    public function getReceiveDate(){
        return $this->receive_date;
    }
    public function setReceiveDate($receive_date){
         $this->receive_date=$receive_date;
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

    public function getReceiveAmount(){
        return $this->receive_amount;
    }
    public function setReceiveAmount($receive_amount){
         $this->receive_amount=$receive_amount;
    }
    public function getIncomeOtherId(){
        return $this->income_other_id;
    }
    public function setIncomeOtherId($income_other_id){
         $this->income_other_id=$income_other_id;
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
    public function getIncomeDetail(){
        return $this->income_detail;
    }
    public function setIncomeDetail($income_detail){
         $this->income_detail=$income_detail;
    }
    

    
    public function jsonSerialize()
    {
        return
        [
            'income_id'=> $this::getIncomeId(),
            'order_id' => $this::getOrderId(),
            'create_date'=>$this::getCreateDate(),
            'create_by'=>$this::getCreateBy(),
            'update_date'=>$this::getUpdateDate(),
            'update_by'=>$this::getUpdateBy(),
            'receive_by'=>$this::getReceiveBy(),
            'customer'=>$this::getCustomer(),
            'discount'=>$this::getDiscount(),
            'amount'=>$this::getAmount(),
            'price'=>$this::getPrice(),
            'debt'=>$this::getDebt(),
            'market_id'=>$this::getMarketId(),
            'institute_id'=>$this::getInstituteId(),
            'receive_amount'=>$this::getReceiveAmount(),
            'receive_date'=>$this::getReceiveDate(),
            'other_customer'=>$this::getOtherCustomer(),
            'doc_no'=>$this::getDocNo(),
            'order_name'=>$this::getOrderName(),
            'comment'=>$this::getComment(),
            'canceled'=>$this::getCanceled(),
            'income_other_id'=>$this::getIncomeOtherId(),
            'sub_group_id'=>$this::getSubGroupId(),
            'business_group_id'=>$this::getBusinessGroupId(),
            'income_detail'=>$this::getIncomeDetail()
        ];
    }
}
?>
