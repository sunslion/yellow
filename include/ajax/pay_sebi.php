<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/json; charset=utf-8");
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
$filter     = new VFilter();
$vid = $filter->get('vid','INTEGER');
$time = strtotime(date('Y-m-d'));
$tomorrow = $time + 86400;
$expire = $tomorrow - time();
$options = array(
    'host'=>$config['mem_host'],
    'port'=>$config['mem_port'],
    'prefix'=>'video',
    'expire'=>$expire,
    'length'=>99999999
);
$cache = Cache::getInstance('MemcacheAction',$options);
//视频播放需要的色币个数，如若没设置，默认为0
$video = $cache->get($vid);
$num = $video['sebi'];
if ($num <= 0) {
    $num = 1;
}
$uid = isset($_SESSION['uid']) ? intval($_SESSION['uid']):0;
$remote_ip = GetRealIP();
$premium  = isset($_SESSION['uid_premium']) ? $_SESSION['uid_premium'] : '';
//记录视频被观看次数
update_cache_mysql($cache, 'up_info',$vid, 'video', 'viewnumber', 'VID',100);
//记录视频作者的视频被观看次数
//update_cache_mysql($cache, 'up_sv', intval($video['UID']), 'signup', 'video_viewed', 'UID',100);
if ($uid > 0) {
    //记录用户了多少个视频
    update_cache_mysql($cache, 'up_sv1', $uid, 'signup', 'watched_video', 'UID',200);
}
require $config['BASE_DIR']. '/classes/sebi.class.php';
$guest_limit = VSebi::check($remote_ip, intval($video['sebi']), $vid,$uid,1);
echo json_encode($guest_limit);
exit;