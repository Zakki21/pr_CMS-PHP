<?php
//Подключаем конфиг для данных
	require_once (dirname(__FILE__) . '/config/main.php');
	$item_values = require (dirname(__FILE__) . '/config/item_values.php');

//Проверяем наличие ранее заполненных данных и метки для вывода сообщения для продолжения
	if(!empty($_GET['continue'])) {
		$continue = $_GET['continue'];
		$show_message_cookie=false;
	}
	if(!empty($_COOKIE)) {
		$user_cookie = $_COOKIE['user_form_val'];
	}
	
//Если есть данны с формы
	if(!empty($_POST)) {
		$form_val = $_POST['form'];
		$form_file = $_FILES['form_file'];
		$show_message_cookie=false;

//Валидация введенных данных
		$form_contact_validation = require (dirname(__FILE__) . '/config/form_validation.php');
		
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
	
	
//Если ошибок нет, отправляем сообщение и удаляем куку
	if (!empty($form_val) && count($form_error)==0) {
		require (dirname(__FILE__) . '/mailsend/mail_send.php');
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
	
//Выводим форму
	ob_start();
	include dirname(__FILE__) . '/template/form.tpl';
	$content = ob_get_contents();
	ob_end_clean();
	echo $content;
	
