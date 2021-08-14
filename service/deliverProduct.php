
<?php 
require_once '../connection/database.php';
require '../model/deliverProductM.php';
require '../service/date.php';
require '../service/SeqService.php';

Class deliverProductService{
    public function createPersonDeliverProductMarket ($deliverProductM) {
        $sql  ="  SELECT Customer_idCustomer, Market_idMarket FROM CustomerMarket_TD where idCustomerMarket=?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
           // $deliverProductM->getIdCustomerMarket(), $deliverProductM->getIdArea()
           $deliverProductM->getIdCustomerMarket()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $deliverProductM->setIdCustomer($row['Customer_idCustomer']);
            $deliverProductM->setIdMarket($row['Market_idMarket']);
        }
        $sql2 = "
            INSERT INTO PersonMarket_TD
            (idPersonMarket, Person_idPerson, Market_idMarket, Grade_codeGrade, MonthNo, YearID, TypeOfArgi_idTypeOfArgi,
            Agri_idAgri, TypeOfStand_idTypeOfStand, Area_idArea, Customer_idCustomer, Value, TotalValue, Volumn,
            dateDeliver, land_detail_id, lossValue, species_Id, dateCultivate, dateHarvest)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt2 = sqlsrv_prepare($conn, $sql2, array(
            $deliverProductM->getIdPersonMarket(), $deliverProductM->getIdPerson(), $deliverProductM->getIdMarket(),
            $deliverProductM->getIdGardProduct(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears(),
            $deliverProductM->getIdTypeAgri(), $deliverProductM->getIdAgri(),
            $deliverProductM->getIdStandrdProduct(), $deliverProductM->getIdArea(), $deliverProductM->getIdCustomer(),
            $deliverProductM->getPrice(), $deliverProductM->getTotalPricre(), $deliverProductM->getQuality(), $deliverProductM->getDateDeliver(),
            $deliverProductM->getlandDetail(), $deliverProductM->getlossValue(), $deliverProductM->getSpeciesId(), $deliverProductM->getDateCultivate(), $deliverProductM->getDateHarvest()
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function updateStatusValue ($deliverProductM) {
        $sql  ="  SELECT idSendStatusValue, idSendStatus 
                FROM SendStatusValue_TD 
                where Area_idArea=? and MonthID= ? and YearID= ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getIdArea(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $idSendStatusValue  = $row['idSendStatusValue'];
            $idSendStatus = $row['idSendStatus'];
        }
        session_start();
        $date = new DateTime();
        $date->getTimestamp();
        $crateDate = $date->format('Y-m-d H:i:s');
        $idStaff = $_SESSION['idStaff'];
        // Update Status Plan
        if($idSendStatus == "" and $deliverProductM->getIdStatus() == "1"){
            $insertDate = $date;
            $insertBy = $idStaff;
            $sql  =" UPDATE SendStatusValue_TD SET ";
            $sql.="  DateInsert =?, InsertBy=?, idSendStatus=? where idSendStatusValue =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $insertDate, $insertBy, $deliverProductM->getIdStatus(), $idSendStatusValue
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }else if ($idSendStatus == "1" and $deliverProductM->getIdStatus() == "1"){
            $updateDate = $date;
            $updateBy = $idStaff;
            $sql  =" UPDATE SendStatusValue_TD SET ";
            $sql.="  DateUpdate =?, UpdateBy=?, idSendStatus=? where idSendStatusValue =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $updateDate, $updateBy, $deliverProductM->getIdStatus(), $idSendStatusValue
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }else if ($deliverProductM->getIdStatus() == "4"){
            $updateDate = $date;
            $updateBy = $idStaff;
            $sql  =" UPDATE SendStatusValue_TD SET ";
            $sql.="  DateUpdate =?, UpdateBy=?, idSendStatus=? where idSendStatusValue =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $insertDate, $insertBy, $deliverProductM->getIdStatus(), $idSendStatusValue
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            sqlsrv_close($conn);
        }
    }
    public function sendStatusValue ($deliverProductM) {
        $sql  ="  SELECT TOP 1 idSendStatusValue, idSendStatus 
                FROM SendStatusValue_TD 
                where Area_idArea=? and MonthID= ? and YearID= ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getIdArea(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $idSendStatusValue  = $row['idSendStatusValue'];
            $idSendStatus = $row['idSendStatus'];
        }
        session_start();
        $date = new DateTime();
        $date->getTimestamp();
        $crateDate = $date->format('Y-m-d H:i:s');
        $idStaff = $_SESSION['idStaff'];
        // Update Status Plan
        $sendDate = $date;
        $sendBy = $idStaff;
        $sql  =" UPDATE SendStatusValue_TD SET ";
        $sql.="  DateSend =?, SendBy=?, idSendStatus=? where idSendStatusValue =?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $sendDate, $sendBy, $deliverProductM->getIdStatus(), $idSendStatusValue
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function backtoEditStatus ($deliverProductM) {
        $sql  ="  SELECT TOP 1 idSendStatusValue, idSendStatus 
                FROM SendStatusValue_TD 
                where Area_idArea=? and MonthID= ? and YearID= ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getIdArea(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $idSendStatusValue  = $row['idSendStatusValue'];
            $idSendStatus = $row['idSendStatus'];
        }
        session_start();
        $date = new DateTime();
        $date->getTimestamp();
        $crateDate = $date->format('Y-m-d H:i:s');
        $idStaff = $_SESSION['idStaff'];
        // Update Status Plan
        $sql  =" UPDATE SendStatusValue_TD SET ";
        $sql.="  DateUpdate =?, UpdateBy=?, idSendStatus=? where idSendStatusValue =?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $date, $idStaff, $deliverProductM->getIdStatus(), $idSendStatusValue
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function confirmStatus ($deliverProductM) {
        $sql  ="  SELECT TOP 1 idSendStatusValue, idSendStatus 
                FROM SendStatusValue_TD 
                where Area_idArea=? and MonthID= ? and YearID= ?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getIdArea(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $idSendStatusValue  = $row['idSendStatusValue'];
            $idSendStatus = $row['idSendStatus'];
        }
        session_start();
        $date = new DateTime();
        $date->getTimestamp();
        $crateDate = $date->format('Y-m-d H:i:s');
        $idStaff = $_SESSION['idStaff'];
        $status = $deliverProductM->getIdStatus();
        // Update Status Plan
        if($status != '4'){
            $sql  =" UPDATE SendStatusValue_TD SET ";
            $sql.="  DateUpdate =?, UpdateBy=?, idSendStatus=? where idSendStatusValue =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $date, $idStaff, $status, $idSendStatusValue
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }else{
            $sql  =" UPDATE SendStatusValue_TD SET ";
            $sql.="  DateUpdate =?, DateSend=?,  UpdateBy=?,  SendBy=?, idSendStatus=? where idSendStatusValue =?";
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $date, $date, $idStaff, $idStaff,$status, $idSendStatusValue
            ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }

    }
    public function updateDeliverProduct ($deliverProductM) {
        // $sql  ="  SELECT Customer_idCustomer, Market_idMarket FROM CustomerMarket where idCustomerMarket=? and Area_idArea= ?";
        $sql  ="  SELECT Customer_idCustomer, Market_idMarket FROM CustomerMarket_TD where idCustomerMarket=?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            // $deliverProductM->getIdCustomerMarket(), $deliverProductM->getIdArea()
            $deliverProductM->getIdCustomerMarket()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $deliverProductM->setIdCustomer($row['Customer_idCustomer']);
            $deliverProductM->setIdMarket($row['Market_idMarket']);
        }
        $sql  ="UPDATE PersonMarket_TD SET ";
        $sql.="TypeOfArgi_idTypeOfArgi=?, Agri_idAgri=?, Market_idMarket=?, Customer_idCustomer=?, Value= ?, TotalValue=?, Volumn=?,";
        $sql.="Grade_codeGrade=?, TypeOfStand_idTypeOfStand=?, lossValue=?, dateCultivate=?, dateHarvest=?, onMB=? where idPersonMarket =?";
        $stmt2 = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getIdTypeAgri(), $deliverProductM->getIdAgri(), $deliverProductM->getIdMarket(), $deliverProductM->getIdCustomer(),
            $deliverProductM->getPrice(), $deliverProductM->getTotalPricre(), $deliverProductM->getQuality(),$deliverProductM->getIdGardProduct(),
            $deliverProductM->getIdStandrdProduct(), $deliverProductM->getlossValue(), $deliverProductM->getDateCultivate(), $deliverProductM->getDateHarvest(), null, $deliverProductM->getIdPersonMarket()
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function delDeliverProduct($idPersonMarket){
        $sql  =" DELETE FROM PersonMarket_TD WHERE idPersonMarket = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($idPersonMarket));
        
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function createNewPerson($deliverProductM){
        $sql = "
            INSERT INTO Person_TD
            (idPerson, Area_idArea, Prefix_idPrefix, firstName, lastName, idcard, phoneNumber, statusPerson)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getIdPerson(), $deliverProductM->getIdArea(), $deliverProductM->getPrefix_idPrefix(),
            $deliverProductM->getFirstName(), $deliverProductM->getLastName(), $deliverProductM->getIdcard(),
            $deliverProductM->getPhoneNumber(), $deliverProductM->getStatusPerson()
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function createUploadImage($imgUpload_Id, $targetFilePath, $newfilename, $typeOfUpload){
        $sql = "
            INSERT INTO ImgUpload_TD
            (idImgTD, ImgPath, ImgName, TypeGroupName)
            VALUES (?, ?, ?, ?)
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_prepare($conn, $sql, array(
            $imgUpload_Id, $targetFilePath, $newfilename, $typeOfUpload
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    } 
    public function createLogsitic($deliverProductM){
        $query = "INSERT INTO Logistic_TD (logistic_id, logistic_name) VALUES (?,?)";
        $db = new Database();
        $conn=  $db->getConnection();
        $resource=sqlsrv_prepare($conn, $query, array($deliverProductM->getlogisticId(),$deliverProductM->getlogisticDetail())); 
        if( !$resource ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $resource ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function createImageLogisticDeliverProduct($logisticId, $imageId, $seqPersonMarket, $isTemp){
        $query = "INSERT INTO LogisticDeliver_TD (idImgUpload, logistic_id, idPersonMarket, temp) VALUES (?, ?, ?, ?)";
        $db = new Database();
        $conn=  $db->getConnection();
        $resource=sqlsrv_prepare($conn, $query, array($imageId, $logisticId, $seqPersonMarket, $isTemp));
        if( !$resource ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $resource ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function updateLogisticDeliverProduct($logisticId, $seqPersonMarket, $isTemp){
        $sqlCheck ="
            SELECT * FROM LogisticDeliver_TD lgd
            WHERE lgd.idPersonMarket='".$seqPersonMarket."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sqlCheck);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt3 !== NULL) {
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows !== true){
                $sql = "
                    INSERT INTO LogisticDeliver_TD
                    (logistic_id, idPersonMarket, temp)
                    VALUES (?, ?, ?)
                ";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt2 = sqlsrv_prepare($conn, $sql, array(
                    $logisticId, $seqPersonMarket, $isTemp
                ));
                if( !$stmt2 ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt2 ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }else{
                $sql  =" UPDATE LogisticDeliver_TD SET ";
                $sql.=" logistic_id =? where idPersonMarket =?";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array( $logisticId, $seqPersonMarket));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }
        }
    }
    public function updateImageLogisticDeliverProduct($logisticId, $imageId, $seqPersonMarket){
        $sqlCheck ="
            SELECT * FROM LogisticDeliver_TD lgd
            WHERE lgd.idPersonMarket='".$seqPersonMarket."' and lgd.idImgUpload = '".$imageId."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sqlCheck);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt3 !== NULL) {
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows !== true){
                $this->createImageLogisticDeliverProduct($logisticId, $imageId, $seqPersonMarket, 'n');
            }else{
                $sql  =" UPDATE LogisticDeliver_TD SET ";
                $sql.="  idImgUpload =? where logistic_id =? and idPersonMarket =?";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array( $logisticId , $imageId, $seqPersonMarket));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }
        }
    }
    public function saveCopyDeliverProduct($deliverProductM, $oldDeliver) {
        $sqlCheck = "
                    SELECT TOP 1 pmk.Market_idMarket, pmk.Person_idPerson, pmk.Grade_codeGrade, pmk.TypeOfArgi_idTypeOfArgi,
                    pmk.Agri_idAgri, pmk.TypeOfStand_idTypeOfStand, pmk.Customer_idCustomer, pmk.land_detail_id, pmk.species_Id,
                    pmk.dateCultivate, pmk.dateHarvest 
                    FROM PersonMarket_TD pmk
                    WHERE pmk.idPersonMarket = '".$oldDeliver."'
                ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sqlCheck);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $sql2 = "
            INSERT INTO PersonMarket_TD
                (idPersonMarket, Person_idPerson, Market_idMarket, Grade_codeGrade, MonthNo, YearID, TypeOfArgi_idTypeOfArgi,
                Agri_idAgri, TypeOfStand_idTypeOfStand, Area_idArea, Customer_idCustomer, dateDeliver, land_detail_id, species_Id, dateCultivate, dateHarvest)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stmt2 = sqlsrv_prepare($conn, $sql2, array(
                $deliverProductM->getIdPersonMarket(), $row['Person_idPerson'], $row['Market_idMarket'],
                $row['Grade_codeGrade'], $deliverProductM->getIdMonth(), $deliverProductM->getIdYears(),
                $row['TypeOfArgi_idTypeOfArgi'], $row['Agri_idAgri'],
                $row['TypeOfStand_idTypeOfStand'], $deliverProductM->getIdArea(), $row['Customer_idCustomer'],
                $deliverProductM->getDateDeliver(), $row['land_detail_id'], $row['species_Id'], $row['dateCultivate'], $row['dateHarvest']
            ));
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt2 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
    }
    public function checkdeliverIncome($area_Id ,$yearsId ,$monthId) {
        $sql3 = "
            SELECT TOP 1 *
            FROM PersonMarket_TD
            WHERE Area_idArea = '".$area_Id."' and YearID = '".$yearsId."' and MonthNo = '".$monthId."' and (Volumn IS NULL or Value IS NULL )
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $resultCheck = null;
        if ($stmt3 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows === true){
                $resultCheck = '0';
            }else{
                $resultCheck = '1';
            }
        }
        echo (int)$resultCheck;
    }
    public function createNewMarket($marketId, $marketName){
        $query = "INSERT INTO Market_TD (idMarket, nameMarket) VALUES (?,?)";
        $db = new Database();
        $conn=  $db->getConnection();
        $resource=sqlsrv_prepare($conn, $query, array($marketId, $marketName)); 
        if( !$resource ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $resource ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        } 
    }
    public function createNewCustomer($customerName){
        $query = "INSERT INTO Customer_TD (c_name) VALUES (?)";
        $db = new Database();
        $conn=  $db->getConnection();
        $resource=sqlsrv_prepare($conn, $query, array($customerName)); 
        if( !$resource ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $resource ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        } 
    }

    public function deletImage($idImgUpload){
        $sql3 = "
            SELECT *
            FROM LogisticDeliver_TD
            WHERE idImgUpload = '".$idImgUpload."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt3 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows === true){
                $sql  =" DELETE FROM LogisticDeliver_TD WHERE idImgUpload = ? ";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array($idImgUpload));
                
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }else{
                return true;
            }
        }
    }
    public function createPersonDeliverProductMB ($deliverProductM) {
        $sql  ="  SELECT Customer_idCustomer, Market_idMarket FROM CustomerMarket_TD where idCustomerMarket=?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
           $deliverProductM->getIdCustomerMarket()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $deliverProductM->setIdCustomer($row['Customer_idCustomer']);
            $deliverProductM->setIdMarket($row['Market_idMarket']);
        }

        $sql2 = "
            INSERT INTO PersonMarket_TD
            (idPersonMarket, Person_idPerson, Market_idMarket, Grade_codeGrade, MonthNo, YearID, TypeOfArgi_idTypeOfArgi,
            Agri_idAgri, TypeOfStand_idTypeOfStand, Area_idArea, Customer_idCustomer, Value, TotalValue, Volumn,
            dateDeliver, land_detail_id, lossValue, onMB, species_Id, dateCultivate, dateHarvest)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt2 = sqlsrv_prepare($conn, $sql2, array(
            $deliverProductM->getIdPersonMarket(), $deliverProductM->getIdPerson(), $deliverProductM->getIdMarket(),
            $deliverProductM->getIdGardProduct(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears(),
            $deliverProductM->getIdTypeAgri(), $deliverProductM->getIdAgri(),
            $deliverProductM->getIdStandrdProduct(), $deliverProductM->getIdArea(), $deliverProductM->getIdCustomer(),
            $deliverProductM->getPrice(), $deliverProductM->getTotalPricre(), $deliverProductM->getQuality(), $deliverProductM->getDateDeliver(),
            $deliverProductM->getlandDetail(), $deliverProductM->getlossValue(), '1', $deliverProductM->getSpeciesId(), $deliverProductM->getDateCultivate(), $deliverProductM->getDateHarvest()
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function updateDeliverProductList ($deliverProductM) {
        $sql  ="UPDATE PersonMarket_TD SET ";
        $sql.="Value= ?, TotalValue=?, Volumn=? ";
        $sql.="where idPersonMarket =?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_prepare($conn, $sql, array(
            $deliverProductM->getPrice(), $deliverProductM->getTotalPricre(), $deliverProductM->getQuality(), $deliverProductM->getIdPersonMarket()
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function savePersonMarketToCart ($deliverProductM, $staffId) {
        $sql  ="  SELECT Customer_idCustomer, Market_idMarket FROM CustomerMarket_TD where idCustomerMarket=?";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
           $deliverProductM->getIdCustomerMarket()
        ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $deliverProductM->setIdCustomer($row['Customer_idCustomer']);
            $deliverProductM->setIdMarket($row['Market_idMarket']);
        }
        $sql2 = "
            INSERT INTO personMarketCart_TD
            (tempPersonMarket_Id, Person_idPerson, Market_idMarket, Grade_codeGrade, MonthNo, YearID, TypeOfArgi_idTypeOfArgi,
            Agri_idAgri, TypeOfStand_idTypeOfStand, Area_idArea, Customer_idCustomer, Value, TotalValue, Volumn,
            dateDeliver, land_detail_id, lossValue, species_Id, staff_Id, idCustomerMarket,  dateCultivate, dateHarvest)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt2 = sqlsrv_prepare($conn, $sql2, array(
            $deliverProductM->getIdPersonMarket(), $deliverProductM->getIdPerson(), $deliverProductM->getIdMarket(),
            $deliverProductM->getIdGardProduct(), $deliverProductM->getIdMonth(), $deliverProductM->getIdYears(),
            $deliverProductM->getIdTypeAgri(), $deliverProductM->getIdAgri(),
            $deliverProductM->getIdStandrdProduct(), $deliverProductM->getIdArea(), $deliverProductM->getIdCustomer(),
            $deliverProductM->getPrice(), $deliverProductM->getTotalPricre(), $deliverProductM->getQuality(), $deliverProductM->getDateDeliver(),
            $deliverProductM->getlandDetail(), $deliverProductM->getlossValue(), $deliverProductM->getSpeciesId(), $staffId, $deliverProductM->getIdCustomerMarket(),
            $deliverProductM->getDateCultivate(), $deliverProductM->getDateHarvest()
        ));
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt2 ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function deletItemInCart ($deliverCartId){
        $sql3 = "
            SELECT *
            FROM personMarketCart_TD
            WHERE tempPersonMarket_Id = '".$deliverCartId."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt3 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows === true){
                $sql  =" DELETE FROM personMarketCart_TD WHERE tempPersonMarket_Id = ? ";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array($deliverCartId));
                
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }else{
                return true;
            }
        }
    }
    public function loadDeliverCart ($yearsId, $monthId, $area_Id, $idStaff){
        $sql = "
            SELECT FORMAT(dateDeliver, 'dd-MM-yyyy', 'th') as dateDeliver, Agri_idAgri, Area_idArea, tempPersonMarket_Id, Grade_codeGrade, staff_Id, lossValue, idCustomerMarket, 
            MonthNo, Person_idPerson, Value, Volumn, species_Id, TypeOfStand_idTypeOfStand, TotalValue, Volumn, TypeOfArgi_idTypeOfArgi, YearID, FORMAT(dateCultivate, 'dd-MM-yyyy', 'th') as dateCultivate,
            FORMAT(dateHarvest, 'dd-MM-yyyy', 'th') as dateHarvest
            FROM personMarketCart_TD
            WHERE YearID = '".$yearsId."' and MonthNo = '".$monthId."' and Area_idArea = '".$area_Id."' and staff_Id = '".$idStaff."'
            ORDER BY tempPersonMarket_Id
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql);
        $data = array();
        $dataset = [];
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $sql2 = "
                SELECT lgsd.logisticImg_Id, lgsd.logistic_id, im.ImgPath, lgsd.idImgUpload
                FROM LogisticDeliver_TD lgsd
                INNER JOIN ImgUpload_TD im ON lgsd.idImgUpload = im.idImgTD
                WHERE lgsd.idPersonMarket = '".$row['tempPersonMarket_Id']."' and lgsd.temp = 'y'
            ";
            $stmt2 = sqlsrv_query( $conn, $sql2 );
            $row_array['logistic_Id'] = null;
            $row_array['listimage'] = [];
            $return_arr = array();
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                $row_array['logistic_Id'] = $row2['logistic_id'];
                $row_array2['parthImage'] = $row2['ImgPath'];
                $row_array2['idimage'] = $row2['idImgUpload'];
                array_push($return_arr, $row_array2);
                $row_array['listimage'] = $return_arr;
            }
            $row_array['agri_Id'] = $row['Agri_idAgri'];
            $row_array['area_Id'] = $row['Area_idArea'];
            $row_array['dataId'] = $row['tempPersonMarket_Id'];
            $row_array['dtp_input2'] = $row['dateDeliver'];
            $row_array['gardProduct'] = $row['Grade_codeGrade'];
            $row_array['idStaff'] = $row['staff_Id'];
            $row_array['lossValue'] = $row['lossValue'];
            $row_array['market_Id'] = $row['idCustomerMarket'];
            $row_array['monthId'] = $row['MonthNo'];
            $row_array['person_Id'] = $row['Person_idPerson'];
            $row_array['price'] = $row['Value'];
            $row_array['quality'] = $row['Volumn'];
            $row_array['speciesId'] = $row['species_Id'];
            $row_array['standardProduct'] = $row['TypeOfStand_idTypeOfStand'];
            $row_array['totalPricre'] = $row['TotalValue'];
            $row_array['totalQuality'] = $row['Volumn'];
            $row_array['typeAgri_Id'] = $row['TypeOfArgi_idTypeOfArgi'];
            $row_array['yearsId'] = $row['YearID'];
            $row_array['dtp_input3'] = $row['dateCultivate'];
            $row_array['dtp_input4'] = $row['dateHarvest'];
            array_push($dataset, $row_array);
        }
        sqlsrv_close($conn);
        echo json_encode($dataset,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function createAllInCart ($yearsId, $monthId, $area_Id, $idStaff) {
        $sql = "
            SELECT *
            FROM personMarketCart_TD
            WHERE YearID = '".$yearsId."' and MonthNo = '".$monthId."' and Area_idArea = '".$area_Id."' and staff_Id = '".$idStaff."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql);
        $data = array();
        $dataset = [];
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $seqService = new SeqService();
            $seqPersonMarketId = $seqService->get('idPersonMarket_seq');
            $sql2 = "
                INSERT INTO PersonMarket_TD
                (idPersonMarket, Person_idPerson, Market_idMarket, Grade_codeGrade, MonthNo, YearID, TypeOfArgi_idTypeOfArgi,
                Agri_idAgri, TypeOfStand_idTypeOfStand, Area_idArea, Customer_idCustomer, Value, TotalValue, Volumn,
                dateDeliver, land_detail_id, lossValue, species_Id, dateCultivate, dateHarvest)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stmt2 = sqlsrv_prepare($conn, $sql2, array(
                $seqPersonMarketId, $row['Person_idPerson'], $row['Market_idMarket'], $row["Grade_codeGrade"], $row["MonthNo"], $row["YearID"], $row["TypeOfArgi_idTypeOfArgi"],
                $row["Agri_idAgri"], $row["TypeOfStand_idTypeOfStand"], $row["Area_idArea"], $row["Customer_idCustomer"], $row["Value"], $row["TotalValue"], $row["Volumn"],
                $row["dateDeliver"], $row["land_detail_id"], $row["lossValue"], $row["species_Id"], $row["dateCultivate"], $row["dateHarvest"]
            ));
            if( !$stmt2 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt2 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $sql3  =" UPDATE LogisticDeliver_TD SET ";
            $sql3.="  idPersonMarket =?, temp=? where idPersonMarket =?";
            $stmt3 = sqlsrv_prepare($conn, $sql3, array(
                $seqPersonMarketId, 'n', $row["tempPersonMarket_Id"]
            ));
            if( !$stmt3 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt3 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }

            $sql4  =" DELETE FROM personMarketCart_TD WHERE tempPersonMarket_Id = ? ";
            $stmt4 = sqlsrv_prepare($conn, $sql4, array($row["tempPersonMarket_Id"]));
            if( !$stmt4 ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt4 ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
    }
    public function deleteAllItemsCart ($yearsId, $monthId, $area_Id, $idStaff) {
        $sql =" DELETE FROM personMarketCart_TD WHERE  YearID = ? and MonthNo = ? and Area_idArea = ? and staff_Id = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($yearsId, $monthId, $area_Id, $idStaff));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
}
?>