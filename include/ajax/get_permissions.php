<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/json; charset=utf-8");
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR'].'/classes/auth.class.php';
Auth::checkAdmin();
$filter     = new VFilter();
$type = $filter->get('user_type');
$arr = array();
if (isset($config['perm_'.$type.'_menus'])) {
    $arr['menus'] = json_decode($config['perm_'.$type.'_menus']);
}
if (isset($config['perm_'.$type.'_submenus'])) {
    $arr['submus'] = json_decode($config['perm_'.$type.'_submenus']);
}
if(!empty($arr)){
    echo json_encode($arr);
}else{
    echo 0;
}
exit;