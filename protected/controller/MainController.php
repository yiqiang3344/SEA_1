<?php
class MainController extends Controller{

    public function actionMain(){
        $list = MUser::getBlogList();
        //end
        $view = 'main';
        $bind = array();
        $bind['list'] = $list;
        $this->render($view,$bind,Y::TEMPLATE_JS);
    }

    public function actionBlog(){
        $id = $_GET['id'];
        $info = MUser::getBlog($id);
        //end
        $view = 'blog';
        $bind = array();
        $bind['info'] = $info;
        $this->render($view,$bind,Y::TEMPLATE_JS);
    }

    public function actionTools(){
        //end
        $view = 'tools';
        $bind = array();
        $this->render($view,$bind,Y::TEMPLATE_JS);   
    }

    public function actionEditor(){
        //end
        $view = 'editor';
        $bind = array();
        $this->render($view,$bind,Y::TEMPLATE_JS);   
    }
}