<b>Поздравляю!</b>, Вы заполнили форму корректно<br>
Ваши данные:<br>
Фамилия: <?=$form_val['fname']?><br>
Имя Отчество: <?=$form_val['sname']?><br>
Возраст: <?=$form_val['age']?><br>
Пароль: <?=$form_val['password']?><br>
Получать уведомлении: <?=$item_values['radio_value'][$form_val['radio']]?><br>
Любимый цвет: <?php foreach ($form_val['checkbox'] as $k_c=>$v_c) { ?>
								<?=$item_values['checkbox_value'][$k_c]?>,
							<?php } ?><br>
Увлечения: <?=$item_values['select_value'][$form_val['select']]?><br>
Предпочтения в еде: <?php foreach ($form_val['selectsize'] as $k_s=>$v_s) { ?>
											<?=$item_values['selectsize_value'][$v_s]?>,
										<?php } ?><br>
О себе: <?=$form_val['textarea']?><br>
Скрытая строка: <?=$form_val['hidden']?><br>
Фото в прикрепленном файле
