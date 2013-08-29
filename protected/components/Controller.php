<?php
class Controller{
    public $layout = '//layouts/main';
    public $pageTitle;
    public $template;
    public $bind;
    public $user;

    public function __construct(){
        $this->pageTitle = Yi::app()->config['webName'];
        $this->init();
    }

    public function init(){
        isset($_SESSION['user']) && $this->user = $_SESSION['user'];
        YDatabase::setDb();
    }

    public function getControllerName(){
		$arr = explode('Controller',get_class($this));
		return strtolower($arr[0]);
	}

    public function getPageData($page,$params){
        list($c,$a) = explode('/', $page);
        $c_name = ucwords($c).'Controller';
        $action = 'action'.ucwords($a);
        $controller = new $c_name;
        $ret = false;
        if(method_exists($controller,$action)){
            $g = $_GET;
            foreach($params as $k=>$v){
                $_GET[$k] = $v;
            }
            $ret = $controller->$action(true);
            $_GET = $g;
        }
        return $ret;
    }

    public function getJsFile($page){
        return file_get_contents(Yi::app()->rootDir.'/'.Yi::app()->lang.'/js/'.strtolower($page).'.js');
    }

    public function render($view,$bind=array(),$template_flag=false){
        //检查是否有事物未处理
        if(getDbh()->checkTransaction()){
            yDie('Transaction no deal.');
        }

        if(is_array($view)){
            echo json_encode($view);
            return true;
        }elseif($view==Y::GET_BIND){
            return $bind;
        }

        if($template_flag==Y::TEMPLATE_PHP || ($template_flag==Y::TEMPLATE_JS && Yi::app()->lang=='dev')){
            $this->template = file_get_contents(Yi::app()->rootDir.'/'.Yi::app()->lang.'/template/'.$this->getControllerName().'/'.$view.'.php');
        }

        ob_start();
        ob_implicit_flush(false);
        extract($bind,EXTR_OVERWRITE);
        unset($bind);
        $lang = Yi::app()->lang=='dev'?'':Yi::app()->lang;
        require(Yi::app()->basePath.'/views/'.$this->getControllerName().'/'.$lang.'/'.$view.'.php');
        $content=ob_get_clean();
        require(Yi::app()->basePath.'/views'.$this->layout.'.php');
        unset($content);

        return true;
    }

    public function url($c,$a=null,$p=array()){
        if($a!==null){
            if(is_array($a)){
                $ret = Yi::app()->baseUri.'/'.$c.'?';
                $params = $a;
            }else{
                $ret = Yi::app()->baseUri.'/'.$c.'/'.$a.'?';
                $params = $p;
            }
            foreach($params as $k=>$v){
                $ret .= urlencode ( $k ) . "=" . urlencode ( $v ) . "&";
            }
        }else{
            $lang = '';

            if(preg_match('{^js/|^template/}', $c) && !preg_match('{^js/(jquery|main|url|shCore)\.}',$c)){
                $c = Yi::app()->lang.'/'.$c;
            }

            //非开发中 自动判断是否有压缩过的文件
            if(Yi::app()->lang!='dev' && preg_match('{^('.Yi::app()->lang.'/js'.'|js|css)/.*?[^\.min\.js$|^\.min\.css$]}', $c) && is_file(Yi::app()->rootDir.'/'.($n_c=str_replace(array('.js','.css'),array('.min.js','.min.css'),$c)))){
                $c = $n_c;
            }

            $md5 = @md5_file (Yi::app()->rootDir.'/'.$c);
            $ret = Yi::app()->baseUrl.'/'.$c.($md5 ? '?v=' . substr ( $md5, 0, 8 ) : '');
        }
        return $ret;
    }

    public function getUserData(){
        return $this->user;
    }

    public function getUser(){
        if(!$this->user){
            yDie('didnt login!');
        }
        return $this->user;
    }
}