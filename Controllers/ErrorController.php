<?php
	namespace Controllers;
	
	class ErrorController extends \Framework\Controller{
		public function error404Action (){
			header("HTTP/1.0 404 Not Found");
			return $this->render('404', array());
		}
	}