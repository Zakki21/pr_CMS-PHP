<?php
	namespace Cron;
	use \Models\UsersModel;
	
	class SendEmailToUser {
		public $mail;
		public $form_interviewer_notifications;
		public $smtp_data;
		public $mail_body;
		public $upload_folder = ROOTPATH.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Image'.DIRECTORY_SEPARATOR;
		public $status = '';
		
		public function __construct() {
			require ROOTPATH.DIRECTORY_SEPARATOR.'Vendor'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'PHPMailer.php';
			require ROOTPATH.DIRECTORY_SEPARATOR.'Vendor'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'SMTP.php';
			require ROOTPATH.DIRECTORY_SEPARATOR.'Vendor'.DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'Exception.php';
			$this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
			$this->form_interviewer_notifications = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerNotifications.php';
			$this->smtp_data = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Smtp.php';
		}

		public function sendEmail () {
			$all_users = $this->getUsers();
			if (count($all_users)>0) {
				foreach ($all_users as $one_user) {
					try {
						//Server settings
						$this->mail->SMTPDebug = 0;
						$this->mail->isSMTP();
						$this->mail->Host = 'smtp.gmail.com';
						$this->mail->SMTPAuth = true;
						
						$this->mail->Username = $this->smtp_data['login'];
						$this->mail->Password = $this->smtp_data['password'];
						$this->mail->SMTPSecure = '';
						$this->mail->Port = 587;
						
						//Recipients
						$this->mail->setFrom($this->smtp_data['from'], 'ZVO');
						$this->mail->addAddress($this->smtp_data['to'], 'ZVO');
						
						//Attachments
						$this->mail->addAttachment($this->upload_folder . basename($one_user['image']), $one_user['image']);
						
						//Content
						$this->mail->isHTML(true);
						$this->mail->Subject = 'PHP+CMS';
						ob_start();
							include ROOTPATH.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Mail.tpl';
							$mail_text = ob_get_contents();
						ob_end_clean();
						$this->mail->Body = $mail_text;

						if ($this->mail->send()) {
							if ($this->updateUserStatus($one_user['id'])!==false) {
								$this->status .= str_replace('{id}', $one_user['id'], $this->form_interviewer_notifications['success_value']['success_send_to_id']).'<br>';
							}
							else {
								$this->status = false;
							}
						}
					} catch (Exception $e) {
						$this->status = $this->form_interviewer_notifications['error_value']['error_send'].':<br>'.$this->mail->ErrorInfo;
					}
				}
			}
			else
				$this->status = $this->form_interviewer_notifications['success_value']['not_users'];
			
			echo $this->status; exit();
			return $this->status;
		}
	
		public function getUsers() {
			$all_users = UsersModel::getUsersToStatus()->fetchAll();
			return $all_users;
		}
		
		public function updateUserStatus($user_id) {
			$result = UsersModel::updateUsersStatusToId($user_id);
			return $result;
		}
	}
	