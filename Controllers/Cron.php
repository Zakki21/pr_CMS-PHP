<?php
	namespace Controllers;
	use \Models\Users;
	
	class Cron extends \App\Controller{
		public function index () {
			
			require_once ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Main.php';
			
			$all_users = Users::getUsersToStatus();
			foreach ($all_users as $one_user) {
				print_r($one_user);
			}

		}
	}