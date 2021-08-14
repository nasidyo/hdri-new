<?php
Class OrgM implements JsonSerializable {


    protected $org_map_id;
    protected $account_year_id;
    protected $org_id;
    protected $person_id;


    public function getOrgMapId(){
        return $this->org_map_id;
    }
    public function setOrgMapId($org_map_id){
         $this->org_map_id=$org_map_id;
    }

    public function getAccountYearId(){
        return $this->account_year_id;
    }
    public function setAccountYearId($account_year_id){
         $this->account_year_id=$account_year_id;
    }


    public function getOrgId(){
        return $this->org_id;
    }
    public function setOrgId($org_id){
         $this->org_id=$org_id;
    }
    public function getPersonId(){
        return $this->person_id;
    }
    public function setPersonId($person_id){
         $this->person_id=$person_id;
    }

    public function jsonSerialize()
    {
        return
        [
            'org_map_id'=> $this::getOrgMapId(),
            'account_year_id'=>$this::getAccountYearId(),
            'org_id'=>$this::getOrgId(),
            'person_id'=>$this::getPersonId()
        ];
    }


}
?>
