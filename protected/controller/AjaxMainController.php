<?php
class AjaxMainController extends Controller{

    public function actionEncrypt(){
        $type = $_POST['type'];
        $source = $_POST['source'];

        $ret = '';
        if(in_array($type, array('md5','base64_encode','base64_decode','addslashes','stripslashes','htmlentities','html_entity_decode','json_encode','json_decode'))){
            if($type=='json_decode'){
                $ret = $type($source,true);
                $ret = print_r($ret,true);
            }elseif($type=='json_encode'){
                list($arr) = strToArr($source);
                $ret = $type($arr);
            }else{
                $ret = $type($source);
            }
        }
        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $bind['ret'] = $ret;
        $this->render($bind);
    }

    public function actionFormat(){
        $type = $_POST['type'];
        $source = $_POST['source'];

        $ret = '';
        if($type=='css'){
            $ret = FormatCss::format($source);
        }
        $ret === null and $ret = 'null';
        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $bind['ret'] = $ret;
        $this->render($bind);
    }

    public function actionCompress(){
        $type = $_POST['type'];
        $source = $_POST['source'];

        $ret = '';
        if($type=='css'){
            $ret = compressCss($source);
        }
        $ret === null and $ret = 'null';
        $code = 1;
        //end
        $bind = array();
        $bind['code'] = $code;
        $bind['ret'] = $ret;
        $this->render($bind);
    }
}