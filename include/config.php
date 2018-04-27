<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control:must-revalidate, max-age=3600");
header("Pragma: no-cache");

require 'debug.php';
require 'config.paths.php';
require 'config.db.php';
require 'config.local.php';
require 'config.seo.php';
require 'config.language.php';
require 'function_global.php';

require $config['BASE_DIR']. '/classes/timer.class.php';
require $config['BASE_DIR']. '/classes/redirect.class.php';

if ($config['splash'] == '1' && !defined('_ENTER') && !defined('_ADMIN') && !defined('_MOBILE') && !defined('_CLI')) {
	if (!isset($_COOKIE['splash'])) {
		VRedirect::go($config['BASE_URL']. '/enter.php');
	}
}
if (isset($_GET['isMakeHtml'])) {
    $isMakeHtml = intval($_GET['isMakeHtml']);
}
require $config['BASE_DIR']. '/include/security.php';
require $config['BASE_DIR']. '/include/smarty/libs/Smarty.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
include $config['BASE_DIR'].'/classes/Cache.class.php';
if ( !defined('_CONSOLE') ) {
    ob_start();
    require $config['BASE_DIR']. '/include/sessions.php';
    ob_end_clean();
}
disableRegisterGlobals();
$login_options = array(
    'host'=>$config['mem_host'],
    'port'=>$config['mem_port'],
    'prefix'=>'login',
    'expire'=>intval($config['session_lifetime']),
    'length'=>0
);
$login_cache = Cache::getInstance('MemcacheAction',$login_options);
if (isset($_SESSION['session_id'])) {
	$session_id = intval($_SESSION['session_id']);
	$uid = intval($_SESSION['uid']);
	$login_session_id = $login_cache->get($uid);
	
	if ($session_id != $login_session_id) {
		set_session_vals(array(
		    'loginerror' => '账号已有其他人使用！'
		));
		unset($_SESSION['session_id']);
		VRedirect::go('/logout.php');
	}
}
require $config['BASE_DIR']. '/include/function_language.php';
if (!isset($_SESSION['language'])) {
    set_session_vals(array(
       'language' =>  $config['language']
    ));
}

if ($config['multi_language'] && isset($_POST['language'])) {
	$language = trim($_POST['language']);
	if (isset($languages[$language])) {
	    set_session_vals(array(
	        'language' => $language
	    ));
	}
}
require $config['BASE_DIR']. '/language/'.$_SESSION['language'].'.lang.php';

require $config['BASE_DIR']. '/classes/remember.class.php';
if ( !defined('_CONSOLE') && $config['gzip_encoding'] == 1 ) {
	ob_start();
	ob_implicit_flush(0);
}

$errors     = array();
$messages   = array();
if ( isset($_SESSION['message']) ) {
    $messages[] = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ( isset($_SESSION['error']) ) {
    $errors[] = $_SESSION['error'];
    unset($_SESSION['error']);
}

$remote_ip = ( isset($_SERVER['REMOTE_ADDR']) && long2ip(ip2long($_SERVER['REMOTE_ADDR'])) ) ? $_SERVER['REMOTE_ADDR'] : NULL;
if ( isset($_SESSION['uid']) ) {
    $sid    = intval($_SESSION['uid']);
    if ( $remote_ip ) {
        $sql    = "UPDATE signup SET user_ip = '" .mysql_real_escape_string($remote_ip). "' WHERE UID = " .$sid. " LIMIT 1";
        $conn->execute($sql);
    }
}

if ( $remote_ip ) {
	$sql = "SELECT ban_id FROM bans WHERE ban_ip = '" .mysql_real_escape_string($remote_ip). "' LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() > 0 ) {
    	    VRedirect::go($config['BASE_URL']. '?msg=You are banned from this site!');
	}
}

if ( $config['user_remember'] == '1' ) {
    Remember::check();
}

/********VIP***********/
$premium = isset($_SESSION['uid_premium']) ? intval($_SESSION['uid_premium']):0;
$user_permisions = array(
        'watch_normal_videos',
        'watch_hd_videos',
        'bandwidth',
        'sd_downloads',
        'hd_downloads',
        'mobile_downloads',
        'in_player_ads',
        'write_in_blog',
        'upload_video',
);
$new_permisions = array();
if (!isset($_SESSION['uid'])) {
    $type_of_user = 'guest';
    foreach ($user_permisions as $v) {
        $new_permisions[$v] = $config['visitors_'.$v];
    }
}elseif (!isset($_SESSION['uid_premium']) && isset($_SESSION['uid'])) {
    $type_of_user = 'free';
    foreach ($user_permisions as $v) {
        $new_permisions[$v] = $config['free_'.$v];
    }
}else {
    $type_of_user = 'premium';
    foreach ($user_permisions as $v) {
        $new_permisions[$v] = $config['premium_'.$v];
    }
}
/***********END**********/
require_once 'function_frontend.php';
require 'smarty.php';

if ( $config['submenu_tag_scroller'] == '1' ) {
    $tags       = array();
    $sql        = "SELECT keyword FROM video WHERE active = '1' ORDER BY viewnumber LIMIT 10";
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
    $smarty->assign('scroller_content', $tags);
}
if ( isset($_SESSION['uid']) ) {
    $expire = 600;
    $options = array(
        'host'=>$config['mem_host'],
        'port'=>$config['mem_port'],
        'prefix'=>'puc_count',
        'expire'=>$expire,
        'length'=>0
    );
    $scache = Cache::getInstance('MemcacheAction',$options);
    
    $sid    = intval($_SESSION['uid']);
    $username = mysql_real_escape_string($_SESSION['username']);
    
    $sql            = "UPDATE users_online SET online = '" .time(). "' WHERE UID = " .$sid. " LIMIT 1";
    $conn->CacheExecute(3000,$sql);
    $sql            = "SELECT COUNT(UID) AS total_requests FROM friends WHERE UID = " .$sid. " AND status = 'Pending'";
    $rs             = $conn->CacheExecute(3000,$sql);
    $requests_count = $rs->fields['total_requests'];
    
    $key = 'total_mails_'.$username;
    $mails_count = $scache->get($key);
    if(empty($mails_count)){
        $sql            = "SELECT COUNT(mail_id) AS total_mails FROM mail
                           WHERE receiver = '" .$username. "' AND status = '1' AND readed = '0'";
        $rs             = $conn->execute($sql);
        $mails_count    = $rs->fields['total_mails'];
        $scache->set($key,$mails_count);
    }
    $smarty->assign('requests_count', $requests_count);
    $smarty->assign('mails_count', $mails_count);
}

$smarty->assign('premium', $premium);
if (isset($config['set_back'])) {
    $back_img = $config['set_back'].'?t='.time();
    $smarty->assign('back_img', $back_img);
}
if (isset($config['set_left_btn_top'])) {
    $smarty->assign('set_left_btn_top', $config['set_left_btn_top']);
}
if (isset($config['set_left_btn_url'])) {
    $smarty->assign('set_left_btn_url', $config['set_left_btn_url']);
}
if (isset($config['set_right_btn_top'])) {
    $smarty->assign('set_right_btn_top', $config['set_right_btn_top']);
}
if (isset($config['set_right_btn_url'])) {
    $smarty->assign('set_right_btn_url', $config['set_right_btn_url']);
}
if (isset($config['set_notice'])) {
    $smarty->assign('notice', $config['set_notice']);
}
