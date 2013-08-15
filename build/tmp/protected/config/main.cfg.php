<?php
define('MYSQL_HOST', defined('SAE_MYSQL_HOST_M')?SAE_MYSQL_HOST_M:'@mysql.host@');
define('MYSQL_PORT', defined('SAE_MYSQL_PORT')?SAE_MYSQL_PORT:'@mysql.port@');
define('MYSQL_DB', defined('SAE_MYSQL_DB')?SAE_MYSQL_DB:'@mysql.db@');
define('MYSQL_USER', defined('SAE_MYSQL_USER')?SAE_MYSQL_USER:'@mysql.user@');
define('MYSQL_PASS', defined('SAE_MYSQL_PASS')?SAE_MYSQL_PASS:'@mysql.pass@');
define('CACHE_HOST', defined('SAE_CACHE_HOST_M')?SAE_CACHE_HOST_M:'@cache.host@');
define('CACHE_PORT', defined('SAE_CACHE_PORT')?SAE_CACHE_PORT:'@cache.port@');
require_once('constant.php');
return array(
	'webName'=>'@app.name@',
	'errorView'=>'Main/Main',
	'lang'=>'@app.lang@',
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