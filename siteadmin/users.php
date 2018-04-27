<?php
require 'common.php';
require '../include/config.products.php';

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}
if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}
$module = '';
if (isset($_GET['m']) && $_GET['m'] != '') {
    $module = trim($_GET['m']);
}
if (isset($_POST['m']) && $_POST['m'] != '') {
    $module = trim($_POST['m']);
}

$module             = !empty($module) ? $module : 'all';
$module_template    = 'users.tpl';
$modules_allowed    = array('all','guests','spread', 'active', 'inactive', 'edit', 'view', 'view', 'mail',
                            'mailall', 'flagged', 'spam', 'commentedit', 'comments', 'add','deposit','deposit_add','deposit_edit','getgame','hongbao','check_guname');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Users Module!';
}

$module_keep = NULL;
switch ( $module ) {
	case 'all':
		$module_keep        = $module;
		$module             = 'all';
		$module_template    = 'users.tpl';
		break;
    case 'edit':
    case 'view':
    case 'add':
    case 'mail':
    case 'mailall':
    case 'spam':
    case 'flagged':
    case 'commentedit':
    case 'comments':
        $module_template = 'users_' .$module. '.tpl';
        break;
    case 'all':
    case 'guests':
    	$module_template = 'users_' .$module. '.tpl';
    	break;
    //case 'active':
    //case 'inactive':
    case 'spread':
    	$module_template = 'users_' .$module. '.tpl';
    	break;
    case 'deposit':
        $module_template = 'users_'.$module.'.tpl';
        break;
    case 'deposit_add':
        $module_template = 'users_'.$module.'.tpl';
        break;
    case 'deposit_edit':
        $module_template = 'users_'.$module.'.tpl';
        break;
    case 'getgame':
        $module_template = 'users_'.$module.'.tpl';
        break;
    case 'hongbao':
        $module_template = 'users_'.$module.'.tpl';
        break;
    case 'check_guname':
        break;
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'users.tpl';
        break;
}
require 'modules/users/' .$module. '.php';
$smarty->assign('admin_name',$config['admin_name']);
$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module_keep);
$smarty->assign('active_menu', 'users');
$smarty->display('header.tpl');
$smarty->display('leftmenu/users.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');