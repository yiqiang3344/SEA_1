<?php
/*
**yi框架
* @author sidneyYi
*/
define('YROOT',dirname(__FILE__));
defined('YDEBUG') or define('YDEBUG',true);


require_once(YROOT.'/yibase.php');
//设置基本路径
Yi::app()->rootDir = getcwd();//框架根目录
Yi::app()->baseUri = $_SERVER['SCRIPT_NAME'];//根脚本地址
Yi::app()->baseUrl = substr(Yi::app()->baseUri,0,strpos(Yi::app()->baseUri,'/index.php'));//根地址

//自定义异常和错误处理
set_error_handler('YError::errorHandle');
set_exception_handler('YError::exceptionHandle');

//预加载文件
Yi::app()->setConfig();
Yi::app()->autoload(Yi::app()->config['reloadDirs']);

//路由
if(!isset($_SERVER['PATH_INFO'])){
	Yi::app()->gotoView();
}

$path = explode('/', $_SERVER['PATH_INFO']);

if(isset($path[1]) && !empty($path[1])){//防止多余/时报错
	$C_name = ucwords($path[1]).'Controller';
	$C = new $C_name;//首字母大写
}else{
	Yi::app()->gotoView();
}

if(isset($path[2]) && !empty($path[2])){
	$a = 'action'.ucwords($path[2]);//方法首字母都要大写
	if(!method_exists($C,$a)){
		Yi::app()->gotoView();
	}
	$C->$a();
}else{
	Yi::app()->gotoView();
}