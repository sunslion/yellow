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
$module_template    = 'hd/list.tpl';
$modules_allowed    = array('list','add','edit','del','cat_add','cat_edit','cat_del','cat_list','prizes','newyear','task','task_add','task_edit','task_receive');
if ( in_array($module, $modules_allowed) ) {
    $module_template = ( $module == 'list' ) ? $module_template : 'hd/' .$module. '.tpl';
    require 'modules/hd/' .$module. '.php';
} else {
    $err = 'Invalid Settings Module!';
}
$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('active_menu', 'hd');
$smarty->display('header.tpl');
$smarty->display('leftmenu/hd.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');