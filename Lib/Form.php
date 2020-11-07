<?php
	namespace Lib;
	use \Models\UsersModel;
	
	class Form {
		
		public $form_interviewer_validation = array();
		public $form_interviewer_notifications = array();
		public $config;
		
		public function __construct() {
			$this->form_interviewer_validation = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerValidation.php';
			$this->form_interviewer_notifications = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerNotifications.php';
			$this->form_interviewer_fields = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormInterviewerFields.php';
			$this->config = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'MainConfig.php';
			$this->cookies_interviewer = new Cookies;
		}
		
		public function validateForm (array $form_interviewer_data) {
			foreach ($form_interviewer_data as $key_form_data=>$item_form_data) {
				if (empty($item_form_data)) {
					$this->error = true;
					$this->error_notifications[$key_form_data] = $this->form_interviewer_notifications['error_value'][$key_form_data.'-empty'];
				}
				else {
					if ($this->form_interviewer_validation[$key_form_data]['filter_name']=='filter_var' && !filter_var($form_interviewer_data[$key_form_data], FILTER_VALIDATE_REGEXP, $this->form_interviewer_validation[$key_form_data]['options'])) {
						$this->error = true;
						$this->error_notifications[$key_form_data] = $this->form_interviewer_notifications['error_value'][$key_form_data];
					}
					if ($this->form_interviewer_validation[$key_form_data]['filter_name']=='filter_array' && count($item_form_data)<$this->form_interviewer_validation[$key_form_data]['options']) {
						$this->error = true;
						$this->error_notifications[$key_form_data] = $this->form_interviewer_notifications['error_value'][$key_form_data];
					}
				}
			}
			
			if(empty($form_interviewer_data['radio'])) {
				$this->error = true;
				$this->error_notifications['radio'] = $this->form_interviewer_notifications['error_value']['radio-empty'];
			}
			if(empty($form_interviewer_data['checkbox'])) {
				$this->error = true;
				$this->error_notifications['checkbox'] = $this->form_interviewer_notifications['error_value']['checkbox-empty'];
			}
			if(empty($form_interviewer_data['file']) && $form_interviewer_data['hidden']=='none') {
				$this->error = true;
				$this->error_notifications['file'] = $this->form_interviewer_notifications['error_value']['form-file'];
			}
			
			if ($this->error===true) {
				$this->cookies_interviewer->setCookie('user_form_interviewer', $form_interviewer_data, (time()+3600*24*30*365));
				return $this->error_notifications;
			}
			else {
				$save_status = $this->saveForm($form_interviewer_data);
print_r($save_status);exit();
				if (is_array($save_status)) {
					//$this->cookies_interviewer->deleteCookieAction('user_form_interviewer');
					return $this->error;
				}
				else {
					$this->error = true;
					$this->error_notifications['not_save_user'] = $this->form_interviewer_notifications['error_value']['not_save_user'];
					return $this->error_notifications;
				}
			}
			
		}
		
		public function saveForm (array $form_interviewer_data) {
			foreach ($form_interviewer_data as $i_val=>$v_val) {
				if ($i_val=='radio') {$v_val=$this->form_interviewer_fields['radio_value'][$v_val];}
				if ($i_val=='checkbox') {
					foreach ($v_val as $ch_v_val) {
						$name_to_str .= $this->form_interviewer_fields['checkbox_value'][$ch_v_val].', ';
					}
					$v_val=$name_to_str;
					$name_to_str = '';
				}
				if ($i_val=='select') {
					$v_val=$this->form_interviewer_fields['select_value'][$v_val];
				}
				if ($i_val=='selectsize') {
					foreach ($v_val as $ss_v_val) {
						$name_to_str .= $this->form_interviewer_fields['selectsize_value'][$ss_v_val].', ';
					}
					$v_val=$name_to_str;
					$name_to_str = '';
				}
				$data[$i_val] = $v_val;
			}
			$add_user_status = UsersModel::addUser($data);
			return $add_user_status;
		}
		
		public function uploadFormFile (array $form_interviewer_file) {
			if(move_uploaded_file($form_interviewer_file['tmp_name'], $this->config['upload_dir'] . basename($form_interviewer_file['name']))) {
//				$form_success['file'] = $item_values['success_value']['file_upload'];
//				$form_val['hidden']=$form_file['name'];
			}
		}
		
	}