<?php
defined('APP_DEV') or define('APP_DEV',true);
defined('APP_DEBUG') or define('APP_DEBUG',true);
define('ROOT', getcwd());
require_once(ROOT.'/protected/includes/functions.inc.php');
defined('SAE_MYSQL_HOST_M') or setDbConfig();
require ROOT.'/yi/yi.php';
Yi::app()->run();
