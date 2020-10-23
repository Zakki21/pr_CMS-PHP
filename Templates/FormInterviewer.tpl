<div class="wrapper-message">
	<h1 style="text-align: center;">Расскажите немного о себе</h1>
	<?php
		if (is_bool($error) === true) {
			// Вывод всех Плохих уведомлений
			foreach ($error_notifications as $one_error){
				echo '<span class="errorsms">'.$one_error.'</span>';
			}
		}
		if ($success_notifications) {
			// Вывод всех Хороших уведомлений
			foreach ($success_notifications as $one_success){
				echo '<div class="success">'.$one_success.'</div>';
			}
		}
	?>
</div>
<div class="wrapper">
	<form enctype="multipart/form-data" action="?continue=yes" method="post">
		<div>
			<p>Укажите Вашу фамилию</p>
			<input <?=(!empty($error_notifications['fname']))?' class="error"':''?> type="text" name="form[fname]" value="<?=$form_interviewer_data['fname']?>"/>
			<i class="info">Символы латиницы и кирилицы</i>
		</div>
		<div>
			<p>Укажите Ваше имя и отчество</p>
			<input <?=(!empty($error_notifications['sname']))?' class="error"':''?> type="text" name="form[sname]" value="<?=$form_interviewer_data['sname']?>"/>
			<i class="info">Символы латиницы и кирилицы через пробел</i>
		</div>
		<div>
			<p>Укажите Ваш возраст</p>
			<input <?=(!empty($error_notifications['age']))?' class="error"':''?> type="text" name="form[age]" value="<?=$form_interviewer_data['age']?>"/>
			<i class="info">Число до 100</i>
		</div>
		<div>
			<p>Укажите Ваш пароль</p>
			<input <?=(!empty($error_notifications['password']))?' class="error"':''?> type="password" name="form[password]" value="<?=$form_interviewer_data['password']?>"/>
			<i class="info">6-15 символов, строчные и верхнего регистра символы, цифру и спецсимволы (!@#$%)</i>
		</div>
		<div>
			<p>Получать уведомлении?</p>
			<?php foreach ($form_interviewer_fields['radio_value'] as $key_rad=>$radio) { ?>
				<label <?=(!empty($error_notifications['radio']))?' class="error"':''?>><input type="radio" name="form[radio]" value="<?=$key_rad?>" <?=($form_interviewer_data['radio']==$key_rad)?'checked':''?>/><?=$radio?></label>
			<?php } ?>
			<i class="info">Выберите один из вариантов</i>
		</div>
		<div>
			<p>Выберите Ваш любимый цвет:</p>
			<?php foreach ($form_interviewer_fields['checkbox_value'] as $key_check=>$checkbox) { ?>
				<label <?=(!empty($error_notifications['checkbox']) && empty($form_interviewer_data['checkbox'][$key_check]))?' class="error"':''?>><input type="checkbox" name="form[checkbox][<?=$key_check?>]" value="<?=$key_check?>" <?=($form_interviewer_data['checkbox'][$key_check]==$key_check)?'checked':''?>><?=$checkbox?></label>
			<?php } ?>
			<i class="info">Выберите несколько вариантов</i>
		</div>
		<div>
			<p>Ваши увлечения:</p>
			<label>
				<select <?=(!empty($error_notifications['select']) && $form_interviewer_data['select']==0)?' class="error"':''?> name="form[select]">
					<?php foreach ($form_interviewer_fields['select_value'] as $key_sel=>$select) { ?>
						<option value="<?=$key_sel!=0?$key_sel:''?>" <?=($form_interviewer_data['select']==$key_sel)?' selected':''?>><?=$select?></option>
					<?php } ?>
				</select>
			</label>
			<i class="info">Выберите один из вариантов</i>
		</div>
		<div>
			<p>Ваши предпочтения в еде:</p>
			<label>
				<select <?=(!empty($error_notifications['selectsize']))?' class="error"':''?> multiple size="4" name="form[selectsize][]">
					<?php foreach ($form_interviewer_fields['selectsize_value'] as $key_selsize=>$selectsize) { ?>
						<option <?//=($key_selsize==0)?' disabled':''?> value="<?=$key_selsize!=0?$key_selsize:''?>" <?=(in_array($key_selsize, $form_interviewer_data['selectsize']))?' selected':empty($form_interviewer_data['selectsize'])&&$key_selsize==0?' selected':''?><?//=empty($form_interviewer_data['selectsize'])&&$key_selsize==0?' selected':''?>><?=$selectsize?></option>
					<?php } ?>
				</select>
			</label>
			<i class="info">Выберите минимум 2 варианта</i>
		</div>
		<div>
			<p>И немножко о себе:</p>
			<label>
				<textarea <?=(!empty($error_notifications['textarea']))?' class="error"':''?> name="form[textarea]"><?=$form_interviewer_data['textarea'];?></textarea>
			</label>
			<i class="info">Напишите не менее 20 символов</i>
		</div>
		<div>
			<p>Ваше фото:</p>
			<label <?=(!empty($error_notifications['file']) && $form_interviewer_data['hidden']=='none')?' class="error"':''?>>
				<input name="form_file" type="file"/>
			</label>
			<?=(!empty($form_interviewer_data['hidden']) && $form_interviewer_data['hidden']!='none')?'<br><br><span class="success">'.$form_interviewer_fields['file_upload_before'].' '.$form_interviewer_data['hidden'].'</span><br><br>':''?>
			<i class="info">Фото не более 3Мб</i>
		</div>
		<div>
			<input type="hidden" name="form[hidden]" value="<?=(!empty($form_interviewer_data['hidden']))?$form_interviewer_data['hidden']:'none'?>">
		</div>
		<div>
			<input type="submit" value="Отправить">
		</div>
	</form>

</div>
