<?php
	namespace Controllers;
	
	class Error extends \App\Controller{
		public function error404 (){
			echo 'error 404';
		}
		public function error500 (){
			echo 'error 500';
		}
	}