<?php
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

// $mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtpout.secureserver.net';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@instantly.legal';                 // SMTP username
$mail->Password = 'dYCs!{t[t?xm';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to                                // TCP port to connect to


$email="ajaykrec@gmail.com"; // recipient's Mail address


$mail->From = 'info@instantly.legal';
$mail->FromName = 'instantly.legal';
//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress($email);               // Name is optional
$mail->addReplyTo('info@instantly.legal', 'Test Mail');


$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$mail->CharSet = 'UTF-8';
$displaytext="Test Mail.......";
$mail->Subject = 'Test Mail - Invoice';
$mail->Body = "<html><body>{$displaytext}</body></html>";
// Plain Text Body
$mail->AltBody = $displaytext;

if(!$mail->send()) {
    echo 'Message could not be sent';
   
} else {
    echo "Mail has been sent to your e-mail address";
}