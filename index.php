<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="wrapper">
<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'mailtest/vendor/autoload.php';
	$mail = new PHPMailer(true);
	
	if(!empty($_POST)) {
		$error = false;
		$form_error = array();
		$form_success = array();
		$checkbox = '';
		$selectsize = '';
		$upload_dir = __DIR__.'/image/';
// Проверка фамилии
		if (!empty($_POST['form']['fname'])){
			if(!preg_match('/^[A-Za-zА-Яа-яЁё]+$/u', $_POST['form']['fname'])){
				$error = true;
				$form_error['fname'] = 'Фамилия введена не корректно!';
			}
		}
		else {
			$error = true;
			$form_error['fname'] = 'Введите Фамилию!';
		}

// Проверка имени и отчества
		if (!empty($_POST['form']['sname'])){
			if(!preg_match('/^[A-Za-zА-Яа-яЁё\s]+$/u', $_POST['form']['sname'])){
				$error = true;
				$form_error['sname'] = 'Имя и Отчество введено не корректно!';
			}
			elseif (!preg_match('/[A-Za-zА-Яа-яЁё][\s][A-Za-zА-Яа-яЁё]+/u', $_POST['form']['sname'])) {
				$error = true;
				$form_error['sname'] = 'Вы указали только Имя или Отчество!';
			}
		}
		else {
			$error = true;
			$form_error['sname'] = 'Введите Имя и Отчество!';
		}

// Проверка возраста
		if (!empty($_POST['form']['age'])){
			if(!preg_match('/^[0-9]+$/', $_POST['form']['age'])){
				$error = true;
				$form_error['age'] = 'Возраст введен не корректно!';
			}
			elseif ($_POST['form']['age']<18) {
				$error = true;
				$form_error['age'] = 'Вы еще маленький(ая)!';
			}
			elseif ($_POST['form']['age']>105) {
				$error = true;
				$form_error['age'] = 'Вы долгожитель, но не на столько!';
			}
		}
		else {
			$error = true;
			$form_error['age'] = 'Введите Возраст!';
		}

// Проверка пароля
		if (!empty($_POST['form']['password'])){
			if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/', $_POST['form']['password'])){
				$error = true;
				$form_error['password'] = 'Пароль должен содержать 6-15 символов, один строчный символ, один символ верхнего регистра, одну цифру и спецсимвол!';
			}
		}
		else {
			$error = true;
			$form_error['password'] = 'Введите Пароль!';
		}

// Проверка radio (Уведомления)
		if (empty($_POST['form']['radio'])){
			$error = true;
			$form_error['radio'] = 'Выберите хотите ли получать уведомления!';
		}

// Проверка checkbox (Цвет)
		if (empty($_POST['form']['checkbox'])){
			$error = true;
			$form_error['checkbox'] = 'Выберите цвет!';
		}
		elseif (count($_POST['form']['checkbox'])<2) {
			$error = true;
			$form_error['checkbox'] = 'Выберите хотя бы 2 цвета!';
		}
		else {
			foreach ($_POST['form']['checkbox'] as $one_checkbox) {
				$checkbox .= $one_checkbox.', ';
			}
		}

// Проверка select (Увлечения) !!!!!!!!!!!!!!
		if (!preg_match('/^[A-Za-zА-Яа-яЁё\s]+$/u', $_POST['form']['select'])){
			$error = true;
			$form_error['select'] = 'Выберите Увлечение!';
		}
		
		
// Проверка selectsize (Предпочтения)
		if (empty($_POST['form']['selectsize'])){
			$error = true;
			$form_error['selectsize'] = 'Выберите свои предпочтения!';
		}
		elseif (count($_POST['form']['selectsize'])<2) {
			$error = true;
			$form_error['selectsize'] = 'Хотя бы 2 предпочтения!';
		}
		else {
			foreach ($_POST['form']['selectsize'] as $one_selectsize) {
				$selectsize .= $one_selectsize.', ';
			}
		}
		
// Проверка textarea (О себе)
		if (empty($_POST['form']['textarea'])){
			$error = true;
			$form_error['textarea'] = 'Расскажите о себе немного';
		}
		elseif (iconv_strlen($_POST['form']['textarea'],'UTF-8')<20) {
			$error = true;
			$form_error['textarea'] = 'Хотя бы 20 символов!';
		}

// Проверка прикрепленного файла
		if (empty($_FILES['form_file']['tmp_name'])) {
			$error = true;
			$form_error['file'] = 'Выберите фото!';
		}
		elseif ($_FILES['form_file']['size']>3000000) {
			$error = true;
			$form_error['file'] = 'Большое фото, не больше 3 Мб!';
		}
		else {
			if (move_uploaded_file($_FILES['form_file']['tmp_name'], $upload_dir . basename($_FILES['form_file']['name']))) {
				$form_success['file'] = "Файл загружен";
			}
		}

//		print_r($_POST);
//		print_r($_FILES);
	}

	if ($error) {
// Вывод всех Плохих уведомлений
		foreach ($form_error as $one_error){
			echo '<div class="errorsms">'.$one_error.'</div>';
		}
	}
	elseif (!empty($_POST)) {
		try {
			//Server settings
			$mail->SMTPDebug = 0;// Enable verbose debug output
			$mail->isSMTP();// Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;// Enable SMTP authentication
			
			$mail->Username = 'zak.kaz21@gmail.com';// SMTP username
			$mail->Password = '1@23456S7891919';// SMTP password
			$mail->SMTPSecure = '';// Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;// TCP port to connect to
			
			//Recipients
			$mail->setFrom('zak.kaz21@gmail.com', 'ZVO');
			$mail->addAddress('adminqqq@gmail.com', 'ZVO');
			
			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment($upload_dir . basename($_FILES['form_file']['name']), $_FILES['form_file']['name']);
			
			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'PHP+CMS';
			$mail->Body    = '<b>Поздравляю!</b>, Вы заполнили форму корректно<br>
												Ваши данные:<br>
												Фамилия: '.$_POST['form']['fname'].'<br>
												Имя Отчество: '.$_POST['form']['sname'].'<br>
												Возраст: '.$_POST['form']['age'].'<br>
												Пароль: '.$_POST['form']['password'].'<br>
												Получать уведомлении: '.$_POST['form']['radio'].'<br>
												Любимый цвет: '.$checkbox.'<br>
												Увлечения: '.$_POST['form']['select'].'<br>
												Предпочтения в еде: '.$selectsize.'<br>
												О себе: '.$_POST['form']['textarea'].'<br>
												Скрытая строка: '.$_POST['form']['hidden'].'<br>
												Фото в прикрепленном файле
';
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			
			$mail->send();
			$form_success['send'] = 'Сообщение отправлено на почту';
		} catch (Exception $e) {
			$form_error['send'] = 'Сообщение не отправлено!';
		}
	}
// Вывод всех Хороших уведомлений
	if ($form_success) {
		foreach ($form_success as $one_success){
			echo '<div class="success">'.$one_success.'</div>';
		}
	}
?>

<form enctype="multipart/form-data" action="index.php" method="post">
	<div>
		<p>Укажите Вашу фамилию</p>
		<input <?php if(!empty($form_error['fname'])){ ?> class="error"<?php } ?> type="text" name="form[fname]" value="<?php echo $_POST['form']['fname'];?>"/>
	</div>
	<div>
		<p>Укажите Ваше имя и отчество</p>
		<input <?php if(!empty($form_error['sname'])){ ?> class="error"<?php } ?> type="text" name="form[sname]" value="<?php echo $_POST['form']['sname'];?>"/>
	</div>

	<div>
		<p>Укажите Ваш возраст</p>
		<input <?php if(!empty($form_error['age'])){ ?> class="error"<?php } ?> type="text" name="form[age]" value="<?php echo $_POST['form']['age'];?>"/>
	</div>

	<div>
		<p>Укажите Ваш пароль</p>
		<input <?php if(!empty($form_error['password'])){ ?> class="error"<?php } ?> type="password" name="form[password]" value="<?php echo $_POST['form']['password'];?>"/>
	</div>

	<div>
		<p>Получать уведомлении?</p>
		<label <?php if(!empty($form_error['radio'])){ ?> class="error"<?php } ?>><input type="radio" name="form[radio]" value="Да" <?php if ($_POST['form']['radio']=='Да') {?>checked<?php } ?>/> Да</label>
		<label <?php if(!empty($form_error['radio'])){ ?> class="error"<?php } ?>><input type="radio" name="form[radio]" value="Нет" <?php if ($_POST['form']['radio']=='Нет') {?>checked<?php } ?>/> Нет</label>
	</div>

	<div>
		<p>Выберите Ваш любимый цвет:</p>
		<label <?php if(!empty($form_error['checkbox']) && empty($_POST['form']['checkbox']['checkbox1'])){ ?> class="error"<?php } ?>><input type="checkbox" name="form[checkbox][checkbox1]" value="Белый" <?php if ($_POST['form']['checkbox']['checkbox1']=='Белый') {?>checked<?php } ?>> Белый</label>
		<label <?php if(!empty($form_error['checkbox']) && empty($_POST['form']['checkbox']['checkbox2'])){ ?> class="error"<?php } ?>><input type="checkbox" name="form[checkbox][checkbox2]" value="Зеленый" <?php if ($_POST['form']['checkbox']['checkbox2']=='Зеленый') {?>checked<?php } ?>> Зеленый</label>
		<label <?php if(!empty($form_error['checkbox']) && empty($_POST['form']['checkbox']['checkbox3'])){ ?> class="error"<?php } ?>><input type="checkbox" name="form[checkbox][checkbox3]" value="Красный" <?php if ($_POST['form']['checkbox']['checkbox3']=='Красный') {?>checked<?php } ?>> Красный</label>
		<label <?php if(!empty($form_error['checkbox']) && empty($_POST['form']['checkbox']['checkbox4'])){ ?> class="error"<?php } ?>><input type="checkbox" name="form[checkbox][checkbox4]" value="Синий" <?php if ($_POST['form']['checkbox']['checkbox4']=='Синий') {?>checked<?php } ?>> Синий</label>
	</div>

	<div>
		<p>Ваши увлечения:</p>
		<label>
			<select <?php if(!empty($form_error['select']) && $_POST['form']['select']==0){ ?> class="error"<?php } ?> name="form[select]">
				<option value="0">Выберите увлечение</option>
				<option value="Спать" <?php if($_POST['form']['select']=='Спать'){ ?> selected<?php } ?>>Спать</option>
				<option value="Путешествовать" <?php if($_POST['form']['select']=='Путешествовать'){ ?> selected<?php } ?>>Путешествовать</option>
				<option value="Гулять" <?php if($_POST['form']['select']=='Гулять'){ ?> selected<?php } ?>>Гулять</option>
				<option value="Играть в PS" <?php if($_POST['form']['select']=='Играть в PS'){ ?> selected<?php } ?>>Играть в PS</option>
			</select>
		</label>
	</div>

	<div>
		<p>Ваши предпочтения в еде:</p>
		<label>
			<select <?php if(!empty($form_error['selectsize'])){ ?> class="error"<?php } ?> multiple size="4" name="form[selectsize][]">
				<option disabled>Выберите предпочтения</option>
				<option <?php if(in_array('Суп', $_POST['form']['selectsize'])) {?> selected<?php } ?> value="Суп">Суп</option>
				<option <?php if(in_array('Оливье', $_POST['form']['selectsize'])) {?> selected<?php } ?> value="Оливье">Оливье</option>
				<option <?php if(in_array('Окрошка', $_POST['form']['selectsize'])) {?> selected<?php } ?> value="Окрошка">Окрошка</option>
				<option <?php if(in_array('Салат', $_POST['form']['selectsize'])) {?> selected<?php } ?> value="Салат">Салат</option>
			</select>
		</label>
	</div>

	<div>
		<p>И немножко о себе:</p>
		<label>
			<textarea <?php if(!empty($form_error['textarea'])){ ?> class="error"<?php } ?> name="form[textarea]"><?php echo $_POST['form']['textarea'];?></textarea>
		</label>
	</div>
	
	<div>
		<p>Ваше фото:</p>
		<label <?php if (!empty($form_error['file'])) { ?> class="error"<?php } ?>>
			<input name="form_file" type="file" value="<?php echo $_FILES['form_file']['tmp_name'];?>"/>
		</label>
	</div>

	<div>
		<input type="hidden" name="form[hidden]" value="hidden-str">
	</div>
	
	<div>
		<input type="submit" value="Отправить">
	</div>
</form>
</div>
</body>
</html>