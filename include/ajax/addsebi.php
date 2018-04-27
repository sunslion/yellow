<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/json; charset=utf-8");
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR'].'/classes/auth.class.php';
Auth::checkAdmin();
disableRegisterGlobals();

$time = strtotime(date('Y-m-d'));

$options = array(
    'host'=>$config['mem_host'],
    'port'=>$config['mem_port'],
    'prefix'=>'sebiv',
    'expire'=>0,
    'length'=>0
);

if (isset($_POST['sebi'])) {
    $cache = Cache::getInstance('MemcacheAction',$options);
    
	$filter = new VFilter();
	$uid = $filter->get('uid');
	$sebi = $filter->get('sebi');
	
	if(intval($sebi) <= 0){
		$response['flag'] = -3;
		echo json_encode($response);
		exit;
	}
	$sql = "SELECT uid FROM signup WHERE uid = {$uid} AND premium = 0 LIMIT 0,1;";
	$rs    = $conn->execute($sql);
	if ( $conn->Affected_Rows() == 0 ) {
	    $response['flag'] = -2;
	    echo json_encode($response);
	    exit;
	}
	$sql = "SELECT uid,sebi_tiyan FROM user_sebi WHERE uid = '{$uid}' LIMIT 0,1;";
	$rs    = $conn->execute($sql);
	$time = time();
	if ( $conn->Affected_Rows() === 0 ) {
		$sql = "INSERT INTO user_sebi (uid,sebi,sebi_tiyan,isfree,jiangli_time) VALUES ('{$uid}','{$sebi}','{$sebi}',1,{$time});";
		$urs = $conn->execute($sql);
	}else {
		$sql = "UPDATE user_sebi set sebi = sebi + {$sebi},sebi_tiyan = sebi_tiyan + {$sebi},isfree=1,jiangli_time = {$time} where uid = {$uid} LIMIT 1;";
		$urs = $conn->execute($sql);
	}
	
	if ($urs) {
		$response['flag'] = 1;
		$cache->_unset($uid.$time.'free');
	}else {
		$response['flag'] = 0;
	}
	echo json_encode($response);
	exit;
}