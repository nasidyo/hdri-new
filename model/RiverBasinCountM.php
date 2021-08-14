<?php 
Class RiverBasinCountM implements JsonSerializable {

    protected  $idRiverBasin;
    protected  $nameRiverBasin;
    protected  $all_member;
    protected  $not_member;
    protected  $member;

    public function getIdRiverBasin(){
        return $this->idRiverBasin;
    }
    public function setIdRiverBasin($idRiverBasin){
         $this->idRiverBasin=$idRiverBasin;
    }

    public function getNameRiverBasin(){
        return $this->nameRiverBasin;
    }
    public function setNameRiverBasin($nameRiverBasin){
         $this->nameRiverBasin=$nameRiverBasin;
    }

    public function getAllMember(){
        return $this->all_member;
    }
    public function setAllMember($all_member){
         $this->all_member=$all_member;
    }

    public function getNotMember(){
        return $this->not_member;
    }
    public function setNotMember($not_member){
         $this->not_member=$not_member;
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
            'idRiverBasin'=> $this::getIdRiverBasin(),
            'nameRiverBasin' => $this::getNameRiverBasin(),
            'all_member'=>$this::getAllMember(),
            'not_member'=>$this::getNotMember(),
            'member'=>$this::getMember()
        ];
    }

}
?>