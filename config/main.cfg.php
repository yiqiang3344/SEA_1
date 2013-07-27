<?php
return array(
	'errorView'=>'main/main',
	'reloadDirs'=>array(
		Yi::app()->rootDir.'/components',
		Yi::app()->rootDir.'/model',
		Yi::app()->rootDir.'/components/mustache',
	),
	'db'=>array(
		'connectionString' => 'mysql:host='.SAE_MYSQL_HOST_M.';port='.SAE_MYSQL_PORT.';charset=utf8;',
		'dbname' => SAE_MYSQL_DB,
		'username' => SAE_MYSQL_USER,
		'password' => SAE_MYSQL_PASS,
	),
	'cache'=>array(
		'server' => '192.168.3.33',
		'port' => '11211',
	),
);