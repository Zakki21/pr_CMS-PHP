<?php
	namespace Controllers;
	use \Lib\Cookies;
	
	class IndexController extends \Framework\Controller{
		
		public $cookies_interviewer;
		
		public function __construct() {
			$this->cookies_interviewer = new Cookies;
		}
		
		public function indexAction () {
			if(!empty($this->cookies_interviewer->getCookieAction('user_form_interviewer'))){
				$cookies = $this->cookies_interviewer->getCookieAction('user_form_interviewer');
			}
			else
				$cookies = '';
			
			$data = array(
				'cookies'=>$cookies
			);
			
			return $this->render('Index', $data);
		}
		
	}