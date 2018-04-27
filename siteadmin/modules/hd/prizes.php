<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$option = (isset($_SESSION['search_hd_option'])) ? $_SESSION['search_hd_option'] : array('sort'=>'id','order'=>'DESC');
$query_add = '';
$where = '';
if (isset($_POST['search_hd'])) {
    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $keyword = mysql_escape_string(trim($_POST['keyword']));
        $option['where'] = $keyword;
        $where = " WHERE uid = '{$keyword}' OR uname like '%{$keyword}%' ";
    }
    $option['sort'] = mysql_escape_string(trim($_POST['sort']));
    $option['order'] = mysql_escape_string(trim($_POST['order']));
    $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];
    $_SESSION['search_hd_option'] = $option;
}
$sql = 'SELECT COUNT(id) total FROM prizes'.$where;
$crs = $conn->execute($sql);
$total  = $crs->fields['total'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination('');
$sql = 'SELECT * FROM prizes '.$where.$query_add.' LIMIT '.$limit;
$crs = $conn->execute($sql);
if($crs){
    $hds = $crs->getrows();
    $smarty->assign('hds', $hds);
}
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('option', $option);