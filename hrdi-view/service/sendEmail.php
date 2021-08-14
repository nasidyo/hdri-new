<?php
    require_once '../vendors/PHPMailer/PHPMailer.php';
    require_once '../vendors/PHPMailer/SMTP.php';
    require_once '../vendors/PHPMailer/Exception.php';
    require_once '../connection/database.php';
    require_once '../model/PlanM.php';
    Class SandEmail {
        // LIST TO DO
        function getinfo($data,$action, $statusType){
            $auth = null;
            $host = null;
            $port = null;
            $email_user = null;
            $email_pass = null;
            $email_from = null;
            $emali_subject = null;
            $email_text = null;
            $fullname = null;
            $sendto = null;

            if($action == 'toManager'){
                $table = "SELECT auth, starttls_enable, host, port, email_user, email_pass, email_from, emali_subject, email_text 
                FROM email_prop 
                WHERE id = '2'";
                $db = new Database();
                $conn =  $db->getConnection();
                $resluts = sqlsrv_prepare($conn, $table);
                if( !$resluts ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $resluts ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                while( $reslutsRow = sqlsrv_fetch_array( $resluts, SQLSRV_FETCH_ASSOC) ) {
                    $auth = $reslutsRow['auth'];
                    $host = $reslutsRow['host'];
                    $port = $reslutsRow['port'];
                    $email_user = $reslutsRow['email_user'];
                    $email_pass = $reslutsRow['email_pass'];
                    $email_from = $reslutsRow['email_from'];
                    $emali_subject = $reslutsRow['emali_subject'];
                    $email_text = $reslutsRow['email_text'];
                }
                //get send e-mail to
                $sql = "SELECT sa.Staff_idStaff, s.staffFirstname+' '+s.staffLastname as fullnameuser, s.staffEmail 
                        FROM StaffArea as sa 
                        INNER JOIN Staff as s ON sa.Staff_idStaff = s.idStaff 
                        WHERE sa.Area_idArea = ? and s.staffPermis = 'manager'";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array($data->getIdArea()));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    //get info in body e-mail
                    $fullname = $row['fullnameuser'];
                    $sendto = $row['fullnameuser'];
                    $sql2 = "SELECT TOP 1 ssp.idSendStatusPlan, lad.target_area_type_title+' '+lad.target_name as areafullname, yt.nameYear +' ['+ FORMAT(yt.dateStart, 'dd/MMMM/yyyy','th') +' - '+ FORMAT(yt.dateStop, 'dd/MMMM/yyyy','th') +']' as displayYear 
                        FROM SendStatusPlan_TD as ssp 
                        INNER JOIN vLinkAreaDetail as lad ON ssp.Area_idArea = lad.target_id 
                        INNER JOIN YearTB as yt ON ssp.YearID = yt.idYearTB 
                        WHERE ssp.Area_idArea = ? and ssp.YearID = ? ";
                    $db = new Database();
                    $conn =  $db->getConnection();
                    $stmt2 = sqlsrv_prepare($conn, $sql2, array($data->getIdArea(), $data->getIdYears()));
                    if( !$stmt2 ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt2 ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                        $areafullname = $row2['areafullname'];
                        $displayYear = $row2['displayYear'];
                        $url = 'https://farmtd.hrdi.or.th/view/yearsListOfPlan.php?area_Id='.$data->getIdArea().'&yearsId='.$data->getIdYears();
                        $email_text = str_replace("&username",$fullname ,$email_text);
                        $email_text = str_replace("&yerasfullname",$displayYear ,$email_text);
                        $email_text = str_replace("&areaName",$areafullname ,$email_text);
                        $email_text = str_replace("&link",$url ,$email_text);
                        self:: sendEmail($auth, $host, $port, $email_user, $email_pass, $email_from, $emali_subject, $email_text, $sendto);
                    }
                }
            }
            if($action == 'toStaff'){
                $table = "SELECT auth, starttls_enable, host, port, email_user, email_pass, email_from, emali_subject, email_text 
                FROM email_prop 
                WHERE id = ?";
                $db = new Database();
                $conn =  $db->getConnection();
                if($statusType == '4'){
                    $id = '3';
                }else{
                    $id = '1';
                }
                echo "id ::: ".$id;
                $resluts = sqlsrv_prepare($conn, $table, array($id));
                if( !$resluts ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $resluts ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                while( $reslutsRow = sqlsrv_fetch_array( $resluts, SQLSRV_FETCH_ASSOC) ) {
                    $auth = $reslutsRow['auth'];
                    $host = $reslutsRow['host'];
                    $port = $reslutsRow['port'];
                    $email_user = $reslutsRow['email_user'];
                    $email_pass = $reslutsRow['email_pass'];
                    $email_from = $reslutsRow['email_from'];
                    $emali_subject = $reslutsRow['emali_subject'];
                    $email_text = $reslutsRow['email_text'];
                }
                $sql = "SELECT sa.Staff_idStaff, s.staffFirstname+' '+s.staffLastname as fullnameuser, s.staffEmail 
                        FROM StaffArea as sa 
                        INNER JOIN Staff as s ON sa.Staff_idStaff = s.idStaff 
                        WHERE sa.Area_idArea = ? and s.staffPermis = 'staff'";
                $db = new Database();
                $conn=  $db->getConnection();
                $stmt = sqlsrv_prepare($conn, $sql, array($data->getIdArea()));
                if( !$stmt ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                if( sqlsrv_execute( $stmt ) === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    //get info in body e-mail
                    $fullname = $row['fullnameuser'];
                    $sendto = $row['fullnameuser'];
                    $sql2 = "SELECT TOP 1 ssp.idSendStatusPlan, lad.target_area_type_title+' '+lad.target_name as areafullname, yt.nameYear +' ['+ FORMAT(yt.dateStart, 'dd/MMMM/yyyy','th') +' - '+ FORMAT(yt.dateStop, 'dd/MMMM/yyyy','th') +']' as displayYear 
                        FROM SendStatusPlan_TD as ssp 
                        INNER JOIN vLinkAreaDetail as lad ON ssp.Area_idArea = lad.target_id 
                        INNER JOIN YearTB as yt ON ssp.YearID = yt.idYearTB 
                        WHERE ssp.Area_idArea = ? and ssp.YearID = ? ";
                    $db = new Database();
                    $conn =  $db->getConnection();
                    $stmt2 = sqlsrv_prepare($conn, $sql2, array($data->getIdArea(), $data->getIdYears()));
                    if( !$stmt2 ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    if( sqlsrv_execute( $stmt2 ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
                    }
                    while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                        $areafullname = $row2['areafullname'];
                        $displayYear = $row2['displayYear'];
                        $url = 'https://farmtd.hrdi.or.th/view/yearsListOfPlan.php?area_Id='.$data->getIdArea().'&yearsId='.$data->getIdYears();
                        $email_text = str_replace("&username",$fullname ,$email_text);
                        $email_text = str_replace("&yerasfullname",$displayYear ,$email_text);
                        $email_text = str_replace("&areaName",$areafullname ,$email_text);
                        $email_text = str_replace("&link",$url ,$email_text);
                        self:: sendEmail($auth, $host, $port, $email_user, $email_pass, $email_from, $emali_subject, $email_text, $sendto);
                    }
                }
            }
        }
        function sendEmail($auth, $host, $port, $email_user, $email_pass, $email_from, $emali_subject, $email_text, $sendto){
            echo $emali_subject;
            date_default_timezone_set('Asia/Bangkok');
            $GUSER = "noreply.hrdi.or.th@gmail.com";
            $GPWD = "&&H%5:Dk3J7w4<a$";
            $mail = new PHPMailer\PHPMailer\PHPMailer(); //Create a new PHPMailer instance
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP(); //Tell PHPMailer to use SMTP
            $mail->SMTPDebug = 1;//Enable SMTP debugging 0 = off (for production use) 1 = client messages 2 = client and server messages
            $mail->isHTML(true);
            $mail->Host = $host;//Set the hostname of the mail server
            $mail->Port = $port; //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->SMTPSecure = 'tls'; //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPAuth = $auth; //Whether to use SMTP authentication
            //Username to use for SMTP authentication
            //$mail->Username = $GUSER;
            $mail->Username = $email_user;
            //Password to use for SMTP authentication
            //$mail->Password = $GPWD;
            $mail->Password = $email_pass;
            $mail->setFrom($email_from, ''); //Set who the message is to be sent from
            // $mail->addAddress('dsrctd@gmail.com', '');
            $mail->addAddress($sendto, ''); //Set who the message is to be sent to
            $mail->AddCC('dsrctd@gmail.com', 'admin systems');
            $mail->Subject = $emali_subject; //Set the subject line
            $mail->Body = $email_text;
            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message sent!";
            }
        }
    }
?>