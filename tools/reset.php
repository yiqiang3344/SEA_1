<?php
define("ALL_STEP", 3);
$lang_list = array('zh_cn');

// 翻译哦
chdir("../translator");
require_once 'run.php';

step2();

echo "step 2 of " . ALL_STEP . " : patch md5, generate url.js success\n";

chdir("../protected");
foreach(scandir("views") as $file){
	if($file=="." ||  $file==".." || !is_dir("views/$file")){
		continue;
	}else{
		step3_doOne($file);
	}
}

echo "step 3 of " . ALL_STEP . " : extract js success\n";

function pushToAr(&$arr,$file,$md5){
	if(in_array($file,array(//这些文件是不会在js中调用的，所以去掉
		"js/url.js",
		"css/base.css",
		"css/page.css",
		"js/main.js",
		"js/helper.js",
		"js/jquery.min.js",
	))){
		return;
	}else if(preg_match("{\\.dic$}su",$file)){//dic文件不做处理
		return;
	}else if(preg_match("{thumb\\.db$}isu",$file)||preg_match("{thumbs\\.db$}isu",$file)||preg_match("{\\.DS_Store$}isu",$file)){
		return;
	}
	$pieces=explode("/",$file);
	for($i=0;$i<count($pieces);$i++){
		if($i==(count($pieces)-1)){//最后一个
			$arr[$pieces[$i]]=$md5;
			break;
		}else if(!isset($arr[$pieces[$i]])){
			$arr[$pieces[$i]]=array();
		}
		$arr= &$arr[$pieces[$i]];
	}	
}

//处理一个语言目录
function step2(){
	$arr=array();	
	//处理语言所对应目录
	//处理根目录下面的img目录
	$adir="../img";
	$file_list=array();
	scan_dir($adir,$file_list);
	foreach($file_list as $file){
		if(preg_match("{thumb\.db}isu",$file)||preg_match("{thumbs\.db}isu",$file)||preg_match("{\\.DS_Store$}isu",$file)){
			continue;
		}
		pushToAr($arr,"img/".substr($file,strlen($adir)+1),substr(md5_file($file),0,8));
	}
	
	//处理根目录下面的images目录
	$adir="../images";
	$file_list=array(); 
	scan_dir($adir,$file_list);
	foreach($file_list as $file){
		if(preg_match("{thumb\.db}isu",$file)||preg_match("{thumbs\.db}isu",$file)||preg_match("{\\.DS_Store$}isu",$file)){
			continue;
		}
		pushToAr($arr,"img/".substr($file,strlen($adir)+1),substr(md5_file($file),0,8));
	}
	
	//保存到url.js
	file_put_contents("../js/url.js","var URLCACHE=".json_encode($arr).";\r\n");
	
	//处理CSS文件给图片加MD5后缀
	$rep=new ReplaceCss('..');
	foreach(array('base.css','page.css') as $css){
		$file='../css/'.$css;
		$content=@file_get_contents($file);
		if(!$content){
			die("$file not found");
		}
		file_put_contents($file,preg_replace_callback("{url\\(\\\"?\\'?([^\\?\\)\\\"\\']*)\\??.*?\\)}u",array($rep,"callback"),$content));	
	}
}

class ReplaceCss{
	private $dir;
	public function __construct($dir){
		$this->dir=$dir;
	}
	public function callback($m){
		$file=$m[1];
		return "url(".$m[1]."?v=".substr(md5_file($file),0,8).")";
	}	
}

//遍历一个文件夹下面的所有文件
function scan_dir($dir,&$file_list,$recursive=true){
	foreach(scandir($dir) as $file){
		if($file=="." || $file==".." || $file==".svn"){
			continue;
		}else if(is_file($dir."/".$file)){
			$file_list[]=$dir."/".$file;
		}else if($recursive && is_dir($dir."/".$file)){
			scan_dir($dir."/".$file,$file_list);
		}else{
			continue;
		}
	}		
}

function step3_doOne($dir){//提取js文件
	global $lang_list;
	foreach($lang_list as $lang){
		if(is_dir("views/$dir/$lang")){			
			foreach(scandir("views/$dir/$lang") as $file){
				if($file=="." ||  $file==".."){
					continue;
				}else if(preg_match("{(.*)\\.php$}",$file,$m)){					
					list($content,$js)=jsExtract(file_get_contents("views/$dir/$lang/$file"),"js/$dir/{$m[1]}.js","../$lang/template/$dir/{$m[1]}.php");
					if($js){
						file_put_contents("views/$dir/$lang/$file",$content);
						@mkdir("../$lang/js/$dir");
						file_put_contents("../$lang/js/$dir/{$m[1]}.js",$js);
					}		
				}				
			}			
		}
	}	
}

function jsExtract($content,$path,$template){
	if(preg_match("{<script\\s+type\\s*=\\s*\"text/javascript\"\\s*>\\s*//static(.*?)</script>}su",$content,$m)){
		$tpl = file_get_contents($template);
		$js='var template='.json_encode($tpl).";\r\n".trim($m[1]);
		$content=preg_replace("{<script\\s+type\\s*=\\s*\"text/javascript\"\\s*>\\s*//template(.*?)</script>\\s*<script\\s+type\\s*=\\s*\"text/javascript\"\\s*>\\s*//static(.*?)</script>}su","<script type='text/javascript' src='<?=\$this->url(\"$path\")?>'></script>",$content,1);
		if(strpos($js ,"<?")!==false){
			echo "jsExtract fail";
			die;
		}
	}else{
		$js=false;
	}
	return array($content,$js);
}