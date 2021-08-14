
<?php 
require_once '../connection/database.php';
require '../service/SeqService.php';
require '../model/PlanM.php';
require '../service/date.php';

Class GradeProductService {
    public function createGradeProduct($gradeM){
        $sql = "
            INSERT INTO Grade
            (idGrade, codeGrade)
            VALUES (?, ?)
        ";
        $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $gradeM->getIdGrade(), $gradeM->getCodeGrade()
            ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    
    public function loadGradeProduct ($id){
        $sql = "SELECT * ";
        $sql.= "FROM Grade ";
        $sql.= "WHERE idGrade = ?";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $gradeM = new GradeM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $gradeM->setIdGrade($row['idGrade']);
            $gradeM->setCodeGrade($row['codeGrade']);
        }
        echo json_encode($gradeM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        sqlsrv_close($conn);
    }

    public function editGradeProduct($gradeM){
        $sql = "UPDATE Grade SET ";
        $sql.= "codeGrade=? ";
        $sql.= "WHERE idGrade = ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $gradeM->getCodeGrade(),
            $gradeM->getIdGrade(),
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function removeGradeItem($id){
        //start delete form deliver
        $sql1  =" DELETE FROM PersonMarket_TD WHERE Grade_codeGrade = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt1 = sqlsrv_prepare($conn, $sql1, array($id));
        if( !$stmt1 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt1 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        //end
        //start delete grade on list
        $sql2  =" DELETE FROM listGradeOfAgri WHERE grade_id = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_prepare($conn, $sql2, array($id));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        //end

        $sql3  =" DELETE FROM Grade WHERE idGrade = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_prepare($conn, $sql3, array($id));
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt3 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
}
?>