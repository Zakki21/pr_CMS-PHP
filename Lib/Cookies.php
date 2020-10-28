<?php
	namespace Lib;
	
	class Cookies {
		
		public function getCookie ($cookie_name) {
			return $_COOKIE[$cookie_name];
		}
		
		public function setCookie ($cookie_name, array $data, $time) {
			setcookie($cookie_name, serialize($data), $time);
		}
		
		public function deleteCookie ($cookie_name) {
			setcookie($cookie_name, '', time()-3600);
		}
	}