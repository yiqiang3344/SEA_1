<?php
class AjaxBlogController extends Controller{

    public function actionAddBlog(){
        $title = $_POST['title'];
        $content = $_POST['content'];

        $m_user = $this->getUser();
        list($id) = MBlog::addBlogT($title,$content);

        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $bind['id'] = $id;
        $this->render($bind);
    }

    public function actionEditBlog(){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $m_user = $this->getUser();
        MBlog::editBlogT($id,$title,$content);

        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $this->render($bind);
    }

    public function actionGetNewBlogs(){
        $id = $_POST['id'];

        $list = MBlog::getNewBlogs($id);
        foreach($list as &$v){
            preg_match('|<p>[\s*&nbsp;]*(.*?)</p>|sS', $v['content'], $match);
            if($match){
                $v['content'] = $match[1];
            }
        }

        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $bind['list'] = $list;
        $this->render($bind);
    }

    public function actionGetMoreBlogs(){
        $id = $_POST['id'];

        $list = MBlog::getMoreBlogs($id);
        foreach($list as &$v){
            preg_match('|<p>[\s*&nbsp;]*(.*?)</p>|sS', $v['content'], $match);
            if($match){
                $v['content'] = $match[1];
            }
        }

        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $bind['list'] = $list;
        $this->render($bind);
    }
}