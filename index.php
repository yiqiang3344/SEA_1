<?php
define('ROOT', getcwd());
require_once(ROOT.'/includes/functions.inc.php');
defined('SAE_MYSQL_HOST_M') or setDbConfig();
require ROOT.'/yi/yi.php';
