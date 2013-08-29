<?php
defined('APP_DEV') or define('APP_DEV',true);//是否是开发阶段
defined('APP_DEBUG') or define('APP_DEBUG',true);//是否显示debug信息
define('YDEBUG',APP_DEBUG);//设置yi框架debug信息
define('ROOT', getcwd());
session_start();
require_once(ROOT.'/protected/includes/functions.inc.php');
require ROOT.'/yi/yi.php';
Yi::app()->run();
