<?php 
Class IncomePerson implements JsonSerializable {

    protected  $idPerson;
    protected  $fullName;
    protected  $nameTypeOfArgi;
    protected  $nameArgi;
    protected  $totalIncomePerson;

    public function getIdPerson(){
        return $this->idPerson;
    }
    public function setIdPerson($idPerson){
         $this->idPerson=$idPerson;
    }

    public function getfullName(){
        return $this->fullName;
    }
    public function setfullName($fullName){
         $this->fullName=$fullName;
    }

    public function getNameTypeOfArgi(){
        return $this->nameTypeOfArgi;
    }
    public function setNameTypeOfArgi($nameTypeOfArgi){
         $this->nameTypeOfArgi=$nameTypeOfArgi;
    }

    public function getNameArgi(){
        return $this->nameArgi;
    }
    public function setNameArgi($nameArgi){
         $this->nameArgi=$nameArgi;
    }

    public function getTotalIncomePerson(){
        return $this->totalIncomePerson;
    }
    public function setTotalIncomePerson($totalIncomePerson){
         $this->totalIncomePerson=$totalIncomePerson;
    }
    public function jsonSerialize()
    {
        return 
        [
            'idPerson'=> $this::getIdPerson(),
            'fullName' => $this::getfullName(),
            'nameTypeOfArgi' => $this::getNameTypeOfArgi(),
            'nameArgi' => $this::getNameArgi(),
            'totalIncomePerson'=>$this::getTotalIncomePerson(),
        ];
    }

}
?>