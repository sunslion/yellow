<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$sql = 'SELECT CHID,name FROM category WHERE parentid = 1;';
$crs = $conn->execute($sql);
$categories = $crs->getrows();

if (isset($_POST['add_novel'])) {
	$title = mysql_real_escape_string(trim($_POST['title']));
	$content = mysql_real_escape_string($_POST['content']);
	$category   = intval($_POST['category']);
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
		$time = time();
		$sql = "INSERT INTO novel(title,content,category_id,addtime) VALUES ('{$title}','{$content}','{$category}','{$time}')";
		$rs = $conn->execute($sql);
		if ($rs) {
			$msg = '小说内容添加成功!';
			VRedirect::go('novel.php?msg=' . $msg . '&m=list');
		}
	}

}

$smarty->assign('categories', $categories);