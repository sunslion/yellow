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
$module_template    = 'avActor/list.tpl';
$modules_allowed    = array('list','add','edit','del','avActorList','avActorAdd','avActorEdit','avActorImgEdit');
if ( in_array($module, $modules_allowed) ) {
	$module_template = ( $module == 'list' ) ? 'avActor/list.tpl' : 'avActor/' .$module. '.tpl';
	require 'modules/avActor/' .$module. '.php';
} else {
	$err = 'Invalid Settings Module!';
}
$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('active_menu', 'avActor');
$smarty->display('header.tpl');
$smarty->display('leftmenu/avActor.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');