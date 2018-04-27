<?php
require 'common.php';
require '../classes/filter.class.php';
if (isset($_GET['msg'])) {
    $messages[] = $_GET['msg'];
}
if (isset($_GET['err'])) {
    $errors[] = $_GET['err'];
}
$filter = new VFilter();
$module = $filter->get('m','string','GET');
$module_template = 'admin.tpl';
$modules_allowed = array('all','add','edit');

if (!empty($module) && !in_array($module, $modules_allowed)) {
    $module = 'all';
    $errors[]    = 'Invalid Albums Module!';
}

switch ($module) {
    case 'add':
        $module_template = 'admin_'.$module.'.tpl';
        break;
    case 'edit':
        $module_template = 'admin_'.$module.'.tpl';
        break;
    default:
        $module = 'all';
        $module_template = 'admin.tpl';
        break;
}

require 'modules/admin/'.$module.'.php';
$purviews = $config['purviews'];
if (!empty($purviews)) {
    $temp = explode('|', $purviews);
    $i = 1;
    $temp_arr = array();
    foreach ($temp as $v){
        $temp_arr[$i] = $v;
        $i++;
    }
   $smarty->assign('purviews', $temp_arr);
}

$smarty->assign('errors', $errors);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module);
$smarty->assign('active_menu', 'admin');
$smarty->display('header.tpl');
$smarty->display('leftmenu/admin.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');