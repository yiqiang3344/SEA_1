<?php
class Controller{
    public $layout = '//layouts/main';
    public $pageTitle;
    public $template;
    public $bind;

    public function __construct(){
        $this->pageTitle = Yi::app()->config['webName'];
        $this->init();
    }

    public function init(){
        YDatabase::setDb();
    }


    public function getControllerName(){
		$arr = explode('Controller',get_class($this));
		return strtolower($arr[0]);
	}

    public function render($view,$bind=array(),$template_flag=false){
        if(is_array($view)){
            echo json_encode($view);
            return;
        }

        if($template_flag==Y::TEMPLATE_PHP){
            $m = new Mustache_Engine;
            $content = $m->render(file_get_contents(Yi::app()->fileDir('view/'.$this->getControllerName().'/'.$view.'.php')), $bind); 
        }else{
            if(APP_DEV && $template_flag==Y::TEMPLATE_JS){
                $this->template = file_get_contents(Yi::app()->fileDir('template/'.$this->getControllerName().'/'.$view.'.php'));
            }
            ob_start();
            ob_implicit_flush(false);
            extract($bind,EXTR_OVERWRITE);
            unset($bind);
            require(Yi::app()->fileDir('view/'.$this->getControllerName().'/'.$view.'.php'));
            $content=ob_get_clean();
        }
        require(Yi::app()->fileDir('view'.$this->layout.'.php'));
        unset($content);    
    }
}