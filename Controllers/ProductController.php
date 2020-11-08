<?php
	namespace Controllers;
	use \Lib\Products;
	
	class ProductController extends \Framework\Controller {
		public $products;
		
		public function __construct() {
			$this->products = new Products;
		}
		
		public function indexAction () {
			$data = array(
				'all_products' => $this->products->allProducts()
			);
			return $this->render('Products', $data);
		}
	}