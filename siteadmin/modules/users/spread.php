<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();
if (isset($_GET['t'])) {
	$id = intval($_GET['id']);
	if ($_GET['t'] == 'del') {
		$sql = "SELECT simg FROM spread WHERE id = {$id} LIMIT 1;";
		$rs             = $conn->execute($sql);
		$simg    = $rs->fields['simg'];
		if (file_exists($simg)) {
			unset($simg);
		}
		$sql =  "DELETE FROM spread WHERE id = {$id} LIMIT 1;";
		$result = $conn->execute($sql);
		if ($result) {
			$messages[] = '删除数据成功！';
		}else {
			$errors[] = '删除数据失败！';
		}
	}
	
	if ($_GET['t'] == 'verify') {
	    $time = strtotime(date('Y-m-d'));
	    $options = array(
	        'host'=>$config['mem_host'],
	        'port'=>$config['mem_port'],
	        'prefix'=>'sebiv',
	        'expire'=>0,
	        'length'=>0
	    );
	    $cache = Cache::getInstance('MemcacheAction',$options);
		$free_tgjlsebi = 3;
		if (isset($config['free_tgjlsebi'])) {
			$free_tgjlsebi = intval($config['free_tgjlsebi']);
		}
		$sql = "SELECT uid,username,status FROM spread WHERE id = {$id} LIMIT 1;";
		$rs             = $conn->execute($sql);
		$uid    = intval($rs->fields['uid']);
		$username    = $rs->fields['username'];
		$status    = intval($rs->fields['status']);
		if ($status == 0) {
			$sql = "SELECT uid FROM user_sebi WHERE uid = '{$uid}'  LIMIT 0,1;";
			$rs    = $conn->execute($sql);
			$jiangli_time = time();
			if ( $conn->Affected_Rows() === 0 ) {
				$sql = "INSERT INTO user_sebi (uid,sebi,sebi_tiyan,isfree,jiangli_time) VALUES ('{$uid}','{$free_tgjlsebi}','{$free_tgjlsebi}',1,{$jiangli_time});";
				$urs = $conn->execute($sql);
			}else {
				$sql = "UPDATE `user_sebi` SET sebi = sebi + {$free_tgjlsebi},sebi_tiyan = sebi_tiyan + {$free_tgjlsebi},isfree=1,jiangli_time={$jiangli_time} WHERE uid = {$uid} LIMIT 1;";
				$urs = $conn->execute($sql);
			}
			$sql = "UPDATE spread SET status = 1 WHERE id = {$id} LIMIT 1;";
			$srs = $conn->execute($sql);
			if ($urs && $srs) {
			    $cache->_unset($uid.$time.'free');
				$messages[] = '审核数据成功！'.$username.'将得到'.$free_tgjlsebi.'个体验币推广奖励。';
			}else {
				$errors[] = '审核数据失败！';
			}
		}
	}
}
$where = '';
$status = 0;
$date = '';
$username = '';
if (isset($_POST['search_spread_count'])) {
	
	if (isset($_POST['status'])) {
		$status = intval($_POST['status']);
		$where = ' status = ' . $status;
	}
	if (isset($_POST['date']) && trim($_POST['date']) != '') {
		$utime = strtotime(trim($_POST['date']))+ 86400;
		$date = date('Y-m-d',$utime - 86400);
		if ($where == '') {
			$where = " utime <= '{$utime}'" ;
		}else {
			$where .= " AND utime <= '{$utime}'";
		}
	}
	if (isset($_POST['username']) && trim($_POST['username']) != '') {
		$username = mysql_real_escape_string(trim($_POST['username']));
		if ($where == '') {
			$where = " username LIKE '%{$username}%'";
		}else {
			$where .= " AND username LIKE '%{$username}%'";
		}
	}
	if ($where != '') {
		$where = ' WHERE '.$where;
	}
}
$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$sql            = 'SELECT count(id) total FROM spread '.$where.' LIMIT 1';
$rs             = $conn->execute($sql);
$total    = $rs->fields['total'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination($remove);
$sql            = 'SELECT * FROM spread '.$where.' ORDER BY id DESC'. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$spreads          = $rs->getrows();

$smarty->assign('messages', $messages);
$smarty->assign('errors', $errors);
$smarty->assign('spreads', $spreads);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('status', $status);
$smarty->assign('date', $date);
$smarty->assign('username', $username);