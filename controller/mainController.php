<?php
class MainController extends Controller{

    public function actionMain(){
        $info = MUser::getBlogList();
        $img = Yi::app()->url('images/1.jpg');
        //end
        $view = 'main';
        $bind = array();
        $bind['info'] = $info;
        $bind['img'] = $img;
        $this->render($view,$bind);
    }

    public function actionBlog(){
        $id = $_GET['id'];
        $info = MUser::getBlog($id);
        //end
        $view = 'blog';
        $bind = array();
        $bind['info'] = $info;
        $this->render($view,$bind);
    }

    public function actionTools(){
        //end
        $view = 'tools';
        $bind = array();
        $this->render($view,$bind);   
    }

    // public function actionAddBlog(){
    //     MUser::addBlog();
    //     $info = '添加成功';
    //     //end
    //     $view = 'add-blog';
    //     $bind = array();
    //     $bind['info'] = $info;
    //     $this->render($view,$bind);
    // }

    // public function actionMemcache(){
    //     $cache = YCache::getInstance();
    //     $cache->flush();
    //     $info = '操作成功';
    //     //end
    //     $view = 'main';
    //     $bind = array();
    //     $bind['info'] = $info;
    //     $this->render($view,$bind);
    // }

    public function actionMustache(){
        $list = array(1,2,3,4);
        $title = '操作成功';
        //end
        $view = 'mustache';
        $bind = array();
        $bind['title'] = $title;
        $bind['list'] = $list;
        $this->render($view,$bind,true);
    }

    public function actionTest(){
        if(isset($_GET['ip'])){
            echo detectCity($_GET['ip']);
        }
        if(isset($_GET['pwd'])){
            echo pwdStrength($_GET['pwd']);
        }
        if(isset($_GET['encrypt'])){
            echo FUE($_GET['encrypt'],2);
        }
        if(isset($_GET['input'])){
            echo sanitize($_GET['input']);
        }
    }
}