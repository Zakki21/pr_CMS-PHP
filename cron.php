<?php
	define('ROOTPATH', dirname(__FILE__));
	
	require ROOTPATH.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'PHPMailer.php';
	require ROOTPATH.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'SMTP.php';
	require ROOTPATH.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'Exception.php';
	require ROOTPATH.DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Db.php';
	$item_values = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'ItemValues.php';
	
	$db = new App\Db();
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
				
				$mail->Username = 'zak.kaz21@gmail.com';
				$mail->Password = '1@23456S7891919';
				$mail->SMTPSecure = '';
				$mail->Port = 587;
				
				//Recipients
				$mail->setFrom('zak.kaz21@gmail.com', 'ZVO');
				$mail->addAddress('adminqqq@gmail.com', 'ZVO');
				
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
					echo str_replace('{id}', $one_user['id'], $item_values['success_value']['success_send_to_id']);
				}
			} catch (Exception $e) {
				echo $item_values['error_value']['error_send'], $mail->ErrorInfo;
			}
		}
	}
	else
		echo $item_values['success_value']['not_users'];
	