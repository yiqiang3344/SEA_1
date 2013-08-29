<?php
class BlogController extends Controller{

    public function actionBlog(){
        $id = $_GET['id'];
        $params = MBlog::getBlog($id);
        //end
        $view = 'blog';
        $bind = array();
        $bind['params'] = $params;
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS);
    }

    public function actionAddBlog(){
        $m_user = $this->getUser();
        //end
        $view = 'addBlog';
        $bind = array();
        $bind['params'] = array(
        );
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS);
    }

    public function actionEditBlog(){
        $id = $_GET['id'];


        $m_user = $this->getUser();
        $params = MBlog::getBlog($id);
        //end
        $view = 'editBlog';
        $bind = array();
        $bind['params'] = $params;
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS);
    }
}