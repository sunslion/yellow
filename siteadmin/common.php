<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_admin.php';
require '../classes/auth.class.php';
require '../include/config.permisions.php';
require '../language/cn_CS_siteadmin.lang.php';
Auth::checkAdmin();

$atype = intval($_SESSION['ATYPE']);
$temp = explode('/', $_SERVER['REQUEST_URI']);
$temp_str = '';

foreach ($temp as $key=>$v) {
    if (empty($v) || $v =='siteadmin') {
        unset($temp[$key]);
    }else{
        $temp_str = $v;
    }
}
if ($atype > 0) {
    $menus = $config['perm_'.$atype.'_menus'];
    if (empty($menus)) {
        echo '<meta http-equiv="refresh" content="3; url=/siteadmin/login.php" />';
        die('您所在的用户组，目前没有可操作的版块，系统只能选择退出，如要操作，请联系管理员!');
    }
    $menus = json_decode($menus);
    if (!is_array($menus) || count($menus) <= 0) {
        echo '<meta http-equiv="refresh" content="3; url=/siteadmin/login.php" />';
        die('您所在的用户组，目前没有可操作的版块，系统只能选择退出，如要操作，请联系管理员!');
    }
    
    $repix = explode('.', $temp_str);
    $menu = $menus[count($menus) - 1];
    if (is_array($repix) && !in_array($repix[0], $menus)) {
        VRedirect::go($config['BASE_URL']. '/siteadmin/'.$menu.'.php');
    }
    
    $subkey = $repix[0];
    $m = strtolower(trim($_REQUEST['m']));
    $a = strtolower(trim($_REQUEST['a']));
    if (!empty($m)) {
        $subkey .= '.'.$m;
    }
    if (!empty($a)) {
        if (empty($m)) {
            $subkey .= '.all';
        }
        $subkey .= '.'.$a;
    }
   
    $submenus = $config['perm_'.$atype.'_submenus'];
    $submenus = json_decode($submenus);
    if ($m && !in_array($subkey, $submenus)) {
        echo '<meta http-equiv="refresh" content="5; url=/siteadmin/'.$menu.'.php" />';
        die('没有操作本模块的权限!请与管理员联系');
    }
}

$smarty->assign('menus', $menus);
$smarty->assign('admin_lang', $admin_lang);