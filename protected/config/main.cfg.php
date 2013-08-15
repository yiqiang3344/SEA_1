<?php
define('MYSQL_HOST', defined('SAE_MYSQL_HOST_M')?SAE_MYSQL_HOST_M:'localhost');
define('MYSQL_PORT', defined('SAE_MYSQL_PORT')?SAE_MYSQL_PORT:'3306');
define('MYSQL_DB', defined('SAE_MYSQL_DB')?SAE_MYSQL_DB:'sae_1');
define('MYSQL_USER', defined('SAE_MYSQL_USER')?SAE_MYSQL_USER:'root');
define('MYSQL_PASS', defined('SAE_MYSQL_PASS')?SAE_MYSQL_PASS:'yjq');
define('CACHE_HOST', defined('SAE_CACHE_HOST_M')?SAE_CACHE_HOST_M:'192.168.3.33');
define('CACHE_PORT', defined('SAE_CACHE_PORT')?SAE_CACHE_PORT:'11211');
require_once('constant.php');
return array(
	'webName'=>'易框架',
	'errorView'=>'Main/Main',
	'lang'=>'zh_cn',
	'reloadDirs'=>array(
		Yi::app()->basePath.'/components',
		Yi::app()->basePath.'/model',
		Yi::app()->basePath.'/controller',
		Yi::app()->basePath.'/components/mustache',
	),
	'db'=>array(
		'connectionString' => 'mysql:host='.MYSQL_HOST.';port='.MYSQL_PORT.';charset=utf8;',
		'dbname' => MYSQL_DB,
		'username' => MYSQL_USER,
		'password' => MYSQL_PASS,
	),
	'cache'=>array(
		'server' => CACHE_HOST,
		'port' => CACHE_PORT,
	),
);