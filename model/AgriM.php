<?php 
Class AgriM implements JsonSerializable {

 
    protected $idAgri;
    protected $TypeOfArgi_idTypeOfArgi;
    protected $speciesArgi;
    protected $nameArgi;
    protected $idTypeOfStand;
    protected $contUnitId;
    protected $grade_Id;
    protected $basin_Id;
    protected $taget_unit;
    protected $unit_plan_id;

    protected $list_taget_agri_Id;
    protected $idArea;

    public function getIdAgri(){
        return $this->idAgri;
    }
    public function setIdAgri($idAgri){
         $this->idAgri=$idAgri;
    }
    public function getTypeOfArgi_idTypeOfArgi(){
        return $this->TypeOfArgi_idTypeOfArgi;
    }
    public function setTypeOfArgi_idTypeOfArgi($TypeOfArgi_idTypeOfArgi){
         $this->TypeOfArgi_idTypeOfArgi=$TypeOfArgi_idTypeOfArgi;
    }
    public function getNameArgi(){
        return $this->nameArgi;
    }
    public function setNameArgi($nameArgi){
         $this->nameArgi=$nameArgi;
    }
    public function getSpeciesArgi(){
        return $this->speciesArgi;
    }
    public function setSpeciesArgi($speciesArgi){
         $this->speciesArgi=$speciesArgi;
    }
    public function getTypeOfStandId(){
        return $this->idTypeOfStand;
    }
    public function setTypeOfStandId($idTypeOfStand){
         $this->idTypeOfStand=$idTypeOfStand;
    }
    public function getContUnitId(){
        return $this->contUnitId;
    }
    public function setContUnitId($contUnitId){
         $this->contUnitId=$contUnitId;
    }
    public function getListTagetId(){
        return $this->list_taget_agri_Id;
    }
    public function setListTagetId($list_taget_agri_Id){
         $this->list_taget_agri_Id=$list_taget_agri_Id;
    }
    public function getAreaId(){
        return $this->idArea;
    }
    public function setAreaId($idArea){
         $this->idArea=$idArea;
    }
    public function getGradeId(){
        return $this->grade_Id;
    }
    public function setGradeId($grade_Id){
         $this->grade_Id=$grade_Id;
    }
    public function getBasinId(){
        return $this->basin_Id;
    }
    public function setBasinId($basin_Id){
         $this->basin_Id=$basin_Id;
    }

    public function getTaget_unit(){
        return $this->taget_unit;
    }
    public function setTaget_unit($taget_unit){
         $this->taget_unit=$taget_unit;
    }
    public function getUnitplan_id_unit(){
        return $this->unit_plan_id;
    }
    public function setUnitplan_id($unit_plan_id){
         $this->unit_plan_id=$unit_plan_id;
    }
    
    
    
    public function jsonSerialize()
    {
        return 
        [
            'idAgri'=> $this::getIdAgri(),
            'TypeOfArgi_idTypeOfArgi'=>$this::getTypeOfArgi_idTypeOfArgi(),
            'nameArgi'=>$this::getNameArgi(),
            'speciesArgi'=>$this::getSpeciesArgi(),
            'idTypeOfStand'=>$this::getTypeOfStandId(),
            'contUnitId'=>$this::getContUnitId(),
            'basin_Id' =>$this::getBasinId(),


            'idArea' =>$this::getAreaId(),
            'grade_Id' =>$this::getGradeId(),
            'list_taget_agri_Id' =>$this::getListTagetId(),
            'taget_unit' =>$this::getTaget_unit(),
            'unit_plan_id' =>$this::getUnitplan_id_unit(),
        ];
    }
    
    
}
?>