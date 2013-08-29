<?php
class DemoController extends Controller {

    public function actionMain(){
        //end
        $view = 'main';
        $bind = array();
        $bind['params'] = array(
        );
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS);
    }

    public function actionEditor(){
        //end
        $view = 'editor';
        $bind = array();
        $bind['params'] = array(
        );
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS); 
    }
}