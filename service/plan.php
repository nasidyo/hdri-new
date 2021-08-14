
<?php 
require_once '../connection/database.php';
require '../service/SeqService.php';
require '../model/PlanM.php';
require '../service/date.php';

Class TargetPlanService{
    public function crateTargetPlan($planM){
        $sql = "
            INSERT INTO TargetPlan_TD
            (idTargetPlan, YearTarget_YearID, TypeOfArgi_idTypeOfArgi, Area_idArea,
            Agri_idAgri, Weight, Price, Total, market_id, month_id, species_Id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $planM->getIdTargetPlan(), $planM->getIdYears(), $planM->getIdTypeOfArgi(),
                $planM->getIdArea(), $planM->getIdAgri(), $planM->getWeight(), $planM->getPrice(),
                $planM->getTotal(), $planM->getMarketId(), $planM->getMonthId(), $planM->getSpeciesId()
            ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function crateTargetPlanHeader($planM){
        $sql2 = "
            SELECT *
            FROM TargetPlan_TD
            WHERE Area_idArea ='".$planM->getIdArea()."' and YearTarget_YearID = '".$planM->getIdYears()."'
            and Agri_idAgri='".$planM->getIdAgri()."' and TypeOfArgi_idTypeOfArgi='".$planM->getIdTypeOfArgi()."'
        ";
        // echo $sql2;
        $db = new Database();
        $conn =  $db->getConnection();
        $checkHeaderTargetPlan = sqlsrv_query($conn, $sql2);
        echo $checkHeaderTargetPlan;
        if ($checkHeaderTargetPlan === true) {
            //There are rows
            while ($row = sqlsrv_fetch_array($checkHeaderTargetPlan, SQLSRV_FETCH_ASSOC)) {
                $idTargetPlan = $row['idTargetPlan'];
            }
            $planM->setIdTargetPlanRef($idTargetPlan);
        }else {
            //There are no rows
            $sql = "
            INSERT INTO TargetPlan_TD
            (idTargetPlan, YearTarget_YearID, TypeOfArgi_idTypeOfArgi, Area_idArea,
            Agri_idAgri)
            VALUES (?, ?, ?, ?, ?)
            ";
            $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array(
                    $planM->getIdTargetPlan(), $planM->getIdYears(), $planM->getIdTypeOfArgi(),
                    $planM->getIdArea(), $planM->getIdAgri()
                ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            $planM->setIdTargetPlanRef($planM->getIdTargetPlan());
        }
    }
    public function updateTargetPlan($planM){
        $sql  =" UPDATE TargetPlan_TD SET ";
        $sql.="  Weight =? , Price=?, Total=? where idTargetPlan =? ";
        $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $planM->getWeight(), $planM->getPrice(), $planM->getTotal(), $planM->getIdTargetPlan()
            ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }
    public function deleteTargetPlan($traget_Id){
        $sql  =" DELETE FROM TargetPlan_TD WHERE idTargetPlan = ? ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array($traget_Id));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $sql2 = "
            SELECT * 
            FROM OutputValue_TD 
            WHERE TargetPlan_idTargetPlan = ?
        ";
        $db2 = new Database();
        $conn2 =  $db2->getConnection();
        $listTargetPlan = sqlsrv_prepare($conn2, $sql2, array($traget_Id));
        if( !$listTargetPlan ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($listTargetPlan !== NULL) {  
            $rows = sqlsrv_has_rows($listTargetPlan);
            echo "\nthere are rows\n".$rows;
            if ($rows === true){
                while( $row3 = sqlsrv_fetch_array( $listTargetPlan, SQLSRV_FETCH_ASSOC) ) {
                    $sql3  =" DELETE FROM OutputValueCast_TD WHERE idOutputValue = ? ";
                    $db = new Database();
                    $conn=  $db->getConnection();
                    $stmt3 = sqlsrv_prepare($conn, $sql3, array($row3['idOutputValue']));
                    if( !$stmt3 ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt3 ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                }

                $sql4  =" DELETE FROM OutputValue_TD WHERE TargetPlan_idTargetPlan = ? ";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt4 = sqlsrv_prepare($conn, $sql4, array($traget_Id));
                if( !$stmt4 ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt4 ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }
        }
    }
    public function sendPlanOfyears($planM){
        session_start();
        $date = new DateTime();
        $date->getTimestamp();
        $crateDate = $date->format('Y-m-d H:i:s');
        $idStaff = $_SESSION['idStaff'];
        // Start Create Status Plan
        $sql = "
                INSERT INTO SendStatusPlan_TD
                (idSendStatusPlan, DateInsert,
                idStatusPlan, Area_idArea, YearID, InsertBy)
                VALUES (?, ?, ?, ?, ?, ?)
            ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_prepare($conn, $sql, array(
            $planM->getIdSendStatusPlan(), $crateDate, $planM->getStatusTypeId(),
            $planM->getIdArea(), $planM->getIdYears(), $idStaff
        ));
        echo $stmt;
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        sqlsrv_close($conn);
    }

    public function updatePlanOfyears($planM){
        session_start();
        $date = new DateTime();
        $date->getTimestamp();
        $crateDate = $date->format('Y-m-d H:i:s');
        $idStaff = $_SESSION['idStaff'];
        $statusId = $planM->getStatusTypeId();
        if($statusId == "2"){
            $sql  =" UPDATE SendStatusPlan_TD SET ";
            $sql.="  DateSend=?, SendBy=?, idStatusPlan=? where YearID =? and Area_idArea =?";
            $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array(
                    $date, $idStaff, $planM->getStatusTypeId(), $planM->getIdYears(), $planM->getIdArea()
                ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }else if($statusId == "4"){
            $sql  =" UPDATE SendStatusPlan_TD SET ";
            $sql.="  DateSend=?, SendBy=?, idStatusPlan=? where YearID =? and Area_idArea =?";
            $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array(
                    $date, $idStaff, $planM->getStatusTypeId(), $planM->getIdYears(), $planM->getIdArea()
                ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }else if ($statusId == "1" || $statusId == "3"){
            $sql  =" UPDATE SendStatusPlan_TD SET ";
            $sql.="  DateUpdate=?, UpdateBy=?, idStatusPlan=? where YearID =? and Area_idArea =?";
            $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array(
                    $date, $idStaff, $planM->getStatusTypeId(), $planM->getIdYears(), $planM->getIdArea()
                ));
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
            }
            if( sqlsrv_execute( $stmt ) === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
        }
        // Update Status Plan
        sqlsrv_close($conn);
    }

    public function sendOutputValue($planM){
        $sql2 = "
            SELECT SUM(tp.Weight) as weight, tp.Price, SUM(tp.Total) as total, tp.Agri_idAgri, tp.month_id, cm.Market_idMarket, tp.species_Id 
            FROM TargetPlan_TD tp
            LEFT JOIN CustomerMarket_TD cm ON tp.market_id = cm.idCustomerMarket
            WHERE tp.Area_idArea ='".$planM->getIdArea()."' and tp.YearTarget_YearID = '".$planM->getIdYears()."'
            GROUP BY tp.Agri_idAgri, tp.TypeOfArgi_idTypeOfArgi, tp.Price, tp.month_id, cm.Market_idMarket, tp.species_Id 
        ";
        $db2 = new Database();
        $conn2 =  $db2->getConnection();
        $listTargetPlan = sqlsrv_prepare($conn2, $sql2);
        if( !$listTargetPlan ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $listTargetPlan ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $listTargetPlan, SQLSRV_FETCH_ASSOC) ) {
            echo "row Agri_idAgri ::".$row['Agri_idAgri']."<br/>";
            if($row['month_id'] != null){
                $dateService = new DateService();
                $years = $planM->getIdYears();
                if($row['month_id'] >= '8'){
                    $years = $years-1;
                }
                $weeknumber = $dateService->getWeeks($row['month_id'], ($years - 543));
                echo "getIdYears ::".$years."<br/>";
                echo "week ::".$weeknumber."<br/>";
                echo "idMarket ::".$row['Market_idMarket']."<br/>";
                //CHECK OPUTVALUE_TD 
                $checkSql = "
                    SELECT *
                    FROM OutputValue_TD
                    WHERE MonthNo ='".$row['month_id']."' and Agri_idAgri = '".$row['Agri_idAgri']."' and species_Id = '".$row['species_Id']."'
                    and Year_id='".$planM->getIdYears()."' and Area_id='".$planM->getIdArea()."' and Market_idMarket = '".$row['Market_idMarket']."'
                ";
                $db = new Database();
                $conn=  $db->getConnection();
                $checkOutValue = sqlsrv_query($conn, $checkSql);
                if( !$checkOutValue ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if ($checkOutValue !== NULL) {
                    $rows = sqlsrv_has_rows($checkOutValue);
                    if ($rows !== true){
                        $seqService = new SeqService();
                        $seqOutputValue = $seqService->get('idOutputValue_seq');
                        $planM->setIdOutputValue($seqOutputValue);
                        echo "1234";
                        $insert = "
                            INSERT INTO OutputValue_TD
                            (idOutputValue, MonthNo, Agri_idAgri,
                            weight, Price, Year_id, Area_id, Market_idMarket, Total, species_Id)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ";
                        $db3 = new Database();
                        $conn3 =  $db3->getConnection();
                        $createOutputValue = sqlsrv_prepare($conn3, $insert, array(
                            $planM->getIdOutputValue(), $row['month_id'], $row['Agri_idAgri'],
                            ceil(sprintf("%.2f",$row['weight'])), ceil(sprintf("%.2f",$row['Price'])), $planM->getIdYears(),
                            $planM->getIdArea(), $row['Market_idMarket'], ceil(sprintf("%.2f",$row['weight'])*sprintf("%.2f",$row['Price'])), $row['species_Id'] 
                        ));
                        if( !$createOutputValue ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        if( sqlsrv_execute( $createOutputValue ) === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        sqlsrv_close($conn3);
                        $weightOnWeek = (float)round($row['weight']/$weeknumber,2);
                        $countWeek = 1;
                        while ($countWeek <= $weeknumber){
                            echo $countWeek."<br/>";
                            echo "5678";
                            $inserts = "
                                INSERT INTO OutputValueCast_TD
                                (idOutputValue, MonthNo, Agri_idAgri,
                                Weight, Price, Total, Week, species_Id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                            ";
                            $db4 = new Database();
                            $conn4 =  $db4->getConnection();
                            $createOutputValueCast = sqlsrv_prepare($conn4, $inserts, array(
                                $planM->getIdOutputValue(), $row['month_id'], $row['Agri_idAgri'],
                                $weightOnWeek, (float)round(ceil(sprintf("%.2f",$row['Price'])),2), (float)round(ceil($weightOnWeek*sprintf("%.2f",$row['Price'])),2), $countWeek, $row['species_Id']
                            ));
                            if( !$createOutputValueCast ) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            if( sqlsrv_execute( $createOutputValueCast ) === false ) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            echo "999999999";
                            $countWeek++;
                            sqlsrv_close($conn4);
                        }
                    }
                }
            }
        }
    }

    public function sendOutputValueN ($planM){
        $sql2 = "
            SELECT tp.idTargetPlan, SUM(tp.Weight) as weight, tp.Price, SUM(tp.Total) as total, tp.Agri_idAgri, tp.month_id, cm.Market_idMarket,
            tp.market_id, tp.species_Id 
            FROM TargetPlan_TD tp 
            LEFT JOIN CustomerMarket_TD cm ON tp.market_id = cm.idCustomerMarket
            WHERE tp.Area_idArea ='".$planM->getIdArea()."' and tp.YearTarget_YearID = '".$planM->getIdYears()."'
            GROUP BY tp.idTargetPlan, tp.Agri_idAgri, tp.TypeOfArgi_idTypeOfArgi, tp.Price, tp.month_id, cm.Market_idMarket, market_id, tp.species_Id 
        ";
        echo "11111sendOutputValue111111";
        echo "11111sendOutputValue111111".$planM->getIdArea();
        echo "11111sendOutputValue111111".$planM->getIdYears();
        $db2 = new Database();
        $conn2 =  $db2->getConnection();
        $listTargetPlan = sqlsrv_prepare($conn2, $sql2);
        if( !$listTargetPlan ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $listTargetPlan ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $listTargetPlan, SQLSRV_FETCH_ASSOC) ) {
            echo "row Agri_idAgri ::".$row['Agri_idAgri']."<br/>";
            if($row['month_id'] != null){
                $dateService = new DateService();
                $years = $planM->getIdYears();
                if($row['month_id'] >= '8'){
                    $years = $years-1;
                }
                $weeknumber = $dateService->getWeeks($row['month_id'], ($years - 543));
                echo "getIdYears ::".$years."<br/>";
                echo "week ::".$weeknumber."<br/>";
                echo "idMarket ::".$row['Market_idMarket']."<br/>";
                //CHECK OPUTVALUE_TD 
                $checkSql = "
                    SELECT *
                    FROM OutputValue_TD
                    WHERE MonthNo ='".$row['month_id']."' and Agri_idAgri = '".$row['Agri_idAgri']."' and TargetPlan_idTargetPlan ='".$row['idTargetPlan']."'
                    and Year_id='".$planM->getIdYears()."' and Area_id='".$planM->getIdArea()."' and Market_idMarket = '".$row['Market_idMarket']."' and species_Id = '".$row['species_Id']."'
                ";
                $db = new Database();
                $conn=  $db->getConnection();
                $checkOutValue = sqlsrv_query($conn, $checkSql);
                if( !$checkOutValue ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if ($checkOutValue !== NULL) {
                    $rows = sqlsrv_has_rows($checkOutValue);
                    if ($rows !== true){
                        $seqService = new SeqService();
                        $seqOutputValue = $seqService->get('idOutputValue_seq');
                        $planM->setIdOutputValue($seqOutputValue);
                        echo "1234";
                        $insert = "
                            INSERT INTO OutputValue_TD
                            (TargetPlan_idTargetPlan, idOutputValue, MonthNo, Agri_idAgri,
                            weight, Price, Year_id, Area_id, Market_idMarket, Total, idCustomer, species_Id)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ";
                        $db3 = new Database();
                        $conn3 =  $db3->getConnection();
                        $createOutputValue = sqlsrv_prepare($conn3, $insert, array(
                            $row['idTargetPlan'], $planM->getIdOutputValue(), $row['month_id'], $row['Agri_idAgri'],
                            (float)round($row['weight'],2), (float)round($row['Price'],2), $planM->getIdYears(),
                            $planM->getIdArea(), $row['Market_idMarket'], (float)round($row['weight'],2)*(float)round($row['Price'],2), $row['market_id'], $row['species_Id']
                        ));
                        if( !$createOutputValue ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        if( sqlsrv_execute( $createOutputValue ) === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        sqlsrv_close($conn3);
                        echo "weight ::".$row['weight']."<br/>";
                        echo "weeknumber ::".$weeknumber."<br/>";
                        $weightOnWeek = (float)round(((float)round($row['weight'],2)/$weeknumber),2);
                        echo "weightOnWeek ::".$weightOnWeek."<br/>";
                        $countWeek = 1;
                        while ($countWeek <= $weeknumber){
                            echo $countWeek."<br/>";
                            echo "5678";
                            $inserts = "
                                INSERT INTO OutputValueCast_TD
                                (idOutputValue, MonthNo, Agri_idAgri,
                                Weight, Price, Total, Week, species_Id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                            ";
                            $db4 = new Database();
                            $conn4 =  $db4->getConnection();
                            $createOutputValueCast = sqlsrv_prepare($conn4, $inserts, array(
                                $planM->getIdOutputValue(), $row['month_id'], $row['Agri_idAgri'],
                                $weightOnWeek, (float)round($row['Price'],2), (float)round($weightOnWeek,2)*(float)round($row['Price'],2), $countWeek, $row['species_Id'] 
                            ));
                            if( !$createOutputValueCast ) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            if( sqlsrv_execute( $createOutputValueCast ) === false ) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            echo "999999999";
                            $countWeek++;
                            sqlsrv_close($conn4);
                        }
                    }
                }
            }
        }
    }

    public function checkStatusSendPlanOfyears($planM){
        $sql2 = "
            SELECT *
            FROM SendStatusPlan_TD
            WHERE Area_idArea ='".$planM->getIdArea()."' and YearID = '".$planM->getIdYears()."'
        ";
        // echo $sql2;
        $db = new Database();
        $conn =  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql2);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt !== NULL) {  
            $rows = sqlsrv_has_rows($stmt);
            echo "\nthere are rows\n".$rows;
            if ($rows === true){
               echo "\nthere are rows\n";
                $TargetPlanService = new TargetPlanService();
                $TargetPlanService->updatePlanOfyears($planM);
            }else{
                echo "\nno rows\n"; 
                $TargetPlanService = new TargetPlanService();
                $TargetPlanService->sendPlanOfyears($planM);
            } 
         }  
    }

    public function createSendOutputValue($planM){
        $sql3 = "
        SELECT *
        FROM SendStatusValue_TD
        WHERE YearID = '".$planM->getIdYears()."' and Area_idArea = '".$planM->getIdArea()."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        // year_target_id_seq
        if ($stmt3 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows !== true){
                $sql2 = "
                    SELECT dateStart, dateStop
                    FROM YearTB
                    WHERE idYearTB = '".$planM->getIdYears()."'
                ";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_query($conn, $sql2);
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                }
                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {  
                    $dateStart = $row['dateStart']->format('Y-m-d H:i:s');
                    $dateStop = $row['dateStop']->format('Y-m-d H:i:s');
                }
                $dateService = new DateService();
                $monthList = $dateService->getmonthOfYears($dateStart, $dateStop);
                foreach($monthList as $month) {
                    $seqService = new SeqService();
                    $seqStatusValueId = $seqService->get('idSendStatusValue_seq');
                    if($month['monthValue']<'10'){
                        $monthId = substr($month['monthValue'], 1, 2);
                    }else{
                        $monthId = $month['monthValue'];
                    }
                    $inserts = "
                        INSERT INTO SendStatusValue_TD
                        (idSendStatusValue, Area_idArea, MonthID, YearID, yearSet)
                        VALUES (?, ?, ?, ?, ?)
                    ";
                    $db4 = new Database();
                    $conn4 =  $db4->getConnection();
                    $stmt = sqlsrv_prepare($conn4, $inserts, array(
                        $seqStatusValueId, $planM->getIdArea(), $monthId,
                        $planM->getIdYears(), $month['yearValue']
                    ));
                    if( !$stmt ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                }
            }
        }
    }

    public function checkYearsTarget($area_Id){
        $sql = "
            SELECT TOP 1 ytb.idYearTB
            FROM YearTB ytb
            ORDER BY ytb.dateStart DESC
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $idYearTB  = $row['idYearTB'];
        }

        $sql2 = "
            SELECT *
            FROM YearTarget
            WHERE YearTB_idYearTB = '".$idYearTB."' and Area_idArea = '".$area_Id."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt2 = sqlsrv_query($conn, $sql2);
        if( !$stmt2 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        // year_target_id_seq
        if ($stmt2 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt2);
            if ($rows !== true){
                echo "\nno rows\n"; 
                $seqService = new SeqService();
                $yearTargetId = $seqService->get('year_target_id_seq');
                $inserts = "
                    INSERT INTO YearTarget
                    (YearTB_idYearTB, Area_idArea)
                    VALUES (?, ?)
                ";
                $db4 = new Database();
                $conn4 =  $db4->getConnection();
                $createOutputValueCast = sqlsrv_prepare($conn4, $inserts, array(
                    $idYearTB, $area_Id
                ));
                if( !$createOutputValueCast ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $createOutputValueCast ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }
         }
    }
    public function pastCreateSendOutputValue($planM){
        $sql2 = "
            SELECT TOP 1 yt.YearTB_idYearTB ,ytb.dateStart, ytb.dateStop
            FROM YearTarget yt
            INNER JOIN YearTB ytb ON yt.YearTB_idYearTB = ytb.idYearTB
            WHERE yt.Area_idArea = '".$planM->getIdArea()."'
            ORDER BY yt.YearTB_idYearTB DESC
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql2);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {  
            $getIdYears = $row['YearTB_idYearTB'];
            $dateStart = $row['dateStart']->format('Y-m-d H:i:s');
            $dateStop = $row['dateStop']->format('Y-m-d H:i:s');
        }
        $sql3 = "
            SELECT *
            FROM SendStatusValue_TD
            WHERE YearID = '".$getIdYears."' and Area_idArea = '".$planM->getIdArea()."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        // year_target_id_seq
        if ($stmt3 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows !== true){
                $dateService = new DateService();
                $monthList = $dateService->getmonthOfYears($dateStart, $dateStop);
                foreach($monthList as $month) {
                    $seqService = new SeqService();
                    $seqStatusValueId = $seqService->get('idSendStatusValue_seq');
                    if($month['monthValue']<'10'){
                        $monthId = substr($month['monthValue'], 1, 2);
                    }else{
                        $monthId = $month['monthValue'];
                    }
                    $inserts = "
                        INSERT INTO SendStatusValue_TD
                        (idSendStatusValue, Area_idArea, MonthID, YearID, yearSet)
                        VALUES (?, ?, ?, ?, ?)
                    ";
                    $db4 = new Database();
                    $conn4 =  $db4->getConnection();
                    $stmt = sqlsrv_prepare($conn4, $inserts, array(
                        $seqStatusValueId, $planM->getIdArea(), $monthId,
                        $getIdYears, $month['yearValue']
                    ));
                    if( !$stmt ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                }
            }
        }
    }
    public function createPlanUnitAttribute($idTargetPlanRef, $TypeOfTargetId, $amount, $plan_unit_attr){
        $sql = "
            INSERT INTO plan_unit_attr_TD
            (plan_unit_attr, idTagetPlan, TypeOfTargetId, amount)
            VALUES (?, ?, ?, ?)
        ";
        $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_prepare($conn, $sql, array(
                $plan_unit_attr, $idTargetPlanRef, $TypeOfTargetId, $amount
            ));
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function updateTargetPlanNew($planM){
        $sql3 = "
            SELECT TOP 1 *
            FROM TargetPlan_TD
            WHERE Price = '".$planM->getPrice()."' and Weight = '".$planM->getWeight()."' and idTargetPlan = '".$planM->getIdTargetPlan()."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt3 !== NULL) {  
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows !== true){
                $sql  =" UPDATE TargetPlan_TD SET ";
                $sql.="  Weight =? , Price=?, Total=? where idTargetPlan =? ";
                $db = new Database();
                    $conn=  $db->getConnection();
                    $stmt = sqlsrv_prepare($conn, $sql, array(
                        $planM->getWeight(), $planM->getPrice(), $planM->getTotal(), $planM->getIdTargetPlan()
                    ));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }
        }
        sqlsrv_close($conn);
    }
    public function updatePlanUnitAttribute ($targetPlanId, $id, $value){
        $sql3 = "
            SELECT TOP 1 *
            FROM plan_unit_attr_TD
            WHERE TypeOfTargetId = '".$id."' and idTagetPlan = '".$targetPlanId."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt3 = sqlsrv_query($conn, $sql3);
        if( !$stmt3 ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if ($stmt3 !== NULL) {
            $rows = sqlsrv_has_rows($stmt3);
            if ($rows !== true){
                //no rows
                $seqService = new SeqService();
                $plan_unit_attr_seq = $seqService->get('plan_unit_attr_seq');
                $sql = "
                    INSERT INTO plan_unit_attr_TD
                    (plan_unit_attr, idTagetPlan, TypeOfTargetId, amount)
                    VALUES (?, ?, ?, ?)
                ";
                $db = new Database();
                    $conn=  $db->getConnection();
                    $stmt = sqlsrv_prepare($conn, $sql, array(
                        $plan_unit_attr_seq, $targetPlanId, $id, $value
                    ));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }

            }else{
                $sql  =" UPDATE plan_unit_attr_TD SET ";
                $sql.="  amount=?";
                $sql.="  WHERE idTagetPlan=? and TypeOfTargetId=?";
                $db = new Database();
                    $conn=  $db->getConnection();
                    $stmt = sqlsrv_prepare($conn, $sql, array(
                        $value, $targetPlanId, $id
                    ));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
            }
        }
    }
    public function loadTargetPlanUint ($id){
        $sql3 = "
            SELECT *
            FROM plan_unit_attr_TD
            WHERE idTagetPlan = '".$id."'
        ";
        $db = new Database();
        $conn=  $db->getConnection();
        $stmt = sqlsrv_query($conn, $sql3);
        if( !$stmt ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $return_arr = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {  
            $row_array = array();
            $row_array['uintPlan'] = $row['TypeOfTargetId']."-".$row['amount'];
            array_push($return_arr, $row_array);
        }
        sqlsrv_close($conn);
        echo json_encode($return_arr);
    }
}
?>