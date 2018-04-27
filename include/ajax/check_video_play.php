<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/sebi.class.php';

if (!isset($_SESSION['uid'])) {
	$type_of_user = "guest";
}
elseif (!isset($_SESSION['uid_premium']) && isset($_SESSION['uid'])) {
	$type_of_user = "free";
}
else {
	$type_of_user = "premium";
}
$uid = intval($_SESSION['uid']);
$vid = intval($_POST['id']);
$msg = '';
$remote_ip = GetRealIP();
if ($type_of_user == 'guest' || $type_of_user == 'free') {
	require $config['BASE_DIR']. '/classes/sebi.class.php';
	$guest_limit = VSebi::check($remote_ip, 1, $vid);
	if (is_array($guest_limit)) {
		$tpl_msg = '亲爱的<font style="color:red;">%s</font>，您目前还有剩余色币个数：<font style="color:red;">%s</font>个，不够色币播放该视频！';
		$type_of_user_str = $guest_limit['name'];
		$msg = sprintf($tpl_msg , $type_of_user_str , intval($guest_limit['sebi_surplus']));
	}
}
echo $msg;