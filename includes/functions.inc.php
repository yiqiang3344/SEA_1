<?php
function yDie($m){
    if(APP_DEBUG){
        throw new YException($m);
    }else{
        Yi::app()->gotoView();
    }
    die();
}

function setDbConfig(){
    define('SAE_MYSQL_HOST_M', 'localhost');
    define('SAE_MYSQL_PORT', '3306');
    define('SAE_MYSQL_DB', 'sae_1');
    define('SAE_MYSQL_USER', 'root');
    define('SAE_MYSQL_PASS', 'yjq');
}

function getTime($refresh = false) {
	$add_time = 24*60*60*0 + 60*60*0 + 60*0;
	return Yi::app()->time($refresh,$add_time);
}

function getDbh(){
	return YDatabase::YGetDbh();
}

function loadByUrls($urls){
	if(is_string($urls)){
		$urls = array($urls);
	}
	foreach($urls as $url){
		if (is_dir($url)) {
		    if ($dh = opendir($url)) {
		        while (($file = readdir($dh)) !== false) {
		        	if(filetype($url.$file) !== 'dir'){
						require($url.$file);
		        	}
		        }
		        closedir($dh);
		    }
		}elseif(is_file($url)){
			require($url);
		}
	}
}


function xcurl($url,$ref=null,$post=array(),$ua="Mozilla/5.0 (X11; Linux x86_64; rv:2.2a1pre) Gecko/20110324 Firefox/4.2a1pre") {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    if(!empty($ref)) {
        curl_setopt($ch, CURLOPT_REFERER, $ref);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(!empty($ua)) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    }
    if(count($post) > 0){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);   
    }
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function cleanInput($input) {
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);
	$output = preg_replace($search, '', $input);
	return $output;
}

function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $output  = cleanInput($input);
    }
    return $output;
}

function detectCity($ip) {
	$location = 'unavailable ip.';
    if (!is_string($ip) || strlen($ip) < 8 || $ip == '127.0.0.1' || $ip == 'localhost'){
        $ip = '8.8.8.8';
    }
    $ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';
    $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
    $content = xcurl($url,$ref=null,$post=array(),$ua);
    if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) )  {
        $city = $regs[1];
    }
    if ( preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs) )  {
        $state = $regs[1];
    }
    if( $city!='-' && $state!='-' ){
      $location = $city . ', ' . $state;
    }
	return $location;
}

function pwdStrength($string){ 
    $h = 0; 
    $size = strlen($string); 
    foreach(count_chars($string, 1) as $v){ 
        $p = $v / $size; 
        $h -= $p * log($p) / log(2); 
    } 
    $strength = ($h / 4) * 100; 
    if($strength > 100){ 
        $strength = 100; 
    } 
    return $strength; 
}

function xexplode($delimiter, $string){
	if(!$string){
		return array();
	}
	return explode($delimiter, $string);
}


function FUE($hash,$times) {
	for($i=$times;$i>0;$i--) {
		// Encode with base64...
		$hash=base64_encode($hash);
		// and md5...
		$hash=md5($hash);
		// sha1...
		$hash=sha1($hash);
		// sha256... (one more)
		$hash=hash("sha256", $hash);
		// sha512
		$hash=hash("sha512", $hash);
	}
	return $hash;
}

//排除转义的符号
function noEscapeStrPos($string,$find,$start){
    if(($pos = strpos($string,$find,$start)) !== false  && substr($string, $pos-1,1)=='\\'){
        $func = __METHOD__;
        $pos = $func($string, $find, $pos+strlen($find));
    }
    return $pos;
}

function strToArr($str){
    $pushByKey = function($str,$s_pos,$i,&$arr,&$key,$v=false){
        $v = $v?$v:substr($str, $s_pos, $i-$s_pos);
        if(is_string($v) && (strpos($v,'\'')===0 || strpos($v,'"')===0)){
            $v = substr($v, 1, strlen($v)-2);
        }
        if($key){
            if(strpos($key,'\'')===0 || strpos($key,'"')===0){
                $key = substr($key, 1, strlen($key)-2);
            }
            $arr[$key] = $v;
            $key = false;
        }else{
            $arr[] = $v;
        }
    };

    $str = str_replace(array("\n","\r\n","\t"," "), '', $str);
    $ass = 'array(';
    if(strpos($str,$ass)!==0){
        return array(null);//非数组则返回空值
    }
    $arr = array();
    $key = false;
    $s_pos = strlen($ass);
    for($i=$s_pos,$c=strlen($str);$i<$c;$i++){
        if($str[$i]=='"'){
            if(($i=noEscapeStrPos($str,'"',$i+1)) === false){
                break;
            }
        }elseif($str[$i]=='\''){
            if(($i=noEscapeStrPos($str,'\'',$i+1)) === false){
                break;
            }
        }elseif(substr($str, $i, 2)=='=>'){
            $key = substr($str, $s_pos, $i-$s_pos);
            $i += 1;
            $s_pos = $i+1;
        }elseif(substr($str, $i, 6)==$ass){
            list($aa,$ii) = strToArr(substr($str, $i));
            if($aa===null){
                break;
            }
            $pushByKey($str,$s_pos,$i,$arr,$key,$aa);
            $i += $ii;
            $s_pos = $i+1;
        }elseif($str[$i]==','){
            $pushByKey($str,$s_pos,$i,$arr,$key);
            $s_pos = $i+1;
        }elseif($str[$i]==')'){
            $pushByKey($str,$s_pos,$i,$arr,$key);
            return array($arr,$i);
        }
    }
    return array(null,null);
}


//暂时不能很好的处理不以;结尾的，注释的换行，以及样式{}与{}之间的换行
function formatCss($str){
    function indent($counts){
        return implode(array_pad(array(), 4*$counts, ' '),'');
    }

    function dealOne($str,$indentation=1){
        $blank = indent($indentation);
        $str = "\r\n".$blank.ltrim($str);
        for($i=0,$c=strlen($str);$i<$c;$i++){
            if($str[$i]=='{'){
                $func = __METHOD__;
                list($r,$l) = $func(substr($str,$i+1),$indentation+1);
                if(!$r){
                    break;
                }
                $str = substr($str, 0, $i+1).$r;
                $c=strlen($str);
                $i+=$l;
            }elseif($str[$i]==':' || $str[$i]==','){
                $str = substr($str, 0, $i+1).' '.ltrim(substr($str, $i+1));
                $c=strlen($str);
            }elseif(substr($str, $i, 2)=='/*'){
                $i = strpos($str, '*/', $i+2);
            }elseif($str[$i]==';'){
                $s = substr($str, 0, $i+1);
                $s1 = ltrim(substr($str, $i+1));
                if(substr($s1, 0, 1)=='}'){
                    $str = $s."\r\n".indent($indentation-1).$s1;
                }else{
                    $str = $s."\r\n".$blank.$s1;
                }
                $c=strlen($str);
            }elseif($str[$i]=='}'){
                $s = substr($str, 0, $i+1);
                $s1 = ltrim(substr($str, $i+1));
                if(substr($s1, 0, 1)=='}'){
                    $str = $s."\r\n".$s1;
                }else{
                    $str = $s."\r\n".indent($indentation-1).$s1;
                }
                return array($str,$i+1);
            }
        }
        return array(null,null);
    };

    $str = trim($str);
    $s_pos = 0;
    for($i=0,$c=strlen($str);$i<$c;$i++){
        if($str[$i]=='{'){
            list($r,$l) = dealOne(substr($str, $i+1));
            if($r===null){
                return null;
            }
            $str = substr($str, 0, $i+1).$r;
            $c=strlen($str);
            $i += $l;
        }elseif(substr($str, $i, 2)=='/*'){
            $i = strpos($str, '*/', $i+2);
        }
    }
    return $str;
}