<?php
Class PlantHouseM implements JsonSerializable {


    protected $plantHouse_Id;
    protected $Area_idArea;
    protected $idLand;
    protected $houseNumber;
    protected $idPerson;
    protected $idRiverBasin;


    public function getPlantHouseId(){
        return $this->plantHouse_Id;
    }
    public function setPlantHouseId($plantHouse_Id){
         $this->plantHouse_Id=$plantHouse_Id;
    }

    public function getAreaId(){
        return $this->Area_idArea;
    }
    public function setAreaId($Area_idArea){
         $this->Area_idArea=$Area_idArea;
    }

    public function getIdLand(){
        return $this->idLand;
    }
    public function setIdLand($idLand){
         $this->idLand=$idLand;
    }
    public function getHouseNumber(){
        return $this->houseNumber;
    }
    public function setHouseNumber($houseNumber){
         $this->houseNumber=$houseNumber;
    }

    public function getIdPerson(){
        return $this->idPerson;
    }
    public function setIdPerson($idPerson){
         $this->idPerson=$idPerson;
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
            'plantHouse_Id'=> $this::getPlantHouseId(),
            'Area_idArea'=>$this::getAreaId(),
            'idLand'=>$this::getIdLand(),
            'houseNumber'=>$this::getHouseNumber(),
            'idPerson'=>$this::getIdPerson(),
            'idRiverBasin'=>$this::getIdRiverBasin()
        ];
    }


}
?>
