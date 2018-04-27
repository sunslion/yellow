<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();
$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$sql            = 'SELECT count(guest_id) total FROM guests LIMIT 1';
$rs             = $conn->execute($sql);
$total    = $rs->fields['total'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination($remove);
$sql            = 'SELECT * FROM guests ORDER BY guest_id DESC'. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$guests          = $rs->getrows();

$smarty->assign('guests', $guests);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);