<?php
	namespace Framework;
	use App;
	
	class Db {
		public $pdo;
		public function __construct() {
			$settings = $this->getPDOSettings();
			$this->pdo = new \PDO($settings['dsn'], $settings['user'], $settings['pass'], null);
		}

		protected function getPDOSettings() {
			$config = include ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Db.php';
			$result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
			$result['user'] = $config['user'];
			$result['pass'] = $config['pass'];
			return $result;
		}

		public function execute($query) {
			$stmt = $this->pdo->prepare($query);
			return $stmt;
		}
		
		public function getPDO() {
			return $this->pdo;
		}
/**/
	}