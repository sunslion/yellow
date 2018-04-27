<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
function code62($x){ 
    $show=''; 
    while($x>0){ 
        $s=$x % 62; 
        if ($s>35){ 
            $s=chr($s+61); 
        }elseif($s>9&&$s<=35){ 
            $s=chr($s+55); 
        } 
        $show.=$s; 
        $x=floor($x/62); 
    } 
    return $show; 
}
function getCode($url){
    if(!$url) return false;//如果为空就不加密 
    $url=crc32($url); 
    $result=sprintf("%u",$url);
    $codeStr = code62($result);
    return $codeStr; 
}

?>