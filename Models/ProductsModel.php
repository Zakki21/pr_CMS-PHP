<?php
	namespace Models;
	use App;
	use \Framework\Db;
	
	class ProductsModel extends \Framework\Db {
		
		public function getCategories () {
			return App::$db->execute('SELECT * FROM product_category');
		}
		
		public function getProductsToCategoryId ($id_category) {
			return App::$db->execute('SELECT * FROM products WHERE id_category=' . $id_category);
		}

		public function getAtributesToProductId ($id_product) {
			return App::$db->execute('SELECT product_atribute.name, product_atribute.value FROM product_atribute
 																		LEFT JOIN product_to_atribute
        														ON product_to_atribute.id_product = '.$id_product.'
        														WHERE product_atribute.id_atribute = product_to_atribute.id_atribute');
		}
	}
