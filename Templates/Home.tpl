<div class="wrapper-message">
	
	<?php
		if ($error) {
			// Вывод всех Плохих уведомлений
			foreach ($form_error as $one_error){
				echo '<span class="errorsms">'.$one_error.'</span>';
			}
		}
		if ($form_success) {
			// Вывод всех Хороших уведомлений
			foreach ($form_success as $one_success){
				echo '<div class="success">'.$one_success.'</div>';
			}
		}
	?>
</div>
<div class="wrapper">
<?php
	if(!empty($user_cookie) && $show_message_cookie==true) {
		?>
		<div>
			<p>Вы уже заполняли данные, хотите продолжить?</p><br>
			<a href="home?continue=yes">Да</a><a href="home?continue=no">Нет</a>
		</div>
		<?php
	}
	else {
		?>
		<form enctype="multipart/form-data" action="home<?=(!empty($continue) && $continue=='yes')?'?continue=no':'?continue=no'?>" method="post">
			<div>
				<p>Укажите Вашу фамилию</p>
				<input <?=(!empty($form_error['fname']))?' class="error"':''?> type="text" name="form[fname]" value="<?=$form_val['fname']?>"/>
				<i class="info">Символы латиницы и кирилицы</i>
			</div>
			<div>
				<p>Укажите Ваше имя и отчество</p>
				<input <?=(!empty($form_error['sname']))?' class="error"':''?> type="text" name="form[sname]" value="<?=$form_val['sname']?>"/>
				<i class="info">Символы латиницы и кирилицы через пробел</i>
			</div>
			<div>
				<p>Укажите Ваш возраст</p>
				<input <?=(!empty($form_error['age']))?' class="error"':''?> type="text" name="form[age]" value="<?=$form_val['age']?>"/>
				<i class="info">Цифры</i>
			</div>
			<div>
				<p>Укажите Ваш пароль</p>
				<input <?=(!empty($form_error['password']))?' class="error"':''?> type="password" name="form[password]" value="<?=$form_val['password']?>"/>
				<i class="info">6-15 символов, строчные и верхнего регистра символы, цифру и спецсимволы</i>
			</div>
			<div>
				<p>Получать уведомлении?</p>
				<?php foreach ($item_values['radio_value'] as $key_rad=>$radio) { ?>
					<label <?=(!empty($form_error['radio']))?' class="error"':''?>><input type="radio" name="form[radio]" value="<?=$key_rad?>" <?=($form_val['radio']==$key_rad)?'checked':''?>/><?=$radio?></label>
				<?php } ?>
				<i class="info">Выберите один из вариантов</i>
			</div>
			<div>
				<p>Выберите Ваш любимый цвет:</p>
				<?php foreach ($item_values['checkbox_value'] as $key_check=>$checkbox) { ?>
					<label <?=(!empty($form_error['checkbox']) && empty($form_val['checkbox'][$key_check]))?' class="error"':''?>><input type="checkbox" name="form[checkbox][<?=$key_check?>]" value="<?=$key_check?>" <?=($form_val['checkbox'][$key_check]==$key_check)?'checked':''?>><?=$checkbox?></label>
				<?php } ?>
				<i class="info">Выберите несколько вариантов</i>
			</div>
			<div>
				<p>Ваши увлечения:</p>
				<label>
					<select <?=(!empty($form_error['select']) && $_POST['form']['select']==0)?' class="error"':''?> name="form[select]">
						<?php foreach ($item_values['select_value'] as $key_sel=>$select) { ?>
							<option value="<?=$key_sel?>" <?=($form_val['select']==$key_sel)?' selected':''?>><?=$select?></option>
						<?php } ?>
					</select>
				</label>
				<i class="info">Выберите один из вариантов</i>
			</div>
			<div>
				<p>Ваши предпочтения в еде:</p>
				<label>
					<select <?=(!empty($form_error['selectsize']))?' class="error"':''?> multiple size="4" name="form[selectsize][]">
						<?php foreach ($item_values['selectsize_value'] as $key_selsize=>$selectsize) { ?>
							<option <?=($key_selsize==0)?' disabled':''?> value="<?=$key_selsize?>" <?=(in_array($key_selsize, $form_val['selectsize']))?' selected':''?>><?=$selectsize?></option>
						<?php } ?>
					</select>
				</label>
				<i class="info">Выберите минимум 2 варианта</i>
			</div>
			<div>
				<p>И немножко о себе:</p>
				<label>
					<textarea <?=(!empty($form_error['textarea']))?' class="error"':''?> name="form[textarea]"><?=$form_val['textarea'];?></textarea>
				</label>
				<i class="info">Напишите не менее 20 символов</i>
			</div>
			<div>
				<p>Ваше фото:</p>
				<label <?=(!empty($form_error['file']) && empty($form_val['hidden']))?' class="error"':''?>>
					<input name="form_file" type="file" value="<?=$form_file['tmp_name'];?>"/>
				</label>
				<?=(!empty($form_val['hidden']))?'<br><br><span class="success">'.$item_values['success_value']['file_upload_before'].' '.$form_val['hidden'].'</span><br><br>':''?>
				<i class="info">Фото не более 3Мб</i>
			</div>
			<div>
				<input type="hidden" name="form[hidden]" value="<?=(!empty($form_val['hidden']))?$form_val['hidden']:''?>">
			</div>
			<div>
				<input type="submit" value="Отправить">
			</div>

		</form>
	<?php } ?>
</div>
