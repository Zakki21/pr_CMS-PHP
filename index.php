<?php
	
	define('ROOTPATH', dirname(__FILE__));
	
	require dirname(__FILE__) . '/Framework/App.php';
	
	App::init();
	App::$kernel->launch();