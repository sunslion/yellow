<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$sql = 'SELECT COUNT(id) total FROM hd_cat';
$crs = $conn->execute($sql);
$total  = $crs->fields['total'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination('');
$sql = 'SELECT * FROM hd_cat ORDER BY id DESC LIMIT '.$limit;
$crs = $conn->execute($sql);
$cat_list = $crs->getrows();
$smarty->assign('cat_list', $cat_list);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);