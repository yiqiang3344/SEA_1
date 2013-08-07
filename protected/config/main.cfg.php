<?php
require_once('constant.php');
return array(
	'webName'=>'易框架',
	'errorView'=>'Main/Main',
	'lang'=>'dev',
	'reloadDirs'=>array(
		Yi::app()->basePath.'/components',
		Yi::app()->basePath.'/model',
		Yi::app()->basePath.'/controller',
		Yi::app()->basePath.'/components/mustache',
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