<?php 
Class ArgiM implements JsonSerializable {

 
    protected $idAgri;
    protected $TypeOfArgi_idTypeOfArgi;
    protected $nameArgi;

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



  

    public function jsonSerialize()
    {
        return 
        [
            'idAgri'=> $this::getIdAgri(),
            'TypeOfArgi_idTypeOfArgi'=>$this::getTypeOfArgi_idTypeOfArgi(),
            'nameArgi'=>$this::getNameArgi()
        ];
    }
    
    
}
?>