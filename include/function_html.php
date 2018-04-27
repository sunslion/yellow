<?php
defined('_VALID') or die('Restricted Access!');
/**
 * 时间计算
 * @return [type] [description]
 */
function get_microtime_array()
{
 return explode(' ', microtime());
}

/**
 * 文件生成函数
 * @param [type] $filename [要生成的文件]
 * @param [type] $content  [要生成的内容]
 */
function GenerateHtml($filename, $content){
    if (is_file ($filename)){//存在，就删除
        @unlink ($filename);
    }
    $cjjer_handle = fopen ($filename,"w");  //创建文件
    if (!is_writable ($filename)){          //判断写权限
        return false;
    }
    if (!fwrite ($cjjer_handle, $content)){
        return false;
    }
    fclose ($cjjer_handle);                 //关闭指针
    return $filename;                       //返回文件名
}

/**
 * 创建一个目录树，失败抛出异常
 * 用法：
 * @code php
 * @endcode
 * @param string $dir 要创建的目录
 * @param int $mode 新建目录的权限
 *
 * @throw Q_CreateDirFailedException
 */
function mkdirs($dir, $mode = 0777)
{
    if (!is_dir($dir))
    {
        $ret = @mkdir($dir, $mode, true);
        if (!$ret)
        {
            return false;
        }
    }
    return true;
}
function curlMultiGet($urlArr=''){
	$mh = curl_multi_init();
	$conn = array();
	foreach ($urlArr as $i => $url) {
		$conn[$i] = curl_init($url);
		curl_setopt($conn[$i], CURLOPT_RETURNTRANSFER, 1);
		curl_multi_add_handle($mh, $conn[$i]);
	}

	do{
		$mrc = curl_multi_exec($mh, $active);
	}while ($mrc == CURLM_CALL_MULTI_PERFORM);
	while ($active and $mrc == CURLM_OK) {
		if (curl_multi_select($mh) != -1) {
			do{
				$mrc = curl_multi_exec($mh, $active);
			}while ($mrc == CURLM_CALL_MULTI_PERFORM);
		}
	}
	$res =  array();
	foreach ($urlArr as $i => $url){
		$res[$i] = curl_multi_getcontent($conn[$i]);
		curl_close($conn[$i]);
	}
	unset($conn);
	curl_multi_close($mh);
	return $res;
}
/**
 * 获取内容
 * @param  string $uri  [description]
 * @param  string $data [description]
 * @return [type]       [description]
 */
function curlGetData($uri='', $data='')
{
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $uri );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    $return = curl_exec ( $ch );
    curl_close ( $ch );
    return $return;
}

/**
 * 生成列表翻页
 * @param  string $totalpages [总页数]
 * @param  string $purl [远程内容]
 * @param  array $starttime  [开始时间]
 * @return [type]       [description]
 */
function makeHtml($totalpages, $purl = '', $dir = 'videos', $starttime = array())
{
    if(!file_exists( $dir ) ) {
        mkdirs($dir);
    }
    //内容替换
    $a_header   = array('"/"', '"/videos"', '"/hd"','"/novels.php"','"/pictures.php"', '?c=', '?page=', '&page=', 'http://www.zhibomo.com/', '"http://www.zhibomo.com"', 'style="display:none;visibility:hidden;"', 'data-cfsrc');
    $a_replace  = array('"/index.html"', '"/videos/index.html"', '"/hd/index.html"','"/novels/"','"/pictures/"', '/', '/index_page_', '/index_page_', '/', 'window.location.host', '', 'src');
    //循环生成
    for ($i=1; $i <= $totalpages; $i++) {

        if( $i == 1) {          //首页取值
        	$filename = $dir . '/index.html';
            $html    = curlGetData( $purl);
            $html    = str_replace($a_header, $a_replace, $html);           //替换
            $htmlstr = preg_replace('/(page_\d+)/', '$1.html', $html);      //再次替换　加html后缀
            file_put_contents($filename, $htmlstr);
        } else {                //翻页取值
            //判断是否有问号
            $url     = strpos($purl, '?') === false ? $purl . '?page=' . $i : $purl . '&page=' . $i;
            $html    = curlGetData( $url );
            $html    = str_replace($a_header, $a_replace, $html);           //替换
            $htmlstr = preg_replace('/(page_\d+)/', '$1.html', $html);      //再次替换加html后缀
            file_put_contents($dir . '/index_page_' . $i . '.html', $htmlstr);
        }
        unset($url, $html);
    }
    $endtime = get_microtime_array();
    $totaltime  = $endtime[0]-$starttime[0]+$endtime[1]-$starttime[1];
    return sprintf(" %s 小时 %s 分钟 %s 秒", floor($totaltime/3600), floor($totaltime/60), ceil($totaltime%60));
}

//删除目录级文件
function deldir($dir) {
      //先删除目录下的文件：
      $dh=opendir($dir);
      while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
          $fullpath=$dir."/".$file;
          if(!is_dir($fullpath)) {
              unlink($fullpath);
          } else {
              deldir($fullpath);
          }
        }
    }

    closedir($dh);
    //删除当前文件夹：
    if(rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}
?>