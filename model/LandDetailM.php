<?php 
Class LandDetailM implements JsonSerializable {

    protected  $land_detail_id;
    protected  $person_id;
    protected  $land_no;
    protected  $x;
    protected  $y;
    protected  $z;
    protected  $basin_quality_class;
    protected  $forest_area_classified;
    protected  $forest_type;
    protected  $forest_name;
    protected  $plots;
    protected  $rai;
    protected  $ngan;
    protected  $sqaure_wa;

    public function getLandDetailId(){
        return $this->land_detail_id;
    }
    public function setLandDetailId($land_detail_id){
         $this->land_detail_id=$land_detail_id;
    }

    public function getPersonId(){
        return $this->person_id;
    }
    public function setPersonId($person_id){
         $this->person_id=$person_id;
    }

    public function getLandNo(){
        return $this->land_no;
    }
    public function setLandNo($land_no){
         $this->land_no=$land_no;
    }

    public function getX(){
        return $this->x;
    }
    public function setX($x){
         $this->x=$x;
    }

    public function getY(){
        return $this->y;
    }
    public function setY($y){
         $this->y=$y;
    }

    public function getZ(){
        return $this->z;
    }
    public function setZ($z){
         $this->z=$z;
    }

    public function getBasinQualityClass(){
        return $this->basin_quality_class;
    }
    public function setBasinQualityClass($basin_quality_class){
         $this->basin_quality_class=$basin_quality_class;
    }

    public function getForestAreaClassified(){
        return $this->forest_area_classified;
    }
    public function setForestAreaClassified($forest_area_classified){
         $this->forest_area_classified=$forest_area_classified;
    }

    public function getForestType(){
        return $this->forest_type;
    }
    public function setForestType($forest_type){
         $this->forest_type=$forest_type;
    }

    public function getForestName(){
        return $this->forest_name;
    }
    public function setForestName($forest_name){
         $this->forest_name=$forest_name;
    }

    public function getPlots(){
        return $this->plots;
    }
    public function setPlots($plots){
         $this->plots=$plots;
    }

    public function getRai(){
        return $this->rai;
    }
    public function setRai($rai){
         $this->rai=$rai;
    }

    public function getNgan(){
        return $this->ngan;
    }
    public function setNgan($ngan){
         $this->ngan=$ngan;
    }

    public function getSqaureWa(){
        return $this->sqaure_wa;
    }
    public function setSqaureWa($sqaure_wa){
         $this->sqaure_wa=$sqaure_wa;
    }


    public function jsonSerialize()
    {
        return 
        [
            'land_detail_id'=>$this::getLandDetailId(),
            'person_id'=>$this::getPersonId(),
            'land_no'=>$this::getLandNo(),
            'x'=>$this::getX(),
            'y'=>$this::getY(),
            'z'=>$this::getZ(),
            'basin_quality_class'=>$this::getBasinQualityClass(),
            'forest_area_classified'=>$this::getForestAreaClassified(),
            'forest_type'=>$this::getForestType(),
            'forest_name'=>$this::getForestName(),
            'plots'=>$this::getPlots(),
            'rai'=>$this::getRai(),
            'ngan'=>$this::getNgan(),
            'sqaurewa'=>$this::getSqaureWa()
        ];
    }
    
    
}
?>