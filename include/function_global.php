<?php
defined('_VALID') or die('Restricted Access!');

function GetRealIP() {
    static $realip;

    if (isset($_SERVER)){
     if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["REMOTE_ADDR"])){
            $realip = $_SERVER["REMOTE_ADDR"];
        } else {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }

    if (strpos($realip, ',') === false) {
            $sUserIp = $realip;
    } else {
        $arrUserIp = explode(',' , $realip);
        $sUserIp = $arrUserIp[0];
    }
    return $sUserIp;
}

/**
 * 取IP所在地区
 * @param string $ip [description]
 */
function GetIpLookup($ip = ''){
    if(empty($ip)){
        $ip = GetIp();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){ return false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    if( isset( $area['country'], $area['province'] ) ) {
        return $area['country'] . '|' . $area['province']. '|' . $area['city']. '|' . $area['district'];
    }
    return $json;
}
function get_request()
{
    $request = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
    $request = ( isset($_SERVER['QUERY_STRING']) ) ? str_replace('?' .$_SERVER['QUERY_STRING'], '', $request) : $request;

    return ( isset($request) ) ? explode('/', $request) : array();
}

function get_request_arg($search, $type = 'INT')
{
    $arg    = NULL;
    $query  = get_request();
    foreach ($query as $key => $value) {
        if ( $value == $search ) {
            if ( isset($query[$key+1]) ) {
                $arg = $query[$key+1];
            }
        }
    }

    return ( $type == 'INT' ) ? intval($arg) : $arg;
}


// 新增加数组切割，用于多选框入库

function explode_array($array){
	foreach ($array as $var) {
	    $value .= htmlspecialchars($var).',';
	}
	return rtrim($value,',');
}


/*
 获取分布式符合权限的链接地址，出来的是一维数组
 // office.frontend@gmail.com
 SELECT s.*,d.* FROM distributed AS d, distributeds AS s  WHERE find_in_set('guest',s.permisions) AND d.distributeds_id = s.distributeds_id AND 100 => d.vid_min AND 100 <= d.vid_min


SELECT s.*,d.* FROM distributed AS d, distributeds AS s WHERE find_in_set('guest',s.permisions) AND d.distributeds_id = s.distributeds_id AND d.vid_min < '11308' AND d.vid_max > '11308' AND s.status = '0'
 $sql        = "SELECT s.*,d.* FROM distributed AS d, distributeds AS s WHERE find_in_set('".$type_of_user."',s.permisions) AND d.distributeds_id = s.distributeds_id AND d.vid_min < '".$VID."' AND d.vid_max > '".$VID."' AND s.status = '0';";

*/


function get_distributed($VID)
{
    global $conn,$type_of_user,$config;
    // 查权限线路
    $VID = intval($VID);

    $sql        = "SELECT s.*,d.* FROM distributed AS d, distributeds AS s WHERE find_in_set('".$type_of_user."',s.permisions) AND d.distributeds_id = s.distributeds_id AND d.vid_min < '".$VID."' AND d.vid_max > '".$VID."' AND s.status = '0';";
 	$rs         = $conn->Execute($sql);
	$distributeds_arr = $rs->getrows();
	
	if(is_array($distributeds_arr)){
    	$file_sd        = '/iphone/' .$VID. '.mp4';
    	$file_hd        = '/iphone/' .$VID. '.mp4';
    	foreach ($distributeds_arr as $k=>$val) {
    	    $timestamp      = time();
            $timestamp_hex  = sprintf("%08x", $timestamp);
        	$md5sum_sd      = md5($val['httpkey'] . $file_sd . $timestamp_hex);
        	$md5sum_hd      = md5($val['httpkey'] . $file_hd . $timestamp_hex);
            $arr['flv'] = ($val['distributeds_id'] ==3 || $val['distributeds_id'] ==2) ? $val['url'].'video'.$file_sd.'?k='.$md5sum_sd.'&t='.$timestamp_hex :$val['url'].'video/'.$md5sum_sd.'/'.$timestamp_hex.$file_sd;
            $arr['mp4'] = ($val['distributeds_id'] ==3 || $val['distributeds_id'] ==2) ? $val['url'].'video'.$file_sd.'?k='.$md5sum_hd.'&t='.$timestamp_hex : $val['url'].'video/'.$md5sum_hd.'/'.$timestamp_hex.$file_hd;
        	$arr['gname'] = $val['gname'];
        	$arr['distributeds_id'] = $val['distributeds_id'];
        	$arr['permisions'] = $val['permisions'];
        	$arr['region'] = $val['region'];
        	$url[] = $arr;
    	}
	}
	return $url;
}

/*************
	获取默认线路信息
	转换成数组
**************/

function default_server_array($VID) {

	    global $conn,$type_of_user,$config;

	    $VID = intval($VID);

	    $sql    = "SELECT VID, title, channel, server, flvdoname, ipod_filename, hd_filename, hd FROM video WHERE VID = '" .mysql_real_escape_string($VID). "' AND active = '1' LIMIT 1";
	    $rs     = $conn->execute($sql);
	    if ( $conn->Affected_Rows() == 1 ) {
	        $video_id   = $rs->fields['VID'];
	        $channel    = $rs->fields['channel'];
	        $title      = prepare_string($rs->fields['title']);
			$server		= $rs->fields['server'];
			$sd_filename    = $rs->fields['flvdoname'];
			$hd_filename    = $rs->fields['hd_filename'];
			$hd    			= $rs->fields['hd'];
			$SD_URL			= $config['FLVDO_URL'].'/'.$sd_filename;
			$HD_URL			= $config['HD_URL'].'/'.$hd_filename;
			//update3.1
			if ($sd_filename == '') {
						$sd_filename    = $rs->fields['ipod_filename'];
						$SD_URL			= $config['IPHONE_URL'].'/'.$sd_filename;
						$sd_mobile = true;
					} else {
						$sd_mobile = false;
					}

			$lighttpd_port  = ':81';
			if($server != ''){
				$sql = "SELECT url FROM servers WHERE video_url = '".$server."' LIMIT 1";
				$rsx = $conn->execute($sql);
				$server_urls = $rsx->fields['url'];
				$server_urls = explode(':',$server_urls);
				if(is_array($server_urls))
					$server_url = $server_urls[0].':'.$server_urls[1];
				else
					$server_url = $server_urls;
			}
	    }
	    //update3.1
	    if ($config['lighttpd'] == '1') {
	      	if ($sd_mobile) {
	      			$file_sd        = '/iphone/' .$video_id. '.mp4';
	      		} else {
	      			$file_sd        = '/flv/' .$video_id. '.flv';
	      		}
	      	$file_hd        = '/iphone/' .$video_id. '.mp4';
	      	//$file_hd        = '/iphone/' .$video_id. '.mp4';
	      	$timestamp      = time();
	      	$timestamp_hex  = sprintf("%08x", $timestamp);
	      	$md5sum_sd      = md5($config['lighttpd_key'] . $file_sd . $timestamp_hex);
	      	$md5sum_hd      = md5($config['lighttpd_key'] . $file_hd . $timestamp_hex);
	    }


	    if ($config['multi_server'] == '1' && $server != '') {
	    	if ($config['lighttpd'] == '1') {
	    		$SD_URL    = $server_url.$lighttpd_port.$config['lighttpd_prefix'].$md5sum_sd.'/'.$timestamp_hex.$file_sd;
	    		$HD_URL    = $server_url.$lighttpd_port.$config['lighttpd_prefix'].$md5sum_hd.'/'.$timestamp_hex.$file_hd;
	    	}
	    } else {
	    	if ($config['lighttpd'] == '1') {
	    		$SD_URL = $config['BASE_URL'].$lighttpd_port.$config['lighttpd_prefix'].$md5sum_sd.'/'.$timestamp_hex.$file_sd;
	      	$HD_URL = $config['BASE_URL'].$lighttpd_port.$config['lighttpd_prefix'].$md5sum_hd.'/'.$timestamp_hex.$file_hd;
	    	}
	    }

	    $default_url['flv'] = $SD_URL;
	    $default_url['mp4'] = $HD_URL;
	    $default_url['gname'] = '默认线路';
	    $default_url['distributeds_id'] = 'default';
	    $default_url['permisions'] = 'guest,free,premium';
	    $default_url['region'] = '默认线路';
	    $default_url_merge[] = $default_url;

			return $default_url_merge;
}


/***********
获取视频信息并给分布式使用
***********/
function distributed_videoinfo($VID){

		global $conn,$type_of_user,$config;

		$sql = "SELECT VID, addtime FROM video WHERE active = '1' AND VID = " .intval($VID). ";";
		$rs             = $conn->Execute($sql);
		$videos         = $rs->getrows();
		$videos         = $videos[0];
		if(!is_array($videos)) return false;
		$added = time()-$videos['addtime'];
		//时间
		if($added>$config['synctime']){
		$videos['added'] = 'yes';
		}else{
		$videos['added'] = 'no';
		}
		return ($videos) ;
}

function distributeds_token() {
    //$time = strtotime(date('Y-m-d H:i',time()));
    $key = 'zhiboav_3783425';
    $ip = GetRealIP();
    $http_host = $_SERVER['HTTP_HOST'];
    return $token = md5(md5($key).md5($ip.$http_host));
}

function get_categories($removeCat = array(),$isremove = 1)
{
    global $conn;
    $where = '';
    if (is_array($removeCat) && !empty($removeCat)) {
        if ($isremove) {
            $where = 'WHERE CHID NOT IN(' .implode(',', $removeCat). ')';
        }else{
            $where = 'WHERE CHID IN(' .implode(',', $removeCat). ')';
        }
    }
    $sql        = "SELECT CHID, name, total_videos FROM channel {$where} ORDER BY CHID ASC";
    $rs         = $conn->CacheExecute(6000,$sql);
    $categories = $rs->getrows();
    $i = 0;
    // 加入到数组中，程序修改// office.frontend@gmail.com
    foreach ($categories as $k => $val) {
       $sql                     = "SELECT `VID` FROM video WHERE active = '1' AND channel = " .$val['CHID']. ";";
       $rs                      = $conn->CacheExecute(6000,$sql);
       $num_rows                = $rs->NumRows();
       $categories[$i++]['num'] = $num_rows;

    }
    return $categories;
}

function get_npcategories()
{
	global $conn;
	$sql = "SELECT CHID,name,totals,(CASE WHEN parentid = 0 THEN 'pictures' ELSE 'novels' END) AS type FROM category ORDER BY parentid ASC";
	$rs = $conn->CacheExecute(6000,$sql);
	$categories = $rs->getrows();
	return $categories;
}
/**
 * 取分类数据
 * @param  [type] $id [父级分类ID]
 * @return [type]     [description]
 */
function get_lists_categories($pid, $limit = 10)
{
    global $conn;
        $sql        = 'SELECT CHID, name ,totals  FROM category where CHID=' . $pid . ' limit 1';
    if($limit == 1) {
    } else {
        $sql        = 'SELECT CHID, name ,totals  FROM category where parentid=' . $pid . ' ORDER BY name ASC';
    }

    $rs         = $conn->CacheExecute(3000,$sql);
    if(!$rs || $conn->Affected_Rows() <= 0){
        return array();
    }
    $categories = $rs->getrows();
    return $categories;
}

function get_top_categories($id)
{
    global $conn;

    $sql        = "SELECT CHID, name FROM channel where parentid=0 and CHID<>'$id' ORDER BY name ASC";
    $rs         = $conn->CacheExecute(3000,$sql);
    $categories = $rs->getrows();

    return $categories;
}

function get_categories_by_parentid($id)
{
    global $conn;

    $sql        = "SELECT CHID, name FROM channel where parentid='$id' ORDER BY name ASC";
    $rs         = $conn->CacheExecute(3000,$sql);
    $categories = $rs->getrows();

    return $categories;
}

function get_games_categories()
{
    global $conn;

    $sql        = "SELECT category_id, category_name FROM game_categories ORDER BY category_name ASC";
    $rs         = $conn->CacheExecute(3000,$sql);
    $categories = $rs->getrows();

    return $categories;
}

function get_popular_tags()
{
    global $conn;

    $tags       = array();
    $sql        = "SELECT keyword FROM video ORDER BY viewnumber LIMIT 10";
    $rs         = $conn->CacheExecute(3000,$sql);
    $rows       = $rs->getrows();
    foreach ( $rows as $row ) {
        $tag_arr = explode(' ', $row['keyword']);
        foreach ( $tag_arr as $tag ) {
            if ( strlen($tag) > 3 && !in_array($tag, $tags) ) {
                $tags[] = $tag;
            }
        }
    }
}

function prepare_string( $string, $url=true )
{
	if (preg_match('/^.$/u', 'ñ')) {
  		$string = preg_replace('/[^\pL\pN\pZ]/u', ' ', $string);
  		$string = preg_replace('/\s\s+/', ' ', $string);
	} else {
		$string = ereg_replace('[^ 0-9a-zA-Z]', ' ', $string);
  		$string = preg_replace('/\s\s+/', ' ', $string);
	}
    $string = trim($string);
    if ( $url === true ) {
        $string = str_replace(' ', '-', $string);
        $string = mb_strtolower($string);
    }

    return $string;
}

function check_string($string)
{
	if (preg_match('/^.$/u', 'ñ')) {
		return (bool) preg_match('/^[-\pL\pN_]++$/uD', $string);
	} else {
		return (bool) preg_match('/^[a-zA-Z0-9_\-\s]+$/', $string);
	}
}

/**access_token**/

function Auth_Access_token($access=array()){
	global $conn,$type_of_user,$config;
	$username = $access['username'];
	$email = $access['email'];
	$ip = $access['ip'];
	$useragent = $access['useragent'];
	$time = $access['time'];
	$random_token = $access['random_token'];
	$access_token = md5(md5($username.md5($email).md5($ip.md5($useragent)).$time.$random_token).$type_of_user);//加密算法
	return $access_token;
}

/* 随机 */
function Auth_Random_token($existed=array(),$num=6){
	$str='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$len=strlen($str);
	$code='';
	for($i=0;$i<$num;$i++){
		$k=rand(0,$len-1);
		$code.=$str[$k];
	}
	if(in_array($code,$existed)) $code=Auth_Random_token($existed,$num);
	return $code;
}

/*清除*/
function StripStr($str){
	if(get_magic_quotes_gpc()) $str=stripslashes($str);
	return addslashes(htmlspecialchars($str,ENT_QUOTES));
}



function truncate( $string, $length=80)
{
    if ( $length == 0 ) {
        return '';
    }

    if (mb_strlen($string) > $length) {
        $etc     = ' ...';
        $length -= min($length, mb_strlen($etc));
        return mb_substr($string, 0, $length) . $etc;
    } else {
        return $string;
    }
}

function duration( $duration)
{
    $duration_formated  = NULL;
    $duration           = round($duration);
    if ( $duration > 3600 ) {
        $hours              = floor($duration/3600);
        $duration_formated .= sprintf('%02d',$hours). ':';
        $duration           = round($duration-($hours*3600));
    }
    if ( $duration > 60 ) {
        $minutes            = floor($duration/60);
        $duration_formated .= sprintf('%02d', $minutes). ':';
        $duration           = round($duration-($minutes*60));
    } else {
        $duration_formated .= '00:';
    }

    return $duration_formated . sprintf('%02d', $duration);
}

function time_range( $time )
{
    $range          = NULL;
    $current_time   = time();
    $interval       = $current_time-$time;
    if ( $interval > 0 ) {
        $day    = $interval/(60*60*24);
        if ( $day >= 1 ) {
            $range      = floor($day). ' days';
            $interval   = $interval-(60*60*24*floor($day));
        }
        if( $interval > 0 && $range == '' ) {
            $hour       = $interval/(60*60);
            if ( $hour >=1 ) {
                $range      = floor($hour). ' hours';
                $interval   = $interval-(60*60*floor($hour));
            }
        }
        if ( $interval > 0 && $range == '' ) {
            $min        = $interval/(60);
            if ( $min >= 1 ) {
                $range=floor($min). ' minutes';
                $interval=$interval-(60*floor($min));
            }
        }
        if ( $interval > 0 && $range == '' ) {
            $scn        = $interval;
            if ( $scn >= 1 ) {
                $range  = $scn. ' seconds';
            }
        }
        return ( $range != '' ) ? $range. ' ago' : 'just now';
    }
}

function video_rating_small( $rate )
{
    $class_1    = '';
    $class_2    = '';
    $class_3    = '';
    $class_4    = '';
    $class_5    = '';
    if ( $rate > 0.5 ) {
        $class_1 = ' class="half"';
        if ( $rate >= 1 ) {
            $class_1 = ' class="full"';
        }
        if ( $rate >= 2 ) {
            $class_2 = ' class="full"';
        } elseif ( $rate >= 1.5 ) {
            $class_2 = ' class="half"';
        }
        if ( $rate >= 3 ) {
            $class_3 = ' class="full"';
        } elseif ( $rate >= 2.5 ) {
            $class_3 = ' class="half"';
        }
        if ( $rate >= 4 ) {
            $class_4 = ' class="full"';
        } elseif ( $rate >= 3.5 ) {
            $class_4 = ' class="half"';
        }
        if ( $rate >= 5 ) {
            $class_5 = ' class="full"';
        } elseif ( $rate >= 4.5 ) {
            $class_5 = ' class="half"';
        }
    }

    $output     = array();
    $output[]   = '<ul class="rating_small">';
    $output[]   = '<li><span' .$class_5. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_4. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_3. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_2. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_1. '>&nbsp;</span></li>';
    $output[]   = '</ul>';

    return implode("\n", $output);
}

function translate($args)
{
	global $lang;
    if (!is_array($args)) {
        $args = func_get_args();
    }

    $code           = $args['0'];
    $translation	= FALSE;
    if (isset($lang[$code])) {
        $translation = $lang[$code];
    }

    if (isset($args['1']) && $translation) {
        $args   = array_slice($args, 1);
        return vsprintf($translation, $args);
    } else {
        return $translation;
    }

    return '';
}

function private_photo($type='video') {
	global $config;
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') === FALSE) {
        return 'private-'.$type.'.png';
    } else {
        return 'private-'.$type.'.gif';
    }
}

function check_image($path, $ext)
{
	$check = FALSE;
    if ($ext == 'gif') {
        $check = imagecreatefromgif($path);
    } elseif ($ext == 'png') {
        $check = imagecreatefrompng($path);
    } elseif ($ext == 'jpeg' OR $ext = 'jpg') {
        $check = imagecreatefromjpeg($path);
    }

	if ($ext == 'gif' && $check) {
  		$contents = file_get_contents($path);
  		if (strpos($contents, 'php') !== FALSE) {
      		$check = FALSE;
  		}
	}

    return ($check) ? TRUE : FALSE;
}

function show_err ($exp)
{
	return '<div class="alert alert-dismissable alert-danger m-t-15 m-b-0"><button type="button" class="close" data-dismiss="alert">×</button>'.$exp.'</div>';
}

function show_msg ($exp)
{
	return '<div class="alert alert-dismissable alert-success m-t-15 m-b-0"><button type="button" class="close" data-dismiss="alert">×</button>'.$exp.'</div>';
}

function show_err_mb ($exp)
{
	return '<div class="alert alert-dismissable alert-danger m-b-15 m-b-0"><button type="button" class="close" data-dismiss="alert">×</button>'.$exp.'</div>';
}

function show_msg_mb ($exp)
{
	return '<div class="alert alert-dismissable alert-success m-b-15 m-b-0"><button type="button" class="close" data-dismiss="alert">×</button>'.$exp.'</div>';
}

function blog_output($content)
{
	global $config;
	$search     = array('/\[b\](.*?)\[\/b\]/ms', '/\[i\](.*?)\[\/i\]/ms', '/\[u\](.*?)\[\/u\]/ms',
						'/\[img\](.*?)\[\/img\]/ms', '/\[email\](.*?)\[\/email\]/ms', '/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
						'/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms', '/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms', '/\[quote](.*?)\[\/quote\]/ms',
						'/\[list\=(.*?)\](.*?)\[\/list\]/ms', '/\[list\](.*?)\[\/list\]/ms', '/\[\*\]\s?(.*?)\n/ms');
	$replace    = array('<strong>\1</strong>', '<em>\1</em>', '<u>\1</u>', '<img src="\1" alt="\1" />',
						'<a href="mailto:\1">\1</a>', '<a href="\1">\2</a>', '<span style="font-size:\1%">\2</span>',
						'<span style="color:\1">\2</span>', '<blockquote>\1</blockquote>', '<ol start="\1">\2</ol>',
						'<ul>\1</ul>', '<li>\1</li>');
	$content    = preg_replace($search, $replace, $content);
	$content    = preg_replace('/\[photo=(.*?)\]/ms', '<div class="row"><div class="col-md-8 col-md-offset-2"><center><img src="' .$config['BASE_URL']. '/media/photos/\1.jpg" alt="" class="blog_image" /></center></div></div>', $content);
	$content    = preg_replace('/\[video=(.*?)\]/ms', '<div class="row"><div class="col-md-8 col-md-offset-2"><div class="blog_video"><div id="blog_video_\1"> <object type="application/x-shockwave-flash" data="' .$config['BASE_URL'].'/media/player/player.swf?f='.$config['BASE_URL']. '/media/player/config_blog.php?vkey=\1" width="100%" height="100%"> <video controls poster="' .$config['BASE_URL']. '/media/videos/tmb/\1/default.jpg" width="100%" height="100%"><source src="' .$config['BASE_URL']. '/mobile_src.php?id=\1" type="video/mp4">This video is not available on this platform.</video> <param name="movie" value="' .$config['BASE_URL'].'/media/player/player.swf?f='.$config['BASE_URL']. '/media/player/config_blog.php?vkey=\1" /> <param name="quality" value="high"/> <param name="allowFullScreen" value="true"/> <param name="allowScriptAccess" value="sameDomain"/> </object></div></div></div></div>', $content);
	$content    = str_replace("\r", "", $content);
	$content    = "<p>".ereg_replace("(\n){2,}", "</p><p>", $content)."</p>";

	return $content;
}

/**
 * +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 * +----------------------------------------------------------
 * @access public
 * +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * +----------------------------------------------------------
 * @return string
 * +----------------------------------------------------------
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (strlen(utf8_decode($str)) > $length) {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
        } else {
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
        if ($suffix) {
            $slice .= "…";
        }
    } else {
        $slice = $str;
    }
    return $slice;
}
function mbstrlen($str){
    $len = strlen($str);
    if ($len <= 0) {
        return  0;
    }
    $count = 0;
    for ($i = 0; $i < $len;) {
        $count++;
        if (ord($str{$i}) >= 0x80) {
            $i += 3;
        }else{
            $i++;
        }
    }
    return $count;
}
/**
 * 根据PHP各种类型变量生成唯一标识号
 * @param mixed $mix 变量
 * @return string
 */
function to_guid_string($mix) {
    if (is_object($mix)) {
        return spl_object_hash($mix);
    }elseif(is_resource($mix)){
        $mix = get_resource_type($mix) . strval($mix);
    }else{
        $mix = serialize($mix);
    }
    return $mix;
}
/*
 * 导入文件
 * */
function require_cache($dir,$filename){
    static $_importFiles = array();
    $filename = $dir.$filename;
    if (!isset($_importFiles[$filename])) {
        if (is_file($filename)) {
            ob_start();
            include  $filename;
            ob_end_clean();
            $_importFiles[$filename] = true;
        }else{
            $_importFiles[$filename] = false;
        }
    }
    return $_importFiles[$filename];
} 
/**
 * 批量导入
 * 
 */
 function import_array_file($dir,$files=array()){
     foreach ($files as $value) {
         require_cache($dir,$value);
     }
 }
function replace_page($content){
    global $isMakeHtml;
    if ($isMakeHtml == 1) {
        $a_header   = array('?c=', '?page=', '&page=');
        $a_replace  = array('/', '/index_page_', '/index_page_');
        $content    = str_replace($a_header, $a_replace, $content);
        $content = preg_replace('/(page_\d+)/', '$1.html', $content);
        $content = str_replace('/index_page_1.html', '/index.html', $content);
    }
    return $content;
}
function set_session_vals($arr = array()){
    if (!is_array($arr)) {
        die('请导入键值对数组!');
    }
    foreach ($arr as $key => $value) {
        if (empty($key) || empty($value)) {
            continue;
        }
        $_SESSION[$key] = $value;
    }
}
function del_session_vals($keys = array()){
    if (!is_array($keys)) {
        die('数据无效');
    }
    foreach ($keys as $k) {
        if (empty($k)) {
            continue;
        }
        if (isset($_SESSION[$k])) {
            unset($_SESSION[$k]);
        }
    }
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(),'',time() - 42000,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
    }
    session_unset();
    session_destroy();
}
function update_cache_mysql($cache,$ikey,$sikey,$table,$field,$where,$utime=300){
    global $conn;
    if (empty($ikey) || empty($table) || empty($field) || empty($where)) {
        return;
    }
    $time = time();
    $update_info = $cache->get($ikey);
    if ($update_info) {
        $btime =  intval(key($update_info));
        if ($time - $btime >= $utime) {
            if (isset($update_info[$btime])) {
                $uarr = $update_info[$btime];
                $vids = implode(',', array_keys($uarr));
                $sql = sprintf('UPDATE %s SET %s = CASE %s ',$table,$field,$where);
                foreach ($uarr as $vid => $v){
                    $sql .= sprintf(" WHEN %d THEN %s + %d",$vid,$field,$v);
                }
                $sql .= sprintf(" END WHERE %s IN({$vids})",$where);
                $conn->execute($sql);
                unset($update_info[$btime]);
                $cache->set($ikey,$update_info);
            }
        }else{
            $update_info[$btime][$sikey] += 1;
            $cache->set($ikey,$update_info,0);
        }
    }else{
        $update_info[$time][$sikey] = 1;
        $cache->set($ikey,$update_info,0);
    }
}
function getRemoteData($guname){
    $url = 'http://47.90.83.83/user/%s/valid/%s/t/%s';
    $key = 'gamedata47.90.83.83_**!@';
    $time = time();
    $valid = md5($key.$guname.$time);
    $nurl = sprintf($url,$guname,$valid,$time);
    $ch = curl_init($nurl);
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $return = curl_exec ( $ch );
    curl_close ( $ch );
    return $return;
}
function is_mobile(){
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    if (isset($_SERVER['HTTP_VIA'])){
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT'])){
        $clientkeywords = array (
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        if (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') != false) {
            return true;
        }
    }
    return false;
}
function getStaticUrl($params){
    global $isMakeHtml;
    extract($params);
    $str = empty($id)?'':'/'.$id;
    if ($isMakeHtml) {
        return '/html/'.$url.$str;
    }
    return '/'.$url.$str;
}
function getRate($params){
    extract($params);
    $rate = !isset($rate) || empty($rate) ? 0 : $rate;
    $count = round($rate / 20);
    $classStr = ' class="on"';
    $html = '<span%s></span>';
    $temp = array();
    for ($i = 0; $i < 5; $i++) {
        if ($i < $count) {
            array_push($temp, sprintf($html,$classStr));
        }else{
            array_push($temp, sprintf($html,''));
        }
    }
    return implode('', $temp);
}
function insert_cleanandtrim_content($options){
    $content = $options['content'];
    $len = $options['len'];
    $content = strip_tags($content);
    $content = trim($content);
    $content = str_replace(array(" ","\r\n","\r","\n","\t"), "", $content);
    $content = preg_replace('/\s+?/', '', $content);
    return mb_substr($content, 0,$len,'UTF-8');
}
function insert_time_range( $options )
{
    $range          = NULL;
    $time           = $options['time'];
    $current_time   = time();
    $interval       = $current_time-$time;
    if ( $interval > 0 ) {
        $day    = $interval/(60*60*24);
        if ( $day >= 1 ) {
            $range      = floor($day).' 天';
            $interval   = $interval-(60*60*24*floor($day));
        }
        if( $interval > 0 && $range == '' ) {
            $hour       = $interval/(60*60);
            if ( $hour >=1 ) {
                $range      = floor($hour). ' 小时';
                $interval   = $interval-(60*60*floor($hour));
            }
        }
        if ( $interval > 0 && $range == '' ) {
            $min        = $interval/(60);
            if ( $min >= 1 ) {
                $range=floor($min). ' 分钟';
                $interval=$interval-(60*floor($min));
            }
        }
        if ( $interval > 0 && $range == '' ) {
            $scn        = $interval;
            if ( $scn >= 1 ) {
                $range  = $scn. ' 称';
            }
        }

        return ( $range != '' ) ? $range. ' 之前' : '刚刚';
    }
}
function getFileTypeList(){
    return array(
        array('FFD8FF','jpg'),
        array('89504E47','png'),
        array('47494638','gif')
    );
}
function getFileType($filename){
    if (!file_exists($filename)) {
        return false;
    }
    $file = fopen($filename, 'rb');
    if (!$file) {
        return false;
    }
    $bin = fread($file, 15);
    fclose($file);
    $fileTypeList = getFileTypeList();
    foreach ($fileTypeList as $k => $v) {
        $blen = strlen(pack("H*",$v[0]));
        $tbin = substr($bin, 0,intval($blen));
        if (strtolower($v[0]) === strtolower(array_shift(unpack("H*", $tbin)))) {
            return $v[1];
        }
    }
    return false;
}
function clearBadHtml($str) {
    //clear script
    $str = preg_replace('/\<script[^>]*?>.*?(\<\/script\>)?/smi', '', $str);
    //clear sobject
    $str = preg_replace('/\<object[^>]*?>.*?(\<\/object\>)?/smi', '', $str);
    //clear iframe
    $str = preg_replace('/\<iframe[^>]*?>.*?(\<\/iframe\>)?/smi', '', $str);
    //clear embed
    $str = preg_replace('/\<embed[^>]*?>.*?(\<\/embed\>)?/smi', '', $str);
    //clear img onerror
    $str = preg_replace('/\<img.*onerror[^>]*?>.*?(\<\/img\>)?/smi', '', $str);
    //clear meta
    $str = preg_replace('/\<meta[^>]*?>.*?(\<\/meta\>)?/smi', '', $str);
    return $str;
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