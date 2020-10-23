<?php
	namespace Framework;
	use App;
	
	class Controller {
		public function renderLayout ($body) {
			ob_start();
			require ROOTPATH.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Layout'.DIRECTORY_SEPARATOR."Layout.tpl";
			return ob_get_clean();
		}
		
		public function render ($viewName, array $params) {
			$viewFile = ROOTPATH.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.$viewName.'.tpl';
			extract($params);
			ob_start();
			require $viewFile;
			$body = ob_get_clean();
			ob_end_clean();
			if (defined(NO_LAYOUT)){
				return $body;
			}
			return $this->renderLayout($body);
		}
		
	}