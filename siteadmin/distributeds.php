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
$module_template    = 'distributeds.tpl';
$modules_allowed    = array('distributeds_all', 'distributeds_add', 'distributeds_edit','distributed_all', 'distributed_add', 'distributed_edit','distributed_config','help');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Distributeds Module!';
}

switch ( $module ) {
		case 'distributeds_edit':
		case 'distributeds_add':
		    $module_template = $module.'.tpl';
		break;
		case 'distributed_edit':
		case 'distributed_add':
		    $module_template = $module.'.tpl';
		break;
	
		case 'distributed_all':
		    $module_template = $module.'.tpl';
		break;
		case 'distributed_config':
		    $module_template = $module.'.tpl';
		break;
		case 'help':
		    $module_template = 'distributeds_'.$module.'.tpl';
		break;
    case 'distributeds_all':
    default:
        $module             = 'distributeds_all';
        $module_template    = 'distributeds_all.tpl';
        break;
}

require 'modules/distributeds/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module);
$smarty->assign('active_menu', 'distributeds');
$smarty->display('header.tpl');
$smarty->display('leftmenu/distributeds.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
