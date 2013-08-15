<?php
class Yi
{
	public $lang;
	public $config;
	public $data;//做全局存储变量

	private static $yi;
	public static function app(){
		if(!self::$yi){
			self::$yi = new self;
		}
		return self::$yi;
	}

	public function run(){
		//路由
		if(!isset($_SERVER['PATH_INFO'])){
			$this->gotoView();
		}

		$path = explode('/', $_SERVER['PATH_INFO']);

		if(isset($path[1]) && !empty($path[1])){//防止多余/时报错
			$C_name = ucwords($path[1]).'Controller';
			$C = new $C_name;//首字母大写
		}else{
			$this->gotoView();
		}


		if(isset($path[2]) && !empty($path[2])){
			$a = 'action'.ucwords($path[2]);//方法首字母都要大写
			if(!method_exists($C,$a)){
				$this->gotoView();
			}
			$C->$a();
		}else{
			$this->gotoView();
		}
	}

	public function setConfig($uri='main'){
		$cfg = $this->getConfig($uri);
		$cfg['reloadDirs'][] = YROOT;
		$this->config = $cfg;
		$this->lang = $this->config['lang'];
	}


	public function autoload($dirs){
		AutoLoader::register($dirs);
	}

	public function gotoView($url=null){
		$url===null and $url = YConfig::get('main','errorView');
		header('Location: '.$this->baseUri.'/'.$url); //默认访问
		die;
	}

	public function getConfig($cfg,$key=false){
		return YConfig::get($cfg,$key);
	}

	public function time($refresh = false,$add_time=0) {
		if ($refresh !== true && $refresh !== false) {
			return strtotime($refresh);
		}
		if (!defined('CUR_TIME') || $refresh) {
			$dba = YDatabase::YGetDbah();
			//sql 结果为字符串型，在js中做数学运算会出问题
			$t = (int)$dba->selectOne('select unix_timestamp()')+$add_time;
			if (!defined('CUR_TIME')) {
				define('CUR_TIME', $t);
			}
			return $t;
		}
		return CUR_TIME;
	}
}

class YException extends Exception
{
	public $errorInfo;

	/**
	 * Constructor.
	 * @param string $message PDO error message
	 * @param integer $code PDO error code
	 * @param mixed $errorInfo PDO error info
	 */
	public function __construct($message,$code=0,$errorInfo=null)
	{
		$this->errorInfo=$errorInfo;
		parent::__construct($message,$code);
	}
}

final class AutoLoader
{
    private $baseDirs;
    private function __construct($baseDirs = array()){
        if (count($baseDirs)==0) {
            $baseDirs[] = getcwd().'/..';
        } else {
        	foreach($baseDirs as &$dir){
        		$dir = rtrim($dir, '/');
        	}
        	$this->baseDirs = $baseDirs;
        }
    }

    public static function register($baseDirs = array()){
        $loader = new self($baseDirs);
        spl_autoload_register(array($loader, 'autoload'));
    }

    public function autoload($class){
        if ($class[0] === '\\') {
            $class = substr($class, 1);
        }
        foreach ($this->baseDirs as $dir) {
            $file = sprintf('%s/%s.php', $dir, $class);
            if (file_exists($file)) {
	            require $file;
	            return;
            }
        }
    }
}

final class YConfig
{
	public static function get($config,$key=false){
		if(isset(Yi::app()->data['configs'][$config])){
			$cfg = Yi::app()->data['configs'][$config];
		}else{
			$cfg = include(Yi::app()->basePath.'/config/'.$config.'.cfg.php');
			Yi::app()->data['configs'][$config] = $cfg;
		}
		return $key?$cfg[$key]:$cfg;
	}
}



final class YError
{
	public static function errorHandle($errno, $errstr, $errfile, $errline){
		restore_error_handler();
		restore_exception_handler();
		$log ='record_time:' . date('Y-m-d H:i:s') . '\n';
		$log.='URL:' . $_SERVER['REQUEST_URI'] . '\n';
		$log.='GET:' . var_export($_GET, true) . '\n';
		$log.='POST:' . var_export($_POST, true) . '\n';
		$log.='COOKIE:' . var_export($_COOKIE, true) . '\n';
		$log .= "#0 Error on $errfile:$errline";
		$show = '<div style="background:#ccc;font-size: 20px;margin:10px;">';
		$show .= "<div><b>error:</b> [$errno] $errstr.</div>";
		$show .= "<div>#0 Error on $errfile:$errline</div>";
		foreach (debug_backtrace(false) as $k => $v) {
			if($k==0){
				continue;
			}
			$d ="#$k ".$v['function'] .' called at [' . $v['file'] . ':' . $v['line'] . ']';
			$log.=$d;
			$show.='<div>'.$d.'</div>';
		}
		$show.='</div>';
		$log.='\n';

		if(YDEBUG){
			echo $show;
		}else{
			self::log($log);
			Yi::app()->getoView();
		}
		die;
	}
	public static function exceptionHandle($e){
		restore_error_handler();
		restore_exception_handler();
		$log ='record_time:' . date('Y-m-d H:i:s') . '\n';
		$log.='URL:' . $_SERVER['REQUEST_URI'] . '\n';
		$log.='GET:' . var_export($_GET, true) . '\n';
		$log.='POST:' . var_export($_POST, true) . '\n';
		$log.='COOKIE:' . var_export($_COOKIE, true) . '\n';
		$show = '<div style="background:#ccc;font-size: 20px;margin:10px;">';
		$show .= '<div><b>'.get_class($e).':</b> '.$e->getMessage().' ('.$e->getFile().':'.$e->getLine().')'.'</div>';
		foreach ($e->getTrace() as $k => $v) {
			$d ='#'.$k.' '.$v['function'] .' called at [' . $v['file'] . ':' . $v['line'] . ']';
			$log.=$d;
			$show.='<div>'.$d.'</div>';
		}
		$show.='</div>';
		$log.='\n';

		if(YDEBUG){
			echo $show;
		}else{
			self::log($log);
			Yi::app()->getoView();
		}
		die;
	}

	public static function log($m){
		$url = Yi::app()->rootDir.'/data/';
		$filename = 'error_log.txt';
		if (!is_dir($url)) {
			@mkdir($url);
		}
		if ($filename) {
			@file_put_contents($url . $filename, $log, FILE_APPEND);
		}
	}
}