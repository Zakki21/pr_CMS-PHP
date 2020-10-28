<?php
	namespace Controllers;
	use \Lib\FormInterviewer;
	use \Lib\Cookies;
	
	class InterviewerController extends \Framework\Controller{
		
		public $error_notifications = array();
		public $success_notifications = array();
		public $error = false;
		public $form_interviewer_fields;
		public $form_interviewer;
		public $cookies_interviewer;
		public $config;
		
		public function __construct() {
			$this->form_interviewer_fields = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerFields.php';
			$this->config = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'MainConfig.php';
			$this->form_interviewer = new FormInterviewer;
			$this->cookies_interviewer = new Cookies;
		}
		
		public function indexAction () {
			
			if(!empty($_GET['continue'])) {
				$continue = $_GET['continue'];
			}
			if (!empty($this->cookies_interviewer->getCookie('user_form_interviewer')) && $continue=='yes') {
				$form_interviewer_data = unserialize($this->cookies_interviewer->getCookie('user_form_interviewer'));
			}
			
			if(!empty($_POST)) {
				$form_interviewer_data = $_POST['form'];
				$form_interviewer_file = $_FILES['form_file'];
				if (!empty($form_interviewer_file['tmp_name'])) {
					$form_interviewer_data['hidden'] = $form_interviewer_file['name'];
					$form_interviewer_data['file'] = $form_interviewer_file;
					$this->form_interviewer->uploadFormFile($form_interviewer_file);
				}
				
				$form_interviewer_response = $this->form_interviewer->index($form_interviewer_data);
				
				ob_start();
				var_dump($form_interviewer_response);
				$print = ob_get_clean();
				ob_end_clean();
				var_dump($print);
				
				if ($form_interviewer_response === false){
					header('Location: '.$this->config['base_url'].'interviewer/success',TRUE,301);
					exit();
				}
				else
					$this->error_notifications = $form_interviewer_response;
			}

			$data = array(
				'form_interviewer_fields' => $this->form_interviewer_fields,
				'form_interviewer_data' => $form_interviewer_data,
				'error_notifications' => $this->error_notifications,
				'success_notifications' => $this->success_notifications,
				'error' => $this->error
			);
			
			return $this->render('FormInterviewer', $data);
		}
		
		public function successAction () {
			return $this->render('Success', array());
		}
		
	}