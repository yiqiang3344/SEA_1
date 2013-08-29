<?php
class AjaxPageController extends Controller{

    public function actionPage(){
        $page = $_POST['page'];
        $params = $_POST['params']!=='null'?$_POST['params']:array();

        $content = '';
        if(!preg_match('/\w\/\w/', $page)){
            $code = 2;
            GOTO END;
        }
        if(($bind_data = $this->getPageData($page,$params))===false){
            $code = 3;
            GOTO END;
        }
        $params = $bind_data['params'];
        $content = $this->getJsFile($page);

        $code = 1;
        //end
        END:
        $bind = array();
        $bind['code'] = $code;
        $bind['params'] = $params;
        $bind['content'] = $content;
        $this->render($bind);
    }
}