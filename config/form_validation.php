<?php
	return array(
	'fname' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^[A-Za-zА-Яа-яЁё]+$/u"))
	),
	'sname' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^[A-Za-zА-Яа-яЁё\s]+$/u"))
	),
	'age' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' => array("options" => array("regexp" => "/^[0-9]+$/"))
	),
	'password' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/"))
	),
	'radio' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" => array("regexp" => "/^(yes|no)$/"))
	),
	'checkbox' => array(
		'filter' => 'FILTER_VALIDATE_ARRAY',
		'options' => 2
	),
	'select' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" =>  array("regexp" => "/(1|2|3|4)/"))
	),
	'selectsize' => array(
		'filter' => 'FILTER_VALIDATE_ARRAY',
		'options' => 2
	),
	'textarea' => array(
		'filter' => FILTER_VALIDATE_REGEXP,
		'options' =>  array("options" =>  array("regexp" => "/^[A-Za-zА-Яа-яЁё\s0-9]{20,}$/"))
	),
);

