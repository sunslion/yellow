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
$module_template    = 'videos.tpl';
$modules_allowed    = array('all', 'public', 'private', 'flagged', 'view', 'edit', 'comments',
                            'commentedit', 'add', 'spam', 'grabber', 'embed');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Videos Module!';
}

switch ( $module ) {
    case 'flagged':
    case 'spam':
    case 'edit':
    case 'view':
    case 'comments':
    case 'commentedit':
    case 'add':
    case 'grabber':
	case 'embed':
        $module_template = 'videos_' .$module. '.tpl';
        break;
    case 'all':
    case 'public':
    case 'private':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'videos.tpl';
        break;
}
require 'modules/videos/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module_keep);
$smarty->assign('active_menu', 'videos');
$smarty->display('header.tpl');
$smarty->display('leftmenu/videos.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
