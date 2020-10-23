<?php
	namespace Lib;
	
	class Cookies {
		
		public function getCookieAction ($cookie_name) {
			return $_COOKIE[$cookie_name];
		}
		
		public function setCookieAction ($cookie_name, array $data, $time) { //(time()+3600*24*30*365)
			setcookie($cookie_name, serialize($data), $time);  // срок действия год
		}
		
		public function deleteCookieAction ($cookie_name) {
			setcookie($cookie_name, '', time()-3600);
		}
	}