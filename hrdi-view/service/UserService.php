<?php
    require_once '../connection/database.php';
    require_once '../model/UserM.php';

Class UserService {
    public function loadUserFromAD($Id){
        $sql = "SELECT frs_nam_tha, lst_nam_tha, usr, eml, pre_nam_id ";
        $sql.= "FROM vLoadDetailStaff ";
        $sql.= "WHERE emp_id = ?";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $UserM = new UserM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $UserM->setFirstname($row['frs_nam_tha']);
            $UserM->setLastname($row['lst_nam_tha']);
            $UserM->setUsername($row['usr']);
            $UserM->setEmail($row['eml']);
            $UserM->setPrefix($row['pre_nam_id']);
        }
        echo json_encode($UserM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }
    public function createNewUser($UserM){
        $sql = "INSERT INTO Staff (Prefix_idPrefix, staffFirstname, staffLastname, staffUsername, staffEmail, staffStatus, staffPermis, staffPassword)";
        $sql.= " VALUES ( ?, ?, ?, ?, ?, ?, ?, ?) SELECT SCOPE_IDENTITY() AS staff_id ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $UserM->getPrefix(),
            $UserM->getFirstname(),
            $UserM->getLastname(),
            $UserM->getUsername(),
            $UserM->getEmail(),
            $UserM->getStatus(),
            $UserM->getPermis(),
            $UserM->getPassword()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_next_result($stmt);  //note this line!!
        sqlsrv_fetch($stmt);
        $staffId = sqlsrv_get_field($stmt, 0);
        $UserM->setStaff_Id($staffId);
        sqlsrv_close($conn);
    }
    public function createUserAndArea($UserM){
        $sql = "INSERT INTO StaffArea (Staff_idStaff, Area_idArea)";
        $sql.= " VALUES ( ?, ?)";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $UserM->getStaff_Id(),
            $UserM->getArea_Id()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function loadUser($Id){
        $sql = "SELECT idStaff, Prefix_idPrefix, staffFirstname, staffLastname, staffLastname, staffUsername, staffEmail, staffStatus, staffPermis ";
        $sql.= "FROM Staff ";
        $sql.= "WHERE idStaff = ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $UserM = new UserM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $UserM->setStaff_Id($row['idStaff']);
            $UserM->setPrefix($row['Prefix_idPrefix']);
            $UserM->setFirstname($row['staffFirstname']);
            $UserM->setLastname($row['staffLastname']);
            $UserM->setUsername($row['staffUsername']);
            $UserM->setEmail($row['staffEmail']);
            $UserM->setStatus($row['staffStatus']);
            $UserM->setPermis($row['staffPermis']);
        }
        $sql2 = "SELECT Area_idArea ";
        $sql2.= "FROM StaffArea ";
        $sql2.= "WHERE Staff_idStaff = ?";
        $stmt2 = sqlsrv_prepare($conn, $sql2, array($Id));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $listArea = [];
        while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
            array_push($listArea, $row2['Area_idArea']);
        }
        $UserM->setArea_Id($listArea);
        echo json_encode($UserM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }
    public function userDetailUser($UserM) {
        if($UserM->getPassword() != null && $UserM->getPassword() != ''){
            $password = $UserM->getPassword();
        }
        $sql = "UPDATE Staff SET ";
        $sql.= "Prefix_idPrefix=?, staffFirstname=?, staffLastname=?, staffUsername=?, staffEmail=?, staffStatus=?, staffPermis=? ";
        $sql.= "WHERE idStaff = ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $UserM->getPrefix(),
            $UserM->getFirstname(),
            $UserM->getLastname(),
            $UserM->getUsername(),
            $UserM->getEmail(),
            $UserM->getStatus(),
            $UserM->getPermis(),
            $UserM->getStaff_Id()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function updateUserAndArea($staff_Id, $area_Id) {
        $sql = "SELECT TOP 1 *";
        $sql.= "FROM StaffArea ";
        $sql.= "WHERE Staff_idStaff='".$staff_Id."' and Area_idArea ='".$area_Id."'";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare( $conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows != true){
            $sql2 = "INSERT INTO StaffArea (Staff_idStaff, Area_idArea)";
            $sql2.= " VALUES ( ?, ?)";
            $db = new Database();
            $conn =  $db->getConnection();
            $stmt2 = sqlsrv_prepare($conn, $sql2, array(
                $staff_Id,
                $area_Id
            ));
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt2 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
    }
    public function deleteAreaFromUpdat($staff_Id, $areaList){
        $sql = "DELETE 
        FROM StaffArea 
        WHERE Area_idArea not in (".$areaList.") and Staff_idStaff = '".$staff_Id."'";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare( $conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function deleteUser($staff_Id){
        $sql = "DELETE 
        FROM StaffArea 
        WHERE Staff_idStaff = '".$staff_Id."'";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare( $conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $sql2 = "DELETE 
        FROM Staff 
        WHERE idStaff = '".$staff_Id."'";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_prepare( $conn, $sql2);
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
}


?>
