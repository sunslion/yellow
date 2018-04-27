<?php
require 'common.php';

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'all';
$module_keep        = NULL;
$module_template    = 'picture.tpl';
$modules_allowed    = array('all', 'add', 'edit','upload','del');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Server Module!';
}

switch ( $module ) {
    case 'edit':
    case 'add':
        $module_template = 'picture_' .$module. '.tpl';
        break;
    case 'all':
    case 'upload':
        break;
    case 'del':
        break;
    default:
        $module             = 'all';
        $module_template    = 'picture.tpl';
        break;
}
require 'modules/picture/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module);
$smarty->assign('active_menu', 'picture');
$smarty->display('header.tpl');
$smarty->display('leftmenu/picture.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');