<?php
Class villageLevelM implements JsonSerializable {


    protected $list_vill_level_id;
    protected $idArea;
    protected $idGroupVillage;
    protected $level;
    protected $idRiverBasin;


    public function getVillageLevelId(){
        return $this->list_vill_level_id;
    }
    public function setVillageLevelId($list_vill_level_id){
         $this->list_vill_level_id=$list_vill_level_id;
    }

    public function getAreaId(){
        return $this->idArea;
    }
    public function setAreaId($idArea){
         $this->idArea=$idArea;
    }

    public function getGroupVillageId(){
        return $this->idGroupVillage;
    }
    public function setGroupVillageId($idGroupVillage){
         $this->idGroupVillage=$idGroupVillage;
    }
    public function getlevel(){
        return $this->level;
    }
    public function setlevel($level){
         $this->level=$level;
    }

    public function getIdRiverBasin(){
        return $this->idRiverBasin;
    }
    public function setIdRiverBasin($idRiverBasin){
         $this->idRiverBasin=$idRiverBasin;
    }


    public function jsonSerialize()
    {
        return
        [
            'list_vill_level_id'=> $this::getVillageLevelId(),
            'idArea'=>$this::getAreaId(),
            'idGroupVillage'=>$this::getGroupVillageId(),
            'level'=>$this::getlevel(),
            'idRiverBasin'=>$this::getIdRiverBasin()
        ];
    }


}
?>
