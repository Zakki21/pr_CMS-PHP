<?php
	class App {
		public static $router;
		public static $db;
		public static $kernel;
		public $defaultControllerPrefix = 'Controller';
		
		public static function init () {
			spl_autoload_register(['static','loadClass']);
			static::bootstrap();
		}
		
		public static function bootstrap () {
			static::$router = new Framework\Router();
			static::$kernel = new Framework\Kernel();
			static::$db = new Framework\Db();
		}
		
		public static function loadClass ($className) {
			$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
			if (file_exists(ROOTPATH.DIRECTORY_SEPARATOR.$className.'.php')) {
				require_once ROOTPATH.DIRECTORY_SEPARATOR.$className.'.php';
			}
		}
	}