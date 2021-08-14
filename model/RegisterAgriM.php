<?php 
Class RegisterAgriM implements JsonSerializable {

    protected $regisAgri_id;
    protected $idPerson;
    protected $idAgri;
    protected $register_year;
    protected $idArea;
    protected $TypeOfArgi_idTypeOfArgi;


    
    public function getRegisAgri_id(){
        return $this->regisAgri_id;
    }
    public function setRegisAgri_id($regisAgri_id){
         $this->regisAgri_id=$regisAgri_id;
    }

    public function getIdPerson(){
        return $this->idPerson;
    }
    public function setIdPerson($idPerson){
         $this->idPerson=$idPerson;
    }

    public function getIdAgri(){
        return $this->idAgri;
    }
    public function setIdAgri($idAgri){
         $this->idAgri=$idAgri;
    }

    public function getRegister_year(){
        return $this->register_year;
    }
    public function setRegister_year($register_year){
         $this->register_year=$register_year;
    }

    public function getIdArea(){
        return $this->idArea;
    }
    public function setIdArea($idArea){
         $this->idArea=$idArea;
    }

    public function getTypeOfArgi_idTypeOfArgi(){
        return $this->TypeOfArgi_idTypeOfArgi;
    }
    public function setTypeOfArgi_idTypeOfArgi($TypeOfArgi_idTypeOfArgi){
         $this->TypeOfArgi_idTypeOfArgi=$TypeOfArgi_idTypeOfArgi;
    }


    public function jsonSerialize()
    {
        return 
        [
            'regisAgri_id'=> $this::getRegisAgri_id(),
            'idPerson'=>$this::getIdPerson(),
            'idAgri'=>$this::getIdAgri(),
            'register_year'=>$this::getRegister_year(),
            'idArea'=>$this::getIdArea(),
            'TypeOfArgi_idTypeOfArgi'=>$this::getTypeOfArgi_idTypeOfArgi()
        ];
    }
    
    
}
?>