<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
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
			<a href="index.php?continue=yes">Да</a><a href="index.php?continue=no">Нет</a>
		</div>
		<?php
	}
		else {
	?>
	<form enctype="multipart/form-data" action="index.php<?=(!empty($continue) && $continue=='yes')?'?continue=no':'?continue=no'?>" method="post">
		<?php foreach ($item_values['form_value'] as $kay_value=>$item_value) { ?>
			<?php if ($item_value['type']=='text' || $item_value['type']=='password') { ?>
				<div>
					<p><?=$item_value['p']?></p>
					<input <?=(!empty($form_error[$kay_value]))?' class="error"':''?> type="<?=$item_value['type']?>" name="form[<?=$kay_value?>]" value="<?=$form_val[$kay_value]?>"/>
					<i class="info"><?=$item_value['i']?></i>
				</div>
			<?php } if ($item_value['type']=='radio') {?>
				<div>
					<p><?=$item_value['p']?></p>
					<?php foreach ($item_values[$kay_value.'_value'] as $key_rad=>$radio) { ?>
						<label <?=(!empty($form_error[$kay_value]))?' class="error"':''?>><input type="<?=$item_value['type']?>" name="form[<?=$kay_value?>]" value="<?=$key_rad?>" <?=($form_val[$kay_value]==$key_rad)?'checked':''?>/><?=$radio?></label>
					<?php } ?>
					<i class="info"><?=$item_value['i']?></i>
				</div>
			<?php } if ($item_value['type']=='checkbox') {?>
				<div>
					<p><?=$item_value['p']?></p>
					<?php foreach ($item_values[$kay_value.'_value'] as $key_check=>$checkbox) { ?>
						<label <?=(!empty($form_error[$kay_value]) && empty($form_val[$kay_value][$key_check]))?' class="error"':''?>><input type="<?=$item_value['type']?>" name="form[<?=$kay_value?>][<?=$key_check?>]" value="<?=$key_check?>" <?=($form_val[$kay_value][$key_check]==$key_check)?'checked':''?>><?=$checkbox?></label>
					<?php } ?>
					<i class="info"><?=$item_value['i']?></i>
				</div>
			<?php } ?>
		<?php } ?>
		
		</form>
		<?php } ?>
	</div>
</body>
</html>