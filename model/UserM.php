<?php 
Class UserM implements JsonSerializable {

    protected $staff_Id;
    protected $staffFirstname;
    protected $staffLastname;
    protected $staffUsername;
    protected $staffPassword;
    protected $staffEmail;
    protected $staffStatus;
    protected $staffPermis;
    protected $Prefix_idPrefix;

    protected $area_Id;

    public function getStaff_Id(){
        return $this->staff_Id;
    }
    public function setStaff_Id($staff_Id){
        $this->staff_Id = $staff_Id;
    }
    public function getFirstname(){
        return $this->staffFirstname;
    }
    public function setFirstname($staffFirstname){
        $this->staffFirstname = $staffFirstname;
    }
    public function getLastname(){
        return $this->staffLastname;
    }
    public function setLastname($staffLastname){
        $this->staffLastname = $staffLastname;
    }
    public function getUsername(){
        return $this->staffUsername;
    }
    public function setUsername($staffUsername){
        $this->staffUsername = $staffUsername;
    }
    public function getPassword(){
        return $this->staffPassword;
    }
    public function setPassword($staffPassword){
        $this->staffPassword = $staffPassword;
    }
    public function getEmail(){
        return $this->staffEmail;
    }
    public function setEmail($staffEmail){
        $this->staffEmail = $staffEmail;
    }
    public function getStatus(){
        return $this->staffStatus;
    }
    public function setStatus($staffStatus){
        $this->staffStatus = $staffStatus;
    }
    public function getPermis(){
        return $this->staffPermis;
    }
    public function setPermis($staffPermis){
        $this->staffPermis = $staffPermis;
    }
    public function getPrefix(){
        return $this->Prefix_idPrefix;
    }
    public function setPrefix($Prefix_idPrefix){
        $this->Prefix_idPrefix = $Prefix_idPrefix;
    }

    public function getArea_Id(){
        return $this->area_Id;
    }
    public function setArea_Id($area_Id){
        $this->area_Id = $area_Id;
    }

    public function jsonSerialize()
    {
        return
        [
            'staff_Id'=> $this::getStaff_Id(),
            'staffFirstname'=> $this::getFirstname(),
            'staffLastname'=> $this::getLastname(),
            'staffUsername'=> $this::getUsername(),
            'staffPassword'=> $this::getPassword(),
            'staffEmail'=> $this::getEmail(),
            'staffStatus'=> $this::getStatus(),
            'staffPermis'=> $this::getPermis(),
            'area_Id'=> $this::getArea_Id(),
            'Prefix_idPrefix'=> $this::getPrefix(),
        ];
    }

}
?>