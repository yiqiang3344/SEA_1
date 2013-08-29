<?php
class MainController extends Controller{

    public function actionMain(){
        $list = MBlog::getBlogList();
        foreach($list as &$v){
            preg_match('|<p>[\s*&nbsp;]*(.*?)</p>|sS', $v['content'], $match);
            if($match){
                $v['content'] = $match[1];
            }
        }
        //end
        $view = 'main';
        $bind = array();
        $bind['params'] = array(
            'list'=>$list
        );
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS);
    }

    public function actionTools(){
        //end
        $view = 'tools';
        $bind = array();
        $bind['params'] = array(
        );
        $view = func_num_args()>0 && func_get_args(0) ? Y::GET_BIND : $view;
        return $this->render($view,$bind,Y::TEMPLATE_JS);
    }
}