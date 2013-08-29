<?php

define("DIC","dictionary.txt");
$input=array(
	array("../protected/views/main","./{lang}"),
	array("../protected/views/demo","./{lang}"),
	array("../protected/views/blog","./{lang}"),
	array("../dev/js","../../{lang}/js"),
	array("../dev/template/main","../../../{lang}/template/main"),
	array("../dev/template/demo","../../../{lang}/template/demo"),
	array("../dev/template/blog","../../../{lang}/template/blog"),
	
);

$ignore=array(
	// '../protected/views/main/index.php'
);

$file_list=array();
foreach($input as $entry){
	list($src,$dst)=$entry;
	if(is_dir($src)){
		foreach(scandir($src) as $f){
			if(in_array($f,array('.','..','jquery.min.js','.DS_Store')) || preg_match("{\\.dic$}",$f)){
				continue;
			}
			$f=$src."/".$f;
			if(in_array($f, $ignore)){
				continue;
			}
			if(is_file($f)){
				$file_list[]=array($f,$dst);
			}
		}		
	}else if(is_file($src)){
		$f=$src;
		$file_list[]=array($f,$dst);
	}
}

require_once "SmartDictionary2.php";