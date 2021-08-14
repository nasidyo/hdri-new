<?php 
Class LandM implements JsonSerializable {

    protected  $idLand;
    protected  $plots;
    protected  $rai;
    protected  $ngan;
    protected  $sqaure_wa;

    protected  $idRiverBasin;
    protected  $idArea;
    protected  $person_id;
    protected  $land_number;
    protected  $axisX;
    protected  $axisY;
    protected  $axisZ;
    protected  $unit1;
    protected  $unit2;
    protected  $unit3;
    protected  $unit4;

    public function getRiverBasin(){
        return $this->idRiverBasin;
    }
    public function setRiverBasin($idRiverBasin){
         $this->idRiverBasin=$idRiverBasin;
    }
    public function getidArea(){
        return $this->idArea;
    }
    public function setidArea($idArea){
         $this->idArea=$idArea;
    }
    public function getPerson_id(){
        return $this->person_id;
    }
    public function setPerson_id($person_id){
         $this->person_id=$person_id;
    }
    public function getLandnumber(){
        return $this->land_number;
    }
    public function setLandnumber($land_number){
         $this->land_number=$land_number;
    }
    public function getAxisX(){
        return $this->axisX;
    }
    public function setAxisX($axisX){
         $this->axisX=$axisX;
    }
    public function getAxisY(){
        return $this->axisY;
    }
    public function setAxisY($axisY){
         $this->axisY=$axisY;
    }
    public function getAxisZ(){
        return $this->axisZ;
    }
    public function setAxisZ($axisZ){
         $this->axisZ=$axisZ;
    }

    public function getUnit1(){
        return $this->unit1;
    }
    public function setUnit1($unit1){
         $this->unit1=$unit1;
    }
    public function getUnit2(){
        return $this->unit2;
    }
    public function setUnit2($unit2){
         $this->unit2=$unit2;
    }
    public function getUnit3(){
        return $this->unit3;
    }
    public function setUnit3($unit3){
         $this->unit3=$unit3;
    }
    public function getUnit4(){
        return $this->unit4;
    }
    public function setUnit4($unit4){
         $this->unit4=$unit4;
    }

    public function getIdLand(){
        return $this->idLand;
    }
    public function setIdLand($idLand){
         $this->idLand=$idLand;
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
            'idLand'=> $this::getIdLand(),
            'plots'=>$this::getPlots(),
            'rai'=>$this::getRai(),
            'ngan'=>$this::getNgan(),
            'sqaurewa'=>$this::getSqaureWa(),
            'idRiverBasin'=>$this::getRiverBasin(),
            'idArea'=>$this::getidArea(),
            'person_id'=>$this::getPerson_id(),
            'land_number'=>$this::getLandnumber(),
            'axisX'=>$this::getAxisX(),
            'axisY'=>$this::getAxisY(),
            'axisZ'=>$this::getAxisZ(),
            'unit1'=>$this::getUnit1(),
            'unit2'=>$this::getUnit2(),
            'unit3'=>$this::getUnit3(),
            'unit4'=>$this::getUnit4()
        ];
    }
    
    
}
?>