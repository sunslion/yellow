<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$vid = intval($_GET['vid']);
$sql = "DELETE FROM novel WHERE VID = {$vid};";
$rs = $conn->execute($sql);
if ($rs) {
	$msg = '小说删除改成功!';
	VRedirect::go('novel.php?msg=' . $msg . '&m=list');
}else {
	$msg = '小说删除改失败!';
	VRedirect::go('novel.php?msg=' . $msg . '&m=list');
}