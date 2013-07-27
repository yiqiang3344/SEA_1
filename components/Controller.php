<?php
class Controller{
    public $layout = '//layouts/main';
    public $pageTitle;

    public function __construct(){
        $this->pageTile = Yi::app()->config['webName'];
        $this->init();
    }

    public function init(){
        YDatabase::setDb();
    }


    public function getControllerName(){
		$arr = explode('Controller',get_class($this));
		return strtolower($arr[0]);
	}

    public function render($view,$bind,$use_template=false){
        if(is_array($view)){
            echo json_encode($view);
            return;
        }

        if($use_template){
            $m = new Mustache_Engine;
            $content = $m->render(file_get_contents(Yi::app()->rootDir.'/view/'.$this->getControllerName().'/'.$view.'.php'), $bind); 
        }else{
            ob_start();
            extract($bind,EXTR_OVERWRITE);
            unset($bind);
            require(Yi::app()->rootDir.'/view/'.$this->getControllerName().'/'.$view.'.php');
            $content=ob_get_contents();
            ob_end_clean();
        }
        require(Yi::app()->rootDir.'/view'.$this->layout.'.php');
        unset($content);    
    }

    public function actionIndex(){
    	echo 'undefined default action..';
    }
}