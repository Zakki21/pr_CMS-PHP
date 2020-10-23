<?php
	namespace Framework;
	use App;
	use \Controllers;
	
	class Kernel{
		public $defaultControllerName = 'Index';
		public $defaultControllerPrefix = 'Controller';
		public $defaultActionName = "indexAction";
		public $defaultActionPrefix = "Action";
		
		public function launch () {
			list($controllerName, $actionName, $params) = App::$router->resolve();
			echo $this->launchAction($controllerName, $actionName, $params);
		}
		
		public function launchAction ($controllerName, $actionName, $params) {
			$controllerName = empty($controllerName) ? $this->defaultControllerName.$this->defaultControllerPrefix : ucfirst($controllerName).$this->defaultControllerPrefix;
			if(!file_exists(ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php')){
				require_once ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'Error'.$this->defaultControllerPrefix.'.php';
			}
			else
				require_once ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php';
			if(!class_exists("\\Controllers\\".ucfirst($controllerName))){
				$controller = new \Controllers\ErrorController;
			}
			else {
				$controllerName = "\\Controllers\\".ucfirst($controllerName);
				$controller = new $controllerName;
			}
			$actionName = empty($actionName) ? $this->defaultActionName : $actionName.$this->defaultActionPrefix;
			if (!method_exists($controller, $actionName))
				return $controller->error404Action();
			else
				return $controller->$actionName($params);
			
		}
	}