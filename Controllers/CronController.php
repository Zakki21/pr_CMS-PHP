<?php
	namespace Controllers;
	use \Cron\SendEmailToUser;
	
	class CronController extends \Framework\Controller{
		
		public $send_email;
		
		public function __construct() {
			$this->send_email = new SendEmailToUser;
		}
		
		public function indexAction () {
			$send_status = $this->send_email->sendEmail();
			if ($send_status!=false)
				echo $send_status;
		}
		
	}