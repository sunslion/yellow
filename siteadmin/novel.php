<?php
require 'common.php';
require '../classes/validation.class.php';
require '../classes/filter.class.php';

if ( isset($_GET['err']) ) {
	$errors[]   = trim($_GET['err']);
}

if ( isset($_GET['err']) ) {
	$errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
	$messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'list';
$module_template    = 'novel/list.tpl';
$modules_allowed    = array('list','add','edit','del');
if ( in_array($module, $modules_allowed) ) {
	$module_template = ( $module == 'list' ) ? 'novel/list.tpl' : 'novel/' .$module. '.tpl';
	require 'modules/novel/' .$module. '.php';
} else {
	$err = 'Invalid Settings Module!';
}
$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('active_menu', 'novel');
$smarty->display('header.tpl');
$smarty->display('leftmenu/novel.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');