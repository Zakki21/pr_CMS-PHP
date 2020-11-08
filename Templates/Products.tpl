<div class="wrapper-message">
	<?php foreach ($all_products as $one_product) { ?>
		<div><span style="font-weight: bold; color: green;">Категория товара: <?=$one_product['name_category']?></span><br><br>
			Товары категории:<br>
			<ul>
			<?php foreach ($one_product['products'] as $product) { ?>
				<li><span style="font-weight: bold; padding: 0 0 0 30px;"><?=$product['name']?></span><br>
					<i style="padding: 0 0 0 50px;">Атрибуты товара:</i><br>
					<ol style="padding: 0 0 0 70px;">
					<?php foreach ($product['atributes'] as $product_atribut) { ?>
						<li><?=$product_atribut['name']?> - <?=$product_atribut['value']?></li>
					<?php } ?>
					</ol><br>
				</li>
			<?php } ?>
			</ul>
		</div>
	<?php } ?>
</div>
