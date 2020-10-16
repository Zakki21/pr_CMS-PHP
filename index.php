<?php
	
	define('ROOTPATH', dirname(__FILE__));
	
	require dirname(__FILE__) . '/App/App.php';
	
	App::init();
	App::$kernel->launch();