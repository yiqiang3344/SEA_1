<?php
chdir('../');
require('protected/includes/functions.inc.php');
require('protected/components/JSMin.php');
//压缩js和css
$deal_list = array();
foreach(yscanDir('.') as $file){
	if(preg_match('{\.min\.js$|\.min\.css$}', $file)){
		if(!isset($deal_list[$file])){
			unlink($file);//删掉压缩过的
		}
	}elseif(preg_match('{\.js$}', $file)){
		$deal_list[$mfile = str_replace('.js','.min.js',$file)] = 1;
		$hd = fopen($mfile,'w');
		fwrite($hd, JSMin::minify(file_get_contents($file)));
		fclose($hd);
	}elseif(preg_match('{\.css$}', $file)){
		$deal_list[$mfile = str_replace('.css','.min.css',$file)] = 1;
		$hd = fopen($mfile,'w');
		fwrite($hd, compressCss(file_get_contents($file)));
		fclose($hd);
	}
}
echo 'already compressed all js and css.';