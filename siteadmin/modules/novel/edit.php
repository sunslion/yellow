<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$sql = 'SELECT CHID,name FROM category WHERE parentid = 1;';
$crs = $conn->execute($sql);
$categories = $crs->getrows();

if (isset($_POST['edit_novel'])) {
	$title = mysql_real_escape_string(trim($_POST['title']));
	$content = mysql_real_escape_string($_POST['content']);
	$category   = intval($_POST['category']);
	$vid = intval($_POST['vid']);
	if ($title == '') {
		$errors[]   = '标题不能为空';
	}
	if (trim($content) == ''){
		$errors[]   = '内容不能为空';
	}
	if ($category == 0) {
		$errors[]   = '请选择小说类别';
	}
	if (!$errors) {
		$sql = "UPDATE novel SET title = '{$title}',content='{$content}',category_id='{$category}' WHERE VID = {$vid};";
		$rs = $conn->execute($sql);
		if ($rs) {
			$msg = '小说内容修改成功!';
			VRedirect::go('novel.php?msg=' . $msg . '&m=list');
		}
	}

}
$vid = intval($_GET['vid']);
$sql = "SELECT title,content,category_id FROM novel WHERE VID = {$vid} LIMIT 1;";
$rs = $conn->execute($sql);
$novels = $rs->getrows();
$novel   = $novels['0'];

$smarty->assign('categories', $categories);
$smarty->assign('vid', $vid);
$smarty->assign('novel', $novel);