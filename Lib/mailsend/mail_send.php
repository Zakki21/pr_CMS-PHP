<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \Models\Users;
use \App;

//Load Composer's autoloader
require 'vendor/autoload.php';
	class Cron extends \App\Controller{
		public function index () {
$all_users = Users::getUsersToStatus();
print_r($all_users);
		}
	}



$mail = new PHPMailer(true);
try {
	//Server settings
	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;

  $mail->Username = 'zak.kaz21@gmail.com';
  $mail->Password = '1@23456S7891919';
	$mail->SMTPSecure = '';
	$mail->Port = 587;

	//Recipients
	$mail->setFrom('zak.kaz21@gmail.com', 'ZVO');
	$mail->addAddress('adminqqq@gmail.com', 'ZVO');
	
	//Attachments
	//$mail->addAttachment($upload_dir . basename($one_user['image']), $one_user['image']);

	//Content
	$mail->isHTML(true);
	$mail->Subject = 'PHP+CMS';
//	ob_start();
//	include dirname(__FILE__) . '/../../Templates/mail.tpl';
//	$mail_text = ob_get_contents();
//	ob_end_clean();
//	$mail->Body = $mail_text;
	$mail->Body = 'test';

//	$mail->send();
//	$form_success['mail'] = $item_values['success_value']['email_send'];
} catch (Exception $e) {
	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}