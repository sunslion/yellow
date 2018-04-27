<?php
require 'common.php';
require '../classes/validation.class.php';
require '../classes/filter.class.php';

Auth::checkAdmin();

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}
if (isset($_GET['m']) && $_GET['m'] != '') {
    $module = trim($_GET['m']);
}
if (isset($_POST['m']) && $_POST['m'] != '') {
    $module = trim($_POST['m']);
}
$module             = !empty($module) ? $module : 'main';
$module_template    = 'index.tpl';
$modules_allowed    = array('main', 'check', 'mail', 'modules', 'static', 'media', 'iphone', 'flv', 'mp4', 'permissions', 'sessions', 'bandwidth','bans', 'emails', 'emailadd', 'emailedit', 'advgroups', 'advs', 'advadd', 'advgroupedit', 'advedit','advmedia', 'advtext', 'advmediaadd', 'advtextadd', 'advtextedit', 'advmediaedit', 'player', 'playeradd', 'playeredit','new_player', 'userpermisions', 'new_advs', 'new_advsedit', 'new_advsadd', 'advzone', 'advzoneadd', 'advzoneedit','adv_count', 'cache', 'mfile','get_permissions');
if ( in_array($module, $modules_allowed) ) {
    $module_template = ( $module == 'main' ) ? 'index.tpl' : 'index_' .$module. '.tpl';
    require 'modules/index/' .$module. '.php';
} else {
    $err = 'Invalid Settings Module!';
}

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('active_menu', 'index');
$smarty->display('header.tpl');
$smarty->display('leftmenu/index.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
