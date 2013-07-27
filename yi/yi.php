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

//路由设置
/*
	规则
		控制器文件名必须小写+Controller结尾
		控制器类名对应其文件名，但首字母必须大写
		控制器方法名按驼峰式命名方法，可访问的方法加action前缀
*/

//路由
if(!isset($_SERVER['PATH_INFO'])){
	Yi::app()->gotoView();
}

$path = explode('/', strtolower($_SERVER['PATH_INFO']));//路径全小写处理

if(isset($path[1]) && !empty($path[1])){//防止多余/时报错
	require(Yi::app()->rootDir.'/controller/'.$path[1].'Controller.php');
	$C_name = ucwords($path[1]).'Controller';
	$C = new $C_name;//首字母大写
}else{
	Yi::app()->gotoView();
}

if(isset($path[2]) && !empty($path[2])){
	$C->{'action'.ucwords($path[2])}();//方法首字母都要大写
}else{
	Yi::app()->gotoView('main/index');
}