<?php
    require_once '../connection/database.php';
    require_once '../model/SavingM.php';
    Class SavingService{
        public function addSaving($SavingM){
            $sql  =" INSERT INTO Saving ( saving_id, person_id, amount, create_date, sub_group_id ) VALUES ( ?, ?, ?, ?, ? ) ";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $SavingM->getSavingId(),
                $SavingM->getPersonId(),
                $SavingM->getAmount(),
                $SavingM->getCreateDate(),
                $SavingM->getSubGroupId()
            ));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);

         }

         public function updateSaving($SavingM){
            $sql  =" UPDATE Saving SET  person_id =? , amount = ?, create_date = getDate(), sub_group_id = ? WHERE saving_id = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $params =array(
                $SavingM->getPersonId(),
                $SavingM->getAmount(),

                $SavingM->getSubGroupId(),
                $SavingM->getSavingId()
            );
            $stmt = sqlsrv_prepare( $conn, $sql, $params);
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
         }

         public function loadSaving($Id){

            $sql  =" SELECT saving_id, person_id, amount, create_date, sub_group_id FROM Saving where saving_id = ? ";

            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array($Id));

            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $SavingM = new SavingM();
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $SavingM->setSavingId($row['saving_id']);
                $SavingM->setPersonId($row['person_id']);
                $SavingM->setAmount($row['amount']);
                $SavingM->setCreateDate($row['create_date']);
                $SavingM->setSubGroupId($row['sub_group_id']);

            }
            echo json_encode($SavingM,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            sqlsrv_close($conn);

     }


     public function loadSavingM($Id){
        $sql  =" SELECT saving_id, person_id, amount, create_date, sub_group_id FROM Saving where saving_id = ? ";

        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($Id));

        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $SavingM = new SavingM();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $SavingM->setSavingId($row['saving_id']);
            $SavingM->setPersonId($row['person_id']);
            $SavingM->setAmount($row['amount']);
            $SavingM->setCreateDate($row['create_date']);
            $SavingM->setSubGroupId($row['sub_group_id']);

        }
        sqlsrv_close($conn);
        return   $SavingM;
 }


 public function loadSavingByUser($Id){
    $sql  =" SELECT saving_id, person_id, amount, create_date, sub_group_id FROM Saving where person_id = ? order by create_date ";

    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql, array($Id));

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $SavingMList =[];
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        $SavingM = new SavingM();
        $SavingM->setSavingId($row['saving_id']);
        $SavingM->setPersonId($row['person_id']);
        $SavingM->setAmount($row['amount']);
        $SavingM->setCreateDate($row['create_date']);
        $SavingM->setSubGroupId($row['sub_group_id']);
        array_push($SavingMList , $SavingM );
    }
    sqlsrv_close($conn);
    return   $SavingMList;
}


public function delSavingByPerson($id){

    $sql  =" DELETE FROM Saving WHERE person_id = ? ";

    $db = new Database();
    $conn=  $db->getConnection();
    $stmt = sqlsrv_prepare($conn, $sql, array($id));

    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

 }

}


?>
