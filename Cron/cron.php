<?php
	define('ROOTPATH', dirname(__FILE__));
	
	require ROOTPATH.DIRECTORY_SEPARATOR.'Vendor'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'PHPMailer.php';
	require ROOTPATH.DIRECTORY_SEPARATOR.'Vendor'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'SMTP.php';
	require ROOTPATH.DIRECTORY_SEPARATOR.'Vendor'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'Exception.php';
	require ROOTPATH.DIRECTORY_SEPARATOR.'Framework'.DIRECTORY_SEPARATOR.'Db.php';
	$form_fields = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormFields.php';
	$smtp_data = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Smtp.php';
	
	$db = new Framework\Db();
	$all_users = $db->execute('SELECT * FROM users WHERE status=0');
	
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	
	if (count($all_users)>0) {
		foreach ($all_users as $one_user) {
			try {
				//Server settings
				$mail->SMTPDebug = 0;
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				
				$mail->Username = $smtp_data['login'];
				$mail->Password = $smtp_data['password'];
				$mail->SMTPSecure = '';
				$mail->Port = 587;
				
				//Recipients
				$mail->setFrom($smtp_data['from'], 'ZVO');
				$mail->addAddress($smtp_data['to'], 'ZVO');
				
				//Attachments
				$mail->addAttachment(dirname(__FILE__).'/Templates/Image/' . basename($one_user['image']), $one_user['image']);
				
				//Content
				$mail->isHTML(true);
				$mail->Subject = 'PHP+CMS';
				ob_start();
				include dirname(__FILE__) . '/Templates/Mail.tpl';
				$mail_text = ob_get_contents();
				ob_end_clean();
				$mail->Body = $mail_text;
				
				if ($mail->send()) {
					$db->execute('UPDATE users SET status=1 WHERE id='.$one_user['id']);
					echo str_replace('{id}', $one_user['id'], $form_fields['success_value']['success_send_to_id']);
				}
			} catch (Exception $e) {
				echo $form_fields['error_value']['error_send'], $mail->ErrorInfo;
			}
		}
	}
	else
		echo $form_fields['success_value']['not_users'];
	