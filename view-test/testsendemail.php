<?php
/**
 * This example shows making an SMTP connection with authentication.
 */
 
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Bangkok');
 
require_once '../vendors/PHPMailer/PHPMailer.php';
require_once '../vendors/PHPMailer/SMTP.php';
require_once '../vendors/PHPMailer/Exception.php';

$GUSER = "noreply.hrdi.or.th@gmail.com";
$GPWD = "&&H%5:Dk3J7w4<a$";
//Create a new PHPMailer instance
$mail = new PHPMailer\PHPMailer\PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 1;
//Ask for HTML-friendly debug output
//$mail->Debugoutput = 'html';
$mail->isHTML(true);
//Set the hostname of the mail server
$mail->Host = "smtp.gmail.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
//$mail->Username = $GUSER;
$mail->Username = 'nasidyo@gmail.com';

//Password to use for SMTP authentication
//$mail->Password = $GPWD;
$mail->Password = '491624Nats';
//Set who the message is to be sent from
$mail->setFrom('noreply.hrdi.or.th@gmail.com', 'Mail this from HKM');
//Set who the message is to be sent to
$mail->addAddress('nasidyo@gmail.com', 'nasidyo');
//Set the subject line
$mail->Subject = 'test email';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('content.html'), dirname(__FILE__));
$mail->msgHTML("Test email by ssl gmail.com");
 
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
?>