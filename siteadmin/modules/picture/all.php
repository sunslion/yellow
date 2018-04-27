<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

$sql = 'SELECT COUNT(VID) AS total FROM picture LIMIT 1';
$rs = $conn->execute($sql);
$total = 0;
if($rs && $conn->Affected_Rows() > 0){
    $total = (int)$rs->fields['total'];
}
$pagination = new Pagination(20);
$limit = $pagination->getLimit($total);
$paging = $pagination->getAdminPagination('');
$sql = 'SELECT p.VID,p.title,p.keyword,p.des,c.name FROM  channel c right join `picture` p On c.CHID = p.category_id WHERE c.parentid = 7 ORDER BY VID DESC LIMIT '.$limit;
$rs = $conn->execute($sql);
$rows = null;
if ($rs && $conn->Affected_Rows() > 0) {
    $rows = $rs->getrows();
}
$smarty->assign('pictures', $rows);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);