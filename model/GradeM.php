<?php 
Class GradeM implements JsonSerializable {

 
    protected $idGrade;
    protected $codeGrade;

    public function getIdGrade(){
        return $this->idGrade;
    }
    public function setIdGrade($idGrade){
         $this->idGrade=$idGrade;
    }
    public function getCodeGrade(){
        return $this->codeGrade;
    }
    public function setCodeGrade($codeGrade){
         $this->codeGrade=$codeGrade;
    }

    public function jsonSerialize()
    {
        return
        [
            'IdGrade'=> $this::getIdGrade(),
            'CodeGrade'=>$this::getCodeGrade()
        ];
    }
    
    
}
?>