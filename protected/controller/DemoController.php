<?php
class DemoController extends Controller {

    public function actionMain(){
        //end
        $view = 'main';
        $bind = array();
        $this->render($view,$bind,Y::TEMPLATE_JS);
    }


    public function actionPop(){
        //end
        $view = 'pop';
        $bind = array();
        $this->render($view,$bind,Y::TEMPLATE_JS);
    }

	// public function actionScrollx(){
 //        $list = MUser::getBlogList();
 //        //end
 //        $view = 'main';
 //        $bind = array();
 //        $bind['list'] = $list;
 //        $this->render($view,$bind,Y::TEMPLATE_JS);
 //    }

    public function actionEditor(){
        //end
        $view = 'editor';
        $bind = array();
        $this->render($view,$bind,Y::TEMPLATE_JS);   
    }
}