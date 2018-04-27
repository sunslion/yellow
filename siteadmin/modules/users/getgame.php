<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
Auth::checkAdmin();
require $config['BASE_DIR'].'/include/config.rank.php';
$where = '';
$option = array();
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $where = empty($where) ? ' s.username = \''.mysql_real_escape_string($_POST['username']).'\'':' AND s.username = \''.mysql_real_escape_string($_POST['username']).'\'';
    $option['username'] = $_POST['username'];
}
if (isset($_POST['gname']) && !empty($_POST['gname'])) {
    $where = empty($where) ? ' gusername = \''.mysql_real_escape_string($_POST['gname']).'\'':' AND gusername = \''.mysql_real_escape_string($_POST['gname']).'\'';
    $option['gname'] = $_POST['gname'];
}
if (!empty($where)) {
    $where = ' WHERE '.$where;
}
$remove = null;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$sql = 'SELECT COUNT(id) AS total FROM qqc_game'.$where;
$rs             = $conn->execute($sql);
$total = 0;
if($rs){
    $total    = $rs->fields['total'];
}
$page_size = 20;
$pagination     = new Pagination($page_size);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination($remove);

$sql            =  "SELECT s.UID, g.gusername,g.gameid,g.isgetsebi,g.btime,s.username,s.premium FROM qqc_game g LEFT JOIN signup s ON g.uid = s.UID {$where} ORDER BY g.id DESC LIMIT {$limit}";
$rs             = $conn->execute($sql);
if($rs)
    $gusers     = $rs->getrows();
$smarty->assign('products', $products);
$smarty->assign('user_range', $user_range);
$smarty->assign('option', $option);
$smarty->assign('gusers', $gusers);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);