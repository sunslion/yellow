<?php
function smarty_modifier_embed($string)
{
    $width = '100';
	$height = '100';
	if(stristr($string,'youtube')) {
		$string=get_youtube($string);
	}


	return SetEmbedSize($width,$height,$string);
}
function SetEmbedSize($iWidth, $iHeight, $s)
{
	$sSearch = '/width\=([\"\']?)[0-9]+\1/isu';
	$sReplace = 'width=${1}' . $iWidth . '%"';
	$s = preg_replace($sSearch, $sReplace, $s);
	$sSearch = '/height\=([\"\']?)[0-9]+\1/isu';
	$sReplace = 'height=${1}' . $iHeight . '%"';	
	$ret= preg_replace($sSearch, $sReplace, $s);
	//$ret=str_replace("px","p",$ret);
	return $ret;
}
function get_youtube($embed) {
	$yt = '';
	if(strlen($embed)>0) 
	{
		$pos = strpos($embed,"youtube.com/embed/");
		if($pos>0) {
			$key = substr($embed,$pos+18,11);

			return '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$key.'?showinfo=0&amp;rel=0&amp;modestbranding=1" frameborder="0" allowfullscreen></iframe>';
		}
		$pos = strpos($embed,"youtube.com");
		if($pos) 
		{
			preg_match('/youtube\.com\/v\/([\w\-]+)/', $embed, $match);
			$mt = $match[1];	
			$pos=strpos($mt,"&");
			if($pos) {
				$mt=substr($mt,$pos); $mt=trim($mt,"&");
			}
			return '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$mt.'?showinfo=0&amp;rel=0&amp;modestbranding=1" frameborder="0" allowfullscreen></iframe>';   
		}
	}
	return $yt;
}
?>