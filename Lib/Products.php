<?php
	namespace Lib;
	use \Models\ProductsModel;
	
	class Products {
		public $products = array();
		
		public function allProducts () {
			$categories = $this->getCategories();
			foreach ($categories as $one_category) {
				$products_to_category = $this->getProductsToCategory($one_category['id_category']);
				$this->products[$one_category['id_category']]['name_category'] = $one_category['name'];
				foreach ($products_to_category as $product_to_category) {
					$this->products[$one_category['id_category']]['products'][$product_to_category['id_product']] = $product_to_category;
					$this->products[$one_category['id_category']]['products'][$product_to_category['id_product']]['atributes'] = $this->getAtributesToProduct($product_to_category['id_product']);
				}
			}
			return $this->products;
		}
	
		public function getCategories () {
			$categories = ProductsModel::getCategories();
			return $categories->fetchAll();
		}
		
		public function getProductsToCategory ($id_category) {
			$products_to_category = ProductsModel::getProductsToCategoryId($id_category);
			return $products_to_category->fetchAll();
		}
		public function getAtributesToProduct ($id_product) {
			$atributes_to_product = ProductsModel::getAtributesToProductId($id_product);
			return $atributes_to_product->fetchAll();
		}
	}