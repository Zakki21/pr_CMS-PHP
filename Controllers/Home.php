<?php
	namespace Controllers;
	use \Models\Users;
	
	class Home extends \App\Controller{
		
		public function index () {
			require_once ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Main.php';
			$item_values = require ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'ItemValues.php';
			
//Проверяем наличие ранее заполненных данных и метки для вывода сообщения для продолжения
			if(!empty($_GET['continue'])) {
				$continue = $_GET['continue'];
				$show_message_cookie=false;
			}
			if(!empty($_COOKIE)) {
				$user_cookie = $_COOKIE['user_form_val'];
			}
			
//Если есть данные с формы
			if(!empty($_POST)) {
				$form_val = $_POST['form'];
				$form_file = $_FILES['form_file'];
				$show_message_cookie=false;
				
//Валидация введенных данных
				$form_contact_validation = include ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'FormValidation.php';
				foreach ($form_contact_validation as $key_valid=>$item_valid) {
					if (empty($form_val[$key_valid])) {
						$error = true;
						$form_error[$key_valid] = $item_values['error_value'][$key_valid.'-empty'];
					}
					if ($item_valid['filter']==='FILTER_VALIDATE_ARRAY') {
						if ($item_valid['filter']==='FILTER_VALIDATE_ARRAY' && count($form_val[$key_valid])<$item_valid['options']) {
							$error = true;
							$form_error[$key_valid] = $item_values['error_value'][$key_valid];
						}
					}
					else {
						if (!filter_var($form_val[$key_valid], FILTER_VALIDATE_REGEXP, $item_valid['options'])) {
							$error = true;
							$form_error[$key_valid] = $item_values['error_value'][$key_valid];
						}
					}
				}
				
//Загружаем файл, если он есть и не более 3Мб
				if (!empty($form_file)) {
					if($form_file['size']>1 && move_uploaded_file($form_file['tmp_name'], $upload_dir . basename($form_file['name']))) {
						$form_success['file'] = $item_values['success_value']['file_upload'];
						$form_val['hidden']=$form_file['name'];
					}
					elseif(empty($form_val['hidden'])) {
						$form_error['file'] = $item_values['error_value']['form_file'];
					}
				}

//Добавление куки для автозаполнения
				$string_form_val = serialize($form_val);
				setcookie("user_form_val", $string_form_val, time()+3600*24*30*365);  // срок действия год
			}

//Если ошибок нет, сохраняем данные и удаляем куку
			if (!empty($form_val) && count($form_error)==0) {
				foreach ($form_val as $i_val=>$v_val) {
					if ($i_val=='radio') {$v_val=$item_values['radio_value'][$v_val];}
					if ($i_val=='checkbox') {
						foreach ($v_val as $ch_v_val) {
							$name_to_str .= $item_values['checkbox_value'][$ch_v_val].', ';
						}
						$v_val=$name_to_str;
						$name_to_str = '';
					}
					if ($i_val=='select') {
						$v_val=$item_values['select_value'][$v_val];
					}
					if ($i_val=='selectsize') {
						foreach ($v_val as $ss_v_val) {
							$name_to_str .= $item_values['selectsize_value'][$ss_v_val].', ';
						}
						$v_val=$name_to_str;
						$name_to_str = '';
					}
					$data[$i_val] = $v_val;
				}
				Users::addUser($data);
				
				$form_success['save_form'] = $item_values['success_value']['form_save'];
				
				$form_val = array();
				setcookie("user_form_val", '', time()-3600);
			}

//Проверяем заполнял ли пользователь ранее форму
			if(!empty($user_cookie) && empty($continue)) {
				$form_val = unserialize($user_cookie);
			}
			elseif (!empty($user_cookie) && $continue=='yes') {
				$form_val = unserialize($user_cookie);
				$user_cookie = 0;
			}
			
			$data_form = array(
				'item_values' => $item_values,
				'form_val' => $form_val,
				'form_error' => $form_error,
				'form_success' => $form_success,
				'user_cookie' => $user_cookie,
				'show_message_cookie' => $show_message_cookie,
				'continue' => $continue,
				'error' => $error
			);
			
			return $this->render('Home', $data_form);
		}
	}