<?php
	namespace Lib;
	use \Models\Users;
	use \Lib\Form;
	
	class FormInterviewer extends Form {
		public function __construct() {
			$this->form_interviewer_validation = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerValidation.php';
			$this->form_interviewer_notifications = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerNotifications.php';
			$this->form_interviewer_fields = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerFields.php';
			$this->config = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'MainConfig.php';
			$this->cookies_interviewer = new Cookies;
		}
		
		public function index (array $form_interviewer_data) {
			$valid_response = $this->validateForm($form_interviewer_data);
			return $valid_response;
		}
	}