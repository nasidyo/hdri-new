<?php 
Class AreaCountM implements JsonSerializable {

    protected  $idArea;
    protected  $areaName;
    protected  $all_member;
    protected  $not_member;
    protected  $member;

    public function getIdArea(){
        return $this->idArea;
    }
    public function setIdArea($idArea){
         $this->idArea=$idArea;
    }

    public function getAreaName(){
        return $this->areaName;
    }
    public function setAreaName($areaName){
         $this->areaName=$areaName;
    }

    public function getAllMember(){
        return $this->all_member;
    }
    public function setAllMember($all_member){
         $this->all_member=$all_member;
    }
    public function getMember(){
        return $this->member;
    }
    public function setMember($member){
         $this->member=$member;
    }
    public function jsonSerialize()
    {
        return 
        [
            'idArea'=> $this::getIdArea(),
            'areaName' => $this::getAreaName(),
            'all_member'=>$this::getAllMember(),
            'member'=>$this::getMember()
        ];
    }

}
?>