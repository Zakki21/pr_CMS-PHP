<?php
	return array(
	'fname' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^[A-Za-zА-Яа-яЁё]+$/u"))
	),
	'sname' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^[A-Za-zА-Яа-яЁё|^\s]+$/u"))
	),
	'age' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' => array("options" => array("regexp" => "/^(?:100|\d{1,2})(?:\.\d{1,2})?$/"))
	),
	'password' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/u"))
	),
	'radio' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^(yes|no)$/"))
	),
	'checkbox' => array(
		'filter_name' => 'filter_array',
		'filter' => '',
		'options' => 2
	),
	'select' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" =>  array("regexp" => "/(1|2|3|4)/"))
	),
	'selectsize' => array(
		'filter_name' => 'filter_array',
		'filter' => '',
		'options' => 2
	),
	'textarea' => array(
		'filter_name' => 'filter_var',
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" =>  array("regexp" => "/^[A-Za-zА-Яа-яЁё\s0-9]{20,}$/u"))
	),
//	'hidden' => array(
//		'filter_name' => 'filter_var',
//		'filter' => 'FILTER_VALIDATE_REGEXP',
//		'options' =>  array("options" =>  array("regexp" => "/^[1]$/u"))
//	),
//	'file' => array(
//		'filter_name' => 'filter_file',
//		'filter' => FILTER_VALIDATE_REGEXP,
//		'options' =>  array("options" =>  array("regexp" => "/^[A-Za-zА-Яа-яЁё\s0-9]{20,}$/u"))
//	),
);

