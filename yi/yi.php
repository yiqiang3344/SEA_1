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
Yi::app()->basePath = Yi::app()->rootDir.'/protected';//项目根目录
Yi::app()->baseUri = $_SERVER['SCRIPT_NAME'];//根脚本地址
Yi::app()->baseUrl = substr(Yi::app()->baseUri,0,strpos(Yi::app()->baseUri,'/index.php'));//根地址

//自定义异常和错误处理
set_error_handler('YError::errorHandle');
set_exception_handler('YError::exceptionHandle');

//预加载文件
Yi::app()->setConfig();
Yi::app()->autoload(Yi::app()->config['reloadDirs']);