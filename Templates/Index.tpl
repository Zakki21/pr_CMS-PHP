<div class="wrapper">
<?php
	if(!empty($cookies)) {
			?>
			<div>
				<p>Вы уже заполняли данные, хотите продолжить?</p><br><br>
				<a href="/interviewer?continue=yes">Да</a><a href="/interviewer?continue=no">Нет</a>
			</div>
			<?php
	}
	else { ?>
		<div>
			<p>У нас есть предложение заполнить краткую информацию о себе. Готовы?<p><br><br>
			<a href="/interviewer">Да</a> Больше выбора у Вас нет)))
		</div>
	<?php
	}
	?>
</div>
