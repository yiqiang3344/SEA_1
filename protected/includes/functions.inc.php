<?php
function yDie($m){
    if(APP_DEBUG){
        throw new YException($m);
    }else{
        Yi::app()->gotoView();
    }
    die();
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


final class FormatCss{
    static private function indent($counts){
        return implode(array_pad(array(), 4*$counts, ' '),'');
    }
    
    static private function dealNote(&$str,&$i,&$c,$s_blank='',$blank=''){
        $endpos = strpos($str, '*/', $i+2)+1;
        if(in_array($before=substr($str, $i-1,1),array(';','}'))){//所有; } 之后的注释都换行
            $b = '';
            if($s_blank!==null){
                $b = substr($str, $i-1,1)=='}'?$s_blank:$blank;//缩进处理
            }
            $i = $endpos+1;
            $s = substr($str, 0, $i);
            $s1 = ltrim(substr($str, $i+1));
            $str = $s."\r\n".$b.$s1;
            $c=strlen($str);
        }elseif(strpos($s2=ltrim(substr($str, $endpos+1),"\t \x0B\0"),"\r\n")===0 || strpos($s2,"\n")===0){//注释后面有换行则加缩进
            $i = $endpos+1;
            $s = substr($str, 0, $i);
            $str = $s."\r\n".$blank.ltrim(substr($str, $i+1));
        }else{//其他注释不处理
            $i = $endpos+1;
        }
    }

    static private function dealEndSign(&$str,&$i,&$c,$s_blank,$blank){
        $s = substr($str, 0, $i+1);
        $o_s1 = substr($str, $i+1);
        $s1 = ltrim($o_s1);

        if($str[$i]=='}' && strlen($s)>1 && !preg_match("/[;{]\\s+}|\$/",$s)){
            $s = substr_replace($s, "\r\n".$s_blank, -1, 0);//不以;或{结尾的}前加换行和缩进
        }

        if(substr($s1, 0, 1)=='}' && $str[$i]=='}'){
            $str = $s."\r\n".$s1;
        }elseif(substr($s1, 0, 1)=='}' && $str[$i]==';'){
            $str = $s."\r\n".$s_blank.$s1;
        }elseif(substr($s1, 0, 2)=='/*'){
            if(($s2_before=substr($s2=ltrim($o_s1,"\t \x0B\0"), 0, 2))!='/*' && (strpos($s2,"\r\n")===0 || strpos($s2,"\n")===0)){
                $str = $s."\r\n".($str[$i]==';'?$blank:$s_blank).ltrim($o_s1);
            }else{
                $str = $s.$s1;//紧接着注释则不换行
            }
        }elseif($str[$i]=='}'){
            $str = $s."\r\n".$s_blank.$s1;
        }elseif($str[$i]==';'){
            $str = $s."\r\n".$blank.$s1;
        }
        $c=strlen($str);
    }

    static private function dealOne($str,$indentation=1){
        $blank = self::indent($indentation);
        $s_blank = self::indent($indentation-1);
        $str=ltrim($str);
        if($str[0]!='}'){
            $str = "\r\n".$blank.$str;
        }
        for($i=0,$c=strlen($str);$i<$c;$i++){
            if($str[$i]=='{'){
                list($r,$l) = self::dealOne(substr($str,$i+1),$indentation+1);
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
                self::dealNote($str,$i,$c,$s_blank,$blank);
            }elseif($str[$i]==';'){
                self::dealEndSign($str,$i,$c,$s_blank,$blank);
            }elseif($str[$i]=='}'){
                self::dealEndSign($str,$i,$c,$s_blank,$blank);
                return array($str,$i+1);
            }
        }
        return array(null,null);
    }

    static public function format($str){
        $str = trim($str);
        $s_pos = 0;
        for($i=0,$c=strlen($str);$i<$c;$i++){
            if($str[$i]=='{'){
                list($r,$l) = self::dealOne(substr($str, $i+1));
                if($r===null){
                    return null;
                }
                $str = substr($str, 0, $i+1).$r;
                $c=strlen($str);
                $i += $l;
            }elseif(substr($str, $i, 2)=='/*'){
                self::dealNote($str,$i,$c);
            }
        }
        return $str;
    }
}

function compressCss($str){
    //删除所有换行
    $str = preg_replace("{/\*[\s\S]*?\*/|\r\n}u", '', $str);
    //两个以上的空格全部换成一个
    $str = preg_replace("/\\s+/u", ' ', $str);
    return $str;
}

function formatJs($str){
    

    
    //删除所有换行
    $str = preg_replace("{/\*[\s\S]*?\*/|\r\n}u", '', $str);
    //两个以上的空格全部换成一个
    $str = preg_replace("/\\s+/u", ' ', $str);
    return $str;
}

function yscanDir($dir,$recursive=true){
    $file_list = array();
    foreach(scandir($dir) as $file){
        if($file=="." || $file==".." || $file==".svn"){
            continue;
        }else if(is_file($dir."/".$file)){
            $file_list[]=$dir."/".$file;
        }else if($recursive && is_dir($dir."/".$file)){
            $func = __FUNCTION__;
            $file_list = array_merge($file_list,$func($dir."/".$file));
        }else{
            continue;
        }
    }       
    return $file_list;
}

function mergePngs($path){
    //切除多余空白，排序，首位相连，输出宽高
    $list = array();
    foreach(scandir($path) as $v){
        if($v=='.' || $v=='..' || is_dir($v) || strrchr($v,'.')!='.png'){
            continue;
        }
        $list[] = $path.'/'.$v;
        $resource = imagecreatefrompng($path.'/'.$v);
        $width = imagesx($resource);
        $height = imagesy($resource);
        isset($p_a) || $p_a = array($width,0,$height,0);
        for($x = 0; $x<$width; $x++) {
            for($y = 0; $y<$height; $y++) {
                if(((imagecolorat($resource,$x,$y) & 0x7F000000) >> 24)!=127){
                    $x<$p_a[0] && $p_a[0]=$x;
                    $x>$p_a[1] && $p_a[1]=$x;
                    $y<$p_a[2] && $p_a[2]=$y;
                    $y>$p_a[3] && $p_a[3]=$y;
                }
            }
        }
    }
    $w = $p_a[1]-$p_a[0]+1;
    $h = $p_a[3]-$p_a[2]+1;
    $count = count($list);

    $croped=imagecreatetruecolor($w, $h*$count);
    imagealphablending($croped, false);
    imagesavealpha($croped, true);
    imagefill($croped, 0, 0, imagecolorallocatealpha($croped,255,255,255,127));
    //排序 合并
    sort($list);
    foreach($list as $k => $v){
        $resource = imagecreatefrompng($v);
        imagecopy($croped,$resource,0,$h*$k,$p_a[0],$p_a[2],$w,$h);
    }
    imagepng($croped, $path.'/merge.png');
    imagedestroy($croped);

    $hd = fopen($path.'/merge.txt', 'w');
    fwrite($hd, 'width:'.$w."\r\n".'height:'.$h."\r\n".'count:'.$count);
    fclose($hd);
}