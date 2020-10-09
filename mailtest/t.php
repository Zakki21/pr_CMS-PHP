<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
	//Server settings
	$mail->SMTPDebug = 2;                                 // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication

  $mail->Username = 'zak.kaz21@gmail.com';                 // SMTP username
  $mail->Password = '1@23456S7891919';                           // SMTP password
	$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	//Recipients
	$mail->setFrom('zak.kaz21@gmail.com', 'Mailer');
	$mail->addAddress('zak.kaz21@gmail.com', 'ZVO');     // Add a recipient
	/*$mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo('info@example.com', 'Information');
	$mail->addCC('cc@example.com');
	$mail->addBCC('bcc@example.com');*/

	//Attachments
	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('image/Screenshot_1.png', 'Screenshot_1.png');    // Optional name

	//Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'Форма для PHP+CMS';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	$mail->send();
	echo 'Message has been sent';
} catch (Exception $e) {
	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}